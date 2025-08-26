<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

// Create a HTTP client
$client = new Client([
    'timeout' => 10, 
]);

// API Endpoints
$apis = [
    'Travel Guides' => 'https://jsonplaceholder.typicode.com/users',
    'Adventure Tourists' => 'https://rickandmortyapi.com/api/character',
];

// Store normalized results
$aggregatedData = [];

// Function to normalize Travel Guides (API A)
function normalizeTravelGuides(array $data): array {
    $normalized = [];
    foreach ($data as $item) {
        $normalized[] = [
            'id' => $item['id'] ?? null,
            'name' => $item['name'] ?? 'Unknown',
            'type' => 'User',
            'status' => 'Active',
            'gender' => 'N/A',
            'location' => $item['address']['city'] ?? 'N/A',
            'contact' => $item['email'] ?? 'N/A',
            'company' => $item['company']['name'] ?? 'N/A',
            'image' => 'https://via.placeholder.com/150',
            'url' => 'https://jsonplaceholder.typicode.com/users/' . ($item['id'] ?? ''),
            'origin' => 'Travel Guides',
        ];
    }
    return $normalized;
}

// Function to normalize Adventure Tourists (API B)
function normalizeAdventureTourists(array $data): array {
    $normalized = [];
    if (!isset($data['results'])) return $normalized;

    foreach ($data['results'] as $item) {
        $normalized[] = [
            'id' => $item['id'] ?? null,
            'name' => $item['name'] ?? 'Unknown',
            'type' => $item['species'] ?? 'Unknown',
            'status' => $item['status'] ?? 'Unknown',
            'gender' => $item['gender'] ?? 'Unknown',
            'location' => $item['location']['name'] ?? 'Unknown',
            'contact' => 'N/A', // no contact info in API B
            'company' => $item['origin']['name'] ?? 'N/A',
            'image' => $item['image'] ?? '',
            'url' => $item['url'] ?? '',
            'origin' => 'Adventure Tourists',
        ];
    }
    return $normalized;
}

// Fetch and normalize data from both APIs
foreach ($apis as $origin => $url) {
    try {
        $response = $client->get($url);
        if ($response->getStatusCode() !== 200) {
            throw new Exception("HTTP Error: " . $response->getStatusCode());
        }
        $data = json_decode($response->getBody()->getContents(), true);

        if ($origin === 'Travel Guides') {
            $aggregatedData = array_merge($aggregatedData, normalizeTravelGuides($data));
        } else {
            $aggregatedData = array_merge($aggregatedData, normalizeAdventureTourists($data));
        }
    } catch (RequestException $e) {
        error_log("Error fetching {$origin}: " . $e->getMessage());
        // Continue with other API
    } catch (Exception $e) {
        error_log("General error for {$origin}: " . $e->getMessage());
    }
}

// Output as JSON
header('Content-Type: application/json');
echo json_encode($aggregatedData, JSON_PRETTY_PRINT);
