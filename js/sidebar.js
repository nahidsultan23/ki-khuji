function openNav() {
	document.getElementById("propertiesList").style.height = "258px";
	document.getElementById("propertiesClose").style.display = "";
	document.getElementById("propertiesOpen").style.display = "none";
}

function closeNav() {
	document.getElementById("propertiesList").style.height = "0";
	document.getElementById("propertiesClose").style.display = "none";
	document.getElementById("propertiesOpen").style.display = "";
}