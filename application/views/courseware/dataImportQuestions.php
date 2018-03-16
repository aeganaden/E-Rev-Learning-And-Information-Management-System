<?php $this->load->view('includes/home-sidenav'); ?>
<?php $this->load->view('includes/home-navbar'); ?>
<div class="row container">
	<blockquote class="color-primary-green">
		<h5 class="color-black">Import Questions</h5>
	</blockquote>
</div>

<div class="container row">
	<div class="col s1"></div>
	<div class="col s11">
		<h1>
			<?php echo "Courseware ID - ".$this->uri->segment(3); ?>
		</h1>
		<h3>
			Use the courseware id to upload in the courseware question table
		</h3>
	</div>
</div>
