<?php include('config/auth/auth_all.php');?>
 
<?php require('config/Controller/archive_controller.php');?>


<?php $title ="Archive"?>
<?php include('template/header.php')?>

<div class="container-fluid rounded py-2 "> 
 
 
                    <h2 class="m-0 p-0">Archive</h2>
 
<?php $orderNumber = 1; ?>
 
    
        <div class="overflow-x-auto"> 
        <?php if(empty($archiveEvent) && empty($archiveUser)): ?>  
            <div class=" text-center order-1 my-5">
          
          <h class="display-6">No Archive Data Found</h>
      
        </div>
            <?php else:?>
                <table class="table table-hover">
            <tr>
                <th> </th>
                <th>Name</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        <?php endif;?>
     
       

        <?php if($archiveEvent): ?>     
        <?php foreach ($archiveEvent as $Event): ?>
            <?php echo '<tr>';?>
            <td><?php echo $orderNumber;?></td>
            <td  ><span class="text-truncate d-inline-block" style="max-width:200px;"> <?php echo htmlspecialchars($Event['eventName']); ?></span></td>
            <td><span class="badge text-bg-success">Events</span></td>
            <td>

            <form   action="archive_list.php" method="POST">
 
            <input type="hidden" name="id" value="<?php echo $Event['event_id'];?>">
            <input type="submit" name="unarchiveEvent" class="btn btn-warning" value="Unarchive" >  
            </form>

            </td>
            <?php $orderNumber++; ?>
            <?php echo '<tr>'; 
            
        endforeach; ?>
        <?php else:?>
        <?php endif;?>
 


        <?php if ($archiveUser): ?>     
        <?php foreach ($archiveUser as $User): ?>
            <?php echo '<tr  >';?>
            
            <td><?php echo $orderNumber;?></td>
            <td  > <span class="text-truncate d-inline-block" style="max-width:200px;"><?php echo htmlspecialchars($User['user_name']); ?></span></td>
            <td><span class="badge text-bg-secondary">Account</span></td>
            <td>

            <form   action="archive_list.php" method="POST">
 
            <input type="hidden" name="id" value="<?php echo $User['user_id'];?>">
            <input type="submit" name="unarchiveUser" class="btn btn-warning" value="Unarchive" >  
            </form>

            </td>
            <?php $orderNumber++; ?>
            <?php echo '<tr>'; 
            
        endforeach; ?>

        <?php else:?>
        <?php endif;?>

     
</table>
 
</div>
</div>


<?php include('template/footer.php')?>
