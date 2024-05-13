<?php include('config/auth/auth_all.php');?>
 <?php
 
include('config/database/db_connect.php');
class AjaxAttendanceController{
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createAttendees($attendeesData){
        $name_message = $this->validateAttendees($attendeesData);
        $date = date("M d, Y h:i:s A");
        
        if (!array_filter($name_message)) {
          
            $timeOut_query = "SELECT * FROM attendance_records WHERE attendeesName = '{$attendeesData['attendeesName']}' 
            AND event_id = '{$attendeesData['event_id']}'  AND time_OUT = '' AND archived = 0 ORDER BY created_At DESC";
            $timeOut_result = mysqli_query($this->conn, $timeOut_query);
         
            
            if(mysqli_num_rows($timeOut_result) === 1){
                $name_message['message'] = "<i class='fa-solid fa-circle-check text-success me-1'></i><span class='text-success'>Goodbye!</span> <b><u>{$attendeesData['attendeesName']}</u></b>, ($date) 
                <audio autoplay='true' style='display:none;'> <style> #message { background-color: 2px solid darkgreen;  } </style>
         <source src='storage/notification.mp3' type='audio/wav'>
      </audio>";
                $sql_update = "UPDATE attendance_records SET time_OUT = '$date' WHERE attendeesName = '{$attendeesData['attendeesName']}'
                AND event_id = '{$attendeesData['event_id']}'";
                if(mysqli_query($this->conn, $sql_update)){ 
                mysqli_free_result($timeOut_result);
                 
            
                }
                else{
                    echo 'query error: ' . mysqli_error($this->conn);
                }
                 
            }
            else{ 
             
            $time_IN = date('Y-m-d H:i:s'); // Format: YYYY-MM-DD;
            $name_message['message'] = "<i class='fa-solid fa-circle-check text-success me-1'></i><span class='text-success'>Thankyou for attending!</span> <b><u>{$attendeesData['attendeesName']}</u></b>, ($date)
            <audio autoplay='true' style='display:none;'>
            <source src='storage/notification.mp3' type='audio/wav'>
         </audio>";

            $total = "SELECT COUNT(*) as count FROM attendance_records WHERE (LAST_DAY(CURDATE()) - LAST_DAY(CURDATE())+1) <= DAY(created_At) AND DAY(LAST_DAY(CURDATE())) >= DAY(created_At) AND MONTH(LAST_DAY(CURDATE())) = MONTH(created_At) AND YEAR(LAST_DAY(CURDATE())) = YEAR(created_At)";
            $submit_result = mysqli_query($this->conn, $total);
            $count = mysqli_fetch_assoc($submit_result)['count'];
            $currentDateTime = date('my');
            
 
            
            $record_id = $currentDateTime  . $count + 1 ;

            $sql_similar = "SELECT * FROM attendance_records WHERE record_id = '$record_id'";
            $sql_similar_result = mysqli_query($this->conn, $sql_similar);

            while(mysqli_num_rows($sql_similar_result) > 0){
                $count++;
                $record_id = $currentDateTime . $count + 1;
                $sql_similar = "SELECT * FROM attendance_records WHERE record_id = '$record_id'";
                $sql_similar_result = mysqli_query($this->conn, $sql_similar);
            }


            mysqli_free_result($sql_similar_result);
            mysqli_free_result($submit_result);

            $sql = "INSERT INTO attendance_records(record_id, event_id, attendeesName, time_IN) 
            VALUES ('$record_id','{$attendeesData['event_id']}', '{$attendeesData['attendeesName']}', '$date' )"   ;

                if(mysqli_query($this->conn, $sql)){
                     
                    unset($date);
                    unset($time_IN);
                    unset($currentDateTime );
                    unset($record_id);
                     
                } else {
                    // error
                    
                    echo 'query error: ' . mysqli_error($this->conn);
                }
                unset($date);
                unset($time_IN);
                unset($currentDateTime );
                unset($record_id);
                }
             
            }
        return $name_message;
    }

    public function validateAttendees($attendeesData){
        $name_message = [];
        
        $user_existed = "SELECT * FROM attendance_records WHERE event_id  =  '{$attendeesData['event_id']}'  
        && attendeesName = '{$attendeesData['attendeesName']}' && time_IN != '' && time_OUT != '' && archived = 0 && DATE(created_At) = CURDATE();";
        $user_existed_result = mysqli_query($this->conn, $user_existed);
        
        if(preg_match('/[0-9]/', $attendeesData['attendeesName'])) {
            $name_message['message'] = "<i class='fa-solid fa-circle-exclamation text-danger me-1'></i>No Numbers Allowed
            <audio autoplay='true' style='display:none;'>
            <source src='storage/error.mp3' type='audio/wav'>
            </audio>";
        } 
        elseif(empty($attendeesData['attendeesName'])){
            $name_message['message'] = "<i class='fa-solid fa-circle-exclamation text-danger me-1'></i>Name is empty
            <audio autoplay='true' style='display:none;'>
            <source src='storage/error.mp3' type='audio/wav'>
            </audio>";
        }
        elseif(mysqli_num_rows($user_existed_result) >= 1){
        
            mysqli_free_result($user_existed_result);
            $name_message['message'] = "<i class='fa-solid fa-circle-exclamation text-danger me-1'></i><u><b>{$attendeesData['attendeesName']}</b></u> <span class='text-warning'>already existed</span> in this day of event.
            <audio autoplay='true' style='display:none;'>
            <source src='storage/error.mp3' type='audio/wav'>
            </audio>";
        }

        return $name_message;
    }
 



    public function closeConnection() {
        mysqli_close($this->conn);
    }
}
 

$AjaxAttendanceController = new AjaxAttendanceController($conn);
 
    $attendeesData = [
        'attendeesName' => mysqli_real_escape_string($conn, $_POST['attendeesName']),
        'event_id' => mysqli_real_escape_string($conn, $_POST['event_id']),
    ];

    $name_message = $AjaxAttendanceController->createAttendees($attendeesData);

    header('Content-Type: application/json');
    echo json_encode(array(
    'name_message' => $name_message
    )); 
    $AjaxAttendanceController->closeConnection();
?>