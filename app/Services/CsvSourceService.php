<?php 
namespace App\Services;

use App\Contracts\Onboarding;
use Illuminate\Support\Facades\File;
use Config;

class CsvSourceService implements Onboarding{

    const DELIMETER = ';';

    const STEPS = 8;

    /**
     * csv file name
     */
    private $file_name;

    /**
     * Constrcutor for CsvSourceService
     */
    public function __construct()
    {
        $this->file_name = config('chart_source.file_name');
    }
    /**
     * returns each steps onborad precentage.
     * 
     * @return Illuminate\Http\JsonResponse
     * 
     */
    public function getOnboardPrecentage() : \Illuminate\Http\JsonResponse
    {
        $source_data = $this->getDataFromSource();
        if(empty($source_data)) 
            return false;
        
        $results_onboard = $this->arrangeOnboardData($source_data);

        $steps_precentage_data = [];
        foreach($results_onboard as $result) {
                $temp_array = [];
        
                for($i = 1; $i <= self::STEPS; $i++){        
                    if($i == 1){
                        $temp_array[$i] = 100;
                    }else{
                        $temp_array[$i] = round(($result["step_".$i]/$result['step_1']) * 100);
                    }       
                }

                $precentage_data['name'] = $result['week'];
                $precentage_data['data'] = array_values($temp_array);

                array_push($steps_precentage_data,$precentage_data);                
        }

        return response()->json(
            $steps_precentage_data
        );
    }

    /**
     * Returns array of data from the source
     * 
     * @return array
     */
    private function getDataFromSource()
    {
        if(!File::exists(storage_path($this->file_name)))
            return false;

        $file = fopen(storage_path($this->file_name), "r");
        $raw_data = [];
        $new_data = [];
        fgetcsv($file, 1000, self::DELIMETER); //skips the first raw

        while ( ($data = fgetcsv($file, 1000, self::DELIMETER)) !==FALSE ) {
            $raw_data['user_id'] = $data[0];
            $raw_data['date'] = $data[1];
            $raw_data['onboard_precentage'] = $data[2];
            $date_array  = explode('-',$data[1]);

            $dateTime = new \DateTime();
            $raw_data['start_date_of_week'] = $dateTime->setISODate($date_array[0], date("W", strtotime($data[1])))->format('Y-M-d');
   
            array_push($new_data, $raw_data);
        }
         fclose($file);

         return $new_data;
    }

    /**
     * 
     */
    private function arrangeOnboardData(array $source_data)
    {
        $result = [];        
        
        foreach ($source_data as $element) { //group array by start_date_of_week
            $result[$element['start_date_of_week']][] = $element;
        }

        $onboard_steps_data = [];
        foreach($result as $key=>$values) {
                $temp_array['week'] = $key;
                $temp_array['step_1'] = 0;
                $temp_array['step_2'] = 0;
                $temp_array['step_3'] = 0;
                $temp_array['step_4'] = 0;
                $temp_array['step_5'] = 0;
                $temp_array['step_6'] = 0;
                $temp_array['step_7'] = 0;
                $temp_array['step_8'] = 0;
            foreach($values as $val){
                if($val['onboard_precentage'] <= 100 )
                    $temp_array['step_1'] =  $temp_array['step_1'] + 1;
                if($val['onboard_precentage'] >= 20 )
                    $temp_array['step_2'] =  $temp_array['step_2'] + 1;
                if($val['onboard_precentage'] >= 40 )
                    $temp_array['step_3'] =  $temp_array['step_3'] + 1;
                if($val['onboard_precentage'] >= 50 )
                    $temp_array['step_4'] =  $temp_array['step_4'] + 1;
                if($val['onboard_precentage'] >= 70 )
                    $temp_array['step_5'] =  $temp_array['step_5'] + 1;
                if($val['onboard_precentage'] >= 90 )
                    $temp_array['step_6'] =  $temp_array['step_6'] + 1;
                if($val['onboard_precentage'] >= 99 )
                    $temp_array['step_7'] =  $temp_array['step_7'] + 1;
                if($val['onboard_precentage'] == 100 )
                    $temp_array['step_8'] =  $temp_array['step_8'] + 1;
            }

            $onboard_steps_data[] =  $temp_array;
            $temp_array = [];

        }
         return $onboard_steps_data;
    }    
}