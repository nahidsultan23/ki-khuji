function startTime(){
	
	var today = new Date();
	var h = today.getHours();
	var m = today.getMinutes();
	var s = today.getSeconds();
	var ampm = 'am';
	
	if(h >= 12){
		
		ampm = 'pm';
		
	}
	
	h = h % 12;
	
	if(h == 0){
		
		h = 12;
		
	}
	
	h = checkTime(h);
	m = checkTime(m);
	s = checkTime(s);
	
	document.getElementById('clock').innerHTML = h + ':' + m + ':' + s + ' ' + ampm;
	
	var t = setTimeout(startTime, 1000);
	
}

function checkTime(i){
	
	if (i < 10) {i = '0' + i};  // add zero in front of numbers < 10
	return i;
	
}