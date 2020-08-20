<?php

header ("Access-Control-Allow-Origin: *");
header("Access-Control-Max-Age: 3600");
header ("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: X-Requested-With,Content-Type");


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lapisha_rentals_system";
$table_name = "users";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// create database if it is not already existing
$sql_create_db = "CREATE DATABASE IF NOT EXISTS " . $dbname . "";
if ($conn->query($sql_create_db) === TRUE) {
    // Database created successfully // don't put here any response or echo // because it may create a confusion because this file is also included in others like signin.php or signup.php which have their own responses
    // that will be a problem because if a request is sent to signin.php // it may produce 2 responses // one from this file and another one from signin.php
    // will confuse the response data if this file is also included in others
    // !!!!!!!!!! we should only produce one response per request 
} else {
    echo "Something went wrong. failed to create database Error: ". $conn->error;
}


// connect to database "lapisha_rentals_system" 
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// create table "users" if it is not already existing
$sql_create_table = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(200) NOT NULL
    )";

if ($conn->query($sql_create_table) === TRUE) {
    // users table created successfully
    // don't put here any response or echo // because it may create a confusion because this file is also included in others like signin.php or signup.php which have their own responses
    // that will be a problem because if a request is sent to signin.php // it may produce 2 responses // one from this file and another one from signin.php
    // will confuse the response data if this file is also included in others
    // !!!!!!!!!! we should only produce one response per request 
} else {
    echo "Something went wrong. failed to create table. Error: ". $conn->error;
}    

$conn->close();  // closes connection

?>