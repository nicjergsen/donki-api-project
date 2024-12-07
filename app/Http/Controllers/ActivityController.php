<?php

namespace App\Http\Controllers;

use App\Application\UseCases\GetActivityIDsUseCase;
use Illuminate\Http\JsonResponse;

class ActivityController
{
    private GetActivityIDsUseCase $useCase;

    public function __construct(GetActivityIDsUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function index(): JsonResponse
    {
        $activityIDs = $this->useCase->execute();
        return response()->json([
            'activityIDs' => array_values($activityIDs),
        ]);
    }
}
