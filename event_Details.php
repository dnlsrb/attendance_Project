<?php include 'config/auth/auth_all.php'; ?>
<?php include('config/auth/auth_admin.php');?>
<?php require 'config/Controller/event_details_controller.php'; ?>

<?php $title = "DETAILS | 
" . htmlspecialchars($eventList['eventName']);?>
<?php include 'template/header.php'; ?>
<div class="container-fluid  ">


 

    <div class="card border-0 bg-transparent rounded-0 py-4 ">
        
        <div class="card card-header bg-transparent   border-0 p-0">
    
               
                <div class="d-flex justify-content-between ">
                        <div>
                            <a href="event_list.php" type="input" class="btn btn-secondary   rounded-0"><i class="fa-solid fa-arrow-left"></i></a>
                            <a href="view_list.php?id=<?php echo htmlspecialchars($event_id);  ?>" type="input" class="btn btn-primary rounded-0 mx-1"> <i class="bi bi-eye-fill"></i></a>
                        </div>
                        <div class="d-flex"> 
                            <div class="order-2 "> 
                                <form action="event_Details.php?id='<?php echo htmlspecialchars($eventList['event_id']); ?>'" method="POST">
                                    <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($eventList['event_id']); ?>">
                                    <button type="submit" class="btn btn-danger  rounded-0   " onclick="return confirm('Are you sure you want to delete?');" name="delete" value="Yes" >
                                    <i class="fa-solid fa-trash"></i></button>
                                </form> 
                            </div>
                            <div class="order-1"> 
                                <form action="event_Details.php?id=<?php echo $event_id; ?>" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($eventList['event_id']); ?>">
                                    <button type="submit" class="mx-1 btn btn-success rounded-0   " value="Save" name="submit"><i class="fa-solid fa-floppy-disk"></i></button>
                            </div>
                        </div>
                    
                </div>
  
        </div>
        <div class="card card-body border-0 p-0 rounded-0 mt-4 bg-transparent">
            <h3>Details</h3>
            <hr class="border border-secondary">

            <div class="row mb-3">
                <label for="eventName" class="col-sm-5  col-form-label col-form-label-sm">Event Name:</label>
                <div class="col-sm-7 d-flex justify-content-end">
                    <input name="eventName" class="col-sm-5 form-control border-secondary rounded-0 form-control-sm <?php if (isset($errors['eventName'])) : ?>border-danger <?php endif ?>" id="eventName" value="<?php echo htmlspecialchars($eventList['eventName']) ?? ''; ?>" type="text">
                </div>
            </div>

            <div class="row mb-3">
                <label for="eventStart" class="col-sm-5 col-form-label col-form-label-sm">Event Start</label>

                <div class="col-sm-7">
                    <input type="date" class="col-sm-5 form-control border-secondary rounded-0 form-control-sm <?php if (isset($errors['eventStart'])) : ?>border-danger <?php endif ?>" id="eventStart" name="eventStart" value="<?php echo htmlspecialchars($eventList['eventStart']); ?>">
                </div>
            </div>


            <div class="row mb-3">
                <label for="eventEnd" class="col-sm-5 col-form-label col-form-label-sm">Event End</label>
                <div class="col-sm-7">
 
                    <input type="date" class="col-sm-5 form-control border-secondary rounded-0 form-control-sm <?php if (isset($errors['eventEnd'])) : ?>border-danger <?php endif ?>" id="eventEnd" name="eventEnd" value="<?php echo htmlspecialchars($eventList['eventEnd']); ?>">
                </div>
            </div>

            <h3>Banner</h3>
            <hr>
            <div class="row d-flex  " id="header_banner" style="background-image:url( image/header/<?php echo htmlspecialchars($eventList['eventHeaderImage']) ?? ''; ?> ) ;  background-size: cover; height:20vh;">
 
                <div class="col-sm-5  "> <input type="file" name="eventHeaderImage" class="border-secondary rounded-0 form-control bg-white" accept=".jpg, .png, .jpeg, .gif,"></div>

            </div>
            <div class="row mb-3 " style="background-image:url(image/background/<?php echo htmlspecialchars($eventList['eventBackgroundImage']) ?? ''; ?>) ;  background-size: cover; height:100vh;">
 
                <div class="col-sm-5  "> <input type="file" name="eventBackgroundImage" class="border-secondary rounded-0 form-control bg-white" accept=".jpg, .png, .jpeg, .gif,"></div>
             
            </div>

            <input type="hidden" name="old_header_path" value="<?php echo htmlspecialchars($eventList['eventHeaderImage']) ?? ''; ?>">
            <input type="hidden" name="old_background_path" value="<?php echo htmlspecialchars($eventList['eventBackgroundImage']) ?? ''; ?>">

            </form>
     





        </div>

    </div>

</div>
<?php include 'template/footer.php'; ?>