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
		<nav style="background-color: transparent !important; box-shadow: none;" >
			<div class="nav-wrapper" >
				<div class="col s12 ">
					<a href="#!" class="breadcrumb">Subjects</a>
				</div>
			</div>
		</nav>
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
		CKEDITOR.replace( 'editor1');
		$("#send").click(function(event) {
			var value = CKEDITOR.instances['q_editor'].getData()
			console.log(value);	
		});
	});
</script>