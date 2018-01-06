<?php $this->load->view('includes/navbar-admin'); ?>
<?php  date_default_timezone_set("Asia/Manila")?>
<!--===========================
=            Cards            =
============================-->

<div class="row">
	<div class="col s3">
		<div class="row">
			<div class="card">
				<div class="card-content bg-primary-yellow">
					<p class="a-oswald flow-text">Good Day, Admin!</p>
					<p class="a-oswald flow-text">TODAY IS</p>
					<h4 class="a-oswald color-white center"><?=date("M d, Y", time())?></h4>
				</div>
			</div>
		</div>
		<div class="row">
			<h4>REPORTS</h4>
			<div class="card" id="card-cosml">
				<div class="card-content bg-primary-green">
					<h6 class="a-oswald color-white  valign-wrapper">Course Offering Schedule Master List <i class="material-icons">keyboard_arrow_right</i></h6>
				</div>
			</div>
			<div class="card" id="card-ls">
				<div class="card-content bg-primary-green">
					<h6 class="a-oswald color-white  valign-wrapper">Lecturers' Schedule <i class="material-icons">keyboard_arrow_right</i></h6>
				</div>
			</div>
			<div class="card" id="card-lahr">
				<div class="card-content bg-primary-green">
					<h6 class="a-oswald color-white  valign-wrapper">Lecturers' Attendance and Hours Rendered <i class="material-icons">keyboard_arrow_right</i></h6>
				</div>
			</div>
			<div class="card" id="card-lcl">
				<div class="card-content bg-primary-green">
					<h6 class="a-oswald color-white  valign-wrapper">Lecturers' Class List <i class="material-icons">keyboard_arrow_right</i></h6>
				</div>
			</div>
		</div>
	</div>
	<div class="col s9">
		<div class="row red" id="div-card-cosml" style="display: none;">
			<h1>REPORT 1</h1>
		</div>
		<div class="row blue" id="div-card-ls" style="display: none;">
			<h1>REPORT 2</h1>
		</div>
		<div class="row green" id="div-card-lahr" style="display: none;">
			<h1>REPORT 3</h1>
		</div>
		<div class="row orange" id="div-card-lcl" style="display: none;">
			<h1>REPORT 4</h1>
		</div>
	</div>
</div>	

<!--====  End of Cards  ====-->
