<?php
namespace App\Application\Services;

class InstrumentDuplicationRemovalService
{

    public function removeDuplicates(array $instruments): array
    {
        return array_values(array_unique($instruments));
    }
}
