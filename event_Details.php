<?php include 'config/auth/auth_all.php'; ?>
<?php require 'config/Controller/event_details_controller.php'; ?>


<?php include 'template/header.php'; ?>
<div class="container-fluid  ">



    <div class="card border-0 rounded-0 mt-2">
        <div class="card card-header rounded-0">
            <h2><?php echo htmlspecialchars($eventList['eventName']); ?></h2>


            <form action="event_Details.php?id=<?php echo $event_id; ?>" method="POST" enctype="multipart/form-data">


        </div>
        <div class="card card-footer order-2">
            <div class="d-flex justify-content-end">
                <div>
                    <a href="event_List.php" type="input" class="  me-3">Back</a>
                </div>

                <div class="d-flex justify-content-start">

                    <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($eventList['event_id']); ?>">
                    <input type="submit" class="  mx-1" value="Save" name="submit">
                </div>
            </div>
        </div>
        <div class="card card-body border-0 rounded-0 order-1">
            <h3>Details</h3>
            <hr>

            <div class="row mb-3">
                <label for="eventName" class="col-sm-5  col-form-label col-form-label-sm">Event Name:</label>
                <div class="col-sm-7 d-flex justify-content-end">
                    <input name="eventName" class="col-sm-5 form-control  form-control-sm <?php if (isset($errors['eventName'])) : ?>border-danger <?php endif ?>" id="eventName" value="<?php echo htmlspecialchars($eventList['eventName']) ?? ''; ?>" type="text">
                </div>
            </div>

            <div class="row mb-3">
                <label for="eventStart" class="col-sm-5 col-form-label col-form-label-sm">Event Start</label>

                <div class="col-sm-7">
                    <input type="date" class="col-sm-5 form-control form-control-sm <?php if (isset($errors['eventStart'])) : ?>border-danger <?php endif ?>" id="eventStart" name="eventStart" value="<?php echo htmlspecialchars($eventList['eventStart']); ?>">
                </div>
            </div>


            <div class="row mb-3">
                <label for="eventEnd" class="col-sm-5 col-form-label col-form-label-sm">Event End</label>
                <div class="col-sm-7">
 
                    <input type="date" class="col-sm-5 form-control form-control-sm <?php if (isset($errors['eventEnd'])) : ?>border-danger <?php endif ?>" id="eventEnd" name="eventEnd" value="<?php echo htmlspecialchars($eventList['eventEnd']); ?>">
                </div>
            </div>

            <h3>Banner</h3>
            <hr>
            <div class="row mb-3">
                <h6>Background</h6>
                <div class="col-sm-5"> <input type="file" name="eventBackgroundImage" accept=".jpg, .png, .jpeg, .gif,"></div>
                <div class="col-sm-7  ">

                    <img src="image/background/<?php echo htmlspecialchars($eventList['eventBackgroundImage']) ?? ''; ?>" class="col-sm-5 " width="30%">
                </div>
            </div>

            <div class="row mb-3">
                <h6>Header</h6>
                <div class="col-sm-5"> <input type="file" name="eventHeaderImage" accept=".jpg, .png, .jpeg, .gif,">
                </div>
                <div class="col-sm-7  ">

                    <img src="image/header/<?php echo htmlspecialchars($eventList['eventHeaderImage']) ?? ''; ?>" class="col-sm-5 " width="30%">
                </div>
            </div>

            <input type="hidden" name="old_header_path" value="<?php echo htmlspecialchars($eventList['eventHeaderImage']) ?? ''; ?>">
            <input type="hidden" name="old_background_path" value="<?php echo htmlspecialchars($eventList['eventBackgroundImage']) ?? ''; ?>">

            </form>
            <h3>Action</h3>
            <hr>
            <div class="row mb-3 d-flex align-items-center">
                <div class="col-sm-5 col-5">Cancel Event</div>
                <div class="col-sm-7 col-5">

                    <form action="event_Details.php?id='<?php echo htmlspecialchars($eventList['event_id']); ?>'" method="POST">
                        <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($eventList['event_id']); ?>">
                        <div>
                            <input type="submit" class="btn btn-danger  rounded-0  " name="delete" value="Yes">
                        </div>
                    </form>
                </div>
            </div>





        </div>

    </div>

</div>
<?php include 'template/footer.php'; ?>