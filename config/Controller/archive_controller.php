 
 
<?php 
include('config/database/db_connect.php');

class archiveController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getarchived($sql){
        
        $result = mysqli_query($this->conn, $sql);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
    
        return $data;
    }
    
    public function unarchive($record, $table, $col){
        
        $sql = "UPDATE {$table} SET archived = 0 WHERE {$col} = $record";
        if(mysqli_query($this->conn, $sql)){
            mysqli_close($this->conn);
            header('Location: archive_list.php');
            exit();
        }else{
            echo 'query error: ' . mysqli_error($this->conn);
        }
    }

    public function closeConnection() {
        mysqli_close($this->conn);
    }
}

$archiveManager = new archiveController($conn);
$archiveEvent = $archiveManager->getArchived("SELECT * FROM event_list WHERE archived = 1 ORDER BY created_At DESC");
$archiveUser = $archiveManager->getArchived("SELECT * FROM user WHERE archived = 1 ORDER BY created_At DESC");

if(isset($_POST['unarchiveEvent'])){
    $event_id =  mysqli_real_escape_string($conn, $_POST['id']);
    
    $archiveManager->unarchive($event_id, 'event_list', 'event_id');  
    echo 'sadsad';
}

if(isset($_POST['unarchiveUser'])){
    $user_id =  mysqli_real_escape_string($conn, $_POST['id']);
    
    $archiveManager->unarchive($user_id, 'user', 'user_id');  
}

$archiveManager->closeConnection();

?>