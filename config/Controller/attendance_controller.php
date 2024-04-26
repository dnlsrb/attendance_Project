<?php 
include('config/database/db_connect.php');
class attendanceController{
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function validator($event_id){
    
    if(isset($event_id) && preg_match('/^\d+$/', $event_id)){
       
        $validated = "SELECT archived FROM event_list WHERE event_id = $event_id" ;
        $result = mysqli_query($this->conn, $validated);
        
        if(mysqli_num_rows($result) === 0){
             
            mysqli_free_result($result);
            header('Location: error/404.php');
        }
    
        $archived = mysqli_fetch_assoc($result);
        $validating = $archived['archived'];
    
        if($validating == 1){
           
            mysqli_free_result($result);
            header('Location: error/404.php');
        }
        else{
           
            mysqli_free_result($result);
        }

    }else{
   
        header('Location: error/404.php');
    }
    }

    public function getEvent($sql){
        
        $result = mysqli_query($this->conn, $sql);
        $data = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
    
        return $data;
         
    }

    
 


    public function createAttendees($attendeesData){
        $name_error = $this->validateAttendees($attendeesData);
        $date = date("M d, Y h:i:s A");

        if (!array_filter($name_error)) {
          
            $timeOut_query = "SELECT * FROM attendance_records WHERE attendeesName = '{$attendeesData['attendeesName']}' 
            AND event_id = '{$attendeesData['event_id']}'  AND time_OUT = '' AND archived = 0 ORDER BY created_At DESC";
            $timeOut_result = mysqli_query($this->conn, $timeOut_query);
         
            
            if(mysqli_num_rows($timeOut_result) === 1){
         
                $sql_update = "UPDATE attendance_records SET time_OUT = '$date' WHERE attendeesName = '{$attendeesData['attendeesName']}'
                AND event_id = '{$attendeesData['event_id']}'";
                if(mysqli_query($this->conn, $sql_update)){ 
                mysqli_free_result($timeOut_result);
                mysqli_close($this->conn);
                header('Location: attendance_List.php?id='. $attendeesData['event_id']);
                exit();
                }
                else{
                    echo 'query error: ' . mysqli_error($this->conn);
                }
            }
            else{ 
            $time_IN = date('Y-m-d H:i:s'); // Format: YYYY-MM-DD;
            $total = "SELECT COUNT(*) as count FROM attendance_records WHERE (LAST_DAY(CURDATE()) - LAST_DAY(CURDATE())+1) <= DAY(created_At) AND DAY(LAST_DAY(CURDATE())) >= DAY(created_At) AND MONTH(LAST_DAY(CURDATE())) = MONTH(created_At) AND YEAR(LAST_DAY(CURDATE())) = YEAR(created_At)";
            $submit_result = mysqli_query($this->conn, $total);
            $count = mysqli_fetch_assoc($submit_result)['count'];
            $currentDateTime = date('my');
            
            // IF SIMILAR
            $record_id = $currentDateTime  . $count + 1 ;

            $sql_similar = "SELECT * FROM attendance_records WHERE record_id = '$record_id' ";
            $sql_similar_result = mysqli_query($this->conn, $sql_similar);

            if(mysqli_num_rows($sql_similar_result) > 1){
            $record_id = $currentDateTime  .'0'. $count + 1 ;
            }
            
            mysqli_free_result($sql_similar_result);
            mysqli_free_result($submit_result);

            $sql = "INSERT INTO attendance_records(record_id, event_id, attendeesName, time_IN) 
            VALUES ('$record_id','{$attendeesData['event_id']}', '{$attendeesData['attendeesName']}', '$date' )"   ;

                if(mysqli_query($this->conn, $sql)){
                    mysqli_close($this->conn);
                    unset($date);
                    unset($time_IN);
                    unset($currentDateTime );
                    unset($record_id);
                    header('Location: attendance_List.php?id='. $attendeesData['event_id']);
                    exit();
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
        return $name_error;
    }

    public function validateAttendees($attendeesData){
        $name_error = [];
        
        $user_existed = "SELECT * FROM attendance_records WHERE event_id  =  '{$attendeesData['event_id']}'  
        && attendeesName = '{$attendeesData['attendeesName']}' && time_IN != '' && time_OUT != '' && archived = 0 && DATE(created_At) = CURDATE();";
        $user_existed_result = mysqli_query($this->conn, $user_existed);
        
        if(preg_match('/[0-9]/', $attendeesData['attendeesName'])) {
            $name_error['attendeesError'] = "No Numbers Allowed";
        } 
        elseif(empty($attendeesData['attendeesName'])){
            $name_error['attendeesError'] = "Name is empty";
        }
        elseif(mysqli_num_rows($user_existed_result) >= 1){
        
            mysqli_free_result($user_existed_result);
            $name_error['attendeesError'] = "Attendee Already existed in this event to this day.";
        }

        return $name_error;
    }
 



    public function closeConnection() {
        mysqli_close($this->conn);
    }
}
 

    $attendanceController = new attendanceController($conn);
 
    $date = date("M d, Y h:i:s A");
    $attendanceController->validator($_GET['id']);
    $id= mysqli_real_escape_string($conn, $_GET['id']);
   
    $eventLists = $attendanceController->getEvent("SELECT * FROM event_list WHERE event_id = $id");
    

    if(isset($_POST['submit'])){
        $attendeesData = [
            'attendeesName' => mysqli_real_escape_string($conn, $_POST['attendeesName']),
            'event_id' => mysqli_real_escape_string($conn, $_POST['event_id']),
        ];
    
        $name_error = $attendanceController->createAttendees($attendeesData);
 
    }
 
    $attendanceController->closeConnection();
 
 
 
 
 
?>
 