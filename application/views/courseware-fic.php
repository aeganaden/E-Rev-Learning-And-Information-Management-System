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

<div class="row container">
	<div class="col s1"></div>
	<div class="col s11">
		<?php 
		$offering = $this->Crud_model->fetch("offering",array("offering_department"=>$info['user']->fic_department));
		?>
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
	</div>
</div>
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
	});
</script>