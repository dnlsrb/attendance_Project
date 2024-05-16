<?php include 'config/auth/auth_all.php'; ?>
 
<?php require 'config/Controller/event_list_controller.php'; ?>


<?php $title ="Events"?>
<?php include 'template/header.php'; ?>


<!-- Modal -->
<div class="modal" id="create_event" tabindex="-1" aria-labelledby="create_eventLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title p-0 m-0" id="create_eventLabel">Create Event</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="event_list.php" method="POST" enctype="multipart/form-data"  autocomplete="off" >
                <div class="modal-body">



                    <label for="eventName" class="form-label">Event Name:</label>
  
                    <input type="text" id="eventName"
                        class="form-control  border-secondary " name="eventName"
                        value="<?php echo htmlspecialchars($eventData['eventName'] ?? ''); ?>"> 
                        <?php if (isset($errors['eventName'])):?>
                        <div class="alert alert-danger p-0 m-0 rounded-0 w-100" role="alert"><i class="fa-solid fa-circle-exclamation me-1"></i><?php echo htmlspecialchars($errors['eventName'] ?? ''); ?></div> 
                        <?php endif;?>
                        <br>


                    <label for="TableBackground" class="form-label">Background Image</label>
                    <input type="file" id="TableBackground" class="form-control  border-secondary" name="eventBackgroundImage"
                        accept=".jpg, .png, .jpeg, .gif,"> <br>
                    <label for="bannerImage" class="form-label">Banner Image</label>
                    <input type="file" id="bannerImage" class="form-control  border-secondary" name="eventHeaderImage"
                        accept=".jpg, .png, .jpeg, .gif,"> <br>
                    <label for="eventStart" class="form-label">Start of Event</label>
                   
                    <input type="date" id="eventStart" value="<?php echo htmlspecialchars($eventData['eventStart'] ?? ''); ?>"
                        class="form-control   border-secondary" name="eventStart" min="<?php echo date('Y-m-d'); ?>"> 
                        <?php if (isset($errors['eventStart'])):?>
                        <div class="alert alert-danger p-0 m-0 rounded-0 w-100" role="alert"><i class="fa-solid fa-circle-exclamation me-1"></i><?php echo htmlspecialchars($errors['eventStart'] ?? ''); ?></div> 
                        <?php endif;?>
                        <br>

                    <label for="eventEnd" class="form-label">End of Event</label>
                     
                    <input type="date" id="eventEnd" value="<?php echo htmlspecialchars($eventData['eventEnd'] ?? ''); ?>"
                        class="form-control  border-secondary " name="eventEnd" min="<?php echo date('Y-m-d'); ?>">
                        <?php if (isset($errors['eventEnd'])):?>
                        <div class="alert alert-danger p-0 m-0 rounded-0 w-100" role="alert"><i class="fa-solid fa-circle-exclamation me-1"></i><?php echo htmlspecialchars($errors['eventEnd'] ?? ''); ?></div> 
                        <?php endif;?>
                        <br>


                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="submit" name="submit">
                </div>
            </form>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div>
        <?php if (isset($errors)):
            echo "<script>
             // This script can be removed if you want to open the modal only using Bootstrap data attributes
             var myModal = new bootstrap.Modal(document.getElementById('create_event'));
             myModal.show();
         </script>";
        
            unset($errors['eventName']);
        endif; ?>
        <div class="container-fluid">
            <div class="row d-flex align-items-center  py-2  ">
                <div class="col-md col-6  p-1 ">
                    <h2>Events</h2>
                </div>
                <?php if( $_SESSION['role'] == 1   ): ?>
                <div class=" col-md col-6 d-flex justify-content-end order-1 order-md-2  p-1 ">
                    <div>
                        <button type="button" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" data-bs-toggle="modal"
                            data-bs-target="#create_event">
                          Create Event 
                        </button>
                    </div>
                </div>
                <?php endif;?>

            </div>

        </div>  
 
        <div class="row mx-1 ">
        <div class="card card-header p-0 px-2 rounded-1 border-0 bg-white ">
                    <form action="event_list.php" method="GET" autocomplete="off" class="d-md-flex   align-items-center"
                        role="search">


                        <label for="nameSearch" class="form-label mx-1 m-0 fw-medium">Name</label>
                        <input class="form-control mx-md-2  bg-body-secondary rounded" type="search" id="nameSearch"
                            value="<?php echo htmlspecialchars($name ?? ''); ?>" name="name" aria-label="Search">


                        <label for="eventStart" class="form-label mx-1 m-0 fw-medium">Start</label>
                        <input type="date" id="eventStart" class="form-control mx-md-2  bg-body-secondary  rounded"
                            value="<?php echo htmlspecialchars($startRange ?? ''); ?>" name="startRange">


                        <label for="eventEnd" class="form-label mx-1 m-0 fw-medium">End</label>
                        <input type="date" id="eventEnd" class="form-control mx-md-2  bg-body-secondary  rounded"
                            value="<?php echo htmlspecialchars($endRange ?? ''); ?>" name="endRange">


                        <div class=" w-100 my-2">
                            <input class="btn btn-outline-secondary w-100 rounded text-dark " value="search" type="submit"
                                name="search">
                        </div>


                    </form>
                </div>
        </div>
        <?php if ($eventLists): ?>
   

        <table class="table mt-3 table-borderless table rounded">
 
            <tr class="table-secondary ">
 
                <th>Event</th>
                <th>Date <span class="text-secondary">(Start/End)</span></span></th>
          
                <th  > </th>
          
            </tr>
   
            <?php echo '<tr >';
        foreach ($eventLists as $eventLists): ?>

            <td> <?php echo htmlspecialchars($eventLists['eventName']); ?> </td>
            <td>
                <span class="badge text-info-emphasis bg-primary-subtle"> 
                <?php echo htmlspecialchars($eventLists['eventStart']); ?> 
                </span>
                <span class="badge text-info-emphasis bg-primary-subtle"> 
                <?php echo htmlspecialchars($eventLists['eventEnd']); ?>
                </span>
            </td>
            <td class="width:3.5em">
            <?php if( $_SESSION['role'] == 1   ): ?>
            <div class="dropdown">
            <button class="  btn btn-transparent border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-ellipsis-vertical"></i>
            </button>
            <ul class="dropdown-menu">
                <li><a  class="dropdown-item" target="_blank" href="attendance_list.php?id=<?php echo $eventLists['event_id']; ?>"><i class="fa-solid fa-book me-3"></i>Attendance</a></li>
                <li><a  class="dropdown-item " href="event_Details.php?id=<?php echo $eventLists['event_id']; ?>"><i class="fa-solid fa-pencil me-3"></i>Edit Details</a></li>
                <li><a  class="dropdown-item  text-start  " href="view_list.php?id=<?php echo $eventLists['event_id']; ?>"><i class="fa-solid fa-users  me-3"></i>Guestlist</a> </li>
            </ul>
            </div>

            <?php else:?>
            <a  class="dropdown-item" target="_blank" href="attendance_list.php?id=<?php echo $eventLists['event_id']; ?>"><i class="fa-solid fa-book me-3"></i>Attendance</a>
            
                 
            <?php endif;?>
            </td>
            
 
            <?php echo '<tr>'; endforeach; ?>
        </table>
        <div class="row">
 
 
        <?php else: ?>
 
            <div class=" text-center  my-5">
            <div class="  mx-3" role="status">
            <span class="visually-hidden">Loading...</span>
            </div>  
            <h class="display-6">No Data Found</h>
             <div>
      
            </div>
            </div>
 
        <?php endif ?>
        <div class="col">
              
            </div>

        </div>

        <!--  -->

 
</div>
</div>
<?php include 'template/footer.php'; ?>
