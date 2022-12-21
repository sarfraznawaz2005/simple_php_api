<?php

function logMessage($level, $message, $context = []) {
    
    // Set the log level names
    $levelNames = [
        'emergency' => 'EMERGENCY',
        'alert' => 'ALERT',
        'critical' => 'CRITICAL',
        'error' => 'ERROR',
        'warning' => 'WARNING',
        'notice' => 'NOTICE',
        'info' => 'INFO',
        'debug' => 'DEBUG',
    ];

    // Set the log format
    $logFormat = "[%datetime%] %level_name%: %message%\n";

    // Set the log date format
    $dateFormat = "Y-m-d H:i:s";

    // Get the current date and time
    $date = new DateTime();
    $datetime = $date->format($dateFormat);

    // Get the log level name
    $levelName = $levelNames[$level];

    // Build the log message
    $logMessage = str_replace(
        ['%datetime%', '%level_name%', '%message%'],
        [$datetime, $levelName, $message],
        $logFormat
    );

    // Add the context data to the log message
    foreach ($context as $key => $value) {
        $logMessage .= "$key: $value\n";
    }

	$logMessage .= "\n";

    // Open the log file for writing
    $logFile = fopen("log.txt", "a") or die("Unable to open file!");

    // Lock the log file to prevent race conditions
    flock($logFile, LOCK_EX);

    // Write the log message to the file
    fwrite($logFile, $logMessage);

    // Unlock the log file
    flock($logFile, LOCK_UN);

    // Close the log file
    fclose($logFile);
}

function generateToken() {
    // Use the OpenSSL library to generate a random token
    $token = openssl_random_pseudo_bytes(16);

    // Hash the token to create a unique, 32-character hexadecimal string
    $token = hash('sha256', $token);

    return $token;
}
