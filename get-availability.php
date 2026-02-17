<?php
require __DIR__ . '/vendor/autoload.php';

use Google\Client;
use Google\Service\Calendar;

// Simple safety
header('Content-Type: application/json');

// Calendar ID passed from frontend
$calendarId = $_GET['calendar'] ?? null;

if (!$calendarId) {
  http_response_code(400);
  echo json_encode(["error" => "Missing calendar id"]);
  exit;
}

// Google client
$client = new Client([
  'curl' => [CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4]
]);
$client->setApplicationName('Free Walking Tour Curaçao');
$client->setScopes([Calendar::CALENDAR_READONLY]);
$client->setAuthConfig(__DIR__ . DIRECTORY_SEPARATOR . 'secure' . DIRECTORY_SEPARATOR . 'calendar-key.json');

$client->setAccessType('offline');

$service = new Calendar($client);

// Time window: today → +3 months
$params = [
  'timeMin' => date('c'),
  'timeMax' => date('c', strtotime('+3 months')),
  'singleEvents' => true,
  'orderBy' => 'startTime',
];

$events = $service->events->listEvents($calendarId, $params);

// Extract dates
$availableDates = [];

foreach ($events->getItems() as $event) {
  $start = $event->getStart()->getDateTime()
        ?? $event->getStart()->getDate();

  if ($start) {
    $availableDates[] = substr($start, 0, 10);
  }
}

echo json_encode(array_values(array_unique($availableDates)));
