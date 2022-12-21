<?php
header("Access-Control-Allow-Origin: *");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// valid tokens - we can give this one token to those who call our api
	$valid_tokens = [
		'0cd5cb10880d70d7c45eb53c07a2757bf38e933b456fc1594e3ca9a3dd40d9e5',
	];
	
	// Check for the "Authorization" header
	if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
		http_response_code(401);
		echo json_encode(array('error' => 'Authorization header not found'));
		exit;
	}

	// Extract the token from the "Authorization" header
	$header = $_SERVER['HTTP_AUTHORIZATION'];
	$token = substr($header, strpos($header, ' ') + 1);

	// Validate the token
	if (!in_array($token, $valid_tokens)) {
		http_response_code(401);
		echo json_encode(array('error' => 'Invalid Token'));
		exit;
	}
	
    // Read the request body
    //$data = file_get_contents('php://input');
    //$data = json_decode($data);
    
    $data = $_POST;

	#######################################################
    // Insert the data into the database or whatever
	#######################################################
	
    // but for this exampke, we pass this data back to user
    echo json_encode(['data' => $data]);
}

