<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\InstrumentRepository;

class GetInstrumentActivityUsageUseCase
{
    private InstrumentRepository $repository;

    public function __construct(InstrumentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $instrument): array
    {
        $activities = $this->repository->getActivitiesByInstrument($instrument);

        $totalActivities = count($activities);
        if ($totalActivities === 0) {
            return [];
        }

        $activityCounts = array_count_values($activities);
        $activityUsage = [];
        foreach ($activityCounts as $activity => $count) {
            $activityUsage[$activity] = round($count / $totalActivities, 4);
        }

        return [
            $instrument => $activityUsage,
        ];
    }
}
