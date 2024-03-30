<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="db_create.php" method="GET">
<input type="text" name="run">
<input type="submit" value="submit" name="submit">
</form>
    <?php 


$query = [];

array_push($query, "CREATE TABLE `attendance_records` (
  `record_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `attendeesName` varchar(255) NOT NULL,
  `attendeesEmail` varchar(255) NOT NULL,
  `time_IN` datetime NOT NULL,
  `time_OUT` date DEFAULT NULL,
  `archived` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");


array_push($query, "ALTER TABLE `attendance_records` ADD PRIMARY KEY (`record_id`);");


array_push($query, "CREATE TABLE `event_list` (
  `event_id` int(11) NOT NULL,
  `eventName` varchar(255) NOT NULL,
  `eventBackgroundImage` varchar(255) NOT NULL,
  `eventHeaderImage` varchar(255) NOT NULL,
  `eventStart` date NOT NULL,
  `eventEnd` date NOT NULL,
  `created_At` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

array_push($query, "ALTER TABLE `event_list`
  ADD PRIMARY KEY (`event_id`);");

array_push($query, "ALTER TABLE `event_list`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;");
 
if(isset($_GET['submit'])){
    $run = $_GET['run'];
   
   
    if($run == "runsql"){
       sql_Query($query);
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
function sql_Query($query){
    include('db_connect.php');   

 


    $q = 0;
    print_r($query);

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
        echo "<br> Finished ";
    }
  
    } 

     
   
    mysqli_close($conn);
    echo "<br>";
 
}

?>
</body>
</html>

 