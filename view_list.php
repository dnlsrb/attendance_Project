<?php include('config/auth/auth_all.php');?>
<?php include('config/auth/auth_admin.php');?> 


<?php include('config/Controller/view_list_controller.php'); ?>
<?php $title = htmlspecialchars($eventLists['eventName']);?>
<?php include('template/header.php')?>
 
 
<div class="container-fluid  py-4">
    
    <div class="d-flex justify-content-between">
        <div  >
            <a href="event_list.php" type="input" class="btn btn-secondary  rounded-0"><i class="fa-solid fa-arrow-left"></i></a>
        
            <a href="event_Details.php?id=<?php echo htmlspecialchars($id);  ?>" type="input" class="btn btn-primary  mx-1 rounded-0"><i class="bi bi-pencil-fill"></i></a>
        </div>
        <div> 
        <form action="export_to_excel.php" method="GET">
            <button type="submit"  class="btn btn-success rounded-0 " name="getsubmit"  ><span class="d-sm-none d-block  "><i class="fa-solid fa-file-excel"></i></span><span class="d-none d-sm-block ms-1"> Download Excel</span> </button>
            <input type="hidden" name="authentication" value="allowed">
            <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($id);  ?>">
        </form>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-3 rounded-1 text-bg-light  p-3">
        <p class="m-0   "><span class="fw-bold display-6">
            <?php echo htmlspecialchars($eventLists['eventName']);?><br></span> 
            (<?php echo htmlspecialchars($eventLists['eventStart']);?> To <?php echo htmlspecialchars($eventLists['eventEnd']);?>)
            <br><span class="fw-bold">ATTENDEES:</span> <?php echo $count_display?> 
            <span class="text-success fw-bold">(Archived attendees not included)</span></p>
   
    </div>
    <div class="mt-2  d-flex justify-content-end" > 
        
    <form action="view_list.php?id=<?php echo htmlspecialchars($id);  ?>" method="POST" class="d-flex" role="search" autocomplete="off">
        <input class="form-control mx-md-2 border-secondary rounded-0 " type="search" id="nameSearch" value="<?php echo htmlspecialchars($name ?? ''); ?>" name="name" aria-label="Search">
        <div> 
        <input class="btn btn-outline-secondary w-100 rounded-0 text-dark " value="search" type="submit" name="search">
        </div>      
    </form>
    </div>
 
    <div class="row">
        <div class="col ">
   
        <div class="overflow-x-auto d-flex"> 
        <?php if(isset($attendees_Records)): ?>
        <table class=" table table-secondary shadow-sm mt-2 table-hover ">
            <tr >
                <th> </th>
                <th>NAME</th>
                <th>TIME IN</th>
                <th>TIME OUT</th>
                <th> </th>
            </tr>   
            <?php $count = 1;?> 
            <?php foreach($attendees_Records as $Attendees):?>
                <?php if($Attendees['archived'] == 1): echo '<tr class="opacity-50">'; else: echo '<tr>'; endif; ?>
            <td><?php echo $count; ?></td>
            <td class="fw-bold  text-truncate" style="max-width: 250px;"><?php echo htmlspecialchars($Attendees['attendeesName']);  ?></td>
            <td class="fw-bold text-success"><?php echo htmlspecialchars( $Attendees['time_IN']);?></td>
            <td class="fw-bold text-primary  "><?php echo htmlspecialchars($Attendees['time_OUT']);  ?></td>
            <td>

            <?php if($Attendees['archived'] == 0):?>
            <form   action="view_list.php?id=<?php echo htmlspecialchars($id);  ?>" method="POST">
            <input type="hidden" name="archive_record" value="<?php echo htmlspecialchars($Attendees['record_id']);?>">
            <input type="hidden" name="event_id"  value="<?php echo htmlspecialchars($Attendees['event_id']);?>">
            <input type="submit" name="archive" class="btn btn-danger w-100 rounded-0" value="Archive" >  
            </form>
            
            <?php else: ?>
            <form   action="view_list.php?id=<?php echo htmlspecialchars($id);  ?>" method="POST">
            <input type="hidden" name="unarchive_record" value="<?php echo htmlspecialchars($Attendees['record_id']);?>">
            <input type="hidden" name="event_id"  value="<?php echo htmlspecialchars($Attendees['event_id']);?>">
            <input type="submit" name="unarchive"  class="btn btn-success w-100 rounded-0" value="Unarchive" >  
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

 

 