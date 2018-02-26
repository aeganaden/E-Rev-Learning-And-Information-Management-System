<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>


<div class="row container">		
	<blockquote class="color-primary-green">
		<h3 class="color-black">Coursewares</h3>
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
				<a href="#!" class="breadcrumb" id="btn_launch_subjects">Subjects</a>
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
	$offering_data = $this->Crud_model->fetch("offering", array("offering_department"=>$dep,"course_id"=>$offering->course_id));


	// echo "<pre>";
	// print_r($offering_data);
	// die();

	

	$count = 1;
	?>
	<?php foreach ($offering_data as $key => $value): ?>
		<?php if ($count == 4): ?><?=  "<div class='row'>" ?><?php endif ?>
			<?php 

			// $section = $this->Crud_model->fetch("offering",array("offering_id"=>$info['user']->offering_id));
			// $section = $section[0];
			$subjects = $this->Crud_model->fetch("subject",array("offering_id"=>$value->offering_id));
			$subjects = $subjects[0];
			?>
			<?php if ($subjects): ?>
				<?php 

				$lecturer = $this->Crud_model->fetch("lecturer",array("lecturer_id"=>$subjects->lecturer_id));
				$lecturer = $lecturer[0];
				?>	
				<div class="col s3" >
					<div class="card sticky-action" >
						<div class="card-image waves-effect waves-block waves-light" >
							<img class="activator" src="<?=base_url()?>assets/img/background-2.jpg">
						</div>
						<div class="card-content bg-primary-yellow" >
							<blockquote class="color-primary-green" style="margin-top: 0;">
								<span class="card-title activator color-black  grey-text text-darken-4 sub_name"><?=$subjects->subject_name?><i class="material-icons right ">more_vert</i></span>
							</blockquote>
							<h6><?=$lecturer->firstname." ".$lecturer->midname." ".$lecturer->lastname?></h6>
						</div>
						<div class="card-reveal bg-primary-green">
							<span class="card-title color-white ">ABOUT</span>
							<p class="valign-wrapper"><i class="material-icons color-primary-yellow">chevron_right</i><span class="color-white"><?=$subjects->subject_description?></span></p>
						</div>

						<div class="card-action bg-primary-yellow " style="padding: 0.02px !important;">
							<div class="row ">
								<div class="col s12 ">

									<a class="btn_launch_topics waves-effect waves-light btn right" data-id="<?=$subjects->subject_id?>" style="background-color: transparent; box-shadow: none !important;">Launch<i class="material-icons right">launch</i></a>

								</div>
							</div>
						</div>
					</div>
				</div>
				<?php if ($count == 4): ?><?= "</div>" ?><?php endif ?>
				<?php $count++; ?>
			<?php endif ?>
		<?php  endforeach ?>

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

<div class="row container" id="question-section" style="display: none;">
	<div class="col s1"></div>
	<div class="col s11" id="div-q-sec">
		

	</div> 
</div>

<!--====  End of DIV COURSEWARE QUESTION SECTION  ====-->



<script type="text/javascript">
	jQuery(document).ready(function($) {
		jQuery(".sub_name").fitText();

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
						'<div class="collapsible-header" style="background-color: transparent; text-transform: capitalize;"><div class="col s6"><i class="material-icons color-primary-green">navigate_next</i>'+data[i].topic_name+'</div>'+
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
					'</div>'+
					'<div class="col s6"><a class=" waves-effect waves-light btn right color-black btn_cw_question" data-cwid="'+i_data[j].courseware_id+'" style="background-color: transparent; box-shadow: none !important;">View<i class="material-icons right ">launch</i></a></div>'+
					'</div>'+
					'</div>';
				}
				$("#courseware_"+topic_id).html(courseware_content);
				$('.tooltipped').tooltip({delay: 50});

			}
		});
	}


	function fetchQuestion(id) {
		console.log(id);	
		$.ajax({
			url: '<?=base_url()?>Coursewares/fetchQuestions ',
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