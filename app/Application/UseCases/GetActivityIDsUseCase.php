<?php
namespace App\Application\UseCases;

use App\Domain\Repositories\ActivityRepository;

class GetActivityIDsUseCase
{
    private ActivityRepository $repository;

    public function __construct(ActivityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array
    {
        return $this->repository->getActivityIDs();
    }
}
