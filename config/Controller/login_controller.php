<?php
 
session_start();
include_once('config/database/db_connect.php');
class loginController{
    private $conn;
  
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
 
    public function rememberMe($username, $password, $remember_me) {
        if ($remember_me) {
            // Generate a random token
            $token = bin2hex(random_bytes(16));

            // Save the token to the database or any other storage mechanism you prefer
            $login_query = "UPDATE user SET remember_token = '$token' WHERE user_name = '$username'";
            mysqli_query($this->conn, $login_query);

            // Set the "Remember Me" cookie
            $cookie_value = $username . ':' . $token;
            setcookie('remember_me', $cookie_value, time() + (86400 * 30), '/'); // 30 days expiry
        }
    }

    public function cookieSet($remember_token){
        if ($remember_token) {
            list($cookie_username, $token) = explode(':', $_COOKIE['remember_me']);

            $login_query = "SELECT * FROM user WHERE user_name = '$cookie_username' && remember_token = '$token' && archived = 0";
            $login_result = mysqli_query($this->conn, $login_query);
            $row = mysqli_fetch_assoc($login_result);
 
            if ($row) {
                $_SESSION['username'] = $row['user_name'];
                $_SESSION['password'] = $row['user_password'];
                $_SESSION['role'] = $row['user_role'];
                mysqli_free_result($login_result);

                $this->closeConnection();
                header("Location: event_List.php");
                exit();
            }
        }
    }

    public function loginAuthentication($username, $password, $remember_me) {
 
        $login_query = "SELECT * FROM user WHERE user_name = '$username' && archived = 0";
        $login_result = mysqli_query($this->conn, $login_query);
        $row = mysqli_fetch_assoc($login_result);

        if ($row && password_verify($password, $row['user_password'])) {
            $_SESSION['username'] = $row['user_name'];
            $_SESSION['password'] = $row['user_password'];
            $_SESSION['role'] = $row['user_role'];
            
            mysqli_free_result($login_result);
         
            $this->rememberMe($username, $password, $remember_me);
            
            header("Location: event_List.php");
            exit();
        } else {
            mysqli_free_result($login_result);
            header("Location: index.php?error=User not found");
        }
    }


    public function closeConnection() {
        mysqli_close($this->conn);
    }
}

$loginProcess = new loginController($conn);
if(isset($_COOKIE['remember_me'])){ 
$loginProcess->cookieSet(mysqli_real_escape_string($conn, $_COOKIE['remember_me']));
}

if(isset($_POST['submit'])){

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$remember_me= mysqli_real_escape_string($conn, $_POST['remember_me']);

$loginProcess->loginAuthentication($username, $password, $remember_me);
$loginProcess->closeConnection();
}
 


?>