<?php


// required headers
header ("Access-Control-Allow-Origin: *");
header("Access-Control-Max-Age: 3600");
header ("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if($_SERVER['REQUEST_METHOD'] != "POST") {
    http_response_code(405); // method not allowed
    echo json_encode(array("message" => "only POST method is allowed","status" => 405));
    exit(405);
}

include_once 'session.php';
include_once '../config/core.php';  // just to create database and users table if they don't exits yet
include_once '../config/databaseConnection.php';
include_once '../objects/user.php';

$db_connection = new databaseConnection();
$connection = $db_connection->getConnection();
  
$user = new User($connection);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));

// validate
if(isset($data->firstname) && isset($data->lastname) && 
isset($data->email) && isset($data->password)){
    if(!empty($data->firstname) && !empty($data->lastname) &&
    !empty($data->email) && !empty($data->password)){
        
        // set user object properties
        $user->firstname = $data->firstname;
        $user->lastname = $data->lastname;
        $user->email = $data->email;
        $user->password = $data->password;
        
        $sign_up_results = $user->sign_up(); // returns an array

        if(isset($sign_up_results['status'])){
            http_response_code($sign_up_results['status']);
            echo json_encode(array(
                "message" => $sign_up_results['message'],
                "status" => $sign_up_results['status']
            ));
        }else{
            http_response_code(500);
            echo json_encode(array(
                "message" => "an error occurred",
                "status" => 500
            )); 
        }
    }else{
        http_response_code(400);
        echo json_encode(array(
            "message" => "user data has empty fields",
            "status" => 400
        )); 
    }
}else{
    http_response_code(400);
    echo json_encode(array(
        "message" => "user data is required",
        "status" => 400
    )); 
}


?>