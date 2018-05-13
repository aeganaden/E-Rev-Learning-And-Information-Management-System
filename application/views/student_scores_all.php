<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>
<?php 
$ds_id = $this->uri->segment(3); 
$data_scores = $this->Crud_model->fetch("student_scores",array("data_scores_id"=>$ds_id));
?>

<div  class="container row">
	<div class="col s1"></div>
	<div class="col s11">
		<blockquote class="color-primary-green">
			<h5 class="color-black">Student Scores</h5>
		</blockquote>
		<div class="row">
			<?php if ($data_scores): ?>  
				<table class="data-table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Student</th>
							<th>Student Number</th>
							<th>Score</th>
							<th>Remarks</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($data_scores as $key => $value): ?>
							<tr>
								<?php 
								$student = $this->Crud_model->fetch("student",array("student_num"=>$value->student_scores_stud_num));
								$student = $student[0];  
								$fullname = $student->firstname." ".$student->lastname;
								?>
								<td><?=$value->student_scores_id?></td>
								<td><?=$fullname?></td>
								<td><?=$value->student_scores_stud_num?></td>
								<td><?=$value->student_scores_score?></td>
								<td>
									<?php if ($value->student_scores_is_failed == 1): ?>
										<span class="new badge red" data-badge-caption="">Failed</span> 
									<?php else: ?>
										<span class="new badge" data-badge-caption="">Passed</span> 
									<?php endif ?>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
	</div>
</div>