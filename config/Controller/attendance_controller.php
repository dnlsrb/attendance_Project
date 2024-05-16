
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
            header('Location: error/403.php');
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
    
 

    
 

 
    public function closeConnection() {
        mysqli_close($this->conn);
    }
}
 

    $attendanceController = new attendanceController($conn);
 
    $date = date("M d, Y h:i:s A");
    $attendanceController->validator($_GET['id']);
    $id= mysqli_real_escape_string($conn, $_GET['id']);
    
    $eventLists = $attendanceController->getEvent("SELECT * FROM event_list WHERE event_id = $id");
    

    // if(isset($_POST['submit'])){
    //     $attendeesData = [
    //         'attendeesName' => mysqli_real_escape_string($conn, $_POST['attendeesName']),
    //         'event_id' => mysqli_real_escape_string($conn, $_POST['event_id']),
    //     ];
    
    //     $name_error = $attendanceController->createAttendees($attendeesData);
 
    // }
 
    $attendanceController->closeConnection();
 
 
 
 
 
?>
 