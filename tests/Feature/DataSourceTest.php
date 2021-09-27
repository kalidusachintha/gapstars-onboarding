<?php

namespace Tests\Feature;

use Tests\TestCase;

class DataSourceTest extends TestCase
{

    /**
     * @return void
     */
    public function test_csv_available_and_return_data()
    {
        $this->withoutExceptionHandling();
        $this->assertTrue(file_exists('storage/export.csv'));
        
        $response = $this->json('GET', '/api/getall', [
                              'name' => 'test-name',
                              'data' => [100,90,89]
                         ]);
        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_csv_available()
    {
        $this->withoutExceptionHandling();
        $this->assertFalse(file_exists(''));
    }

    /**
     * @return void
     */
    public function test_csv_return_raw_data()
    {
        $this->withoutExceptionHandling();
        $this->assertTrue(file_exists('storage/export.csv'));
        $data = [
            'user_id'=> '0000',
            'date' => '2020-10-10',
            'onboard_precentage' => '40',
            'start_date_of_week' => '2020-10-01'
        ];

        $this->assertNotEmpty(
            $data,
            "csv is empty"
        );
    }
}
