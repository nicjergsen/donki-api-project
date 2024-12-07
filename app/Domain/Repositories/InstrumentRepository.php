<?php 

namespace App\Domain\Repositories;

use App\Domain\Entities\Instrument;

interface InstrumentRepository
{
    public function getAllInstruments(): array;
    public function getActivitiesByInstrument(string $instrument): array;
}
