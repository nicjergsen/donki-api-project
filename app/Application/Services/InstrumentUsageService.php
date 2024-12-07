<?php

namespace App\Application\Services;

use App\Domain\Repositories\InstrumentRepository;

class InstrumentUsageService
{
    private InstrumentRepository $repository;

    public function __construct(InstrumentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getInstrumentUsage(): array
    {
        $instruments = $this->repository->getAllInstruments();
        $totalInstruments = count($instruments);
        if ($totalInstruments === 0) {
            return [];
        }
        $usageCounts = array_count_values($instruments);
        $instrumentUsage = [];
        foreach ($usageCounts as $instrument => $count) {
            $instrumentUsage[$instrument] = round($count / $totalInstruments, 4);
        }

        return $instrumentUsage;
    }
}
