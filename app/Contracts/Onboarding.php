<?php
namespace App\Contracts;

use Illuminate\Http\JsonResponse;

/**
 * should be implemented in to any service class that uses different sources for chart data
 */
interface Onboarding
{
    /**
     * Generate precentage amount for each step that needs to chart
     * @return JsonResponse
     */
    public function getOnboardStepsPrecentage(): JsonResponse;
}
