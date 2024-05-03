<?php include 'config/auth/auth_all.php'; ?>
<?php require 'config/Controller/event_list_controller.php'; ?>


<?php $title ="Events"?>
<?php include 'template/header.php'; ?>


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



                    <label for="eventName" class="form-label">Event Name:</label>
                    <?php if(isset($errors['eventName'])): ?><span class="text-danger ">*</span><?php endif;?>
                    <input type="text" id="eventName"
                        class="form-control  <?php if(isset($errors['eventName'])): ?>border-danger<?php endif;?>" name="eventName"
                        value="<?php echo htmlspecialchars($eventData['eventName'] ?? ''); ?>"><br>
                    <label for="TableBackground" class="form-label">Background Image</label>
                    <input type="file" id="TableBackground" class="form-control" name="eventBackgroundImage"
                        accept=".jpg, .png, .jpeg, .gif,"> <br>
                    <label for="bannerImage" class="form-label">Banner Image</label>
                    <input type="file" id="bannerImage" class="form-control" name="eventHeaderImage"
                        accept=".jpg, .png, .jpeg, .gif,"> <br>
                    <label for="eventStart" class="form-label">Start of Event</label>
                    <?php if(isset($errors['eventStart'])): ?><span class="text-danger ">*</span><?php endif;?>
                    <input type="date" id="eventStart" value="<?php echo htmlspecialchars($eventData['eventStart'] ?? ''); ?>"
                        class="form-control  <?php if(isset($errors['eventStart'])): ?>border-danger<?php endif;?>" name="eventStart"
                        min="<?php echo date('Y-m-d'); ?>"><br>
                    <label for="eventEnd" class="form-label">End of Event</label>
                    <?php if(isset($errors['eventEnd'])): ?><span class="text-danger ">*</span><?php endif;?>
                    <input type="date" id="eventEnd" value="<?php echo htmlspecialchars($eventData['eventEnd'] ?? ''); ?>"
                        class="form-control  <?php if(isset($errors['eventEnd'])): ?>border-danger<?php endif;?>" name="eventEnd"
                        min="<?php echo date('Y-m-d'); ?>">
                    <br>


                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="submit" name="submit">
                </div>
            </form>
        </div>
    </div>
</div>


<div class="container-fluid   my-5">
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
            <div class="row d-flex align-items-start py-2  ">
                <div class="col-md col-6  p-1 ">
                    <h3>Events</h3>
                </div>

                <div class=" col-md col-6 d-flex justify-content-end order-1 order-md-2  p-1 ">
                    <div>
                        <button type="button" class="btn btn-primary w-100 " data-bs-toggle="modal"
                            data-bs-target="#create_event">
                            <i class="bi bi-plus-lg"></i> Create Event </button>
                    </div>
                </div>

            </div>

        </div>
        <?php if ($eventLists): ?>
        <?php $orderNumber = 1; ?>

        <table class="table">
            <tr>
                <th scope="col">#</th>
                <th>Name</th>
                <th>Date</th>
                <th>Action</th>
            </tr>


            <?php echo '<tr>';
        foreach ($eventLists as $eventLists): ?>

            <th scope="row"><?php echo $orderNumber . '.'; ?></th>
         
            <td><a target="_blank" href="attendance_List.php?id=<?php echo $eventLists['event_id']; ?>"><?php echo htmlspecialchars($eventLists['eventName']); ?></a></td>
            <td><?php echo htmlspecialchars($eventLists['eventStart']); ?> <b>-</b> <?php echo htmlspecialchars($eventLists['eventEnd']); ?></td>
        


            <td>

                <a href="event_Details.php?id=<?php echo $eventLists['event_id']; ?>" class="mx-1"> <i class="bi bi-pencil-fill"></i></a>
                <a href="view_list.php?id=<?php echo $eventLists['event_id']; ?>" class="mx-1"> <i class="bi bi-eye-fill"></i></a>
            </td>
            <?php $orderNumber++; ?>
            <?php echo '<tr>'; endforeach; ?>
        </table>
        <div class="row">

            <div class="col  ">
                <nav aria-label="Page navigation example" class="d-flex align-items-center">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>


            




        <?php else: ?>
        <h1>No Data Found</h1>

        <?php endif ?>
        <div class="col">
                <div class="card card-header p-0 px-2 rounded-1 bg-white">
                    <form action="event_List.php" method="GET" class="d-md-flex   align-items-center"
                        role="search">


                        <label for="nameSearch" class="form-label mx-1 m-0 fw-medium">Name</label>
                        <input class="form-control mx-md-2" type="search" id="nameSearch"
                            value="<?php echo htmlspecialchars($name ?? ''); ?>" name="name" aria-label="Search">


                        <label for="eventStart" class="form-label mx-1 m-0 fw-medium">Start</label>
                        <input type="date" id="eventStart" class="form-control mx-md-2"
                            value="<?php echo htmlspecialchars($startRange ?? ''); ?>" name="startRange">


                        <label for="eventEnd" class="form-label mx-1 m-0 fw-medium">End</label>
                        <input type="date" id="eventEnd" class="form-control mx-md-2"
                            value="<?php echo htmlspecialchars($endRange ?? ''); ?>" name="endRange">


                        <div class=" w-100 my-2">
                            <input class="btn btn-outline-secondary w-100 " value="search" type="submit"
                                name="search">
                        </div>


                    </form>
                </div>
            </div>

        </div>

        <!--  -->

    </div>
</div>

<?php include 'template/footer.php'; ?>
