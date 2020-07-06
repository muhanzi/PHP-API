<?php

header ("Access-Control-Allow-Origin: *");
header("Access-Control-Max-Age: 3600");
header ("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'session.php';

// remove session variables
session_unset(); 
// destroy session
if(session_destroy()){
    http_response_code(200);
    echo json_encode(array(
        "status" => 200,
        "message" => "user signed out successfully"
    ));
}else{
    http_response_code(500);
    echo json_encode(array(
        "status" => 500,
        "message" => "user signed out failed"
    ));
} 



?>