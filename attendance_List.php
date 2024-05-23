<?php include('config/auth/auth_all.php'); ?>

<?php require('config/Controller/attendance_controller.php'); ?>


<?php $header = 'background-image:url( image/header/' . htmlspecialchars($eventLists['eventHeaderImage']) . ' ) ;  background-size: cover; height:20vh; ' ?>
<?php $title = htmlspecialchars($eventLists['eventName']); ?>
<?php include('template/header.php') ?>

<!-- SCRIPT -->
<script src="js/instascan.js"></script>
<script src="js/time.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<!-- SCRIPT -->


<style>
    body {
        background-image: url("image/background/<?php echo htmlspecialchars($eventLists['eventBackgroundImage']); ?>");
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;

    }
</style>

<div class="position-relative">






    <div class="container-fluid  position-relative">
        <div id="message" class="alert alert-light  shadow-sm mt-2 rounded-0 fw-bold position-fixed bottom-0 end-0 mx-2 border-black z-2  " role="alert">
            WELCOME TO <?php echo  strtoupper(htmlspecialchars($eventLists['eventName'])); ?>
        </div>

        <div class="row">
            <div class="d-flex justify-content-center align-items-center mt-1">

                <h3 class="fw-bold"><u><?php echo htmlspecialchars($eventLists['eventName']); ?></u> </h3>
                <span class="badge text-bg-primary m-3" id="count"></span>
                <hr>
            </div>
            <div class="col-sm-4 col-12  ">
                <div class="position-sticky top-0 ">
                    <div class="text-center  " onLoad="startTime()">
                        <strong>
                            <time class="display-3 fw-bold" id="time">00:00:00</time><br>
                            <p class="h5"><?php echo "Today is " . date("l F d, Y"); ?></p>
                        </strong>
                    </div>

                    <video id="preview" width="100%"> </video>
                    <p class="h6 text-center " id="waitMessage"></p>
                    <span id="attendeesError"></span>
                    <form id="scan_form" autocomplete="off">
                        <div>
                            <input type="text" name="attendeesName" id="attendeesName" class="w-100 form-control border-2 border-dark border rounded-0" placeholder="Attendees Name">
                            <input type="hidden" name="event_id" id="get_id" value="<?php echo htmlspecialchars($id);  ?>">
                            <input type="submit" id="btnsubmit" class="d-sm-none w-100" name="submit" value="submit">
                        </div>
                    </form>
                </div>
            </div>

            <script>
                $(function() {
                    function sendData($form) {
                        let dataString = $form.serialize();

                        return $.ajax({
                            type: 'POST',
                            url: 'get_attendance',
                            data: dataString,
                            dataType: "json",
                            success: function(data) {
                                $("#message").empty();
                                $("#message").empty().html(data.name_message.message).fadeIn().delay(5000).fadeOut();

                            },
                        });

                    }

                    $('form').on('submit', function(e) {
                        e.preventDefault();

                        let $attendeesNameInput = $('#attendeesName');
                        sendData($(this));
                        $attendeesNameInput.val('');
                    });
                });
            </script>


            </style>
            <div class="col   overflow-y-auto">


                <?php if ($eventLists) : ?>
                    <table class="no-background table table-transparent shadow-sm opacity-75">
                        <thead>
                            <tr>

                                <th>NAME</th>
                                <th>TIME IN</th>
                                <th>TIME OUT</th>
                            </tr>
                        </thead>
                        <tbody id="data-container">
                            <!-- Attendance data will be appended here -->
                        </tbody>
                    </table>

                    <script src="js/camera.js"></script>

                <?php else : ?>
                <?php endif; ?>
            </div>
        </div>

    </div>





    <br>
</div>
</div>


<script>
    $(function() {
        // Function to fetch attendance data
        function fetchAttendance() {
            $.ajax({
                type: "GET",
                url: "get_list_attendance?id=<?php echo $id; ?>",
                dataType: "json",
                success: function(data) {
                    $("#data-container").empty();
                    data.attendees_Records.forEach(function(record) {
                        $("#data-container").append('<tr><td class="fw-bold">' + $('<div>').text(record.attendeesName).html() + '</td>' + '<td class="fw-bold text-success">' + record.time_IN + '</td>' + '<td class="fw-bold text-primary  ">' + record.time_OUT + '</td></tr>');

                    });
                    $("#count").html('<tr><td class="fw-bold">' + data.count_display + '</tr>');
                }
            });
        }


        // Fetch attendance initially
        // fetchAttendance();

        // Update attendance every 2 seconds (adjust interval as needed)
        setInterval(fetchAttendance, 2000);
    });
</script>

</div>
</div>
</div>
</div>


<footer class="d-flex flex-wrap  bottom-0 w-100  justify-content-center align-items-center py-3 my-4 border-top">



    <div class="text-center">
        <!-- <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
 <img src="storage/logo2.png" alt="GXII" width="30"   >
 </a> -->
        <figure>
            <blockquote class="blockquote">
                <p>"A vision to seek for options so that quality medical treatment may not have to be expensive"</p>
            </blockquote>
            <figcaption class="blockquote-footer">
                Rodolfo I. Gracia
            </figcaption>
        </figure>
    </div>



</footer>
</body>

</html>