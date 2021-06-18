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
			
		showRow('availableFor');
		showRow('rentalPriceName');
		showRow('securityMoneyName');
		hideRow('priceName');
		hideRow('bookingMoneyName');
		
	}
	else{
		
		document.getElementById("single-male").checked = false;
		document.getElementById("single-female").checked = false;
		document.getElementById("family").checked = true;
			
		hideRow('availableFor');
		hideRow('messUse');
		hideRow('maxNumPeople');
		
		hideRow('rentalPriceName');
		hideRow('securityMoneyName');
		showRow('priceName');
		showRow('bookingMoneyName');
		
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

function _(el){

	return document.getElementById(el);

}
		
function uploadFile_1(){

	var randomNum = _("randomNum_1").value;
	var key = _("key_1").value;
	var image = _("image_1").files[0];
	
	var extension = image.name.split('.').pop();
	
	if(!((extension == 'jpg') || (extension == 'jpeg') || (extension == 'png') || (extension == 'JPG') || (extension == 'JPEG') || (extension == 'PNG'))){
		
		alert('Only jpg,jpeg and png files are acceptable.');
		exit;
		
	}
	
	if(image.size > 5242880){
		
		alert('Photo size must not exceed 5 mb.');
		exit;
		
	}
	
	var name = _("upload-btn-wrapper_1");
	name.style.display = 'none';
	_("progressbarContainer_1").style.display = '';
	
	var formdata = new FormData();
	formdata.append("randomNum_1", randomNum);
	formdata.append("key_1", key);
	formdata.append("image_1", image);
	
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.open("POST", "fileUploadDelete/fileUpload.php");
	ajax.send(formdata);
	
	function progressHandler(event){
	
		var percent = (event.loaded / event.total) * 100;
		_("progressBar_1").value = Math.round(percent);
		
		if(percent == '100'){
			
			var randomNum = _("randomNum_1").value;
			var key = _("key_1").value;
			var image = _("image_1").files[0];
			var name = image.name;
			var extension = name.split('.').pop();
			
			var filename =  randomNum + '_' + key + '_' + '1.' + extension;
			
			var x = 3;
			
			var startTime = function startTime(){
				
				x = x - 1;
				
				if(x == 0){
					
					_("progressbarContainer_1").style.display = 'none';
					_("uploadedImage_1").src='uploadedPhotos/temp/' + filename;
					_("uploadedImage_1").style.display = '';
					_("remove_1").style.display = '';
				
				}
				
				if(x > 0){
					
					var t = setTimeout(startTime, 1000);
					
				}
		
			}
		
			startTime();
		
		}
	
	}
			
	function completeHandler(event){
	
		_("status").innerHTML = event.target.responseText;
		_("progressBar_1").value = 100;
	
	}
			
	function errorHandler(event){
	
		alert("Upload Failed");
	
	}
			
	function abortHandler(event){
	
		alert("Upload Aborted");
	
	}

}

function uploadFile_2(){

	var randomNum = _("randomNum_2").value;
	var key = _("key_2").value;
	var image = _("image_2").files[0];
	
	var extension = image.name.split('.').pop();
	
	if(!((extension == 'jpg') || (extension == 'jpeg') || (extension == 'png') || (extension == 'JPG') || (extension == 'JPEG') || (extension == 'PNG'))){
		
		alert('Only jpg,jpeg and png files are acceptable.');
		exit;
		
	}
	
	if(image.size > 5242880){
		
		alert('Photo size must not exceed 5 mb.');
		exit;
		
	}
	
	var name = _("upload-btn-wrapper_2");
	name.style.display = 'none';
	_("progressbarContainer_2").style.display = '';
	
	var formdata = new FormData();
	formdata.append("randomNum_2", randomNum);
	formdata.append("key_2", key);
	formdata.append("image_2", image);
	
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.open("POST", "fileUploadDelete/fileUpload.php");
	ajax.send(formdata);
	
	function progressHandler(event){
	
		var percent = (event.loaded / event.total) * 100;
		_("progressBar_2").value = Math.round(percent);
		
		if(percent == '100'){
			
			var randomNum = _("randomNum_2").value;
			var key = _("key_2").value;
			var image = _("image_2").files[0];
			var name = image.name;
			var extension = name.split('.').pop();
			
			var filename = randomNum + '_' + key + '_' + '2.' + extension;
			
			var x = 3;
			
			var startTime = function startTime(){
				
				x = x - 1;
				
				if(x == 0){
					
					_("progressbarContainer_2").style.display = 'none';
					_("uploadedImage_2").src='uploadedPhotos/temp/' + filename;
					_("uploadedImage_2").style.display = '';
				
				}
				
				if(x > 0){
					
					var t = setTimeout(startTime, 1000);
					
				}
		
			}
		
			startTime();
		
		}
	
	}
			
	function completeHandler(event){
	
		_("status").innerHTML = event.target.responseText;
		_("progressBar_2").value = 100;
	
	}
			
	function errorHandler(event){
	
		alert("Upload Failed");
	
	}
			
	function abortHandler(event){
	
		alert("Upload Aborted");
	
	}

}

function uploadFile_3(){

	var randomNum = _("randomNum_3").value;
	var key = _("key_3").value;
	var image = _("image_3").files[0];
	
	var extension = image.name.split('.').pop();
	
	if(!((extension == 'jpg') || (extension == 'jpeg') || (extension == 'png') || (extension == 'JPG') || (extension == 'JPEG') || (extension == 'PNG'))){
		
		alert('Only jpg,jpeg and png files are acceptable.');
		exit;
		
	}
	
	if(image.size > 5242880){
		
		alert('Photo size must not exceed 5 mb.');
		exit;
		
	}
	
	var name = _("upload-btn-wrapper_3");
	name.style.display = 'none';
	_("progressbarContainer_3").style.display = '';
	
	var formdata = new FormData();
	formdata.append("randomNum_3", randomNum);
	formdata.append("key_3", key);
	formdata.append("image_3", image);
	
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.open("POST", "fileUploadDelete/fileUpload.php");
	ajax.send(formdata);
	
	function progressHandler(event){
	
		var percent = (event.loaded / event.total) * 100;
		_("progressBar_3").value = Math.round(percent);
		
		if(percent == '100'){
			
			var randomNum = _("randomNum_3").value;
			var key = _("key_3").value;
			var image = _("image_3").files[0];
			var name = image.name;
			var extension = name.split('.').pop();
			
			var filename = randomNum + '_' + key + '_' + '3.' + extension;
			
			var x = 3;
			
			var startTime = function startTime(){
				
				x = x - 1;
				
				if(x == 0){
					
					_("progressbarContainer_3").style.display = 'none';
					_("uploadedImage_3").src='uploadedPhotos/temp/' + filename;
					_("uploadedImage_3").style.display = '';
				
				}
				
				if(x > 0){
					
					var t = setTimeout(startTime, 1000);
					
				}
		
			}
		
			startTime();
		
		}
	
	}
			
	function completeHandler(event){
	
		_("status").innerHTML = event.target.responseText;
		_("progressBar_3").value = 100;
	
	}
			
	function errorHandler(event){
	
		alert("Upload Failed");
	
	}
			
	function abortHandler(event){
	
		alert("Upload Aborted");
	
	}

}

function uploadFile_4(){

	var randomNum = _("randomNum_4").value;
	var key = _("key_4").value;
	var image = _("image_4").files[0];
	
	var extension = image.name.split('.').pop();
	
	if(!((extension == 'jpg') || (extension == 'jpeg') || (extension == 'png') || (extension == 'JPG') || (extension == 'JPEG') || (extension == 'PNG'))){
		
		alert('Only jpg,jpeg and png files are acceptable.');
		exit;
		
	}
	
	if(image.size > 5242880){
		
		alert('Photo size must not exceed 5 mb.');
		exit;
		
	}
	
	var name = _("upload-btn-wrapper_4");
	name.style.display = 'none';
	_("progressbarContainer_4").style.display = '';
	
	var formdata = new FormData();
	formdata.append("randomNum_4", randomNum);
	formdata.append("key_4", key);
	formdata.append("image_4", image);
	
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.open("POST", "fileUploadDelete/fileUpload.php");
	ajax.send(formdata);
	
	function progressHandler(event){
	
		var percent = (event.loaded / event.total) * 100;
		_("progressBar_4").value = Math.round(percent);
		
		if(percent == '100'){
			
			var randomNum = _("randomNum_4").value;
			var key = _("key_4").value;
			var image = _("image_4").files[0];
			var name = image.name;
			var extension = name.split('.').pop();
			
			var filename = randomNum + '_' + key + '_' + '4.' + extension;
			
			var x = 3;
			
			var startTime = function startTime(){
				
				x = x - 1;
				
				if(x == 0){
					
					_("progressbarContainer_4").style.display = 'none';
					_("uploadedImage_4").src='uploadedPhotos/temp/' + filename;
					_("uploadedImage_4").style.display = '';
				
				}
				
				if(x > 0){
					
					var t = setTimeout(startTime, 1000);
					
				}
		
			}
		
			startTime();
		
		}
	
	}
			
	function completeHandler(event){
	
		_("status").innerHTML = event.target.responseText;
		_("progressBar_4").value = 100;
	
	}
			
	function errorHandler(event){
	
		alert("Upload Failed");
	
	}
			
	function abortHandler(event){
	
		alert("Upload Aborted");
	
	}

}

function uploadFile_5(){

	var randomNum = _("randomNum_5").value;
	var key = _("key_5").value;
	var image = _("image_5").files[0];
	
	var extension = image.name.split('.').pop();
	
	if(!((extension == 'jpg') || (extension == 'jpeg') || (extension == 'png') || (extension == 'JPG') || (extension == 'JPEG') || (extension == 'PNG'))){
		
		alert('Only jpg,jpeg and png files are acceptable.');
		exit;
		
	}
	
	if(image.size > 5242880){
		
		alert('Photo size must not exceed 5 mb.');
		exit;
		
	}
	
	var name = _("upload-btn-wrapper_5");
	name.style.display = 'none';
	_("progressbarContainer_5").style.display = '';
	
	var formdata = new FormData();
	formdata.append("randomNum_5", randomNum);
	formdata.append("key_5", key);
	formdata.append("image_5", image);
	
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.open("POST", "fileUploadDelete/fileUpload.php");
	ajax.send(formdata);
	
	function progressHandler(event){
	
		var percent = (event.loaded / event.total) * 100;
		_("progressBar_5").value = Math.round(percent);
		
		if(percent == '100'){
			
			var randomNum = _("randomNum_5").value;
			var key = _("key_5").value;
			var image = _("image_5").files[0];
			var name = image.name;
			var extension = name.split('.').pop();
			
			var filename = randomNum + '_' + key + '_' + '5.' + extension;
			
			var x = 3;
			
			var startTime = function startTime(){
				
				x = x - 1;
				
				if(x == 0){
					
					_("progressbarContainer_5").style.display = 'none';
					_("uploadedImage_5").src='uploadedPhotos/temp/' + filename;
					_("uploadedImage_5").style.display = '';
				
				}
				
				if(x > 0){
					
					var t = setTimeout(startTime, 1000);
					
				}
		
			}
		
			startTime();
		
		}
	
	}
			
	function completeHandler(event){
	
		_("status").innerHTML = event.target.responseText;
		_("progressBar_5").value = 100;
	
	}
			
	function errorHandler(event){
	
		alert("Upload Failed");
	
	}
			
	function abortHandler(event){
	
		alert("Upload Aborted");
	
	}

}

function remove_1(){
	
	var randomNum = _("randomNum_1").value;
	var key = _("key_1").value;
	var image = _("image_1").files[0];
	
	var formdata = new FormData();
	formdata.append("randomNum_1", randomNum);
	formdata.append("key_1", key);
	formdata.append("image_1", image);
	
	var ajax = new XMLHttpRequest();
	ajax.addEventListener("load", completeHandler, false);
	ajax.open("POST", "fileUploadDelete/fileDelete.php");
	ajax.send(formdata);
	
	_("uploadedImage_1").style.display = 'none';
	_("upload-btn-wrapper_1").style.display = '';
	_("uploadedImage_1").src="";
			
	function completeHandler(event){
	
		_("status").innerHTML = event.target.responseText;
	
	}
	
}

function remove_2(){
	
	var randomNum = _("randomNum_2").value;
	var key = _("key_2").value;
	var image = _("image_2").files[0];
	
	var formdata = new FormData();
	formdata.append("randomNum_2", randomNum);
	formdata.append("key_2", key);
	formdata.append("image_2", image);
	
	var ajax = new XMLHttpRequest();
	ajax.addEventListener("load", completeHandler, false);
	ajax.open("POST", "fileUploadDelete/fileDelete.php");
	ajax.send(formdata);
	
	_("uploadedImage_2").style.display = 'none';
	_("upload-btn-wrapper_2").style.display = '';
	_("uploadedImage_2").src="";
			
	function completeHandler(event){
	
		_("status").innerHTML = event.target.responseText;
	
	}
	
}

function remove_3(){
	
	var randomNum = _("randomNum_3").value;
	var key = _("key_3").value;
	var image = _("image_3").files[0];
	
	var formdata = new FormData();
	formdata.append("randomNum_3", randomNum);
	formdata.append("key_3", key);
	formdata.append("image_3", image);
	
	var ajax = new XMLHttpRequest();
	ajax.addEventListener("load", completeHandler, false);
	ajax.open("POST", "fileUploadDelete/fileDelete.php");
	ajax.send(formdata);
	
	_("uploadedImage_3").style.display = 'none';
	_("upload-btn-wrapper_3").style.display = '';
	_("uploadedImage_3").src="";
			
	function completeHandler(event){
	
		_("status").innerHTML = event.target.responseText;
	
	}
	
}

function remove_4(){
	
	var randomNum = _("randomNum_4").value;
	var key = _("key_4").value;
	var image = _("image_4").files[0];
	
	var formdata = new FormData();
	formdata.append("randomNum_4", randomNum);
	formdata.append("key_4", key);
	formdata.append("image_4", image);
	
	var ajax = new XMLHttpRequest();
	ajax.addEventListener("load", completeHandler, false);
	ajax.open("POST", "fileUploadDelete/fileDelete.php");
	ajax.send(formdata);
	
	_("uploadedImage_4").style.display = 'none';
	_("upload-btn-wrapper_4").style.display = '';
	_("uploadedImage_4").src="";
			
	function completeHandler(event){
	
		_("status").innerHTML = event.target.responseText;
	
	}
	
}

function remove_5(){
	
	var randomNum = _("randomNum_5").value;
	var key = _("key_5").value;
	var image = _("image_5").files[0];
	
	var formdata = new FormData();
	formdata.append("randomNum_5", randomNum);
	formdata.append("key_5", key);
	formdata.append("image_5", image);
	
	var ajax = new XMLHttpRequest();
	ajax.addEventListener("load", completeHandler, false);
	ajax.open("POST", "fileUploadDelete/fileDelete.php");
	ajax.send(formdata);
	
	_("uploadedImage_5").style.display = 'none';
	_("upload-btn-wrapper_5").style.display = '';
	_("uploadedImage_5").src="";
			
	function completeHandler(event){
	
		_("status").innerHTML = event.target.responseText;
	
	}
	
}