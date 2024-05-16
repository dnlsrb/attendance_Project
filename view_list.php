<?php include('config/auth/auth_all.php');?>
<?php include('config/auth/auth_admin.php');?> 


<?php include('config/Controller/view_list_controller.php'); ?>
<?php $title = htmlspecialchars($eventLists['eventName']);?>
<?php include('template/header.php')?>
 
 
<div class="container-fluid  py-4">
    <div>
    <nav  style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item "   aria-current="page"  ><a href="event_list.php"><span class="fw-bold  "  >Events</span></a> </li>
                    <li class="breadcrumb-item active"   aria-current="page"  ><span class="fw-bold  "  ><?php echo htmlspecialchars($eventLists['eventName']);?></span></li>
                    <li class="breadcrumb-item active" aria-current="page">Participant List</li>
                </ol>
                </nav>
    </div>
    <div class="d-flex justify-content-between">
 
        <div> 
        <form action="export_to_excel.php" method="GET">
            <button type="submit"  class="btn btn-success rounded-0 " name="getsubmit"  ><span class="d-sm-none d-block  "><i class="fa-solid fa-file-excel"></i></span><span class="d-none d-sm-block ms-1"> Download Excel</span> </button>
            <input type="hidden" name="authentication" value="allowed">
            <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($id);  ?>">
        </form>
        </div>

               
    <form action="view_list.php?id=<?php echo htmlspecialchars($id);  ?>" method="POST" class="d-flex" role="search" autocomplete="off">
        <input class="form-control mx-md-2  rounded  bg-body-secondary" type="search" id="nameSearch" value="<?php echo htmlspecialchars($name ?? ''); ?>" name="name" aria-label="Search">
        <div> 
        <input class="btn btn-outline-secondary w-100  rounded text-dark " value="search" type="submit" name="search">
        </div>      
    </form>
    </div>
    
     
 
    <div class="row">
        <div class="col ">
   
        <div class="overflow-x-auto d-flex"> 
        <?php if(isset($attendees_Records)): ?>
        <table class=" table  shadow-sm mt-2 table-hover ">
            <tr class="table-secondary">
                <th> </th>
                <th>NAME</th>
                <th>TIME IN</th>
                <th>TIME OUT</th>
                <th> </th>
            </tr>   
            <?php $count = 1;?> 
            <?php foreach($attendees_Records as $Attendees):?>
                
            <td><?php echo $count; ?></td>
            <td class="fw-bold  text-truncate <?php if($Attendees['archived'] == 1): echo 'opacity-50'; endif; ?>" style="max-width: 250px;"><?php echo htmlspecialchars($Attendees['attendeesName']);  ?></td>
            <td class="fw-bold text-success <?php if($Attendees['archived'] == 1): echo 'opacity-50'; endif; ?>"><?php echo htmlspecialchars( $Attendees['time_IN']);?></td>
            <td class="fw-bold text-primary <?php if($Attendees['archived'] == 1): echo 'opacity-50'; endif; ?>"><?php echo htmlspecialchars($Attendees['time_OUT']);  ?></td>
            <td>

            <?php if($Attendees['archived'] == 0):?>
            <form   action="view_list.php?id=<?php echo htmlspecialchars($id);  ?>" method="POST">
            <input type="hidden" name="archive_record" value="<?php echo htmlspecialchars($Attendees['record_id']);?>">
            <input type="hidden" name="event_id"  value="<?php echo htmlspecialchars($Attendees['event_id']);?>">
            <input type="submit" name="archive" class="btn btn-success w-100  " value="Archive" >  
            </form>
            
            <?php else: ?>
            <form   action="view_list.php?id=<?php echo htmlspecialchars($id);  ?>" method="POST">
            <input type="hidden" name="unarchive_record" value="<?php echo htmlspecialchars($Attendees['record_id']);?>">
            <input type="hidden" name="event_id"  value="<?php echo htmlspecialchars($Attendees['event_id']);?>">
            <input type="submit" name="unarchive"  class="btn btn-warning w-100 rounded-0" value="Unarchive" >  
            </form>
            
            <?php endif;?>
            </td>  
            <?php $count++;?>
            <?php 
            echo '<tr>';   
            endforeach;
            unset($count);
            ?>
            </table>
            </div>
        <?php endif;?>
        </div>
  
 
        </div>
        </div>
    </div>
</div>
 



 

<?php include('template/footer.php')?>

 

 