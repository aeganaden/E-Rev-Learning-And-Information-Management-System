$(document).ready(function() {
	$(".button-collapse").sideNav();
	$('.modal').modal();
	$('.slider').slider({
		indicators:false,
		height: 500
	});
	positionOverlayDiv();
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