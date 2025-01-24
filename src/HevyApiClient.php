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
            'base_uri' => 'https://api.hevyapp.com/v1',
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Accept' => 'application/json',
            ],
            'timeout' => 10, // Set a timeout for requests
        ]);
    }

    private function request($method, $endpoint, $data = [])
    {
        try {
            $response = $this->client->request($method, $endpoint, [
                'json' => $data,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            // Handle HTTP errors (4xx, 5xx)
            throw new \Exception(
                'Hevy API error: ' . $e->getResponse()->getBody()->getContents(),
                $e->getCode()
            );
        }
    }


    // User Endpoints
    public function getUser()
    {
        return $this->request('GET', '/user');
    }

    // Workout Endpoints
    public function getWorkouts()
    {
        return $this->request('GET', '/workouts');
    }

    public function getWorkoutById($id)
    {
        return $this->request('GET', "/workouts/$id");
    }

    public function createWorkout(array $data)
    {
        return $this->request('POST', '/workouts', $data);
    }

    public function updateWorkout($id, array $data)
    {
        return $this->request('PUT', "/workouts/$id", $data);
    }

    public function deleteWorkout($id)
    {
        return $this->request('DELETE', "/workouts/$id");
    }

    // Exercise Endpoints
    public function getExercises()
    {
        return $this->request('GET', '/exercises');
    }

    public function getExerciseById($id)
    {
        return $this->request('GET', "/exercises/$id");
    }

    public function createExercise(array $data)
    {
        return $this->request('POST', '/exercises', $data);
    }

    public function updateExercise($id, array $data)
    {
        return $this->request('PUT', "/exercises/$id", $data);
    }

    public function deleteExercise($id)
    {
        return $this->request('DELETE', "/exercises/$id");
    }

    // Set Endpoints
    public function getSets($workoutId)
    {
        return $this->request('GET', "/workouts/$workoutId/sets");
    }

    public function createSet($workoutId, array $data)
    {
        return $this->request('POST', "/workouts/$workoutId/sets", $data);
    }

    public function updateSet($workoutId, $setId, array $data)
    {
        return $this->request('PUT', "/workouts/$workoutId/sets/$setId", $data);
    }

    public function deleteSet($workoutId, $setId)
    {
        return $this->request('DELETE', "/workouts/$workoutId/sets/$setId");
    }

    // Measurement Endpoints
    public function getMeasurements()
    {
        return $this->request('GET', '/measurements');
    }

    public function getMeasurementById($id)
    {
        return $this->request('GET', "/measurements/$id");
    }

    public function createMeasurement(array $data)
    {
        return $this->request('POST', '/measurements', $data);
    }

    public function updateMeasurement($id, array $data)
    {
        return $this->request('PUT', "/measurements/$id", $data);
    }

    public function deleteMeasurement($id)
    {
        return $this->request('DELETE', "/measurements/$id");
    }

}

