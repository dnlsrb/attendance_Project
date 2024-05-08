 
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

<?php require('config/Controller/iframe_attendance_controller.php');?>
 

 
<style>
    
</style>



<!DOCTYPE html>
<html lang="en">
<meta http-equiv="refresh" content="3">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="css/style.css" rel="stylesheet">
    <!-- BOOTSTRAP CSS  -->
    <link rel="stylesheet" href="css/bootstrapcss/bootstrap.min.css">
 
    <!-- BOOTSTRAP ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="css/icon/fontawesome-free-6.5.2-web/css/fontawesome.css" rel="stylesheet">
    <link rel="stylesheet" href="css/icon/fontawesome-free-6.5.2-web/css/brands.css" rel="stylesheet">
    <link rel="stylesheet" href="css/icon/fontawesome-free-6.5.2-web/css/solid.css" rel="stylesheet">
    <link rel="stylesheet" href="css/icon/fontawesome-free-6.5.2-web/css/regular.css" rel="stylesheet">
</head>
 
 
<body  class="bg-transparent">
    <!-- BOOTSTRAP JS-->
    <script src="js//bootstrapjs/bootstrap.min.js"></script>

<?php if(!empty($attendees_Records) ): ?>
 
<table class=" no-background table table-transparent shadow-sm">
<tr >
    <th>#</th>
    <th>NAME</th>
    <th>TIME IN</th>
    <th>TIME OUT</th>
    <!-- <th></th> -->
</tr>   
<?php $count = 1;?>
<?php foreach( $attendees_Records as $Attendees):?>
<?php echo '<tr>';?>
<td><?php echo $count; ?></td>
<td class="fw-bold"><?php echo htmlspecialchars($Attendees['attendeesName']);  ?></td>
<td class="fw-bold text-success"><?php echo htmlspecialchars( $Attendees['time_IN']);?></td>
<td class="fw-bold text-primary  "><?php echo htmlspecialchars($Attendees['time_OUT']);  ?></td>
 
<?php $count++;?>
<?php 
echo '<tr>';   
endforeach;
unset($count);
?>
</table>


<?php else: ?>

    <div class="text-center my-5 rounded-1 ">
      
            <h class="display-6">Waiting for Attendees</h>
             
            </div>
<?php endif ?>
 

</body>

</html>