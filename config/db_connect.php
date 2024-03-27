<?php
session_start();
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
  echo  'connection with database is connected';
}


date_default_timezone_set('Asia/Taipei');
?>