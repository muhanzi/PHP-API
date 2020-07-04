<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if($_SERVER['REQUEST_METHOD'] != "POST") {
    http_response_code(403); // forbidden
    echo json_encode(array("message" => "only POST method is allowed"));
    exit(403);
}

include_once 'session.php';
include_once '../config/core.php';  // just to create database and users table if they don't exits
include_once '../config/databaseConnection.php';
include_once '../objects/user.php';

$db_connection = new databaseConnection();
$connection = $db_connection->getConnection();
  
$user = new User($connection);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));

// validate
if(isset($data->email) && isset($data->password)){
    if(!empty($data->email) && !empty($data->password)){
  
        // set user object properties
        $user->email = $data->email;
        $user->password = $data->password;
      
        $sign_in_results = $user->sign_in(); // returns an array
    
        if(isset($sign_in_results['status'])){
            if($sign_in_results['status'] === 200){
                http_response_code(200);
                echo json_encode(array(
                    "message" => $sign_in_results['message'],
                    "status" => 200,
                    "user_data" => array(
                        "id" => $user->id,
                        "firstname" => $user->firstname,
                        "lastname" => $user->lastname,
                        "email" => $user->email
                    ),
                    "session_data" => array(
                        "user_id" => $_SESSION['user_id'],
                        "user_firstname" => $_SESSION['user_firstname'],
                        "user_lastname" => $_SESSION['user_lastname'],
                        "user_email" => $_SESSION['user_email']
                    )
                ));
            }else{
                http_response_code($sign_in_results['status']);
                echo json_encode(array(
                    "message" => $sign_in_results['message'],
                    "status" => $sign_in_results['status']
                ));
            }
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
        "message" => "user credentials are required",
        "status" => 400
    )); 
}

?>