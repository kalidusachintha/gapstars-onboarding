<?php
namespace App\Contracts;

use Illuminate\Http\JsonResponse;

Interface Onboarding {

    public function getOnboardPrecentage(): JsonResponse;
    
}