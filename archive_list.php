<?php include('config/auth/auth_all.php');?>
 
<?php require('config/Controller/archive_controller.php');?>


<?php $title ="Archive"?>
<?php include('template/header.php')?>

<div class="container-fluid"> 
<h3 class="mt-3">Archive</h3>

<?php $orderNumber = 1; ?>
 
    
        <div class="overflow-x-auto"> 
        <?php if(empty($archiveEvent) && empty($archiveUser)): ?>  
            <div class=" text-center order-1 my-5">
          
          <h class="display-6">No Archive Data Found</h>
      
        </div>
            <?php else:?>
                <table class="table">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Action</th>
            </tr>
        <?php endif;?>
     
       

        <?php if($archiveEvent): ?>     
        <?php foreach ($archiveEvent as $Event): ?>
            <?php echo '<tr>';?>
            <td><?php echo $orderNumber;?></td>
            <td> <?php echo htmlspecialchars($Event['eventName']); ?></td>
            <td>Events</td>
            <td>

            <form   action="archive_list.php" method="POST">
 
            <input type="hidden" name="id" value="<?php echo $Event['event_id'];?>">
            <input type="submit" name="unarchiveEvent" value="Unarchive" >  
            </form>

            </td>
            <?php $orderNumber++; ?>
            <?php echo '<tr>'; 
            
        endforeach; ?>
        <?php else:?>
        <?php endif;?>
 


        <?php if ($archiveUser): ?>     
        <?php foreach ($archiveUser as $User): ?>
            <?php echo '<tr>';?>
            
            <td><?php echo $orderNumber;?></td>
            <td> <?php echo htmlspecialchars($User['user_name']); ?></td>
            <td>Account</td>
            <td>

            <form   action="archive_list.php" method="POST">
 
            <input type="hidden" name="id" value="<?php echo $User['user_id'];?>">
            <input type="submit" name="unarchiveUser" value="Unarchive" >  
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
