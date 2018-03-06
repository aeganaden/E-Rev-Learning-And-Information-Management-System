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
		<?php 
		$remedial_coursewares = $this->Crud_model->fetch("remedial_coursewares");
		?>
	</div>
</div>