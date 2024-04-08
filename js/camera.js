 
    document.getElementById('waitMessage').innerText = "Please wait...";
    setTimeout(function() {
      
	let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});
	Instascan.Camera.getCameras().then(function(cameras){
		if(cameras.length > 0){
			scanner.start(cameras[0]);
		}else{
			 
		}
    document.getElementById('waitMessage').innerText = "";
	}).catch(function(e){
		console.error(e);
	});

	scanner.addListener('scan',function(c){
		document.getElementById('attendeesName').value=c;
        // 1 Sec Delay to Avoid Time in and Time out in the flash
        document.getElementById('btnsubmit').click();
    
	}); }, 1000);
 