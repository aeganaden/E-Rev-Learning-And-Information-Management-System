$(document).ready(function() {
	$(".button-collapse").sideNav();
	$('.modal').modal();
	$('.slider').slider({
		indicators:false,
		height: 500
	});
	positionOverlayDiv();
	initiateOnClick();
	
});

function positionOverlayDiv(){
	var margin_top = getDivHeightClass("a-navbar");
	var height = getDivHeightID("a-div-slider");
	$("#a-div-overlay").css({
		"top":margin_top, 
		"height": height
	});
}

function getDivHeightClass(x){	
	var height = $("."+x).height();
	return height;
}
function getDivHeightID(x){	
	var height = $("#"+x).height();
	return height;
}

/*================================
=            Admin JS            =
================================*/

function initiateOnClick(){
	showReportonClick("card-cosml","div-card-cosml","div-card-ls","div-card-lahr","div-card-lcl");
	showReportonClick("card-ls","div-card-ls","div-card-cosml","div-card-lahr","div-card-lcl");
	showReportonClick("card-lahr","div-card-lahr","div-card-cosml","div-card-ls","div-card-lcl");
	showReportonClick("card-lcl","div-card-lcl","div-card-cosml","div-card-ls","div-card-lahr");
}

function showReportonClick(id,div_id,div_hide_1,div_hide_2,div_hide_3){
	$("#"+id).click(function(event) {
		$("#"+div_id).fadeIn();
		$("#"+div_id).css("display","block");
		$("#"+div_hide_1).css("display","none");
		$("#"+div_hide_2).css("display","none");
		$("#"+div_hide_3).css("display","none");

	});
}

/*=====  End of Admin JS  ======*/
