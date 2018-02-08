$(document).ready(function() {
	$(".button-collapse").sideNav({
		onOpen: function(el) { 
			$("#slide-out").css("display","block");
		},
	});
	$('.modal').modal();
	$('.collapsible').collapsible();
	$('select').material_select();
	$(".dropdown-button").dropdown();
	$('.slider').slider({
		indicators:false,
		height: 500
	});
	$('input#input_text, textarea#reg_expertise').characterCounter();
	
	$('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15, // Creates a dropdown of 15 years to control year,
    today: false,
    clear: 'Clear',
    close: 'Ok',
    hiddenName: true,
    min: new Date("now"),
    format: 'mmmm d, yyyy',
    closeOnSelect: false // Close upon selecting a date,
});
	$('.timepicker').pickatime({
    default: 'now', // Set default time: 'now', '1:30AM', '16:30'
    fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
    twelvehour: true, // Use AM/PM or 24-hour format
    donetext: 'OK', // text for done-button
    cleartext: 'Clear', // text for clear-button
    canceltext: 'Cancel', // Text for cancel-button
    autoclose: false, // automatic close timepicker
    ampmclickable: true, // make AM PM clickable
    aftershow: function(){} //Function for after opening timepicker
});
	initiateOnClick();
	schedule();
	navigations();
});




/*=================================
=            Schedule             =
===================================*/

function schedule() {
	

	$("#sections").change(function(){
		$.ajax({
			url: base_url+"Welcome/fetchSchedule",
			type: 'post',
			dataType: 'json',
			data: {id: $(this).val()},
			success: function(data){
				if (data==false) {
					$("#schedule_section").html("<div class='col s4'></div><div class='col s4'><h4>No Attendance Encoded Yet</h4></div><div class='col s4'></div>");
				}else{
					var calendar = new Timetable();
					calendar.setScope(7, 21);
					calendar.addLocations(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']);
					for(var i =0; i < data.length ; i++){

					// console.log(data[i]);	
					calendar.addEvent(data[i].schedule_venue, 	data[i].day, new Date(2015,7,data[i].s_d,data[i].s_h,data[i].s_min), new Date(2015,7,data[i].e_d,data[i].e_h,data[i].e_min));
					var renderer = new Timetable.Renderer(calendar);
					renderer.draw('.timetable'); 
					
				}
			}

		}
	});


	});
}
/*=====  End of Schedule   ======*/


/*=========================================
=            Navigation jQuery            =
=========================================*/

function navigations() {
	//Navigation Button
	$("#nav_schedule").click(function() {
		$('html, body').animate({
			scrollTop: $("#nav_schedule_sec").offset().top
		}, 500);
	});
	$("#nav_features").click(function() {
		$('html, body').animate({
			scrollTop: $("#nav_features_sec").offset().top
		}, 500);
	});
	$("#nav_benefits").click(function() {
		$('html, body').animate({
			scrollTop: $("#nav_benefits_sec").offset().top
		}, 500);
	});
	$("#nav_statements").click(function() {
		$('html, body').animate({
			scrollTop: $("#nav_statements_sec").offset().top
		}, 500);
	});
	$("#nav_login").click(function() {
		$('html, body').animate({
			scrollTop: $("#nav_login_sec").offset().top
		}, 500);
	});

	$("#nav_top").click(function() {
		$('html, body').animate({
			scrollTop: $("#top").offset().top
		}, 500);
	});

}

/*=====  End of Navigation jQuery  ======*/




/*==================================
=            Class List            =
==================================*/

function showonlyone(thechosenone) {
	$('.div_section').each(function(index) {
		if ($(this).attr("id") == thechosenone) {
			$(this).show(200);
		}
		else {
			$(this).hide(600);
		}
	});
}

/*=====  End of Class List  ======*/




function getDivHeightClass(x){	
	var height = $("."+x).height();
	return height;
}
function getDivHeightID(x){	
	var height = $("#"+x).height();
	return height;
}

/*=====================================
=            Datatables JS            =
=====================================*/

$(document).ready(function() {
	$('.data-table').DataTable();
} );

/*=====  End of Datatables JS  ======*/



/*======================================
=            Login Modal JS            =
======================================*/

$("#login-password").keydown(function(event) {
	if (event.keyCode == 13) {
		login_verify();
	}
});

// document.getElementById('login-password').onkeydown = function(event) {
// 	if (event.keyCode == 13) {
// 		login_verify();
// 	}
// }


function login_verify() {

	$username = $("#login-username").val();
	$password = $("#login-password").val();
	$.ajax({
		url: base_url+"Login/verify",
		type: "post",
		dataType: "json",
		data:{
			username: $username,
			password: $password
		},
		success: function(data){
			if (data == false) {
				$("#login-username").addClass('invalid');
				$("#login-password").addClass('invalid');
				$("#login-message").css('display', 'block');
			}else if(data == "68d5fef94c7754840730274cf4959183b4e4ec35"){
				$.ajax({
						// professor
						url: base_url+"Login/redirect/68d5fef94c7754840730274cf4959183b4e4ec35",
						type: "post",
						dataType: "json",
						data:{
							username: $username,
						},
						success: function(data){
							window.location.href = data;	
						},
						error: function(data){
							console.log(data);	
						}

					});
			}else if(data == "b3aca92c793ee0e9b1a9b0a5f5fc044e05140df3"){
				$.ajax({
						// administrator
						url: base_url+"Login/redirect/b3aca92c793ee0e9b1a9b0a5f5fc044e05140df3",
						type: "post",
						dataType: "json",
						data:{
							username: $username,
						},
						success: function(data){
							window.location.href = data;	
						},
						error: function(data){
							console.log(data);	
						}

					});
			}else if(data == "204036a1ef6e7360e536300ea78c6aeb4a9333dd"){
				$.ajax({
						// student
						url: base_url+"Login/redirect/204036a1ef6e7360e536300ea78c6aeb4a9333dd",
						type: "post",
						dataType: "json",
						data:{
							username: $username,
						},
						success: function(data){
							window.location.href = data;	
						},
						error: function(data){
							console.log(data);	
						}

					});
			}else if(data == "ea1462c1fe6251c885dce5002ad73edb0f613628"){
				$.ajax({
						// student
						url: base_url+"Login/redirect/ea1462c1fe6251c885dce5002ad73edb0f613628",
						type: "post",
						dataType: "json",
						data:{
							username: $username,
						},
						success: function(data){
							window.location.href = data;	
						},
						error: function(data){
							console.log(data);	
						}

					});
			}
		},
		error: function(data){
		}
	});

}

/*=====  End of Login Modal JS  ======*/



/*================================
=            Admin JS            =
================================*/

function initiateOnClick(){
	showReportonClick("card-cosml","div-card-cosml","div-card-ls","div-card-lahr","div-card-lcl","div-card-clof","div-card-fic","div-card-chart","div-card-lf");
	showReportonClick("card-ls","div-card-ls","div-card-cosml","div-card-lahr","div-card-lcl","div-card-clof","div-card-fic","div-card-chart","div-card-lf");
	showReportonClick("card-lahr","div-card-lahr","div-card-cosml","div-card-ls","div-card-lcl","div-card-clof","div-card-fic","div-card-chart","div-card-lf");
	showReportonClick("card-lcl","div-card-lcl","div-card-cosml","div-card-ls","div-card-lahr","div-card-clof","div-card-fic","div-card-chart","div-card-lf");
	showReportonClick("card-clof","div-card-clof","div-card-lcl","div-card-cosml","div-card-ls","div-card-lahr","div-card-fic","div-card-chart","div-card-lf");
	showReportonClick("card-fic","div-card-fic","div-card-lcl","div-card-cosml","div-card-ls","div-card-lahr","div-card-clof","div-card-chart","div-card-lf");
	showReportonClick("card-chart","div-card-chart","div-card-fic","div-card-lcl","div-card-cosml","div-card-ls","div-card-lahr","div-card-clof","div-card-lf");
	showReportonClick("card-lf","div-card-lf","div-card-fic","div-card-lcl","div-card-cosml","div-card-ls","div-card-lahr","div-card-clof","div-card-chart");

}

function showReportonClick(id,div_id,div_hide_1,div_hide_2,div_hide_3,div_hide_4,div_hide_5,div_hide_6,div_hide_7){
	$("#"+id).click(function(event) {
		$("#"+div_id).fadeIn();
		$("#"+div_id).css("display","block");
		$("#"+div_hide_1).css("display","none");
		$("#"+div_hide_2).css("display","none");
		$("#"+div_hide_3).css("display","none");
		$("#"+div_hide_4).css("display","none");
		$("#"+div_hide_5).css("display","none");
		$("#"+div_hide_6).css("display","none");
		$("#"+div_hide_7).css("display","none");

	});
}

/*=====  End of Admin JS  ======*/
