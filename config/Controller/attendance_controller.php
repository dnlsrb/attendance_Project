<?php 
 

 
?>

<?php
include_once('config/database/db_connect.php');

// DISPLAY DATA
// ------------------------------------------------------------------------------------------
    if(isset($_GET['id'])){

        $date = date("M d, Y h:i:s A");
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        $sql = "SELECT * FROM event_list WHERE event_id = $id";
        $result = mysqli_query($conn, $sql);
        $eventLists = mysqli_fetch_assoc($result);

        $count_Attendees = "SELECT COUNT(*) as count FROM attendance_records WHERE event_id = '$id' AND archived = 0";
        $count_result = mysqli_query($conn, $count_Attendees);
        $count_display = mysqli_fetch_assoc($count_result)['count'];

        mysqli_free_result($count_result);
        mysqli_free_result($result);
        
        $AttendanceList_sql = 
        "SELECT record_id, attendance_records.event_id, attendeesName, attendeesEmail, time_IN, time_OUT,  eventName
        FROM attendance_records INNER JOIN event_list ON event_list.event_id = attendance_records.event_id 
        WHERE attendance_records.event_id = $id AND attendance_records.archived = 0
        ORDER BY time_IN DESC
        ";
        $AttendanceList_result = mysqli_query($conn, $AttendanceList_sql);
        $Attendees_Records = mysqli_fetch_all($AttendanceList_result, MYSQLI_ASSOC);
        
        mysqli_free_result($AttendanceList_result);
    }
 

// BUTTON SUBMIT
// ------------------------------------------------------------------------------------------
    if(isset($_POST['submit'])){
    $name_error = "";
    $attendeesName = mysqli_real_escape_string($conn, $_POST['attendeesName']);

        if(preg_match('/[0-9]/', $attendeesName)) {
            echo $name_error = "No Numbers Allowed";
        } 
        elseif(empty($attendeesName)){
            echo $name_error = "Name is empty";
        }
        else{ 
            $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);
            $timeOut_query = "SELECT * FROM attendance_records WHERE attendeesName = '$attendeesName' AND event_id = '$event_id'  AND time_OUT = '' AND archived = 0 ORDER BY created_At DESC";
            $timeOut_result = mysqli_query($conn, $timeOut_query);
            $timeOut_display = mysqli_fetch_assoc($timeOut_result);
            
            if(mysqli_num_rows($timeOut_result) === 1){
                // TIME OUT
                $sql_update = "UPDATE attendance_records SET time_OUT = '$date' WHERE attendeesName = '$attendeesName' AND event_id = '$event_id'";
                $timeOut_update = mysqli_query($conn, $sql_update);
                mysqli_free_result($timeOut_result);
                mysqli_close($conn);
                header('Location: attendance_List.php?id='. $event_id);
            }
            else{ 
                // TIME IN
                $time_IN = date('Y-m-d H:i:s'); // Format: YYYY-MM-DD;
                $total = "SELECT COUNT(*) as count FROM attendance_records WHERE (LAST_DAY(CURDATE()) - LAST_DAY(CURDATE())+1) <= DAY(created_At) AND DAY(LAST_DAY(CURDATE())) >= DAY(created_At) AND MONTH(LAST_DAY(CURDATE())) = MONTH(created_At) AND YEAR(LAST_DAY(CURDATE())) = YEAR(created_At)";
                $submit_result = mysqli_query($conn, $total);
                $count = mysqli_fetch_assoc($submit_result)['count'];
                $currentDateTime = date('my');
                
                // IF SIMILAR
                $record_id = $currentDateTime  . $count + 1 ;

                $sql_similar = "SELECT * FROM attendance_records WHERE record_id = '$record_id' ";
                $sql_similar_result = mysqli_query($conn, $sql_similar);

                if(mysqli_num_rows($sql_similar_result) === 1){
                $record_id = $currentDateTime  .'0'. $count + 1 ;
                }
                
                mysqli_free_result($sql_similar_result);
                mysqli_free_result($submit_result);

                $sql = "INSERT INTO attendance_records(record_id, event_id, attendeesName, time_IN) 
                VALUES ('$record_id','$event_id', '$attendeesName', '$date' )"   ;

                    if(mysqli_query($conn, $sql)){
                        mysqli_close($conn);
                        unset($date);
                        unset($time_IN);
                        unset($currentDateTime );
                        unset($record_id);
                        header('Location: attendance_List.php?id='. $event_id);
                    } else {
                        // error
                        mysqli_close($conn);
                        echo 'query error: ' . mysqli_error($conn);
                    }
                    unset($date);
                    unset($time_IN);
                    unset($currentDateTime );
                    unset($record_id);
                    }
            }
    }
 
 
// ARCHIVE DATA
// ------------------------------------------------------------------------------------------
    if(isset($_POST['delete'])){
        

        $delete_record = mysqli_real_escape_string($conn, $_POST['delete_record']);
        $event_id= mysqli_real_escape_string($conn, $_POST['event_id']);
        $sql = "UPDATE attendance_records SET archived = 1 WHERE record_id=$delete_record";
        if(mysqli_query($conn, $sql)){
            mysqli_close($conn);
            header('Location: attendance_List.php?id='. $event_id);
        }else{
            echo 'query error: ' . mysqli_error($conn);
        }

    
    }

 
mysqli_close($conn);
?>
 