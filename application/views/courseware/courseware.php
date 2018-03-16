<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>


<div class="row container" id="top">		
	<blockquote class="color-primary-green">
		<h5 class="color-black">Practice Exams</h5>
	</blockquote>
</div>
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


<!--======================================
=            SUBJECTS SECTION            =
=======================================-->

<div class="row	 container" id="subject-section">

	<?php 
	$dep = $info['user']->student_department;
	$offering = $this->Crud_model->fetch("offering",array("offering_id"=>$info['user']->offering_id));
	$offering = $offering[0];

	$course = $this->Crud_model->fetch("course", array("course_department"=>$dep,"course_id"=>$offering->course_id));
	$count = 1;
	?>
	<?php if ($course): ?>
		
		<?php foreach ($course as $key => $value): ?>
			<?php if ($count == 4): ?><?=  "<div class='row'>" ?><?php endif ?>
				<?php 

			// $section = $this->Crud_model->fetch("offering",array("offering_id"=>$info['user']->offering_id));
			// $section = $section[0];
				$subjects = $this->Crud_model->fetch("subject",array("course_id"=>$value->course_id));
				?>
				<?php if ($subjects): ?>
					<?php foreach ($subjects as $key => $value): ?>
						<?php 
						$lecturer = $this->Crud_model->fetch("lecturer",array("lecturer_id"=>$value->lecturer_id));
						$lecturer = $lecturer[0];
						?>	
						<div class="col s3" >
							<div class="card sticky-action" >
								<div class="card-image waves-effect waves-block waves-light" >
									<img class="activator" src="<?=base_url()?>assets/img/background-2.jpg">
								</div>
								<div class="card-content bg-primary-yellow" >
									<blockquote class="color-primary-green" style="margin-top: 0;">
										<span class="card-title activator color-black  grey-text text-darken-4 sub_name"><?=$value->subject_name?><i class="material-icons right ">more_vert</i></span>
									</blockquote>
									<?php if ($lecturer): ?>
										<h6><?=$lecturer->firstname." ".$lecturer->midname." ".$lecturer->lastname?></h6>
									<?php endif ?>
								</div>
								<div class="card-reveal bg-primary-green">
									<span class="card-title color-white ">ABOUT</span>
									<p class="valign-wrapper"><i class="material-icons color-primary-yellow">chevron_right</i><span class="color-white"><?=$value->subject_description?></span></p>
								</div>

								<div class="card-action bg-primary-yellow " style="padding: 0.02px !important;">
									<div class="row ">
										<div class="col s12 ">

											<a class="btn_launch_topics waves-effect waves-light btn right" data-id="<?=$value->subject_id?>" style="background-color: transparent; box-shadow: none !important;">Launch<i class="material-icons right">launch</i></a>

										</div>
									</div>
								</div>
							</div>
						</div>
						<?php if ($count == 4): ?><?= "</div>" ?><?php endif ?>
						<?php $count++; ?>
					<?php endforeach ?>
				<?php endif ?>
			<?php  endforeach ?>
		<?php else: ?>
			<h5 class="center">NO SUBJECTS YET</h5>
		<?php endif ?>

	</div>


	<!--====  End of SUBJECTS SECTION  ====-->


	<!--========================================
	=            DIV TOPICS SECTION            =
	=========================================-->
	
	<div id="topics-section" class="row container" style="display: none;">
		
		<!-- DIV FOR TOPICS -->
		<div class="row" id="topics">
			<div class="col s1"></div>
			<div class="col s11">
				<ul class="collapsible" id="topic_content" data-collapsible="accordion">
					
				</ul>
				<div class="col s12" style="display: none" id="div-topics"></div>
			</div>
		</div>

	</div>

	<!--====  End of DIV TOPICS SECTION  ====-->


<!--=====================================================
=            DIV COURSEWARE QUESTION SECTION            =
======================================================-->

<div class="row" id="question-section" style="display: none;">
	<div class="col s2">
	</div>
	<div class="col s8" id="div-q-sec">
		

	</div>
	<div class="col s2" id="timer_div">
		<div  id="sticky" class="bg-color-black" style="padding: 1%; padding-left: 2%; border-radius: 10px;">
			<p class=" valign-wrapper">
				<i class="material-icons color-white" style="margin-right: 5%;">access_time</i>
				<span class="values color-black color-white"></span>
			</p>
		</div>
	</div>

	<div class="fixed-action-btn">
		<a class="btn-floating btn-large bg-primary-green" id="btn_submit_answers">
			<i class="large material-icons tooltipped" data-tooltip="Submit Answers" data-position="left">navigation</i>
		</a>
	</div>

</div> 



<!--====  End of DIV COURSEWARE QUESTION SECTION  ====-->



<script type="text/javascript">


	var o_ex = false;

	var timer = new Timer();
	jQuery(document).ready(function($) {

		$("#sticky").sticky({topSpacing:0});

		window.onbeforeunload = function() { 
			if (o_ex==true) {
				return 'Leave the exam? This exam will not be recorded if you leave.';
			}
		}

		jQuery(".sub_name").fitText();

		// Submit Answer
		$("#btn_submit_answers").click(function() {

			var cw_id = $(this).data('id');

			$chkr_answer = false;
			$q_id_error = [];
			$q_id = [];
			$ans_id = [];

			$.ajax({
				url: '<?=base_url()?>Coursewares/fetchQuestionJson ',
				type: 'post',
				dataType: 'json',
				data: {cw_id: cw_id},
				success: function(data){
					for(var i = 0; i< data.length; i++){
						$q_id.push(data[i].courseware_question_id);
						$ans_id.push($("input[name=group"+data[i].courseware_question_id+"]:checked").next().data("id"));
						$ans_id_chk = $("input[name=group"+data[i].courseware_question_id+"]:checked").next().data("id");
						if ($ans_id_chk === undefined) {
							$chkr_answer = true;
							$q_id_error.push((i+1));
						}

					}

					if ($chkr_answer == true) {
						$.each($q_id_error, function( index, value ) {
							var $toastContent = $('<span>You still have question unanswered - Question '+value+'</span>');
							Materialize.toast($toastContent, 2000);
						});
						
					}

					if ($chkr_answer == false) {
						swal({
							title: "Submit Exam?",
							text: "You are about to submit this Exam, are you sure you want to submit?",
							icon: "info",
							buttons: {
								cancel: true,
								confirm: "Submit",
							},
						})
						.then((submitAnswer) => {
							if (submitAnswer) { 


								$.ajax({
									url: '<?=base_url()?>Coursewares/isExisting ',
									type: 'post',
									dataType: 'json',
									data: {
										cw_id: cw_id,
										student_id: <?=$info['user']->student_id?>,
									},
									success:function(existing){
										if (existing == true) {
											updateAnswer($ans_id,$q_id,cw_id);
											grade_assessment(cw_id,<?=$info['user']->student_id?>);
											
										}else{
											for(var i = 0; i< data.length; i++){ 
												insertAnswer($ans_id[i],$q_id[i],cw_id);
											}
											grade_assessment(cw_id,<?=$info['user']->student_id?>);
										}
									}
								});
								
							}
						});



					}
					

				}
			});


		});




		// LAUNCH TOPICS
		$(document).on("click touchend", ".btn_launch_topics, #div-bread-topics", function () {
			var chk = false;
			if (o_ex == true) {
				var answer = confirm('Leave the exam? This exam will not be recorded if you leave.');
				if (answer) {  
					timer.reset();
				} else { 
					chk = true;
				}
			}

			if (chk == false) {
				$id = $(this).data("id");
				if ($("#div-bread-topics").length==0) {
					$("#div-bread").append('<a href="#!" class="breadcrumb"  id="div-bread-topics">Topics</a>');
					$("#div-bread-topics").attr('data-id', $id);
				} 
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
			}
			fetchTopics($id);		





		});



		$("#btn_launch_subjects").click(function(event) {

			$("#div-bread-topics").remove();
			if ($("#subject-section").css('display')=="none") {
				$('#topics-section').animateCss('zoomOut', function() {
					$("#topics-section").css('display', 'none');
					$('#subject-section').addClass('animated zoomIn');
					$("#subject-section").css('display', 'block');
				});
			}

		});


		// LAUNCH QUESTION
		$(document).on("click", ".btn_cw_question", function () {
			$id = $(this).data('cwid');


			swal({
				title: "Take this exam?",
				text: "You are about the take this exam. This exam will be used to assess your grades and configure your skills reports.",
				icon: "info",
				buttons: {
					cancel: true,
					confirm: "Continue",
				},
			})
			.then((takeExam) => {
				if (takeExam) { 

					o_ex = true;
						// add data cwid to q_id_num
						$("#q_id_num").data('cwid', $id);

						if ($("#div-bread-question").length==0) {
							$("#div-bread").append('<a href="#!" class="breadcrumb"  id="div-bread-question">Courseware Question</a>');
							// $("#div-bread").;
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

					}
				});


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


	});


function insertAnswer(answer_id,q_id,cw_id) {
	$.ajax({
		url: '<?=base_url()?>Coursewares/insertAnswer',
		type: 'post', 
		dataType: 'html',
		data: {
			answer: answer_id,
			q_id: q_id,
			cw_id: cw_id,
		},
		success: function(data){
			// console.log(data);	\
			if (data!=false) {
				o_ex = false;
				$("#question-section").html(data);
				$('html, body').animate({
					scrollTop: $("#top").offset().top
				}, 500);
			}
		}
	});
}
function updateAnswer(answer_id,q_id,cw_id) {

	var answer_json = JSON.stringify(answer_id);
	var q_json = JSON.stringify(q_id);
	// console.log(answer_id);	
	// console.log(q_id);	
	// console.log(cw_id);	


	$.ajax({
		url: '<?=base_url()?>Coursewares/updateAnswer',
		type: 'post', 
		dataType: 'html',
		data: {
			answer: answer_json,
			q_id: q_json,
			cw_id: cw_id,
		},
		success: function(data){
			// console.log(data);	\
			if (data!=false) {
				o_ex = false;
				$("#question-section").html(data);
				$('html, body').animate({
					scrollTop: $("#top").offset().top
				}, 500);
			}else{
				return false;
			}
		}
	});
}

function grade_assessment(cw_id,student_id) {
	$time = timer.getTimeValues().toString();
	console.log($time);	
	$.ajax({
		url: '<?=base_url()?>Coursewares/countCorrect',
		type: 'post',
		dataType: 'json',
		data: {
			cw_id: cw_id,
			student_id: student_id,
		},
		success: function(data){
			// console.log(data);
			$score = data;	
			$.ajax({
				url: '<?=base_url()?>Coursewares/insertGrade ',
				type: 'post',
				dataType: 'html',
				data: {
					cw_id: cw_id,
					student_id: student_id,
					score: $score,
					time: $time,
				},
				success: function(data){
					// console.log(data);	
					if (data!=false) {
						o_ex = false;
						$("#question-section").html(data);
						$('html, body').animate({
							scrollTop: $("#top").offset().top
						}, 500);
					}
				}
			});

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
					'<div class="col s6"></div></div>'+
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



function fetchCourseware(topic_id) { 
	var courseware_content = "";
	var time = "";
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
				if (!i_data[j].time) {
					time = " -----";
				}else{
					time = i_data[j].time;
				}
				courseware_content +='<div class="row valign-wrapper" style="margin: 0; border: 1px solid #007A33; border-radius: 5px; margin-bottom: 1%;">'+
				'<div class="col s6">'+
				'<p id="cw_t_'+i_data[j].courseware_id+'"><b>'+i_data[j].courseware_name+'</b></p>'+
				'<p style="font-size: 0.8vw">Date added: '+i_data[j].date_added+' | Edited:<span id="cw_te_'+i_data[j].courseware_id+'">'+i_data[j].date_edited+'</span><p>'+ 
				'<blockquote class="color-primary-green"><span class="color-black" id="cw_d_'+i_data[j].courseware_id+'">'+i_data[j].courseware_description+'</span> </blockquote>'+
				'</div>'+
				'<div class="col s6">'+
				'<div class="col s6"> '+ 
				'<div class="col s12 valign-wrapper"><i class="material-icons">access_time</i>'+
				time+ 
				'</div>'+
				'</div>'+
				'<div class="col s6" id="btn_cw_question'+i_data[j].courseware_id+'"><a class=" waves-effect waves-light btn right color-black btn_cw_question"  data-cwid="'+i_data[j].courseware_id+'" style="background-color: transparent; box-shadow: none !important;">Take Exam<i class="material-icons right ">launch</i></a></div>'+
				'</div>'+
				'</div>';

				countQuestion(i_data[j].courseware_id);		
			}
			$("#courseware_"+topic_id).html(courseware_content);
			$('.tooltipped').tooltip({delay: 50});

		}
	});
}


function fetchQuestion(id) {
		// console.log(id);	
		$.ajax({
			url: '<?=base_url()?>Coursewares/fetchQuestions ',
			type: 'post',
			dataType: 'html',
			data: {cw_id: id},
			beforeSend: function() {
				$("#preloader").css('display', 'block');
			},
			success: function(data){ 

				$("#btn_submit_answers").attr('data-id', id);
				timer.start({precision: 'seconds'});
				timer.addEventListener('secondsUpdated', function (e) {   

					$('#timer_div .values').html(timer.getTimeValues().toString());
				});   
				$("#preloader").css('display', 'none');
				$("#div-q-sec").html(data);
				$("#btn_add_q").attr("data-cwid",id)
			},
			error: function(){
				console.log("error");	
			}
		});
	}

	function countQuestion(id) {
		// console.log(id);	
		$.ajax({
			url: '<?=base_url()?>Coursewares/countQuestion ',
			type: 'post',
			dataType: 'html',
			data: {cw_id: id},
			success: function(data){
				console.log();	
				if (data!=="true") {
					$("#btn_cw_question"+id).html(
						`
						<i class="material-icons right tooltipped" data-position="left" data-tooltip="No Questions Yet">remove_circle_outline</i>
						`);


					$('.tooltipped').tooltip({delay: 50});
				}
			}
		});
	}




</script>