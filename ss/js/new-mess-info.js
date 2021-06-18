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