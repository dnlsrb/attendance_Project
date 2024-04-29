<?php include('config/auth/auth_all.php');?>
 
<?php require('config/Controller/archive_controller.php');?>


<?php $title ="archive list"?>
<?php include('template/header.php')?>

<div class="container-fluid"> 
<h3>Events</h3>
<hr>
<?php if ($archiveEvent): ?>
        <?php $orderNumber = 1; ?>
        <div class="overflow-x-auto"> 
        <table class="table">
            <tr>
                <th scope="col">#</th>
                <th>ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Unarchive</th>
            </tr>


             
        <?php foreach ($archiveEvent as $Event): ?>
            <?php echo '<tr>';?>
            
            <th scope="row"><?php echo $orderNumber . '.'; ?></th>
             <td><?php echo htmlspecialchars($Event['event_id']); ?></td> 
            <td> <?php echo htmlspecialchars($Event['eventName']); ?></td>
            <td><?php echo htmlspecialchars($Event['eventStart']); ?> <b>-</b> <?php echo htmlspecialchars($Event['eventEnd']); ?></td>
            <td>

            <form   action="archive_list.php" method="POST">
 
            <input type="hidden" name="id" value="<?php echo $Event['event_id'];?>">
            <input type="submit" name="unarchiveEvent" value="Unarchive" >  
            </form>

            </td>
            <?php $orderNumber++; ?>
            <?php echo '<tr>'; 
            
        endforeach; ?>
        </table>
        </div>
<?php else:?>
    No Archive User Data Found
<?php endif;?>


<h3>User</h3>
<hr>
<?php if ($archiveUser): ?>
        <?php $orderNumber = 1; ?>
        <div class="overflow-x-auto"> 
        <table class="table">
            <tr>
                <th scope="col">#</th>
                <th>ID</th>
                <th>Name</th>
          
                <th>Unarchive</th>
            </tr>


             
        <?php foreach ($archiveUser as $User): ?>
            <?php echo '<tr>';?>
            
            <th scope="row"><?php echo $orderNumber . '.'; ?></th>
             <td><?php echo htmlspecialchars($User['user_name']); ?></td> 
            <td> <?php echo htmlspecialchars($User['user_role']); ?></td>
 
            <td>

            <form   action="archive_list.php" method="POST">
 
            <input type="hidden" name="id" value="<?php echo $User['user_id'];?>">
            <input type="submit" name="unarchiveUser" value="Unarchive" >  
            </form>

            </td>
            <?php $orderNumber++; ?>
            <?php echo '<tr>'; 
            
        endforeach; ?>
        </table>
        </div>
<?php else:?>
    No Archive User Data Found
<?php endif;?>


</div>


<?php include('template/footer.php')?>
