<?php $this->load->view('includes/navbar'); ?>

<!-- Include in footer

<div>Icons made by <a href="https://www.flaticon.com/authors/popcorns-arts" title="Icon Pond">Icon Pond</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
-->
<!--======================================
=            Banner Slideshow            =
=======================================-->
<div class="row" style="height: 100%;">
	<div id="a-div-slider" class="slider" style="position: relative; z-index: 0;">
		<ul class="slides">
			<li>
				<!-- <img src="https://lorempixel.com/580/250/nature/1"> -->
				<img src="<?=base_url()?>assets/img/slides/slide-5.jpg" style="filter: blur(2px);"> 
				<div  class="caption left-align">
					<h3 >Sharpen your skills</h3>
					<h5 class="light grey-text text-lighten-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h5>
				</div>
			</li>
			<li>
				<img src="<?=base_url()?>assets/img/slides/slide-2.jpeg" style="filter: blur(2px);"> 
				<!-- <img src="https://lorempixel.com/580/250/nature/2"> -->
				<!-- <img src="<?=base_url()?>assets/img/2.png" >  -->
				<div class="caption left-align">
					<h3>Achieve your Goal</h3>
					<h5 class="light grey-text text-lighten-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h5>
				</div>
			</li>
			<li>
				<img src="<?=base_url()?>assets/img/slides/slide-3.jpg" > 
				<!-- <img src="<?=base_url()?>assets/img/3.png" >  -->
				
			</li>
			<li>
				<img src="<?=base_url()?>assets/img/slides/slide-4.jpg" > 
				<!-- <img src="<?=base_url()?>assets/img/4.png" > -->
				
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
		<center><i class="material-icons small color-primary-green">clear_all</i></center>
		<h4 class="center a-roboto-cond">Features</h4>
	</div>
	<div class="row">
		<div class="col s12">
			<div class="col s3">	
				<center>
					<img src="<?=base_url()?>assets/img/icons/learning.svg" class="a-icons-landing" alt="">
					<h5 class="a-icons-header center">Learn Online</h5>
				</center>
				<p class="a-icons-description">
					Est pariatur ullamco fugiat velit labore dolor pariatur aute officia in ad consectetur minim et excepteur cupidatat qui ut occaecat qui fugiat in adipisicing cupidatat amet.
				</p>
			</div>	
			<div class="col s3">
				<center>
					<img src="<?=base_url()?>assets/img/icons/personalized.svg" class="a-icons-landing" alt="">
					<h5 class="a-icons-header center">Personalized Experience</h5>
				</center>
				<p class="a-icons-description">
					Est pariatur ullamco fugiat velit labore dolor pariatur aute officia in ad consectetur minim et excepteur cupidatat qui ut occaecat qui fugiat in adipisicing cupidatat amet.
				</p>
			</div>
			<div class="col s3">
				<center>
					<img src="<?=base_url()?>assets/img/icons/analytics.svg" class="a-icons-landing" alt="">
					<h5 class="a-icons-header center">Grades Analysis</h5>
				</center>
				<p class="a-icons-description">
					Est pariatur ullamco fugiat velit labore dolor pariatur aute officia in ad consectetur minim et excepteur cupidatat qui ut occaecat qui fugiat in adipisicing cupidatat amet.
				</p>
			</div>
			<div class="col s3">
				<center>
					<img src="<?=base_url()?>assets/img/icons/monitor.svg" class="a-icons-landing" alt="">
					<h5 class="a-icons-header center">Lecturer Monitoring</h5>
				</center>
				<p class="a-icons-description">
					Est pariatur ullamco fugiat velit labore dolor pariatur aute officia in ad consectetur minim et excepteur cupidatat qui ut occaecat qui fugiat in adipisicing cupidatat amet.
				</p>
			</div>
		</div>
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
				<form action="<?=base_url()?>Login " method="post">
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
					<button href="#!" class="waves-effect waves-light btn bg-primary-green right color-white">LOG IN</button>
				</form>
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





<!--============================
=            FOOTER            =
=============================-->


<footer class="page-footer bg-primary-yellow color-black">
	<div class="container">
		<div class="row">
			<div class="col l6 s12">
				<h5 class="">P. PAREDES ST, SAMPALOC, MANILA</h5>
				<div >Icons made by 
					<a class="color-black a-Footer_Credits" href="http://www.freepik.com" title="Freepik">Freepik</a> 
					from 
					<a class="color-black a-Footer_Credits" href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a>
					is licensed by
					<a class="color-black a-Footer_Credits" href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a>
				</div>
			</div>
			<div class="col l4 offset-l2 s12">
				<h5 class="">External Links</h5>
				<ul>
					<li><a class="color-black" href="#!">FEU - Institute of Technology</a></li>
					<li><a class="color-black" href="#!">Somelink</a></li>
					<li><a class="color-black" href="#!">Somelink</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="color-black">
			© 2017 LAGDDA - ONLINE COMMUNITY
		</div>
	</div>
</footer>


<!--====  End of FOOTER  ====-->
