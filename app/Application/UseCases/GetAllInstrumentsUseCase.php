<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\InstrumentRepository;
use App\Application\Services\InstrumentDuplicationRemovalService;

class GetAllInstrumentsUseCase
{
    private InstrumentRepository $repository;
    private InstrumentDuplicationRemovalService $duplicationRemovalService;

    public function __construct(InstrumentRepository $repository, InstrumentDuplicationRemovalService $duplicationRemovalService)
    {
        $this->repository = $repository;
        $this->duplicationRemovalService = $duplicationRemovalService;
    }

    public function execute(): array
    {
        $instruments = $this->repository->getAllInstruments();
        $uniqueInstruments = $this->duplicationRemovalService->removeDuplicates($instruments);

        return $uniqueInstruments;
    }
}
