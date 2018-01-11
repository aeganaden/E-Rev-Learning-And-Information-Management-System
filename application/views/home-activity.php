<!--====================================
=            Navigation Top            =
=====================================-->

<div class="row valign-wrapper">
	<div class="col s4 ">

		<a href="#" style="padding-left: 2%" data-activates="slide-out" class="color-black button-collapse valign-wrapper">
			<i class="material-icons small">menu</i> MENU
		</a>
	</div>
	<div class="col s4">
		<center>
			<img src="<?=base_url()?>assets/img/feu-header.png" style="width: 40vh; margin-top: 2%;">
		</center> 
	</div>
	<div class="col s4"></div>
</div>

<!--====  End of Navigation Top  ====<--></-->
<?php $this->load->view('includes/home-sidenav'); ?>

<div class="row">
	<div class="col s4">
		
		<blockquote class="color-primary-green">
			<?php echo strtotime("now") ?>
			<h1 class="color-black">Activity</h1>
		</blockquote>
	</div>
	<div class="col s4"></div>
	<div class="col s4"></div>
</div>

<div class="row">
	<div class="col s4">
		<div class="card bg-primary-green ">
			<div class="card-content white-text">
				<span class="card-title">Card Title</span>
				<p>I am a very simple card. I am good at containing small bits of information.
				I am convenient because I require little markup to use effectively.</p>
			</div>
			<div class="card-action">
				<a href="#">This is a link</a>
				<a href="#">This is a link</a>
			</div>
		</div>
	</div>
</div>
