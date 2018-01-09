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
		<div class="row" id="div-card-cosml" style="display: none;">
			<h3>Course Offering Schedule Master List</h3>
			<table id="tbl-card-cosml" >
				<thead >
					<tr>
						<th>ID</th>
						<th>Course Code</th>
						<th>Course Title</th>
						<th>Section</th>
						<th>Day</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Venue</th>
						<th>Assigned Lecturer</th>
						<th>Term</th>
						<th>School Year</th>
					</tr>
				</thead>

				<tbody class="bg-color-white">

					<?php foreach ($div_cosml_data as $key => $value): ?>
						<tr class="bg-color-white">
							<td><?= $value->schedule_id ?></td>
							<td><?= strtoupper($value->course_code) ?></td>
							<td><?= ucwords($value->course_title) ?></td>
							<td><?= strtoupper($value->course_section) ?></td>
							<td><?= date("l",$value->schedule_start_time) ?></td>
							<td><?= date("h:i A",$value->schedule_start_time) ?></td>
							<td><?= date("h:i A",$value->schedule_end_time) ?></td>
							<td><?= strtoupper($value->schedule_venue) ?></td>
							<td><?= ucwords($value->lecturer_name) ?></td>
							<td><?= $value->term ?></td>
							<td><?= $value->sy ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
		<div class="row " id="div-card-ls" style="display: none;">
			<h3>Lecturers' Schedule</h3>
			<table id="tbl-card-ls" >
				<thead >
					<tr>
						<th>ID</th>
						<th>Last Name</th>
						<th>First Name</th>
						<th>Middle Name</th>
						<th>Course Code</th>
						<th>Day</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Venue</th>
						<th>Expertise</th>
						<th>Status</th>
					</tr>
				</thead>

				<tbody class="bg-color-white">
					<?php foreach ($div_cosml_data as $key => $value): ?>
						<tr class="bg-color-white">
							<td><?= $value->lecturer_id ?></td>
							<td><?= ucwords($value->lecturer_firstname) ?></td>
							<td><?= ucwords($value->lecturer_middlename) ?></td>
							<td><?= ucwords($value->lecturer_lastname) ?></td>
							<td><?= strtoupper($value->course_code) ?></td>
							<td><?= date("l",$value->schedule_start_time) ?></td>
							<td><?= date("h:i A",$value->schedule_start_time) ?></td>
							<td><?= date("h:i A",$value->schedule_end_time) ?></td>
							<td><?= strtoupper($value->schedule_venue) ?></td>
							<td><?= ucwords($value->lecturer_expertise) ?></td>
							<td>
								<?php if ($value->lecturer_status == 1): ?>
									<p class="color-green">Active</p>
								<?php else: ?>
									<p class="color-red">Inactive</p>
								<?php endif ?>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
		<div class="row" id="div-card-lahr" style="display: none;">
			<h3>Lecturers' Attendance and Hours Rendered</h3>
			<table id="tbl-card-lahr" >
				<thead >
					<tr>
						<th>ID</th>
						<th>Last Name</th>
						<th>First Name</th>
						<th>Middle Name</th>
						<th>Expertise</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>

				<tbody class="bg-color-white">
					<?php foreach ($div_cosml_data as $key => $value): ?>
						<tr class="bg-color-white">
							<td><?= $value->lecturer_id ?></td>
							<td><?= ucwords($value->lecturer_firstname) ?></td>
							<td><?= ucwords($value->lecturer_middlename) ?></td>
							<td><?= ucwords($value->lecturer_lastname) ?></td>
							<td><?= ucwords($value->lecturer_expertise) ?></td>
							<td>
								<?php if ($value->lecturer_status == 1): ?>
									<p class="color-green">Active</p>
								<?php else: ?>
									<p class="color-red">Inactive</p>
								<?php endif ?>
							</td>
							<td>
								<a href="<?=base_url()?>Admin/viewAttendance/<?=$value->lecturer_id?>" target="_blank" class="btn waves-effect waves-light ">View</a>
							</td>
							<td><button class="btn waves-effect waves-light">Download</button></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
			
		</div>
		<div class="row" id="div-card-lcl" style="display: none;">
			<h3>Lecturers' Class List</h3>
			<table id="tbl-card-lahr" >
				<thead >
					<tr>
						<th>ID</th>
						<th>Last Name</th>
						<th>First Name</th>
						<th>Middle Name</th>
						<th>Expertise</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>

				<tbody class="bg-color-white">
					<?php foreach ($div_cosml_data as $key => $value): ?>
						<tr class="bg-color-white">
							<td><?= $value->lecturer_id ?></td>
							<td><?= ucwords($value->lecturer_firstname) ?></td>
							<td><?= ucwords($value->lecturer_middlename) ?></td>
							<td><?= ucwords($value->lecturer_lastname) ?></td>
							<td><?= ucwords($value->lecturer_expertise) ?></td>
							<td>
								<?php if ($value->lecturer_status == 1): ?>
									<p class="color-green">Active</p>
								<?php else: ?>
									<p class="color-red">Inactive</p>
								<?php endif ?>
							</td>
							<td>
								<a href="<?=base_url()?>Admin/viewClassList/<?=$value->lecturer_id?>" target="_blank" class="btn waves-effect waves-light ">View</a>
							</td>
							<td><button class="btn waves-effect waves-light">Download</button></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>	

<!--====  End of Cards  ====-->



