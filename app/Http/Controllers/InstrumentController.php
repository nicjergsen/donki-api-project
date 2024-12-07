<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\UseCases\GetAllInstrumentsUseCase;
use App\Application\UseCases\GetInstrumentUsageUseCase;
use App\Application\UseCases\GetInstrumentActivityUsageUseCase;
use Illuminate\Http\JsonResponse;

class InstrumentController extends Controller
{
    private GetAllInstrumentsUseCase $getAllInstrumentsUseCase;
    private GetInstrumentUsageUseCase $getInstrumentUsageUseCase;
    private GetInstrumentActivityUsageUseCase $getInstrumentActivityUsageUseCase;

    public function __construct(
        GetAllInstrumentsUseCase $getAllInstrumentsUseCase,
        GetInstrumentUsageUseCase $getInstrumentUsageUseCase,
        GetInstrumentActivityUsageUseCase $getInstrumentActivityUsageUseCase
    ) {
        $this->getAllInstrumentsUseCase = $getAllInstrumentsUseCase;
        $this->getInstrumentUsageUseCase = $getInstrumentUsageUseCase;
        $this->getInstrumentActivityUsageUseCase = $getInstrumentActivityUsageUseCase;
    }

    public function index(): JsonResponse
    {
        $instruments = $this->getAllInstrumentsUseCase->execute();
        return response()->json($instruments);
    }

    public function usage(): JsonResponse
    {
        $usage = $this->getInstrumentUsageUseCase->execute();
        return response()->json($usage);
    }
}
