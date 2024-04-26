<?php
class attendanceController{
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
 
 
    public function getList($sql){

        $result = mysqli_query($this->conn, $sql);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);

        return $data;
    }

    public function getCount($sql){
    
        $result = mysqli_query($this->conn, $sql);
        $data = mysqli_fetch_assoc($result)['count'];
        mysqli_free_result($result);
    
        return $data;
         
    }

    public function archiveAttendees($delete_record, $event_id){
        
        $sql = "UPDATE attendance_records SET archived = 1 WHERE record_id=$delete_record";
        if(mysqli_query($this->conn, $sql)){
            mysqli_close($this->conn);
            header('Location: iframe_attendance.php?id='. $event_id);
            exit();
        }else{
            echo 'query error: ' . mysqli_error($this->conn);
        }
    }

public function closeConnection() {
    mysqli_close($this->conn);
}
}
$id= mysqli_real_escape_string($conn, $_GET['id']); 
 
$attendanceController = new attendanceController($conn);
$count_display = $attendanceController->getCount("SELECT COUNT(*) as count FROM attendance_records WHERE event_id = '$id' AND archived = 0");
if(isset($_POST['delete'])){
    $delete_record = mysqli_real_escape_string($conn, $_POST['delete_record']);
    $event_id= mysqli_real_escape_string($conn, $_POST['event_id']);
    $attendanceController->archiveAttendees($delete_record, $event_id);
}
$attendees_Records = $attendanceController->getList(
    "SELECT record_id, attendance_records.event_id, attendeesName, attendeesEmail, time_IN, time_OUT,  eventName
    FROM attendance_records INNER JOIN event_list ON event_list.event_id = attendance_records.event_id 
    WHERE attendance_records.event_id = $id AND attendance_records.archived = 0
    ORDER BY time_IN DESC");
$attendanceController->closeConnection();

?>