$(function(){
	
    $("#datepicker").datepicker({
		
		changeMonth: true,
		changeYear: true,
		yearRange: "c-20:c+20",
		dateFormat: 'dd-mm-yy',
		minDate: '-10y',
		maxDate: '10y'
		
    });
	
});

function checkIfInputHasVal(){
	
	if($("#datepicker").val==""){
		
		alert("formAfterRederict should have a value");
		return false;
	}
	
}

function changeAdType(a){
	
	var x = (a.value || a.options[a.selectedIndex].value);
	
	function showRow(id){

		var row = document.getElementById(id);
		row.style.display = '';
		
	}
	
	function hideRow(id){

		var row = document.getElementById(id);
		row.style.display = 'none';
		
	}
	
	if(x == 'rent'){
			
		showRow('rentalPriceName');
		showRow('securityMoneyName');
		hideRow('priceName');
		hideRow('bookingMoneyName');
		
	}
	else{
		
		hideRow('rentalPriceName');
		hideRow('securityMoneyName');
		showRow('priceName');
		showRow('bookingMoneyName');
		
	}
	
}