<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>
<!-- <textarea name="editor1"></textarea>
<script>

	CKEDITOR.replace( 'editor1');
</script> -->

<div class="row container">
	<div class="col s1"></div>
	<div class="col s7">
		<blockquote class="color-primary-green">
			<h3 class="color-black">Coursewares</h3>
		</blockquote>
	</div>
	<div class="col s4"></div>
</div>
<!--======================================
=            SUBJECTS SECTION            =
=======================================-->

<div class="row	 container" id="subject-section">
	<div class="col s1"></div>
	<div class="col s11">
		<?php 
		$section = $this->Crud_model->fetch("offering",array("offering_id"=>$info['user']->offering_id));
		$section = $section[0];
		$subjects = $this->Crud_model->fetch("subject",array("offering_id"=>$section->offering_id));

		$count = 1;
		?>
		<?php foreach ($subjects as $key => $value): ?>
			<?php if ($count == 4): ?><?=  "<div class='row'>" ?><?php endif ?>
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
							<h6><?=$lecturer->firstname." ".$lecturer->midname." ".$lecturer->lastname?></h6>
						</div>
						<div class="card-reveal bg-primary-green">
							<span class="card-title color-white"><?=$value->subject_name?></span>
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
			<?php  endforeach ?>
		</div>

	</div>


	<!--====  End of SUBJECTS SECTION  ====-->


	<!--========================================
	=            DIV TOPICS SECTION            =
	=========================================-->
	
	<div id="topics-section" class="row container" style="display: none;">
		<div class="row">
			<div class="col s1"></div>
			<div class="col s7">
				<h3 class="color-black">Topics</h3>
			</div>
			<div class="col s4"><button class="btn waves-light waves-effect right bg-primary-green" id="btn_launch_subjects">Return</button></div>
		</div>
		<!-- DIV FOR TOPICS -->
		<div class="row" id="topics">
			<div class="col s1"></div>
			<div class="col s11">
				<ul class="collapsible" id="topic_content" data-collapsible="accordion">
					
				</ul>
			</div>
		</div>

	</div>

	<!--====  End of DIV TOPICS SECTION  ====-->


	<script type="text/javascript">
		jQuery(document).ready(function($) {
			jQuery(".sub_name").fitText();
			jQuery(".subject_title").fitText();

			// ajax
			$(".btn_launch_topics").click(function(event) {

				$id = $(this).data("id");
				var html_content = "";
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
						for(var i = 0; i < data.length; i++){
							html_content += '<li>'+
							'<div class="collapsible-header" style="background-color: transparent; text-transform: capitalize;"><i class="material-icons color-primary-green">navigate_next</i>'+data[i].topic_name+'</div>'+
							'<div class="collapsible-body">'+
							'<div class="row valign-wrapper" style="margin: 0; border: 1px solid #007A33; border-radius: 5px;">'+
							'<div class="col s6">'+
							'<p>Coursware Name here</p>'+ 
							'</div>'+
							'<div class="col s6">'+
							'<a class=" waves-effect waves-light btn right color-black" style="background-color: transparent; box-shadow: none !important;">Launch<i class="material-icons right ">launch</i></a>'+
							'</div>'+
							'</div>'+
							'</div>'+
							'</li>';
						}

						$("#topic_content").html(html_content);
					}
				});
				


			});

			$("#btn_launch_subjects").click(function(event) {
				$('#topics-section').animateCss('zoomOut', function() {
					$("#topics-section").css('display', 'none');
					$('#subject-section').addClass('animated zoomIn');
					$("#subject-section").css('display', 'block');
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
	</script>