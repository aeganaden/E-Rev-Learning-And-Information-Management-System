<?php $this->load->view('includes/home-sidenav'); ?>
<?php $this->load->view('includes/home-navbar'); ?>
<div class="row container">
	<div class="col s1"></div>
	<div class="col s7">
		<blockquote class="color-primary-green">
			<h3 class="color-black">Manage Coursewares</h3>
		</blockquote>
	</div>
	<div class="col s4"></div>
</div>
<!--=================================
=            Breadcrumbs            =
==================================-->

<div class="row container">
	<div class="col s1"></div>
	<div class="col s11">
		<nav  style="background-color: transparent; box-shadow: none;">
			<div class="nav-wrapper">
				<div class="col s12" id="div-bread">
					<a href="#!" class="breadcrumb" id="btn_launch_subjects">Subjects</a>
				</div>
			</div>
		</nav>
	</div>
</div>

<!--====  End of Breadcrumbs  ====-->
<div class="row container" id="subject-section">
	<div class="col s1"></div>
	<div class="col s11">

		<?php 
		$offering = $this->Crud_model->fetch("offering",array("offering_department"=>$info['user']->fic_department));
		?>
		<?php if ($offering): ?>
			<?php foreach ($offering as $key => $value): ?>
				<?php
				$subject = $this->Crud_model->fetch("subject",array("offering_id"=>$value->offering_id));
				$subject = $subject[0];
				$lecturer = $this->Crud_model->fetch("lecturer",array("lecturer_id"=>$subject->lecturer_id));
				$lecturer = $lecturer[0];
				?>
				<div class="col s3" >
					<div class="card sticky-action" >
						<div class="card-image waves-effect waves-block waves-light" >
							<img class="activator" src="<?=base_url()?>assets/img/background-2.jpg">
						</div>
						<div class="card-content bg-primary-yellow" >
							<blockquote class="color-primary-green" style="margin-top: 0;">
								<span class="card-title activator color-black  grey-text text-darken-4 sub_name"><?=$subject->subject_name?><i class="material-icons right ">more_vert</i></span>
							</blockquote>
							<h6><?=$lecturer->firstname." ".$lecturer->midname." ".$lecturer->lastname?></h6>
						</div>
						<div class="card-reveal bg-primary-green">
							<span class="card-title color-white ">ABOUT</span>
							<p class="valign-wrapper"><i class="material-icons color-primary-yellow">chevron_right</i><span class="color-white"><?=$subject->subject_description?></span></p>
						</div>

						<div class="card-action bg-primary-yellow " style="padding: 0.02px !important;">
							<div class="row ">
								<div class="col s12 ">

									<a class="btn_launch_topics waves-effect waves-light btn right" data-id="<?=$subject->subject_id?>" style="background-color: transparent; box-shadow: none !important;">Launch<i class="material-icons right">launch</i></a>

								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach ?>
		<?php else: ?>

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

		<?php endif ?>
	</div>
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

<!--=======================================
=            WIRIS TEXT EDITOR            =
========================================-->
<!-- 
<div class="row container">
	<div class="col s1"></div>
	<div class="col s11">
		<textarea name="editor1" id="q_editor"></textarea>
		<input id="send" type="button" value="Send">
	</div>

</div> -->

<!--====  End of WIRIS TEXT EDITOR  ====-->

<a id="btn_show_menu"  class="btn-floating btn-large waves-effect waves-light red button-collapse right" data-activates="slide-out"><i  class="material-icons">menu</i></a>


<script>
	jQuery(document).ready(function($) {
		jQuery(".sub_name").fitText();
		// CKEDITOR.replace( 'editor1');
		$("#send").click(function(event) {
			var value = CKEDITOR.instances['q_editor'].getData()
			console.log(value);	
		});




		/*===============================================
		=            AJAX AND ANIMATE SCRIPT            =
		===============================================*/
		
		// ajax
		$(".btn_launch_topics").click(function(event) {
			// alert();
			$id = $(this).data("id");
			var html_content = "";
			if ($("#div-bread-topics").length==0) {
				$("#div-bread").append('<a href="#!" class="breadcrumb" id="div-bread-topics">Topics</a>');
			}

			$('#subject-section').animateCss('zoomOut', function() {
				$("#subject-section").css('display', 'none');
				$('#topics-section').addClass('animated zoomIn');
				$("#topics-section").css('display', 'block');
			});

			$.ajax({
				url: '<?=base_url()?>Coursewares/fetchTopics',
				type: 'post',
				dataType: 'json',
				data: {id: $id},
				success: function(data){
					// console.log(data);	
					if (data.length > 0) {
						$("#div-topics").css('display', 'none');

						for(var i = 0; i < data.length; i++){
							$topic_id = data[i].topic_id;

							// console.log(i);	
							html_content += '<li>'+
							'<div class="collapsible-header" style="background-color: transparent; text-transform: capitalize;"><i class="material-icons color-primary-green">navigate_next</i>'+data[i].topic_name+'</div>'+
							'<div class="collapsible-body" id="courseware_'+data[i].topic_id+'">'+
							'</div>'+
							'</li>';

							// AJAX FOR COURSEWARE
							var courseware_content = "";
							$.ajax({
								url: '<?=base_url()?>Coursewares_fic/fetchCoursewares',
								type: 'post',
								dataType: 'json',
								data: {topic_id: $topic_id},
								success: function(i_data){
									for(var j = 0; j < i_data.length; j++){
										courseware_content +='<div class="row valign-wrapper" style="margin: 0; border: 1px solid #007A33; border-radius: 5px;">'+
										'<div class="col s6">'+
										'<p>Coursware Name here</p>'+ 
										'</div>'+
										'<div class="col s6">'+
										'<a class=" waves-effect waves-light btn right color-black" style="background-color: transparent; box-shadow: none !important;">Launch<i class="material-icons right ">launch</i></a>'+
										'</div>'+
										'</div>';
									}
									$("#courseware_"+$topic_id).html(courseware_content);


								}
							});
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
	</script>