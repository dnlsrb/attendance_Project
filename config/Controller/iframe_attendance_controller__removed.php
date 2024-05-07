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

 
public function closeConnection() {
    mysqli_close($this->conn);
}
}
$id= mysqli_real_escape_string($conn, $_GET['id']); 
 
$attendanceController = new attendanceController($conn);
$Banner = $attendanceController->getList("SELECT * FROM event_list WHERE event_id = '$id' AND archived = 0");
$count_display = $attendanceController->getCount("SELECT COUNT(*) as count FROM attendance_records WHERE event_id = '$id' AND archived = 0");
 
$attendees_Records = $attendanceController->getList(
    "SELECT record_id, attendance_records.event_id, attendeesName, attendeesEmail, time_IN, time_OUT,  eventName
    FROM attendance_records INNER JOIN event_list ON event_list.event_id = attendance_records.event_id 
    WHERE attendance_records.event_id = $id AND attendance_records.archived = 0
    ORDER BY attendance_records.created_At DESC");
$attendanceController->closeConnection();

?>