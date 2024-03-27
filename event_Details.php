<?php

include('config/db_connect.php');

if(isset($_GET['id'])){

$id = mysqli_real_escape_string($conn, $_GET['id']);

// make sql
$sql = "SELECT * FROM event_list WHERE event_id = $id";

// get the query result
$result = mysqli_query($conn, $sql);
 
// one result
$user = mysqli_fetch_assoc($result);


// FREE RESULT FROM MEMORY
mysqli_free_result($result);


// CLOSE CONNECTION
mysqli_close($conn);
 
 

}


?>


<?php include('template/header.php');?>





<?php include('template/footer.php');?>