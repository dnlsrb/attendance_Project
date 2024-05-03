document.getElementById('waitMessage').innerText = "Please wait...";
setTimeout(function() {
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});
    Instascan.Camera.getCameras().then(function(cameras){
        if(cameras.length > 0){
            scanner.start(cameras[0]);
        } else {
            // Handle no cameras
        }
        document.getElementById('waitMessage').innerText = "";
    }).catch(function(e){
        console.error(e);
    });

    // Variable to keep track of button click status
    let btnClicked = false;

    scanner.addListener('scan',function(c){
        if (!btnClicked) {
            // Set button click status to true
            btnClicked = true;

            // Set a timeout to reset button click status after 1 second
            setTimeout(function() {
                btnClicked = false;
            }, 1000);

            document.getElementById('attendeesName').value=c;
            document.getElementById('btnsubmit').click();
        }
    });
}, 1000);