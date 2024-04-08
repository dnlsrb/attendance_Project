 

 
function startTime()
{
	var today=new Date();
	var h=today.getHours();
	var m=today.getMinutes();
	var s=today.getSeconds();

	
	var time_ampm = today.toLocaleTimeString();
	m=checkTime(m);
	s=checkTime(s);
	
	if(h>12)
	{
		h=h-12;
	}
	document.getElementById('time').innerHTML=time_ampm;
	document.getElementById('time').innerHTML=time_ampm;
	t=setTimeout(function(){startTime()},500);
}
function checkTime(i)   
{
	if (i<10)
	{
	  i="0" + i;
	}
	return i;
}
 
 window.onload = function() {
    startTime();
};
 