<?php

namespace Purposebuiltscott\LaravelHevy;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class HevyApiClient
{
    protected $client;

    public function __construct($apiKey)
    {
        $this->client = new Client([
            'base_uri' => 'https://api.hevyapp.com/v1/',
            'headers' => [
                'api-key' => $apiKey,
                'Accept' => 'application/json',
            ],
            'timeout' => 10,
        ]);
    }

    private function request($method, $endpoint, $data = [])
    {
        try {
            $response = $this->client->request($method, $endpoint, [
                'query' => $data, // Using 'query' for GET requests with parameters
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            throw new \Exception(
                'Hevy API error: ' . ($e->getResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage()),
                $e->getCode()
            );
        }
    }


    // Workout Endpoints
    public function getWorkouts($page = 1, $pageSize = 5)
    {
        return $this->request('GET', 'workouts', [
            'page' => $page,
            'pageSize' => $pageSize,
        ]);
    }

    public function getWorkoutById($id)
    {
        return $this->request('GET', "workouts/$id");
    }

    /**
     * Get workout events
     *
     * @param int $page
     * @param int $pageSize
     * @param \Carbon\Carbon|null $since
     * @return array
     * @throws \Exception
     */
    public function getWorkoutEvents($page = 1, $pageSize = 5, ?\Carbon\Carbon $since = null)
    {
        $params = [
            'page' => $page,
            'pageSize' => $pageSize,
        ];

        if ($since) {
            $params['since'] = $since->utc()->format('Y-m-d\TH:i:s\Z');
        }

        return $this->request('GET', 'workouts/events', $params);
    }
    
    public function createWorkout(array $data)
    {
        return $this->request('POST', 'workouts', $data);
    }

    public function updateWorkout($id, array $data)
    {
        return $this->request('PUT', "workouts/$id", $data);
    }


    // Exercise Endpoints
    public function getExercises()
    {
        return $this->request('GET', 'exercise_templates');
    }

    public function getExerciseById($id)
    {
        return $this->request('GET', "exercise_templates/$id");
    }


    
}

