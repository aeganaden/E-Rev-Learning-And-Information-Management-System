<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>

<?php 
$data_id = $this->uri->segment(3); 
$data_scores = $this->Crud_model->fetch("data_scores",array("data_scores_type"=>$data_id));
$score_type = "";
if ($data_id == 1) $score_type = "Long Quiz";
elseif ($data_id == 2) $score_type = "Short Quiz";
elseif ($data_id == 3) $score_type = "Seatwork";
elseif ($data_id == 4) $score_type = "Exam";

?>


<div class="container row">
	<div class="col s1"></div>
	<div class="col s11">
		<blockquote class="color-primary-green">
			<h5 class="color-black">Student Scores Data</h5>
		</blockquote>

		<div class="row">
			<?php if ($data_scores): ?>
				<table class="data-table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Score Type</th>
							<th>Topics Covered</th>
							<th>Total Score</th>
							<th>Passing Score</th>
							<th>Action</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($data_scores as $key => $value): ?>
							<tr>
								<?php  
								if ($student_scores = $this->Crud_model->fetch("student_scores",array("data_scores_id"=>$value->data_scores_id))) {
									$student_scores = $student_scores[0];   
									$topics = explode(",",$student_scores->student_scores_topic_id);
								}else{
									$topics = "";
								}
								?>
								<td><?=$value->data_scores_id?></td>
								<td><?=$score_type?></td>
								<td>
									<?php if ($topics): ?>
										<?php foreach ($topics as $i_key => $i_value): ?>
											<?php 
											$topic_i  = $this->Crud_model->fetch("topic",array("topic_id"=>$i_value));
											$topic_i = $topic_i[0];
											?>
											<blockquote class="color-primary-green">
												<h6 class="color-black"><?=$topic_i->topic_name?></h6>
											</blockquote> 
										<?php endforeach ?>
									<?php else: ?>
										<h1></h1>
									<?php endif ?>
								</td>
								<td><?=$value->data_scores_score?></td>
								<td><?=$value->data_scores_passing?></td>  
								<td>
									<a class="waves-effect waves-light btn bg-primary-green" 
									href="<?=base_url()?>Student_scores/view_allScores/<?=$value->data_scores_id?>">
									<i class="material-icons right">visibility</i>View
								</a>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		<?php else: ?>
			<div class="row valign-wrapper">
				<div class="col s4 ">
					<h5 class="center" style="text-transform: uppercase; text-align: justify-all;">Seems pretty empty here...</h5>
				</div>
				<div class="col s4">
					<img src="<?=base_url()?>assets/chibi/Chibi_crying.svg " alt="">
				</div>	
				<div class="col s4">
					<h5 class="center" style="text-transform: uppercase; text-align: justify-all;">Upload some scores for this score type</h5>
				</div>
			</div>
		<?php endif ?>
	</div>
</div>
</div>
