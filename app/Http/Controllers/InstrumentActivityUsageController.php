<?php

namespace App\Http\Controllers;

use App\Application\UseCases\GetInstrumentActivityUsageUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InstrumentActivityUsageController
{
    private GetInstrumentActivityUsageUseCase $useCase;

    public function __construct(GetInstrumentActivityUsageUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function index(Request $request): JsonResponse
    {
        $instrument = $request->input('instrument');
        if (!$instrument) {
            return response()->json(['error' => 'El Instrumento es requerido'], 400);
        }

        $result = $this->useCase->execute($instrument);

        return response()->json([
            'instrument_activity' => $result,
        ]);
    }
}
