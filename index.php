<?php
header('Content-Type: application/json');

// Only allow GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get number of tosses from query string
$times = isset($_GET['times']) ? (int) $_GET['times'] : 1;

// Safety limits
if ($times < 1) {
    $times = 1;
}
if ($times > 100) {
    $times = 100;
}

$results = [];
$heads = 0;
$tails = 0;

// Perform coin tosses
for ($i = 0; $i < $times; $i++) {
    $toss = rand(0, 1) === 0 ? 'heads' : 'tails';
    $results[] = $toss;

    if ($toss === 'heads') {
        $heads++;
    } else {
        $tails++;
    }
}

// Return response
echo json_encode([
    'tosses' => $times,
    'results' => $results,
    'summary' => [
        'heads' => $heads,
        'tails' => $tails
    ],
    'timestamp' => time()
]);
