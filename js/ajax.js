$(document).ready(function(){

	$("#adiciona").change(function(){
	    $.get("ajax.php", function(data, status){
	    	console.log(data);
	    	console.log(Object.keys(data).length);
	    }, "json");
	});
});