$(document).ready(function() {
	$(".button-collapse").sideNav();
	$('.modal').modal();
	$(".dropdown-button").dropdown();
	$('.slider').slider({
		indicators:false,
		height: 500
	});
	initiateOnClick();
	login_verify();
});


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
	$('#tbl-card-cosml').DataTable();
	$('#tbl-card-ls').DataTable();
	$('#tbl-mdl-attendance').DataTable( {
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax": {
			url: base_url+"Admin/fetchLecturer",
			type: "post"
		},
		"columnDefs":[
		{
			"target":[0,3,4],
			"orderable":false
		}]
	} );
} );

/*=====  End of Datatables JS  ======*/



/*======================================
=            Login Modal JS            =
======================================*/

function login_verify() {
	$("#btn-login").click(function(event) {
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
				}else if(data == "1dfbba5b5fa79b789c93cfc2911d846124153615"){
					$.ajax({
						// lecturer
						url: base_url+"Login/redirect/1dfbba5b5fa79b789c93cfc2911d846124153615",
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
				}
			},
			error: function(data){
			}
		});
	});
}

/*=====  End of Login Modal JS  ======*/



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
