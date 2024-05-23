<?php include('config/auth/auth_all.php');?>
<?php
 include_once('config/database/db_connect.php');


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
 
$getListAjax = new attendanceController($conn);
$Banner = $getListAjax->getList("SELECT * FROM event_list WHERE event_id = '$id' AND archived = 0");
$count_display = $getListAjax->getCount("SELECT COUNT(*) as count FROM attendance_records WHERE event_id = '$id' AND archived = 0");
 
$attendees_Records = $getListAjax->getList(
    "SELECT record_id, attendance_records.event_id, attendeesName, time_IN, time_OUT,  eventName
    FROM attendance_records INNER JOIN event_list ON event_list.event_id = attendance_records.event_id 
    WHERE attendance_records.event_id = $id AND attendance_records.archived = 0
    ORDER BY attendance_records.created_At DESC");
 

header('Content-Type: application/json');
echo json_encode(array(
    'count_display' => $count_display,
    'attendees_Records' => $attendees_Records
)); 
$getListAjax->closeConnection();
?> 