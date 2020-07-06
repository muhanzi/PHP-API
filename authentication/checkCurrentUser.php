<?php
// required headers
header ("Access-Control-Allow-Origin: *");
header("Access-Control-Max-Age: 3600");
header ("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if($_SERVER['REQUEST_METHOD'] != "GET") {
    http_response_code(405); // method not allowed
    echo json_encode(array("message" => "only GET method is allowed","status" => 405));
    exit(405);
}

include_once 'session.php';

if (isset($_SESSION['user_id']) && isset($_SESSION['user_firstname']) 
  && isset($_SESSION['user_lastname']) && isset($_SESSION['user_email'])) {
    http_response_code(200);
    echo json_encode(array(
        "status" => 200,
        "session_data" => array(
            "user_id" => $_SESSION['user_id'],
            "user_firstname" => $_SESSION['user_firstname'],
            "user_lastname" => $_SESSION['user_lastname'],
            "user_email" => $_SESSION['user_email']
        ),
        "message" => "there is a session",
    ));
}else{
    http_response_code(401);
    echo json_encode(array(
        "message" => "there is no current user",
        "status" => 401,
        "user_data" => array()
    ));
}


?>