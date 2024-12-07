<?php
namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\ActivityRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class DonkiActivityRepository implements ActivityRepository
{
    private Client $client;
    private array $endpoints;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('nasa.base_url'),
            'timeout' => 10.0,
        ]);

        $this->endpoints = [
            'CME' => 'CME',
            'FLR' => 'FLR',
            'SEP' => 'SEP',
            'MPC' => 'MPC',
            'RBE' => 'RBE',
            'HSS' => 'HSS',
            'WSAEnlilSimulation' => 'WSAEnlilSimulations',
        ];
    }

    public function getActivityIDs(): array
    {
        $activityIDs = [];
        $startDate = '2024-06-01';
        $endDate = date("Y-m-d");

        foreach ($this->endpoints as $endpoint) {
            try {
                $response = $this->client->get("DONKI/$endpoint", [
                    'query' => [
                        'api_key' => config('nasa.api_key'),
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                    ],
                ]);

                if ($response->getStatusCode() === 200) {
                    $data = json_decode($response->getBody()->getContents(), true);

                    foreach ($data as $item) {
                        foreach ($item as $key => $value) {
                            if (str_ends_with($key, 'ID')) {
                                $activityIDs[] = $this->cleanActivityID($value);
                            }
                        }
                    }
                }
            } catch (GuzzleException $e) {
                Log::error("Error del $endpoint: " . $e->getMessage());
            }
        }

        return array_unique($activityIDs);
    }

    private function cleanActivityID(string $activityID): string
    {
        $parts = explode('-', $activityID);
        return $parts[count($parts) - 2] . '-' . end($parts);
    }
}
