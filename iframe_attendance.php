 
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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <!-- BOOTSTRAP ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="css/icon/fontawesome-free-6.5.2-web/css/fontawesome.css" rel="stylesheet">
    <link rel="stylesheet" href="css/icon/fontawesome-free-6.5.2-web/css/brands.css" rel="stylesheet">
    <link rel="stylesheet" href="css/icon/fontawesome-free-6.5.2-web/css/solid.css" rel="stylesheet">
    <link rel="stylesheet" href="css/icon/fontawesome-free-6.5.2-web/css/regular.css" rel="stylesheet">
</head>
<script>
    window.addEventListener('unload', function () {
        document.documentElement.innerHTML = '';
    });
</script>

<body>
    <!-- BOOTSTRAP JS-->
    <script src="js//bootstrapjs/bootstrap.min.js"></script>

<?php if(isset($attendees_Records)): ?>
  <p>Total Attendees: <?php echo $count_display?></p>
<table  >
<tr>
    <th>#</th>
      <!--<th>ID</th> -->
    <th>name</th>
    <!-- <th>email</th> -->
    <th>Time in</th>
    <th>Time out</th>
    <th></th>
</tr>   
<?php $count = 1;?>
<?php  echo '<tr>'; foreach( $attendees_Records as $Attendees):?>
<td><?php echo $count; ?></td>
<!-- <td><?php echo htmlspecialchars($Attendees['record_id']); ?></td> -->
<td><?php echo htmlspecialchars($Attendees['attendeesName']);  ?></td>
<!-- <td><?php echo htmlspecialchars($Attendees['attendeesEmail']);  ?></td> -->
<td><?php echo htmlspecialchars( $Attendees['time_IN']);?></td>
<td><?php echo htmlspecialchars($Attendees['time_OUT']);  ?></td>
<td>


<form   action="iframe_attendance.php?id=<?php echo htmlspecialchars($id);  ?>" method="POST">
<input type="hidden" name="delete_record" value="<?php echo $Attendees['record_id'];?>">
<input type="hidden" name="event_id" value="<?php echo $Attendees['event_id'];?>">
<input type="submit" name="delete" value="delete" >  
</form>
 


</td>
<?php $count++;?>
<?php 
echo '<tr>';   
endforeach;
unset($count);
?>
</table>


<?php else: ?>
<h3>No Attendees Yet</h3><br>
<?php endif ?>
 

</body>

</html>