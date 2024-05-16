<?php

// Get the current timestamp from a trusted time server
$trustedTime = file_get_contents('http://worldtimeapi.org/api/ip');

// Parse the JSON response
$timeData = json_decode($trustedTime, true);

// Get the current time from the time server
$serverTime = strtotime($timeData['datetime']);

// Get the client's current time
$clientTime = time();

// Define a threshold for time difference (in seconds)
$timeDifferenceThreshold = 60; // 1 minute difference threshold

// Calculate the time difference
$timeDifference = abs($serverTime - $clientTime);

// Check if the time difference is within the threshold
if ($timeDifference <= $timeDifferenceThreshold) {
    
} else {
    header('Location: error/400.php');
}


?>