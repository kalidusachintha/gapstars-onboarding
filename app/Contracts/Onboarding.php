<?php
namespace App\Contracts;

use Illuminate\Http\JsonResponse;

interface Onboarding
{
    public function getOnboardStepsPrecentage(): JsonResponse;
}
