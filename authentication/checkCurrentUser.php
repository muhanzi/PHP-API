<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] != "GET") {
    http_response_code(403); // forbidden
    echo json_encode(array("message" => "only GET method is allowed"));
    exit(403);
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
        )
    ));
}else{
    http_response_code(401);
    echo json_encode(array(
        "message" => "there is no current user",
        "status" => 401,
        "user_data" => []
    ));
}


?>