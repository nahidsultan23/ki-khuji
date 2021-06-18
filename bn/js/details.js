function preNext(x){
	
	var y = ['','','','',''];
	var currentPhoto = document.getElementById('bigPhoto').src;
	var i;
	
	for(i=1; i<=5; i++){
		
		if(document.getElementById('photoInside' + i)){
			
			y[i-1] = document.getElementById('photoInside' + i).src;
			
		}
		
	}
	
	if(currentPhoto == y[0]){
		
		if(x == 'next'){
			
			document.getElementById('bigPhoto').src = y[1];
			
			document.getElementById('previous').style.display = '';
			
			if(y[2]){
				
				document.getElementById('next').style.display = '';
				
			}
			else{
				
				document.getElementById('next').style.display = 'none';
				
			}
			
		}
		
	}
	else if(currentPhoto == y[1]){
		
		if(x == 'previous'){
			
			document.getElementById('bigPhoto').src = y[0];
			
			document.getElementById('previous').style.display = 'none';
			document.getElementById('next').style.display = '';
			
		}
		else if(x == 'next'){
			
			document.getElementById('bigPhoto').src = y[2];
			
			document.getElementById('previous').style.display = '';
			
			if(y[3]){
				
				document.getElementById('next').style.display = '';
				
			}
			else{
				
				document.getElementById('next').style.display = 'none';
				
			}
			
		}
		
	}
	else if(currentPhoto == y[2]){
		
		if(x == 'previous'){
			
			document.getElementById('bigPhoto').src = y[1];
			
			document.getElementById('previous').style.display = '';
			document.getElementById('next').style.display = '';
			
		}
		else if(x == 'next'){
			
			document.getElementById('bigPhoto').src = y[3];
			
			document.getElementById('previous').style.display = '';
			
			if(y[4]){
				
				document.getElementById('next').style.display = '';
				
			}
			else{
				
				document.getElementById('next').style.display = 'none';
				
			}
			
		}
		
	}
	else if(currentPhoto == y[3]){
		
		if(x == 'previous'){
			
			document.getElementById('bigPhoto').src = y[2];
			
			document.getElementById('previous').style.display = '';
			document.getElementById('next').style.display = '';
			
		}
		else if(x == 'next'){
			
			document.getElementById('bigPhoto').src = y[4];
			
			document.getElementById('previous').style.display = '';
			document.getElementById('next').style.display = 'none';
			
		}
		
	}
	else if(currentPhoto == y[4]){
		
		if(x == 'previous'){
			
			document.getElementById('bigPhoto').src = y[3];
			
			document.getElementById('previous').style.display = '';
			document.getElementById('next').style.display = '';
		
		}
		
	}
	
}

function showIt(x){
	
	var y = ['','','','',''];
	var i;
	
	for(i=1; i<=5; i++){
		
		if(document.getElementById('photoInside' + i)){
			
			y[i-1] = document.getElementById('photoInside' + i).src;
			
		}
		
	}
	
	if(x == 0){
		
		document.getElementById('bigPhoto').src = y[0];
		
		document.getElementById('previous').style.display = 'none';
		
		if(y[1]){
			
			document.getElementById('next').style.display = '';
			
		}
		else{
			
			document.getElementById('next').style.display = 'none';
			
		}
		
	}
	else if(x == 1){
		
		document.getElementById('bigPhoto').src = y[1];
		
		document.getElementById('previous').style.display = '';
		
		if(y[2]){
			
			document.getElementById('next').style.display = '';
			
		}
		else{
			
			document.getElementById('next').style.display = 'none';
			
		}
		
	}
	else if(x == 2){
		
		document.getElementById('bigPhoto').src = y[2];
		
		document.getElementById('previous').style.display = '';
		
		if(y[3]){
			
			document.getElementById('next').style.display = '';
			
		}
		else{
			
			document.getElementById('next').style.display = 'none';
			
		}
		
	}
	else if(x == 3){
		
		document.getElementById('bigPhoto').src = y[3];
		
		document.getElementById('previous').style.display = '';
		
		if(y[4]){
			
			document.getElementById('next').style.display = '';
			
		}
		else{
			
			document.getElementById('next').style.display = 'none';
			
		}
		
	}
	else if(x == 4){
		
		document.getElementById('bigPhoto').src = y[4];
		
		document.getElementById('previous').style.display = '';
		document.getElementById('next').style.display = 'none';
		
	}
	
}

function popUp(x){
	
	document.getElementById(x).style.display = '';
	
}

function popDown(x){
	
	document.getElementById(x).style.display = 'none';
	
}