<?php $this->load->view('includes/navbar'); ?>


<!--======================================
=            Banner Slideshow            =
=======================================-->
<div class="row" style="height: 100%;">
	<div id="a-div-slider" class="slider" style="position: relative; z-index: 0;">
		<ul class="slides">
			<li>
				<!-- <img src="https://lorempixel.com/580/250/nature/1"> -->
				<img src="<?=base_url()?>assets/img/slides/slide-1.jpeg" > 
				<div  class="caption left-align">
					<h3>Sharpen your skills</h3>
					<h5 class="light grey-text text-lighten-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h5>
				</div>
			</li>
			<li>
				<img src="<?=base_url()?>assets/img/slides/slide-2.jpeg" > 
								<!-- <img src="https://lorempixel.com/580/250/nature/2"> -->
				<!-- <img src="<?=base_url()?>assets/img/2.png" >  -->
				<div class="caption left-align">
					<h3>Achieve your Goal</h3>
					<h5 class="light grey-text text-lighten-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h5>
				</div>
			</li>
			<li>
				<img src="<?=base_url()?>assets/img/slides/slide-3.jpeg" > 
								<!-- <img src="<?=base_url()?>assets/img/3.png" >  -->
				<div class="caption left-align">
					<h3>Right Aligned Caption</h3>
					<h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
				</div>
			</li>
			<li>
				<img src="<?=base_url()?>assets/img/slides/slide-4.jpeg" > 
								<!-- <img src="<?=base_url()?>assets/img/4.png" > -->
				<div class="caption left-align">
					<h3>This is our big Tagline!</h3>
					<h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
				</div>
			</li>
		</ul>
	</div>
</div>

<!--====  End of Banner Slideshow  ====-->


<!--==============================
=            Features            =
===============================-->

<div class="row">
	<div class="row">
		
	</div>
</div>

<!--====  End of Features  ====-->



<!--=================================
=            Modal Login            =
==================================-->
<div id="a-login-modal" class="modal bg-color-white">
	<center>
		<img src="<?=base_url()?>assets/img/feu-header.png" style="width: 50vh; margin-top: 1%;">
	</center>
	
	<hr>

	<div class="modal-content ">
		<div class="row">
			<div class="col s2"></div>
			<div class="col s8">
				<blockquote class="color-primary-yellow">
					<h3 class="color-primary-green">LOGIN</h3>
				</blockquote>
				<form>
					<div class="row ">
						<div class="input-field">
							<input id="username" type="text" class="validate">
							<label for="username" class="color-primary-green">Username</label>
						</div>
					</div>
					<div class="row ">
						<div class="input-field">
							<input id="password" type="password" class="validate">
							<label for="password" class="color-primary-green">Password</label>
						</div>
					</div>
				</form>
				<a href="#!" class="waves-effect waves-light btn bg-primary-green right color-white">LOG IN</a>
				<a href="#!" class="modal-effect modal-close waves-effect waves-light btn red left color-white">Return</a>
			</div>
			<div class="col s2"></div>
		</div>
	</div>
	<div class="modal-footer bg-primary-green">
		<p class="center"> FEU - INSTITUTE OF TECHONOLOGY | &copy; 2017</p>
	</div>
</div>


<!--====  End of Modal Login  ====-->
