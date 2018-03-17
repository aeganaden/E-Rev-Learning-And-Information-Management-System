<?php $this->load->view('includes/home-sidenav'); ?>
<?php $this->load->view('includes/home-navbar'); ?>
<div class="row container">
	<blockquote class="color-primary-green">
		<h5 class="color-black">Import Questions</h5>
	</blockquote>
</div>

<div class="container row">
	<div class="col s1"></div>
	<div class="col s11">

		<?php  $course = $this->Crud_model->fetch("course",array("course_id"=>$this->uri->segment(3)));  ?>
		<?php if ($course): ?>
			<h5>Subject Area</h5>
			<ul class="collapsible" data-collapsible="accordion">
				<?php foreach ($course as $key => $value): ?>
					<?php  $subject_area = $this->Crud_model->fetch("subject",array("course_id"=>$value->course_id)); ?>

					<?php if ($subject_area): ?>
						<?php foreach ($subject_area as $key => $i_value): ?>
							<li>
								<div class="collapsible-header bg-primary-green color-white"><i class="material-icons color-primary-yellow">aspect_ratio</i><?= $i_value->subject_name ?></div>
								<div class="collapsible-body">

									<h5>Topics</h5>
									<ul class="collapsible" data-collapsible="accordion">
										<?php $topics =  $this->Crud_model->fetch("topic",array("subject_id"=>$i_value->subject_id)) ?>

										<?php if ($topics): ?>
											<?php foreach ($topics as $key => $j_value): ?>
												<li>
													<div class="collapsible-header bg-primary-green color-white"><i class="material-icons color-primary-yellow">title</i><?=$j_value->topic_name?></div>
													<div class="collapsible-body">

														<ul class="collection with-header">
															<li class="collection-header bg-color-white"><h5><i class="material-icons">book</i>Practice Exams</h5></li>
															<?php $courseware = $this->Crud_model->fetch("courseware",array("topic_id"=>$j_value->topic_id)) ?>
															<?php if ($courseware): ?>
																<?php foreach ($courseware as $key => $j2_value): ?>
																	<?php $status = $j2_value->courseware_status == 1 ? "visible" : "not visible" ?>
																	<?php $status_sw = $j2_value->courseware_status == 1 ? "checked" : "" ?>
																	<?php $status_c = $j2_value->courseware_status == 1 ? "" : "red" ?>
																	<li class="collection-item bg-color-white">
																		<a href="<?=base_url()?>ImportQuestions/importQuestions/<?=$j2_value->courseware_id?>">
																			<span class="new badge bg-primary-green" style="margin-left: 2%;"  data-badge-caption=""><i class="material-icons">backup</i></span> 
																		</a>
																		<div class="switch">
																			<span class="new badge <?=$status_c?>" id="badge_status<?=$j2_value->courseware_id?>" data-badge-caption="<?=$status?>"></span>
																			<?=$j2_value->courseware_name?>
																		</div>
																	</li>
																<?php endforeach ?>
															<?php else: ?>
																<li class="collection-item bg-color-white">No courseware</li>

															<?php endif ?>
														</ul>

													</div>
												</li>
											<?php endforeach ?>

										<?php else: ?>
											<h5 class="center" style="padding: 2%;">No topics</h5>
										<?php endif ?>

									</ul>

								</div>
							</li>
						<?php endforeach ?>
					<?php endif ?>
				<?php endforeach ?>

			</ul>
		<?php endif ?>


	</div>
</div>
