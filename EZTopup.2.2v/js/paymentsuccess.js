var checkBox = document.getElementById("detail-checkbox");
var text = document.getElementById("");
function myFunction() {
	if (checkBox.checked == true){
		alert("Purchase has been successfully, thank you.");
	 }
	else{
		alert("Purchase has been rejected! Please tick the checkbox.");
	}
}