<?php 

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Instrument;
use App\Domain\Repositories\InstrumentRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class DonkiInstrumentRepository implements InstrumentRepository
{

    private Client $client;
    private array $endpoints;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('nasa.base_url'),
            'timeout' => 60.0,
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

    public function getAllInstruments(): array
    {

        $instruments = [];
        $startDate = '2024-06-01';
        $endDate = date("Y-m-d");

        foreach ($this->endpoints as $key => $endpoint) {
            $attempts = 0;
            $maxAttempts = 3;
    
            while ($attempts < $maxAttempts) {
                try {
                    Log::info("Iniciando solicitud para el endpoint: $endpoint");
    
                    $response = $this->client->get(config('nasa.base_url') . "DONKI/$endpoint", [
                        'query' => [
                            'startDate' => $startDate,
                            'endDate' => $endDate,
                            'api_key' => config('nasa.api_key'),
                        ]
                    ]);
                    if ($response->getStatusCode() === 200) {
                        Log::info("Solicitud exitosa para el endpoint: $endpoint");
                        $data = json_decode($response->getBody()->getContents(), true);
                        foreach ($data as $item) {
                            if (isset($item['instruments'])) {
                                foreach ($item['instruments'] as $instrument) {
                                    $instruments[] = $instrument['displayName'];
                                    Log::info("Instrumento: {$instrument['displayName']} - Endpoint: $endpoint");
                                }
                            }
                        }
                        break;
                    } else {
                        Log::warning("La respuesta para el endpoint $endpoint no fue exitosa. Código de estado: " . $response->getStatusCode());
                        break;
                    }
                } catch (RequestException $e) {
                    if ($e->getResponse() && $e->getResponse()->getStatusCode() == 429) {
                        Log::warning("Se alcanzó el límite de tasa para el endpoint $endpoint. Intentando nuevamente...");
                        $attempts++;
                        sleep(5);
                    } else {
                        Log::error('Error al obtener instrumentos de ' . $endpoint . ': ' . $e->getMessage());
                        break;
                    }
                }
            }
    
            if ($attempts >= $maxAttempts) {
                Log::error("Se alcanzó el límite de intentos para el endpoint $endpoint.");
            }
    
            Log::info("Finalizada la solicitud para el endpoint: $endpoint");
            sleep(1);
        }
        return $instruments;
    }

    public function getActivitiesByInstrument(string $instrument): array
    {
        $activities = [];
        $startDate = '2024-06-01';
        $endDate = date("Y-m-d");

        foreach ($this->endpoints as $endpoint) {
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
                    if (isset($item['instruments'])) {
                        foreach ($item['instruments'] as $inst) {
                            if ($inst['displayName'] === $instrument) {
                                $activities[] = $item['activityID'] ?? $item['flrID'] ?? $item['sepID'] ?? $item['mpcID'];
                            }
                        }
                    }
                }
            }
        }

        return array_filter($activities);
    }

}