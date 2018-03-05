<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>

<div class="container row">
	<div class="col s1"></div>
	<div class="col s11">
		<blockquote class="color-primary-green">
			<h5 class="color-black">Grade Assessment </h5>
		</blockquote>
	</div>
</div>

<div class="container row">
	<div class="col s1"></div>
	<div class="col s11">
		<div class="row">
			<div class="col s12"> 
				<ul class="tabs tabs-fixed-width bg-primary-green">
					<li class="tab"><a class="active color-white" href="#grades">Grades</a></li>
					<li class="tab"><a class="color-white" href="#saPercentage">Subject Area Percentage</a></li>
				</ul>
			</div>
			<div id="grades" class="col s12">
				<?php 
				$active_enrollment = $this->Crud_model->fetch("enrollment",array("enrollment_is_active"=>1));
				$active_enrollment = $active_enrollment[0];
				$offering = $this->Crud_model->fetch("offering",array("offering_id"=>$info['user']->offering_id));
				$cw_percentage_sa = array();
				$cw_percentage = array();
				$p_total_score = 0;
				$p_scores = 0;
				?> 
				<?php if ($offering): ?>
					<ul class="collapsible" data-collapsible="accordion">
						<?php foreach ($offering as $key => $value): ?>
							<?php $course = $this->Crud_model->fetch("course",array("course_id"=>$value->course_id)) ?>
							<?php foreach ($course as $key => $i_value): ?>
								<?php $subject = $this->Crud_model->fetch("subject",array("course_id"=>$i_value->course_id));?>
								<?php if ($subject): ?>
									<?php foreach ($subject as $key => $j_value): ?>
										<?php $topic = $this->Crud_model->fetch("topic",array("subject_id"=>$j_value->subject_id)) ?>
										<?php if ($topic): ?>
											<?php foreach ($topic as $key => $k_value): ?>
												<?php $courseware = $this->Crud_model->fetch("courseware",array("topic_id"=>$k_value->topic_id,"courseware_status"=>1)) ?>
												<?php if ($courseware): ?>
													<?php foreach ($courseware as $key => $l_value): ?>
														<li>
															<div class="collapsible-header bg-primary-green color-white"><i class="material-icons color-white">book</i><?=$l_value->courseware_name?></div>

															<div class="collapsible-body">
																<?php 
																$grade_assessment = $this->Crud_model->fetch("grade_assessment",array("student_id"=>$info['user']->student_id,"courseware_id"=>$l_value->courseware_id));
																?>
																<?php if ($grade_assessment): ?>
																	<table class="data-table">
																		<thead>
																			<tr>
																				<th>Take #</th>
																				<th>SCORE</th>
																				<th>TOTAL SCORE</th>
																				<th>PERCENTAGE</th>
																				<th>TIME</th>
																				<th>REMARKS</th>
																			</tr>
																		</thead>
																		<tbody>
																			<?php foreach ($grade_assessment as $m_key => $m_value): ?>
																				<?php 
																				$percent = (($m_value->grade_assessment_score / $m_value->grade_assessment_total) * 100)."%";
																				$remarks = $percent >= 70 ? "passed" : "failed";
																				$remarks_color = $percent >= 70 ? "" : "red";

																				if ($time = $this->Crud_model->fetch("courseware_time",array("grade_assessment_id"=>$m_value->grade_assessment_id))) {
																					$time = $time[0];
																					$time = $time->courseware_time_time;
																				}else{
																					$time ="-";
																				}
																				?>
																				<tr>
																					<td><?=$m_key+1?></td>
																					<td><?=$m_value->grade_assessment_score?></td>
																					<td><?=$m_value->grade_assessment_total?></td>
																					<td><?=$percent?></td>
																					<td><?=$time?></td>
																					<td><span class="new badge <?=$remarks_color?>" data-badge-caption="<?=$remarks?>"></span></td>
																				</tr>
																			<?php endforeach ?>
																		</tbody>
																	</table>
																<?php endif ?>

															</div>
														</li>		
													<?php endforeach ?>
												<?php endif ?>		
											<?php endforeach ?>
										<?php endif ?>
									<?php endforeach ?>
								<?php endif ?>
							<?php endforeach ?>
						<?php endforeach ?>				
					</ul>
				<?php endif ?>

			</div>
			<div id="saPercentage" class="col s12">
				<?php if ($offering): ?>
					<ul class="collapsible" data-collapsible="accordion">
						<?php foreach ($offering as $key => $value): ?>
							<?php $course = $this->Crud_model->fetch("course",array("course_id"=>$value->course_id)) ?>
							<?php foreach ($course as $key => $i_value): ?>
								<?php $subject = $this->Crud_model->fetch("subject",array("course_id"=>$i_value->course_id));?>
								<?php if ($subject): ?>
									<?php foreach ($subject as $key => $j_value): ?>
										<?php $topic = $this->Crud_model->fetch("topic",array("subject_id"=>$j_value->subject_id)) ?>
										<?php if ($topic): ?>
											<?php foreach ($topic as $key => $k_value): ?>
												<?php $courseware = $this->Crud_model->fetch("courseware",array("topic_id"=>$k_value->topic_id,"courseware_status"=>1)) ?>
												<?php if ($courseware): ?>
													<?php foreach ($courseware as $key => $l_value): ?>

														<?php $grade_assessment = $this->Crud_model->fetch("grade_assessment",array("student_id"=>$info['user']->student_id,"courseware_id"=>$l_value->courseware_id));
														?>
														<?php if ($grade_assessment): ?>
															<?php foreach ($grade_assessment as $m_key => $m_value): ?>
																<?php 
																$p_scores += $m_value->grade_assessment_score;
																$p_total_score += $m_value->grade_assessment_total;
																?>
															<?php endforeach ?>

														<?php endif ?>
													<?php endforeach ?>

												<?php endif ?>		
											<?php endforeach ?>
										<?php endif ?>
										<?php 
										$total = ($p_scores/$p_total_score)*100;
										$p_scores = 0;
										$p_total_score = 0;
										$cw_percentage[$j_value->subject_id] = $total;
										?>
									<?php endforeach ?>
								<?php endif ?>
							<?php endforeach ?>
						<?php endforeach ?>				
					</ul>
				<?php endif ?>
				<link href="https://fonts.googleapis.com/css?family=Raleway:400,300,600,800,900" rel="stylesheet" type="text/css">
				<?php foreach ($cw_percentage as $key => $value): ?>
					<?php 
					$subject = $this->Crud_model->fetch("subject",array("subject_id"=>$key));
					$subject = $subject[0];
					?>
					<div class="row valign-wrapper">
						<div class="col s6">
							<h5 class="center"><?=$subject->subject_name?></h5>
						</div>
						<div class="col s6">
							<div id="sa_<?=$key?>" style="width: 50%; position: relative;">
								
							</div>

						</div>
					</div>

					<script type="text/javascript">

						jQuery(document).ready(function($) {

							var bar = new ProgressBar.Circle(sa_<?=$key?>, {
								color: '#F2A900',
								strokeWidth: 4,

								trailColor: '#007A33',
								trailWidth: 1,
								easing: 'easeInOut',
								duration: 3000,
								text: {
									autoStyleContainer: false
								},
								from: { color: '#F2A900', width: 1 },
								to: { color: '#F2A900', width: 4 },
								step: function(state, circle) {
									circle.path.setAttribute('stroke', state.color);
									circle.path.setAttribute('stroke-width', state.width);

									var value = Math.round(circle.value() * 100);
									if (value === 0) {
										circle.setText('0');
									} else {
										circle.setText(value+"%");
									}

								}
							});
							bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
							bar.text.style.fontSize = '2rem';

							bar.animate(<?=$value/100?>);  
						});
					</script>

				<?php endforeach ?>
			</div>
		</div>
	</div>
</div>

