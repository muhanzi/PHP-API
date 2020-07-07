<?php

header ("Access-Control-Allow-Origin: *");
header("Access-Control-Max-Age: 3600");
header ("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'session.php';

// destroy session
if(session_destroy()){
    echo json_encode(array(
        "status" => 200,
        "message" => "user signed out successfully"
    ));
}else{
    echo json_encode(array(
        "status" => 500,
        "message" => "user signed out failed"
    ));
} 



?>