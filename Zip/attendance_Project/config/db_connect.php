 

<?php
 
// GET DATA
// hostname / username / password / database
$conn = mysqli_connect(
// hostname 
'localhost', 
// username
'ojt', 
//  password 
'123123', 
// database
'attendanceProject'
);

if(!$conn){
  die( 'Connection' . mysqli_connect_error());
}else{
 
}
 

date_default_timezone_set('Asia/Taipei');
?>
 