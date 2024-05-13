
<?php 
include_once('config/database/db_connect.php');

class UserManagementController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
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

        return $errors;
    }

    public function deleteUser($userId) {
        $delete_user_id = mysqli_real_escape_string($this->conn, $userId);
        $sql = "UPDATE user SET archived = 1 WHERE user_id = $delete_user_id";
        
        if(mysqli_query($this->conn, $sql)){
            header('Location: user_management.php');
            exit(); // Redirect before script execution ends
        } else {
            echo 'query error: ' . mysqli_error($this->conn);
        }
    }

    public function getAllUsers() {
        $sqlDisplay = "SELECT * FROM user WHERE user_id > 1 && archived = 0";
        $result = mysqli_query($this->conn, $sqlDisplay);
        $userList = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        return $userList;
    }

    public function getUser($data){
        $sqlDisplay = "SELECT * FROM user WHERE user_id = {$data} ";
        $result = mysqli_query($this->conn, $sqlDisplay);
        $selectedUser = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
         
        return $selectedUser;
    }
    private function validateUserData($userData) {
        $errors = [];

        // REMARK
        if(strlen($userData['user_remark']) > 254){
            $errors['user_remark'] = "max is 255 letters";
        }

        // PASSWORD
        if(empty($userData['user_password'])){ 
            $errors['user_password'] = "password is required!";
        } else {
            $confirm_password = $userData['confirm_password'];
            $user_password = $userData['user_password'];
            if($confirm_password != $user_password){
                $errors['user_password'] = "password and confirmation password is not the same";
            }
            elseif(!preg_match('/^.{8,}$/',$user_password) ){
                $errors['user_password'] = "password must be at least 8 characters long.";  
            }
        }

        // USERNAME
        if(empty($userData['user_name'])){
            $errors['user_name'] = "username is required!";
        } else {
            $query =  "SELECT user_name FROM user WHERE user_name='".$userData['user_name']."'";
            $result_user = mysqli_query($this->conn, $query);
            if(mysqli_num_rows($result_user) != 0){
                $errors['user_name'] = "user already existed";
            }
        }

        return $errors;
    }

    public function UpdateUser($sql){

        return(mysqli_query($this->conn, $sql));             
    }

    public function closeConnection() {
        mysqli_close($this->conn);
    }
}

// Usage
$userManager = new UserManagementController($conn);

if(isset($_POST['createSubmit'])){
    $userData = [
        'user_name' => mysqli_real_escape_string($conn, $_POST['user_name']),
        'user_password' => mysqli_real_escape_string($conn, $_POST['user_password']),
        'confirm_password' => mysqli_real_escape_string($conn, $_POST['confirm_password']),
        'user_role' => 0,
        'user_remark' => mysqli_real_escape_string($conn, $_POST['user_remark'])
    ];

    $errors = $userManager->createUser($userData);
 
}

if(isset($_POST['delete_user'])){
    $userManager->deleteUser($_POST['delete_user_id']);
}

if (isset($_POST['editSubmit'])) {
 
 
            foreach($_POST['user_id'] as $userCount => $userUpdate){
               
                if(isset($_POST['user_remark'][$userCount])){
                    $user_remark = mysqli_escape_string($conn, $_POST['user_remark'][$userCount]);
                    
                    $sql = "UPDATE user SET user_remark = '$user_remark' WHERE user_id = $userUpdate";
                    
                    $userManager->UpdateUser($sql);
                }
                if (isset($_POST['user_role'][$userCount])) {
                    $user_role = mysqli_escape_string($conn, $_POST['user_role'][$userCount]);
 

                    $sql = "UPDATE user SET user_role = $user_role WHERE user_id = $userUpdate";
                    $userManager->UpdateUser($sql);
                     
                }
                if (isset($_POST['isArchive'][$userCount])) {
                    $isArchive = mysqli_escape_string($conn, $_POST['isArchive'][$userCount]);
  
                    
                    $sql = "UPDATE user SET archived = 1 WHERE user_id = $isArchive";
                    
                    $userManager->UpdateUser($sql);
                }
         
            }
    // user_remark[] user_role[] isArchive []


 
     
} 
 

$userList = $userManager->getAllUsers();
$userManager->closeConnection();
?>