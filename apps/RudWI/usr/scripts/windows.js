/**
 * $Id$ 
 * $URL$
 * $Revision$
 */

$(document).ready(function() {
	$(".reload").click(function(event){
     event.preventDefault();
	 location.reload(); 
   });

	$("#testwin").newWindow({
		//ajaxURL: "ajaxcontent.html",
		ajaxURL: "http://work.rudisoft.dev/RudWEb/test/users/error",
		windowTitle : "Test Window",
		width : 500,
		height : 400,
		posx : 400,
		posy : 100
	});
});