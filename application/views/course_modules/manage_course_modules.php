<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>

<div class="container row">
	<blockquote class="color-primary-green">
		<h5 class="color-black">Manage Course Modules</h5>
	</blockquote>
	<div class="row">
		<?php   
		$enrollment = $this->Crud_model->fetch("enrollment",array("enrollment_is_active"=>1));
		$enrollment = $enrollment[0];

		$ident = $info['identifier'];
		$ident.="_department"; 
		// fetch course
		$course = $this->Crud_model->fetch("course",
			array("course_department"=>$info['user']->$ident,
				"enrollment_id"=>$enrollment->enrollment_id));
				?> 
				<?php if ($course): ?>
					<?php foreach ($course as $key => $value): ?>
						<!-- fetch subject -->
						<?php $subject = $this->Crud_model->fetch("subject",array("course_id"=>$value->course_id)); ?>
						<?php if ($subject): ?>
							<?php $counter = 0; ?>
							<?php foreach ($subject as $key => $i_value): ?>
								<?php $counter == 2 ? "<div class='row'>" : "" ?>
									<div class="col s12 m6">
										<div class="card bg-primary-green">
											<div class="card-content white-text">
												<span class="card-title "><?=$i_value->subject_name?></span>
												<p><?=$i_value->subject_description?></p>
											</div>
											<div class="card-action">
												<a href="<?=base_url()?>ManageCourseModules/viewCourseModules/<?=$i_value->subject_id?>" class="valign-wrapper"> <i class="material-icons left">visibility</i>View</a>
											</div>
										</div>
									</div>
									<?php $counter == 2 ? "</div>" : "" ?>
									<?php $counter = $counter + 1; ?>
								<?php endforeach ?>

							<?php endif ?>
						<?php endforeach ?>
					<?php endif ?>
				</div>
			</div>
			