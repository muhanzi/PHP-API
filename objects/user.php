<?php 

class User {
  
    // database connection and table name
    private $conn;
    private $table_name = "users";
  
    // object properties
    public $id;
    public $firstname; 
    public $lastname;
    public $email;
    public $password;
  
    // constructor with $db_connection as database connection
    public function __construct($db_connection){
        $this->conn = $db_connection;
    }

    function sign_up(){
        // validate
        if(isset($this->firstname) && isset($this->lastname) 
        && isset($this->email) && isset($this->password)
        && isset($this->conn)){
            // sanitize properties
            $this->firstname=htmlspecialchars(strip_tags($this->firstname));  // remove special characters
            $this->lastname=htmlspecialchars(strip_tags($this->lastname));
            // hash password
            $this->password=password_hash($this->password, PASSWORD_DEFAULT);
            // sql query
            $query = "INSERT INTO " . $this->table_name . " (firstname, 
            lastname, email, password) VALUES (?,?,?,?)";
            // prepare statement
            $stmt = $this->conn->prepare($query);
            // bind values
            $stmt->bind_param("ssss", $this->firstname, $this->lastname, 
            $this->email, $this->password);  // the "ssss" characters represent the data types passed to the query  --> // i - integer // d - double // s - string // b - BLOB

            // execute query
            if($stmt->execute()){
                //echo "user details saved successfully";
                return array(
                    "message" => "user details saved successfully",
                    "status" => 200
                );
            }else{
                return array(
                    "message" => "user sign up failed",
                    "status" => 500
                );
            }            
        }
        
        return array(
            "message" => "bad request",
            "status" => 400
        );

    } 

    function sign_in(){
        // validate
        if(isset($this->email) && isset($this->password) && isset($this->conn)){
            // sql query
            $query = "SELECT * FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1"; // retrieve one row // range from index [0-->1]
            // prepare statement
            $stmt = $this->conn->prepare($query);
            // bind values
            $stmt->bind_param("s", $this->email);  // the "s" character represent the data type passed to the query  --> // i - integer // d - double // s - string // b - BLOB
            // execute query
            if($stmt->execute()){
                // get retrieved row
                $row = $stmt->get_result()->fetch_assoc();
                if($row['password'] != null){
                    // verify password
                    if(password_verify($this->password, $row['password'])){
                        // the user password matches the hash in the database
                        // set user details
                        $this->id = $row['id'];
                        $this->firstname = $row['firstname'];
                        $this->lastname = $row['lastname'];
                        $this->email = $row['email'];
                        // start user session or resume it
                        include_once '../authentication/session.php';
                        $_SESSION['user_id']=$this->id;
                        $_SESSION['user_firstname']=$this->firstname;
                        $_SESSION['user_lastname']=$this->lastname;
                        $_SESSION['user_email']=$this->email;
                        return array(
                            "message" => "user signed in successfully",
                            "status" => 200
                        );
                    }else{
                        return array(
                            "message" => "the password is incorrect",
                            "status" => 401
                        );
                    }
                }else{
                    return array(
                        "message" => "the user credentials are wrong",
                        "status" => 401
                    );
                }
            }else{
                return array(
                    "message" => "user sign in failed",
                    "status" => 500
                );
            }     
        }else{
            return array(
                "message" => "bad request",
                "status" => 400
            );
        }
    }

}

?>