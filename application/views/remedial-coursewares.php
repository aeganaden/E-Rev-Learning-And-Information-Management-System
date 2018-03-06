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
		$student_scores = $this->Crud_model->fetch("student_scores",array("student_scores_stud_num"=>$info['user']->student_id));
		?>
		<?php if ($student_scores): ?>
			<?php foreach ($student_scores as $key => $value): ?>
				<?php 
				$remedial_coursewares = $this->Crud_model->fetch("remedial_coursewares",array("student_scores_id"=>$value->student_scores_id));
				?>

				<ul class="collapsible " data-collapsible="accordion"> 
					<li class="">
						<div class="collapsible-header bg-primary-green color-white">
							<i class="material-icons color-white">book</i>Remedial Coursewares #<?=$key+1?>
						</div>
						<div class="collapsible-body">
							<ul class="collection "> 
								<?php if ($remedial_coursewares): ?>
									<?php foreach ($remedial_coursewares as $i_key => $i_value): ?>
										<?php 
										$courseware = $this->Crud_model->fetch("courseware",array("courseware_id"=>$i_value->courseware_id));
										$courseware = $courseware[0];
										?>
										<li class="collection-item bg-color-white">
											<div  class="valign-wrapper">
												<?php if ($i_value->is_done == 1): ?>
													<i class="material-icons color-primary-green">done</i>
													<?=strtoupper($courseware->courseware_name)?>

												<?php else: ?>
													<i class="material-icons color-red">remove</i>

													<?=strtoupper($courseware->courseware_name)?>
													<span href="#!" class="badge">
														<i class="material-icons ">send</i>
													</span>
												<?php endif ?>


											</div>
										</li>
									<?php endforeach ?>
								<?php endif ?>
							</ul>
						</div>
					</li>
				</ul>
			<?php endforeach ?>
		<?php endif ?>
	</div>
</div>