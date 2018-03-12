<?php $this->load->view('includes/home-sidenav'); ?>
<?php $this->load->view('includes/home-navbar'); ?>
<div class="row container">
	<blockquote class="color-primary-green">
		<h5 class="color-black">Manage Coursewares</h5>
	</blockquote>
</div>
<!--=================================
=            Breadcrumbs            =
==================================-->

<div class="row container">
	<nav  style="background-color: transparent; box-shadow: none;">
		<div class="nav-wrapper">
			<div class="col s12" id="div-bread">
				<a href="#!" class="breadcrumb" id="btn_launch_subjects"><i class="material-icons">map</i>Subject Area</a>
			</div>
		</div>
	</nav>
</div>

<!--====  End of Breadcrumbs  ====-->


<div class="row container" id="subject-section">
	<?php 
	$course = $this->Crud_model->fetch("course",array("course_department"=>$info['user']->fic_department));
	?>
	<?php if ($course): ?>
		<?php foreach ($course as $key => $value): ?>

			<?php
			$subject = $this->Crud_model->fetch("subject",array("course_id"=>$value->course_id));
			?>
			<?php if ($subject): ?>
				<?php foreach ($subject as $key => $i_value): ?>

					<?php  
					$lecturer = $this->Crud_model->fetch("lecturer",array("lecturer_id"=>$i_value->lecturer_id));
					$lecturer = $lecturer[0];
					?>
					<div class="col s3" >
						<div class="card sticky-action" >
							<div class="card-image waves-effect waves-block waves-light" >
								<img class="activator" src="<?=base_url()?>assets/img/background-2.jpg">
							</div>
							<div class="card-content bg-primary-yellow" >
								<blockquote class="color-primary-green" style="margin-top: 0;">
									<span class="card-title activator color-black  grey-text text-darken-4 sub_name"><?=$i_value->subject_name?><i class="material-icons right ">more_vert</i></span>
								</blockquote>
								<h6><?=$lecturer->firstname." ".$lecturer->midname." ".$lecturer->lastname?></h6>
							</div>
							<div class="card-reveal bg-primary-green">
								<span class="card-title color-white ">ABOUT</span>
								<p class="valign-wrapper"><i class="material-icons color-primary-yellow">chevron_right</i><span class="color-white"><?=$i_value->subject_description?></span></p>
							</div>

							<div class="card-action bg-primary-yellow " style="padding: 0.02px !important;">
								<div class="row ">
									<div class="col s12 ">

										<a class="btn_launch_topics waves-effect waves-light btn right" data-id="<?=$i_value->subject_id?>" style="background-color: transparent; box-shadow: none !important;">Launch<i class="material-icons right">launch</i></a>

									</div>
								</div>
							</div>
						</div>
					</div>

				<?php endforeach ?>
			<?php endif ?>
		<?php endforeach ?>
	<?php else: ?>

		<div class="row">				
			<img src="<?=base_url()?>assets/img/chibi/Chibi_crying.svg" alt="">
			<h1 class="color-primary-green center">204 No Content</h1>
			<p class="zoom-area color-primary-green center">Contact the <b>CSO-MIS </b>regarding this error</p>
			<section class="error-container">
				<span><span>2</span></span>
				<span>0</span>
				<span><span>4</span></span>
			</section>

			<div class="link-container">
				<a target="_blank" href="!#" class="more-link bg-primary-green">Report to Administrator</a>
			</div>
		</div>
	<?php endif ?>
</div>
<!--========================================
=            DIV TOPICS SECTION            =
=========================================-->

<div id="topics-section" class="row container" style="display: none;">

	<!-- DIV FOR TOPICS -->
	<div class="col s1"></div>
	<div class="col s11">
		<ul class="collapsible" id="topic_content" data-collapsible="accordion">

		</ul>
		<div class="col s12" style="display: none" id="div-topics"></div>
	</div>

</div>

<!--====  End of DIV TOPICS SECTION  ====-->

<!--=====================================================
=            DIV COURSEWARE QUESTION SECTION            =
======================================================-->

<div class="row container" id="question-section" style="display: none;">
	<div class="col s1"></div>
	<div class="col s11" id="div-q-sec">
		

	</div>
	<div class="fixed-action-btn">
		<a class="btn-floating btn-large bg-primary-yellow">
			<i class="large material-icons">menu</i>
		</a>
		<ul>
			<li>
				<a class="btn-floating bg-primary-green modal-trigger tooltipped" id="btn_add_q" data-position="left" data-tooltip="Add Question" href="#modal_q">
					<i class="material-icons">add</i>
				</a>
			</li>
			<!-- <li><a class="btn-floating yellow darken-1"><i class="material-icons">format_quote</i></a></li>
			<li><a class="btn-floating green"><i class="material-icons">publish</i></a></li>
			<li><a class="btn-floating blue"><i class="material-icons">attach_file</i></a></li> -->
		</ul>
	</div>
</div>

<!--====  End of DIV COURSEWARE QUESTION SECTION  ====-->

<!--====================================
=            MODAL QUESTION            =
=====================================-->

<div id="modal_q" class="modal modal-fixed-footer bg-color-white">
	<div class="modal-content">
		<h4 style="border-bottom: 3px solid #007A33; padding-bottom: 2%;">Question <span id="q_id_num"></span></h4>
		<div class="row">
			<div class="col s12">
				<ul class="tabs bg-primary-green">
					<li class="tab col s6"><a class="color-white active" href="#content">Question</a></li>
					<li class="tab col s6"><a class="color-white" href="#answers">Answers</a></li>
				</ul>
			</div>
			<div id="content" class="col s12">
				<blockquote class="color-primary-yellow">
					<h5 class="color-black">Content</h5>
				</blockquote>
				<!-- Editor -->
				<textarea name="editor1" id="q_editor"></textarea>
			</div>
			<div id="answers" class="col s12">
				
				<blockquote class="color-primary-yellow">
					<h5 class="color-black">Answers</h5>
				</blockquote>

				<blockquote class="color-primary-green" style="margin-left: 3%;">

					<h5 class="valign-wrapper">Answer #1 <i class="material-icons" style="cursor: pointer;" id="i_answer_1">check_box</i></h5>
					<textarea name="editor2" id="answer_1"></textarea>

				</blockquote>
				<blockquote class="color-primary-green" style="margin-left: 3%;">

					<h5 class="valign-wrapper">Answer #2 <i class="material-icons" style="cursor: pointer;" id="i_answer_2">check_box_outline_blank</i></h5>
					<textarea name="editor3" id="answer_2"></textarea>
				</blockquote>
				<blockquote class="color-primary-green" style="margin-left: 3%;">
					<h5 class="valign-wrapper">Answer #3 <i class="material-icons" style="cursor: pointer;" id="i_answer_3">check_box_outline_blank</i></h5>
					<textarea name="editor4" id="answer_3"></textarea>
				</blockquote>
				<blockquote class="color-primary-green" style="margin-left: 3%;">
					<h5 class="valign-wrapper">Answer #4 <i class="material-icons" style="cursor: pointer;" id="i_answer_4">check_box_outline_blank</i></h5>
					<textarea name="editor5" id="answer_4"></textarea>
				</blockquote>
			</div>
		</div>



	</div>
	<div class="modal-footer bg-color-white	">
		<a href="#!" id="send" class="waves-effect waves-green btn bg-primary-green ">ADD</a>
	</div>
</div>

<!--====  End of MODAL QUESTION  ====-->

<!--======================================
=            MODAL COURSEWARE            =
=======================================-->

<div id="modal_cw" class="modal modal-fixed-footer bg-color-white">
	<div class="modal-content">
		<h4 style="border-bottom: 2px solid #F2A900; padding-bottom: 1%;">ADD COURSEWARE</h4>
		<div class="row">
			<div class="input-field col s6">
				<blockquote class="color-primary-green"><h5 class="color-black">Title</h5> <input placeholder="" id="cw_title" type="text" class="validate"/> </blockquote>
				
			</div>
		</div>
		<div class="row">
			<form class="col s12">
				<div class="input-field col s12">
					<blockquote class="color-primary-green"><h5 class="color-black">Description</h5>
						<textarea id="cw_des" class="materialize-textarea"></textarea></blockquote>

					</div>
				</form>
			</div>


		</div>
		<div class="modal-footer bg-color-white">
			<a href="#!" id="send_cw" class="modal-action modal-close waves-effect waves-green btn bg-primary-green">ADD</a>
		</div>
	</div>

	<!--====  End of MODAL COURSEWARE  ====-->



<!--=======================================
=            WIRIS TEXT EDITOR            =
========================================-->

<!-- <div class="row container">
	<div class="col s1"></div>
	<div class="col s11">
		<textarea name="editor1" id="q_editor"></textarea>
		<input id="send" type="button" value="Send">
	</div>

</div> -->

<!--====  End of WIRIS TEXT EDITOR  ====-->


<script>
	// window.onbeforeunload = function(){
	// 	myfun();
	// 	return 'Are you sure you want to leave?';
	// };

	// function myfun(){ 
	// 	console.log('hello');
	// }

	jQuery(document).ready(function($) { 
		
		$('.tooltipped').tooltip({delay: 50});

		jQuery(".sub_name").fitText();
		CKEDITOR.replace( 'q_editor');

		var answer1 = CKEDITOR.instances['answer_1'];
		if (!answer1) {  
			CKEDITOR.replace( 'answer_1');
		} 
		var answer2 = CKEDITOR.instances['answer_2'];
		if (!answer2) {  
			CKEDITOR.replace( 'answer_2');
		}

		var answer3 = CKEDITOR.instances['answer_3'];
		if (!answer3) {   
			CKEDITOR.replace( 'answer_3');
		}

		var answer4 = CKEDITOR.instances['answer_4'];
		if (!answer4) {    
			CKEDITOR.replace( 'answer_4');
		}



		var i_a_1 = 1;
		var i_a_2 = 0;
		var i_a_3 = 0;
		var i_a_4 = 0;



		// Mark answer modal
		$("#i_answer_1").click(function(event) {
			i_a_1 = 1;
			i_a_2 = 0;
			i_a_3 = 0;
			i_a_4 = 0;
			$(this).html("check_box");
			$("#i_answer_2").html("check_box_outline_blank");
			$("#i_answer_3").html("check_box_outline_blank");
			$("#i_answer_4").html("check_box_outline_blank");
		});

		$("#i_answer_2").click(function(event) {
			i_a_1 = 0;
			i_a_2 = 1;
			i_a_3 = 0;
			i_a_4 = 0;
			$(this).html("check_box");
			$("#i_answer_1").html("check_box_outline_blank");
			$("#i_answer_3").html("check_box_outline_blank");
			$("#i_answer_4").html("check_box_outline_blank");
		});

		$("#i_answer_3").click(function(event) {
			i_a_1 = 0;
			i_a_2 = 0;
			i_a_3 = 1;
			i_a_4 = 0;
			$(this).html("check_box");
			$("#i_answer_2").html("check_box_outline_blank");
			$("#i_answer_1").html("check_box_outline_blank");
			$("#i_answer_4").html("check_box_outline_blank");
		});

		$("#i_answer_4").click(function(event) {
			i_a_1 = 0;
			i_a_2 = 0;
			i_a_3 = 0;
			i_a_4 = 1;
			$(this).html("check_box");
			$("#i_answer_2").html("check_box_outline_blank");
			$("#i_answer_3").html("check_box_outline_blank");
			$("#i_answer_1").html("check_box_outline_blank");
		});

		// ADD QUESTION
		$("#send").click(function(event) {
			$q_id = 0;
			$.ajax({
				url: '<?=base_url()?>Coursewares_fic/fetchLastQuestion',
				type: 'post',
				dataType: 'json',
				success: function(data){
					$q_id = data; 
					var cw_id = $("#q_id_num").data("cwid");
					var content = CKEDITOR.instances['q_editor'].getData();

					content = "<div>"+content+"</div>";
					console.log(content);	
					var answer1 = CKEDITOR.instances['answer_1'].getData();
					var answer2 = CKEDITOR.instances['answer_2'].getData();
					var answer3 = CKEDITOR.instances['answer_3'].getData();
					var answer4 = CKEDITOR.instances['answer_4'].getData();

					$.ajax({
						url: '<?=base_url()?>Coursewares_fic/insertQuestion ',
						type: 'post',
						dataType: 'json',
						data: {
							content:content,
							answer1:answer1,
							answer2:answer2,
							answer3:answer3,
							answer4:answer4,
							i_a_1:i_a_1,
							i_a_2:i_a_2,
							i_a_3:i_a_3,
							i_a_4:i_a_4,
							q_id:$q_id,
							cw_id:cw_id
						},
						success: function(data){
							if(data==true){
								swal("Question Added!", {
									icon: "success",
								}).then(function(){ 

									$("#answer_1, #answer_2, #answer_3, #answer_4").html("Click Here To Add Answer");
									$('#modal_q').modal('close');
									unsavedChanges = true;
							// fetch question
							fetchQuestion(cw_id);
							$("html, body").animate({ scrollTop: $(document).height() }, 1000);
						});
							}else{
								$toastContent = $('<span>'+data+'</span>');
								Materialize.toast($toastContent, 2000);
							}
						}
					});
				}
			});
			
			

		});




		/*===============================================
		=            AJAX AND ANIMATE SCRIPT            =
		===============================================*/

		//  Delete question
		$(document.body).on('click', '.btn-del-q' ,function(){
			// alert();
			$id = $(this).data('id');
			$cwid = $(this).data('cwid');

			swal({
				title: "Are you sure?",
				text: "This question will be put into archive",
				icon: "error",buttons: {
					cancel: true,
					confirm: true,
				},
			})
			.then((willDelete) => {
				if (willDelete) {
					$.ajax({
						url: '<?=base_url()?>Coursewares_fic/deleteQuestion ',
						type: 'post',
						dataType: 'json',
						data: {
							id: $id
						},
						success: function(data){
							if (data == true) {
								// swal("Success", "Question has been put into archive", "success");
								fetchQuestion($cwid);
							}
						}
					});
				}
			});
		});
		


		// count Question
		$("#btn_add_q").click(function(event) {
			// console.log($(this).data('cwid'));	
			$.ajax({
				url: '<?=base_url()?>Coursewares_fic/countQuestion',
				type: 'post',
				dataType: 'json',
				data: {
					table: 'courseware_question',
					cwid : $(this).data('cwid'),
				},
				success: function(data){
					$no = parseInt(data) + 1;
					$("#q_id_num").html($no);	
				}
			});
			
		});

		// ADD Courseware 
		$("#send_cw").click(function(event) {
			if ($(this).text()=="add") {
				// console.log("add");	
				$cw_t = $("#cw_title").val();
				$cw_d = $("#cw_des").val();
				$t_id = $(this).data('id');
				$s_id = $(this).data('subid');


				$.ajax({
					url: '<?=base_url()?>Coursewares_fic/addCourseware ',
					type: 'post',
					dataType: 'json',
					data: {
						cw_t: $cw_t,
						cw_d: $cw_d,
						t_id: $t_id,
					},
					success:function(data){
						// console.log(data);	
						if (data == true) {
							$toastContent = $('<span>Successfully Added</span>');
							Materialize.toast($toastContent, 2000);
							fetchTopics($s_id);
						}else{
							$toastContent = $('<span>'+data+'</span>');
							Materialize.toast($toastContent, 2000);

						}
					}
				});
			}else{
				// console.log("update");	
				$cw_t = $("#cw_title").val();
				$cw_d = $("#cw_des").val();
				$cw_id = $(this).data('cwid');
				// console.log($cw_id);	
				/*=====================================
				=            DATE AND TIME            =
				=====================================*/
				
				var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"	];
				var dNow = new Date();
				var hours = dNow.getHours();
				var minutes = dNow.getMinutes();
				var ampm = hours >= 12 ? 'PM' : 'AM';
				hours = hours % 12;
				hours = hours ? hours : 12;  
				minutes = minutes < 10 ? '0'+minutes : minutes;
				var strTime = hours + ':' + minutes + ' ' + ampm;
				var localdate= (monthNames[dNow.getMonth()]) + ' ' + dNow.getDate() + ', ' + dNow.getFullYear() + ' ' + strTime;

				
				/*=====  End of DATE AND TIME  ======*/
				

				// console.log($cw_id);	
				$.ajax({
					url: '<?=base_url()?>Coursewares_fic/updateCourseware ',
					type: 'post',
					dataType: 'json',
					data: {
						cw_t: $cw_t,
						cw_d: $cw_d,
						cw_id: $cw_id,
					},
					success: function(data){
						if (data == true) {
							$("#cw_t_"+$cw_id).html("<b>"+$cw_t+"</b>");
							$("#cw_d_"+$cw_id).text($cw_d);
							$("#cw_te_"+$cw_id).text(localdate);

							$toastContent = $('<span>Successfully Updated</span>');
							Materialize.toast($toastContent, 2000); 
						}else{
							$toastContent = $('<span>'+data+'</span>');
							Materialize.toast($toastContent, 2000);

						}

					}
				});
			}

		});

		// Edit Courseware
		$(document).on('click', '.btn-edit-cw', function(event) {
			$cw_id = $(this).data('cwid');
			$cw_t = $("#cw_t_"+$cw_id).text();
			$cw_d = $("#cw_d_"+$cw_id).text();
			$("#send_cw").html("update");
			if (!$('#send_cw').attr('data-cwid')) {
				$('#send_cw').attr('data-cwid', $cw_id);
			}else{
				$('#send_cw').data('cwid', $cw_id);
			}
			$("#cw_title").val($cw_t);
			$("#cw_des").val($cw_d);
			// console.log($cw_id);	


			// console.log("click");	
		});

		// Add courseware
		// Add id to submit button
		$(document).on('click', '.btn-add-cw', function(event) {

			$("#cw_title").val("");
			$("#cw_des").val("");
			$t_id = $(this).data("id");
			$s_id = $(this).data("subid");
			$("#send_cw").html("add");
			// console.log($t_id);	
			$('#send_cw').attr('data-id', $t_id);
			$('#send_cw').attr('data-subid', $s_id);


		});
		// LAUNCH QUESTION
		$(document).on("click", ".btn_cw_question", function () {
			$id = $(this).data('cwid');

			// add data cwid to q_id_num
			$("#q_id_num").data('cwid', $id);

			if ($("#div-bread-question").length==0) {
				$("#div-bread").append('<a href="#!" class="breadcrumb"  id="div-bread-question">Courseware Question</a>');
				// $("#div-bread-question").attr('data-id', $id);
			}
			if ($('#topics-section').css('display') == "block") {
				$('#topics-section').animateCss('zoomOut', function() {
					$("#topics-section").css('display', 'none');
					$('#question-section').addClass('animated zoomIn');
					$("#question-section").css('display', 'block');
				});
			}

			fetchQuestion($id);			
			
		});
		
		// LAUNCH TOPICS
		$(document).on("click touchend", ".btn_launch_topics, #div-bread-topics", function () {
			// alert();
			$id = $(this).data("id");
			if ($("#div-bread-topics").length==0) {
				$("#div-bread").append('<a href="#!" class="breadcrumb"  id="div-bread-topics">Topics</a>');
				$("#div-bread-topics").attr('data-id', $id);
			}
			// alert($(this).data("id"));
			if ($('#subject-section').css('display') == "block") {
				$('#subject-section').animateCss('zoomOut', function() {
					$("#subject-section").css('display', 'none');
					$('#topics-section').addClass('animated zoomIn');
					$("#topics-section").css('display', 'block');
				});
			}

			if ($('#question-section').css('display') == "block") {
				$("#div-bread-question").remove();

				$('#question-section').animateCss('zoomOut', function() {
					$("#question-section").css('display', 'none');
					$('#topics-section').addClass('animated zoomIn');
					$("#topics-section").css('display', 'block');
				});
			}
			fetchTopics($id);			



		});


		// LAUNCH SUBJECTS
		$("#btn_launch_subjects").click(function(event) {
			
			

			// zoomout topics
			if ($("#subject-section").css('display')=="none") {
				$("#div-bread-topics").remove();
				if ($("#topics-section").css('display')=="block") {
					$('#topics-section').animateCss('zoomOut', function() {
						$("#topics-section").css('display', 'none');
						$('#subject-section').addClass('animated zoomIn');
						$("#subject-section").css('display', 'block');
					});
				}
				if ($("#question-section").css('display')=="block") {
					$("#div-bread-question").remove();
					$('#question-section').animateCss('zoomOut', function() {
						$("#question-section").css('display', 'none');
						$('#subject-section').addClass('animated zoomIn');
						$("#subject-section").css('display', 'block');
					});
				}
			}

		});

			/*==========================================
			=            jQuery Animate Css            =
			==========================================*/
			
			$.fn.extend({
				animateCss: function(animationName, callback) {
					var animationEnd = (function(el) {
						var animations = {
							animation: 'animationend',
							OAnimation: 'oAnimationEnd',
							MozAnimation: 'mozAnimationEnd',
							WebkitAnimation: 'webkitAnimationEnd',
						};

						for (var t in animations) {
							if (el.style[t] !== undefined) {
								return animations[t];
							}
						}
					})(document.createElement('div'));

					this.addClass('animated ' + animationName).one(animationEnd, function() {
						$(this).removeClass('animated ' + animationName);

						if (typeof callback === 'function') callback();
					});

					return this;
				},
			});
			
			/*=====  End of jQuery Animate Css  ======*/

			/*=====  End of AJAX AND ANIMATE SCRIPT  ======*/




		});


function fetchCourseware(topic_id) {
	// AJAX FOR COURSEWARE
	var courseware_content = "";
	$.ajax({
		url: '<?=base_url()?>Coursewares_fic/fetchCoursewares',
		type: 'post',
		dataType: 'json',
		data: {topic_id: topic_id},
		beforeSend: function() {
			$("#preloader").css('display', 'block');
		},
		success: function(i_data){
			$("#preloader").css('display', 'none');

			for(var j = 0; j < i_data.length; j++){
				courseware_content +='<div class="row valign-wrapper" style="margin: 0; border: 1px solid #007A33; border-radius: 5px; margin-bottom: 1%;">'+
				'<div class="col s6">'+
				'<p id="cw_t_'+i_data[j].courseware_id+'"><b>'+i_data[j].courseware_name+'</b></p>'+
				'<p style="font-size: 0.8vw">Date added: '+i_data[j].date_added+' | Edited:<span id="cw_te_'+i_data[j].courseware_id+'">'+i_data[j].date_edited+'</span><p>'+ 
				'<blockquote class="color-primary-green"><span class="color-black" id="cw_d_'+i_data[j].courseware_id+'">'+i_data[j].courseware_description+'</span> </blockquote>'+
				'</div>'+
				'<div class="col s6">'+
				'<div class="col s6">'+
				'<span class="valign-wrapper" ><i class="material-icons tooltipped" data-position="bottom" data-delay="50" data-tooltip="No. of students who took this courseware">supervisor_account</i>46 </span> '+
				' <span class="valign-wrapper "> <i class="material-icons tooltipped" data-position="bottom" data-delay="50" data-tooltip="No. of students who have passing remarks">mood</i>46</span>'+
				' <span class="valign-wrapper "> <i class="material-icons tooltipped" data-position="bottom" data-delay="50" data-tooltip="No. of students who have failing remarks">mood_bad</i>46</span>'+
				'</div>'+
				'<div class="col s6"><a class=" waves-effect waves-light btn right color-black btn_cw_question" data-cwid="'+i_data[j].courseware_id+'" style="background-color: transparent; box-shadow: none !important;">View<i class="material-icons right ">launch</i></a><i class="material-icons btn-edit-cw tooltipped modal-trigger" data-position="left" data-tooltip="Edit Courseware Details" style="cursor: pointer;" data-target="modal_cw" data-cwid="'+i_data[j].courseware_id+'">edit</i></div>'+
				'</div>'+
				'</div>';
			}
			$("#courseware_"+topic_id).html(courseware_content);
			$('.tooltipped').tooltip({delay: 50});

		}
	});
}


function fetchTopics(id) {
	
	var html_content = "";
	$.ajax({
		url: '<?=base_url()?>Coursewares/fetchTopics',
		type: 'post',
		dataType: 'json',
		data: {id: id},
		beforeSend: function() {
			$("#preloader").css('display', 'block');
		},
		success: function(data){
			$("#preloader").css('display', 'none');

			if (data!=false) {
				$("#div-topics").css('display', 'none');

				for(var i = 0; i < data.length; i++){
					$topic_id = data[i].topic_id;

					html_content += '<li>'+
					'<div class="collapsible-header" style="background-color: transparent; text-transform: uppercase;"><div class="col s6"><i class="material-icons color-primary-green">navigate_next</i>'+data[i].topic_name+'</div>'+
					'<div class="col s6"><i class="material-icons btn-add-cw right color-primary-green tooltipped modal-trigger" data-position="left" data-tooltip="Add Courseware"  data-target="modal_cw" data-subid="'+id+'" data-id="'+data[i].topic_id+'">add_box</i></div></div>'+
					'<div class="collapsible-body" id="courseware_'+data[i].topic_id+'">'+
					'</div>'+
					'</li>';

					fetchCourseware($topic_id);
				}

				$("#topic_content").html(html_content);
			}else{
				$("#topic_content").html("");
				html_content = '<h1 class="center" style=" box-shadow: none !important;"> No topics added yet</h1>';
				$("#div-topics").css('display', 'block');
				$("#div-topics").html(html_content);

			}
		}
	});
}



function fetchQuestion(id) {
	$.ajax({
		url: '<?=base_url()?>Coursewares_fic/fetchQuestions ',
		type: 'post',
		dataType: 'html',
		data: {cw_id: id},
		beforeSend: function() {
			$("#preloader").css('display', 'block');
		},
		success: function(data){
			$("#preloader").css('display', 'none');
			$("#div-q-sec").html(data);
			$("#btn_add_q").attr("data-cwid",id)
		},
		error: function(){
			console.log("error");	
		}
	});
}



</script>