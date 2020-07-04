<?php

class DatabaseConnection {
    private $servername = "localhost";
    private $dbname = "lapisha_rentals_system";
    private $username = "root";
    private $password = "";
    public $conn;

    // get the database connection
    public function getConnection(){
  
        $this->conn = null;

        // Create connection
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
  
        return $this->conn;
    }
}

?>