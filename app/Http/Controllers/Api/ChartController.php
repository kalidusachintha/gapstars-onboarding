<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Onboarding;
use App\Http\Controllers\Controller;

class ChartController extends Controller
{
    
    /**
     * Returns chart data
     * @retrun App\Contracts\Onboarding
     */
    public function getChartData(Onboarding $onboarding)
    {
        return $onboarding->getOnboardStepsPrecentage();
    }
}
