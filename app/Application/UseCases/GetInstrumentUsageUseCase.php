<?php
namespace App\Application\UseCases;

use App\Application\Services\InstrumentUsageService;

class GetInstrumentUsageUseCase
{
    private InstrumentUsageService $usageService;

    public function __construct(InstrumentUsageService $usageService)
    {
        $this->usageService = $usageService;
    }

    public function execute(): array
    {
        return $this->usageService->getInstrumentUsage();
    }
}
