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

function changeMale(a){
	
	var checkBox = document.getElementById("single-male");
	
		if (checkBox.checked == true){
			
			function showRow(id){
	
				var row = document.getElementById(id);
				row.style.display = '';
				
			}
				
			showRow('messUse');
			
		}
		else{
			
			if(a == 0){
				
				function hideRow(id){
			
					var row = document.getElementById(id);
					row.style.display = 'none';
					
				}
					
				hideRow('messUse');
				hideRow('maxNumPeople');
				
				radiobtn = document.getElementById("messUseNo");
				radiobtn.checked = true;
				
			}
			
		}
	
}

function changeFemale(a){
	
	var checkBox = document.getElementById("single-female");
	
		if (checkBox.checked == true){
		
			function showRow(id){
	
				var row = document.getElementById(id);
				row.style.display = '';
				
			}
				
			showRow('messUse');
			
		}
		else{
			
			if(a == 0){
				
				function hideRow(id){
			
					var row = document.getElementById(id);
					row.style.display = 'none';
					
				}
					
				hideRow('messUse');
				hideRow('maxNumPeople');
			
				radiobtn = document.getElementById("messUseNo");
				radiobtn.checked = true;
				
			}
			
		}
	
}

var checkedOne = 0;

function oneChanged(){
	
	var checkBoxMale = document.getElementById("single-male");
	var checkBoxFemale = document.getElementById("single-female");
	
	if (checkBoxMale.checked == true){
		
		checkedOne = 1;
		
	}
	else if (checkBoxFemale.checked == true){
		
		checkedOne = 1;
		
	}
	else{
		
		checkedOne = 0;
		
	}
	
	if (checkBoxMale.checked == true){
		
		changeMale(checkedOne);
		
	}
	else{
		
		changeMale(checkedOne);
		
	}
	
	if (checkBoxFemale.checked == true){
		
		changeFemale(checkedOne)
		
	}
	else{
		
		changeFemale(checkedOne)
		
	}
	
}

function changeMessInfo(a){
	
	var x = (a.value || a.options[a.selectedIndex].value);
	
	if(x == 'yes'){
		
		function showRow(id){
	
			var row = document.getElementById(id);
			row.style.display = '';
			
		}
			
		showRow('maxNumPeople');
		
	}
	else{
		
		function hideRow(id){
	
			var row = document.getElementById(id);
			row.style.display = 'none';
			
		}
			
		hideRow('maxNumPeople');
		
	}
	
}