<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<span>This will be used only for development </span><a  href="../../index.php">go back</a>
<form action="db_create.php" method="GET">
<input type="text" name="run">
<input type="submit" value="submit" name="submit">
</form>
    <?php 
  session_start();
 

$query = [];

array_push($query, "CREATE TABLE `attendance_records` (
  `record_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `attendeesName` varchar(255) NOT NULL,
  `attendeesEmail` varchar(255) NOT NULL,
  `time_IN` varchar(255) NOT NULL,
  `time_OUT` varchar(255) NOT NULL,
   `created_At` datetime NOT NULL DEFAULT current_timestamp(),
  `archived` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");


array_push($query, "ALTER TABLE `attendance_records` ADD PRIMARY KEY (`record_id`);");


array_push($query, "CREATE TABLE `event_list` (
  `event_id` int(11) NOT NULL,
  `event_count` int(11) NOT NULL,
  `eventName` varchar(255) NOT NULL,
  `eventBackgroundImage` varchar(255) NOT NULL,
  `eventHeaderImage` varchar(255) NOT NULL,
  `eventStart` date NOT NULL,
  `eventEnd` date NOT NULL,
  `created_At` datetime NOT NULL DEFAULT current_timestamp(),
  `archived` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

array_push($query, "ALTER TABLE `event_list`
  ADD PRIMARY KEY (`event_id`);");
 
  
array_push($query, "CREATE TABLE `user` (
    `user_id` int(11) NOT NULL,
    `user_name` varchar(100) NOT NULL,
    `user_password` varchar(255) NOT NULL,
    `user_role` tinyint(1) NOT NULL,
    `user_remark` varchar(255) NULL,
    `created_At` datetime NOT NULL DEFAULT current_timestamp(),
    `archived` tinyint(1) NOT NULL,
    `remember_token` varchar(255) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

array_push($query, "ALTER TABLE `user`
ADD PRIMARY KEY (`user_id`);");
  
array_push($query, "ALTER TABLE `user`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;");

$password = "admin";
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

//  1 = admin
//  0 = user

array_push($query, "INSERT INTO `user` (`user_name`, `user_password`, `user_role`) 
VALUES ('admin', '$hashedPassword', 1);");

if(isset($_GET['submit'])){
    $run = $_GET['run'];
   
   
    if($run == "runsql"){
    sql_CreateDB();
    sql_Query($query);
    }
    elseif($run == "DROPALL"){
    sql_DropAll();
    }
    else{
    echo '
    <script>
    alert("Wrong Input Key");
    </script>';
    }
}
?>
 

<?php
 
function sql_DropAll(){
    
$override = mysqli_connect(
'localhost',
'root',
'',
); 
mysqli_query($override, 
"DROP DATABASE attendanceproject"
);
mysqli_query($override, 
"DROP USER 'ojt'@'localhost';"
);
echo 'all data has been deleted';
mysqli_close($override);  
}

function sql_CreateDB(){
 
$override = mysqli_connect(
'localhost',
'root',
'',
);

mysqli_query($override, 
"GRANT ALL PRIVILEGES ON *.* TO `ojt`@`localhost` IDENTIFIED BY PASSWORD '*E56A114692FE0DE073F9A1DD68A00EEB9703F3F1' WITH GRANT OPTION;"
);
mysqli_query($override, 'GRANT ALL PRIVILEGES ON `mysql`.* TO `ojt`@`localhost`');

try {
  
mysqli_query($override, 'CREATE DATABASE attendanceproject' );

echo '<br><b>query: </b> CREATE DATABASE attendance_records <br><span style="color:green;">executed successfully</span>';
    }
    catch(mysqli_sql_exception $e){
        echo '<br><b>Error with query: </b><span style="color:red;"> CREATE DATABASE attendance_records </span><br><b>Error Message: '. $e .' </b>' ;
    }
    finally{
        echo "<br> Creating Database Finished";
    }
mysqli_close($override);      
}

function sql_Query($query){
  
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

 


    $q = 0;
    // print_r($query);

    echo '<br/>';
     
   
   for ($q = 0; $q <  count($query); $q++){ 
    echo "<hr>";
    try {
 
    mysqli_query($conn, $query[$q]);
    echo '<br><b>query: </b>'. $query[$q] .'<br><span style="color:green;">executed successfully</span>';
    }
    catch(mysqli_sql_exception $e){
        echo '<br><b>Error with query: </b><span style="color:red;">' . $query[$q] . "</span><br><b>Error Message: $e </b>" ;
    }
    finally{
        
    }
  
    } 

     
   
    mysqli_close($conn);
    echo "<br>";
 
}

?>
</body>
</html>


 