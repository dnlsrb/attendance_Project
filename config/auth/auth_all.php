<?php
 
 
session_start();
class UserAuthenticator {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function authenticate($username, $password) {
        $username = mysqli_real_escape_string($this->conn, $username);
        $password = mysqli_real_escape_string($this->conn, $password);

        $login_query = "SELECT * FROM user WHERE user_name = '$username' && archived = 0";
        $login_result = mysqli_query($this->conn, $login_query);
        $row = mysqli_fetch_assoc($login_result);

        if ($row && $password == htmlspecialchars($row['user_password']) && $username == htmlspecialchars($row['user_name'])) {
            return true;
        } else {
            return false;
        }
    }
}
 

if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    include('config/database/db_connect.php');
    
    $authenticator = new UserAuthenticator($conn);
    
    if ($authenticator->authenticate($_SESSION['username'], $_SESSION['password'])) {
     
    } else {
        header("Location: config/Controller/logout.php");
        exit(); // Stop further execution
    }
} else {
    header("Location: index.php");
    exit(); // Stop further execution
}
?>