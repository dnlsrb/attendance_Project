<?php
include('config/database/db_connect.php');

class accountController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    private function validateUserData($userData) {
        $errors = [];
          // old_password new_password confirm_password $_SESSION['password']

        // PASSWORD
        if(empty($userData['old_password'])){ 
            $errors['old_password'] = "old password is required!";
        } else {
 
            $old_password = $userData['old_password'];
            if(password_verify($old_password, $_SESSION['password'])){
                if(empty($userData['new_password'])){ 
                    $errors['new_password'] = "new password is required!";
                } else {
                    $confirm_password = $userData['confirm_password'];
                    $new_password = $userData['new_password'];
                    if($confirm_password != $new_password){
                        $errors['new_password'] = "password and confirmation password is not the same";
                    }
                    elseif(!preg_match('/^.{8,}$/',$new_password) ){
                        $errors['new_password'] = "password must be at least 8 characters long.";  
                    }
                }
                 
            }
            else {
                $errors['old_password'] = "Incorrect old password";
            }
        }

        return $errors;
    }

    public function UpdateUser($userData){
        $errors = $this->validateUserData($userData);
        if (!array_filter($errors)) {
            $hashedPassword = password_hash($userData['new_password'], PASSWORD_DEFAULT);
            $username = $_SESSION['username'];

            $sql = "UPDATE user SET user_password = '".$hashedPassword."' WHERE user_name = '".$username."'";

            if(mysqli_query($this->conn, $sql)){
                header('Location: account.php');
                exit(); // Redirect before script execution ends
            } else {
                echo 'query error: ' . mysqli_error($this->conn);
            }
        }


        return $errors;   
    }

    public function createUser($userData) {
        $errors = $this->validateUserData($userData);

        if (!array_filter($errors)) {
            $hashedPassword = password_hash($userData['user_password'], PASSWORD_DEFAULT);
            $sql = "INSERT INTO user(user_name, user_password, user_role, user_remark) 
                    VALUES('{$userData['user_name']}', '$hashedPassword', '0', '{$userData['user_remark']}')";
        
            if(mysqli_query($this->conn, $sql)){
                header('Location: user_management.php');
                exit(); // Redirect before script execution ends
            } else {
                echo 'query error: ' . mysqli_error($this->conn);
            }
        }

        
    }
    public function closeConnection() {
        mysqli_close($this->conn);
    }
}

$accountManager = new accountController($conn);
 
if(isset($_POST['updateUser'])){
    $userData = [
        'old_password' => mysqli_real_escape_string($conn, $_POST['old_password']),
        'new_password' => mysqli_real_escape_string($conn, $_POST['new_password']),
        'confirm_password' => mysqli_real_escape_string($conn, $_POST['confirm_password']),
 
    ];

    $errors = $accountManager->updateUser($userData);
 
}
$accountManager->closeConnection();

?>