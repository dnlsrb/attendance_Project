<?php include ('config/auth/auth_all.php'); ?>

<?php require ('config/Controller/event_list_controller.php'); ?>


<?php include ('template/header.php') ?>

<!-- 2nd Navbar -->
<nav>
    <!-- parent div -->
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <!-- left side -->
        <div>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create_event">
                Create Event
            </button>
            <a href="" class="btn btn-secondary">User Management</a>
        </div>

        <!-- right side -->
        <div class="d-flex align-items-center p-1">
            <!-- searchbar -->
            <input type="text" placeholder="search" class="pr-1">

            <!-- Dropdown menu -->
            <div class="dropdown shadow ">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    filter
                </button>
                <ul class="dropdown-menu">
                    <li class="d-flex justify-content-start align-items-center">
                    <div class="m-2"> 
                    <input type="checkbox" class="dropdown-item" id="ongoing" name="ongoing">
                    </div>
                    <label for="ongoing">Ongoing</label>
                    </li>
                    <li class="d-flex justify-content-start align-items-center">
                    <div class="m-2"> 
                    <input type="checkbox" class="dropdown-item" id="ongoing" name="ongoing">
                    </div>
                    <label for="ongoing">Ongoing</label>
                    </li>
                    <li class="d-flex justify-content-end align-items-center">
                    <a href="#" class="btn btn-primary mx-1 mt-5">Confirm</a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Modal -->
<div class="modal" id="create_event" tabindex="-1" aria-labelledby="create_eventLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="create_eventLabel">Create Event</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="event_List.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
               

                    <p style="color:red;"> <?php echo htmlspecialchars($errors['eventName'] ?? ''); ?>
                    <p>
                        Event Name: <input type="text" name="eventName" value="<?php echo $eventName ?? '' ?>"><br>
                        Background image: <input type="file" name="eventBackgroundImage"
                            accept=".jpg, .png, .jpeg, .gif,"> <br>
                        Header Image: <input type="file" name="eventHeaderImage" accept=".jpg, .png, .jpeg, .gif,"> <br>
                    <p style="color:red;"> <?php echo htmlspecialchars($errors['eventStart'] ?? ''); ?> </p>
                    Event Start: <input type="date" name="eventStart" min="<?php echo date('Y-m-d'); ?>"><br>
                    <p style="color:red;"><?php echo htmlspecialchars($errors['eventEnd'] ?? ''); ?></p>
                    Event End <input type="date" name="eventEnd" min="<?php echo date('Y-m-d'); ?>">
                    <br>
                     
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="submit" name="submit">
            </div>
            </form>
        </div>
    </div>
</div>


<?php if(($errors['eventName'] ?? '') != '' || ($errors['eventStart'] ?? '') != '' || ($errors['eventEnd'] ?? '') != ''): 
 

 
 echo 
 "<script>
     // This script can be removed if you want to open the modal only using Bootstrap data attributes
     var myModal = new bootstrap.Modal(document.getElementById('create_event'));
     myModal.show();
 </script>";
  endif;?>


<h3>Event List</h3>
<?php if ($eventLists): ?>
    <?php $orderNumber = 1; ?>

    <table>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Event ID</th>
            <th>Event Name</th>
            <th>Start Date</th>
            <th>End Date</th>

            <th></th>
            <th></th>
        </tr>


        <?php echo '<tr>';
        foreach ($eventLists as $eventLists): ?>

            <th scope="row"><?php echo $orderNumber . "."; ?></th>
            <td><?php echo htmlspecialchars($eventLists['event_id']); ?></td>
            <td><?php echo htmlspecialchars($eventLists['eventName']); ?></td>
            <td><?php echo htmlspecialchars($eventLists['eventStart']); ?></td>
            <td><?php echo htmlspecialchars($eventLists['eventEnd']); ?></td>

            <td><a href="attendance_List.php?id=<?php echo $eventLists['event_id']; ?>"><i class="bi bi-eye"></i> List</a>
            </td>
            <td><a href="event_Details.php?id=<?php echo $eventLists['event_id']; ?>">
                    <i> </i>Details</a></td>
            <?php $orderNumber++; ?>
            <?php echo '<tr>'; endforeach; ?>
    </table>
<?php else: ?>
    <h1>No Data Found, Create Event</h1>

<?php endif ?>
<!--  -->




<?php include ('template/footer.php') ?>