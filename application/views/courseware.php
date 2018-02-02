<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>
<!-- <textarea name="editor1"></textarea>
<script>

	CKEDITOR.replace( 'editor1');
</script> -->
<div class="row">

	<div class="row	 container">
		<?php 

		$subjects = $this->Crud_model->fetch("subject");
		$count = 1;
		?>
		<?php foreach ($subjects as $key => $value): ?>
			<?php if ($count == 4): ?>
				<?=  "<div class='row'>" ?>
				<?php endif ?>
				<div class="col s3" >
					<div class="card sticky-action" >
						<div class="card-image waves-effect waves-block waves-light" >
							<img class="activator" src="<?=base_url()?>assets/img/background-2.jpg">
						</div>
						<div class="card-content bg-primary-yellow" >
							<blockquote class="color-primary-green" style="margin-top: 0;">
								<span class="card-title activator color-black  grey-text text-darken-4"><?=$value->subject_name?><i class="material-icons right">more_vert</i></span>
							</blockquote>
							<h6>Ms. Cayle Gaspar</h6>
						</div>
						<div class="card-reveal bg-primary-green">
							<span class="card-title color-white">Physics<i class="material-icons right ">close</i></span>
							<p class="">Here is some more information about this product that is only revealed once clicked on.</p>
						</div>

						<div class="card-action bg-primary-yellow" style="padding-bottom: 0.02px !important;">
							<div class="row">
								<div class="col s12">

									<a class="waves-effect waves-light btn right" style="background-color: transparent; box-shadow: none !important;">Launch<i class="material-icons right">launch</i></a>

								</div>
							</div>
						</div>
					</div>
				</div>
				<?php if ($count == 4): ?>
					<?= "</div>" ?>
				<?php endif ?>
				<?php $count++; endforeach ?>
				<div class="col s3"></div>
				<div class="col s3"></div>
				<div class="col s3"></div>

			</div>
		</div>