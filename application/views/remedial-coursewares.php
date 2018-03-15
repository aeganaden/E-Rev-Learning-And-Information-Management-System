<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>


<div class="container row">
	<div class="col s1"></div>
	<div class="col s11">
		<blockquote class="color-primary-green">
			<h5 class="color-black">Remedial Coursewares </h5>
		</blockquote>
	</div>
</div>

<div class="container row">
	<div class="col s1"></div>
	<div class="col s11">
		<div class="row" id="topics-section">
			<?php 
			$student_scores = $this->Crud_model->fetch("student_scores",array("student_scores_stud_num"=>$info['user']->student_num));
			?>
			<?php if ($student_scores): ?>
				<?php foreach ($student_scores as $key => $value): ?>
					<?php 
					$remedial_coursewares = $this->Crud_model->fetch("remedial_coursewares",array("student_scores_id"=>$value->student_scores_id));
					?>

					<ul class="collapsible " data-collapsible="accordion"> 
						<li class="">
							<div class="collapsible-header bg-primary-green color-white">
								<i class="material-icons color-white">book</i>Remedial Coursewares #<?=$key+1?>
							</div>
							<div class="collapsible-body">
								<ul class="collection "> 
									<?php if ($remedial_coursewares): ?>
										<?php foreach ($remedial_coursewares as $i_key => $i_value): ?>
											<?php 
											// fetch grade assessment
											$r_grade_assessment = $this->Crud_model->fetch_last("remedial_grade_assessment","remedial_grade_assessment_score",
												array("student_num"=>$info['user']->student_num,"courseware_id"=>$i_value->courseware_id));

											if ($r_grade_assessment) {
												
											// computer passing score
												$r_score = $r_grade_assessment->remedial_grade_assessment_score;
												$r_total = $r_grade_assessment->remedial_grade_assessment_total;
												$r_result = ($r_score / $r_total) * 100;

											// check if passed
												$remarks = $r_result > 69 ? "passed" : "failed";
												$color = $r_result > 69 ? "" : "red";	

											// update is_done
												if ($remarks == "passed") {
													$this->Crud_model->update("remedial_coursewares",
														array("is_done"=>1),array("remedial_coursewares_id",$i_value->remedial_coursewares_id));
													
													
												}												
											}



											$courseware = $this->Crud_model->fetch("courseware",array("courseware_id"=>$i_value->courseware_id));
											$courseware = $courseware[0];

											$count_question = $this->Crud_model->countResult("courseware_question",
												array("courseware_id"=>$courseware->courseware_id));
												?>
												<li class="collection-item bg-color-white">
													<div  class="valign-wrapper">
														<?php if ($i_value->is_done == 1): ?>
															<i class="material-icons color-primary-green">done</i>
															<?=strtoupper($courseware->courseware_name)?>

														<?php else: ?>
															<i class="material-icons color-red">remove</i>
															<?=strtoupper($courseware->courseware_name)?>
															<?php if ($count_question == 0): ?>
																<span href="#!" class="badge">
																	<i class="material-icons color-grey tooltipped" 
																	data-tooltip="No Question Made Yet" data-position="left"
																	>
																	not_interested
																</i>
															</span>
														<?php else: ?>


															<span href="#!" class="badge new" data-badge-caption="<?=$remarks?>">
															</span>
															<span href="#!" class="badge">
																<i class="material-icons color-primary-green btn_take_exam tooltipped" 
																data-tooltip="TAKE EXAM" style="cursor: pointer" data-position="left"
																data-id="<?=$courseware->courseware_id?>">
																send
															</i>
														</span>
													<?php endif ?>
												<?php endif ?>


											</div>
										</li>
									<?php endforeach ?>
								<?php endif ?>
							</ul>
						</div>
					</li>
				</ul>
			<?php endforeach ?>
		<?php endif ?>
	</div>



</div>
</div>
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





<script type="text/javascript">
	
	$(document).ready(function() {

		var o_ex = false;
		var timer = new Timer();


		window.onbeforeunload = function() { 
			if (o_ex==true) {
				return 'Leave the exam? This exam will not be recorded if you leave.';
			}
		}


		$(".btn_take_exam").click(function(event) {
			$cw_id = $(this).data("id");

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

					if ($('#topics-section').css('display') == "block") {
						$('#topics-section').animateCss('zoomOut', function() {
							$("#topics-section").css('display', 'none');
							$('#question-section').addClass('animated zoomIn');
							$("#question-section").css('display', 'block');
						});
					}


					fetchQuestion($cw_id);			

				}
			});

		});

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
									url: '<?=base_url()?>RemedialCoursewares/isExisting ',
									type: 'post',
									dataType: 'json',
									data: {
										cw_id: cw_id,
										student_num: <?=$info['user']->student_num?>,
									},
									success:function(existing){
										if (existing == true) {
											updateAnswer($ans_id,$q_id,cw_id);
											grade_assessment(cw_id,<?=$info['user']->student_num?>);
											
										}else{
											for(var i = 0; i< data.length; i++){ 
												insertAnswer($ans_id[i],$q_id[i],cw_id);
											}
											grade_assessment(cw_id,<?=$info['user']->student_num?>);
										}
									}
								});
								
							}
						});



					}
					

				}
			});


		});


		function insertAnswer(answer_id,q_id,cw_id) {
			$.ajax({
				url: '<?=base_url()?>RemedialCoursewares/insertAnswer',
				type: 'post', 
				dataType: 'html',
				data: {
					answer: answer_id,
					q_id: q_id,
					cw_id: cw_id,
				},
				success: function(data){
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


			$.ajax({
				url: '<?=base_url()?>RemedialCoursewares/updateAnswer',
				type: 'post', 
				dataType: 'html',
				data: {
					answer: answer_json,
					q_id: q_json,
					cw_id: cw_id,
				},
				success: function(data){
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


		function grade_assessment(cw_id,student_num) {
			$time = timer.getTimeValues().toString();
			console.log($time);	
			$.ajax({
				url: '<?=base_url()?>RemedialCoursewares/countCorrect',
				type: 'post',
				dataType: 'json',
				data: {
					cw_id: cw_id,
					student_num: student_num,
				},
				success: function(data){
					$score = data;	
					$.ajax({
						url: '<?=base_url()?>RemedialCoursewares/insertGrade ',
						type: 'post',
						dataType: 'html',
						data: {
							cw_id: cw_id,
							student_num: student_num,
							score: $score,
							time: $time,
						},
						success: function(data){	
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




		function fetchQuestion(id) {
			$("#btn_submit_answers").attr('data-id', id);


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




</script>