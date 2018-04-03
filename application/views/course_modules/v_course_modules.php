<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>

<div class="container row">
	<blockquote class="color-primary-green">
		<h5 class="color-black">Course Modules</h5>
	</blockquote>
	<div class="row">
		<!-- fetch subject -->
		<?php 

		$offering = $this->Crud_model->fetch("offering",array("offering_id"=>$info['user']->offering_id));
		$offering = $offering[0];

		?>
		<?php if ($this->uri->segment(3) == $offering->course_id): ?>
			<?php $subject = $this->Crud_model->fetch("subject",array("course_id"=>$this->uri->segment(3))); ?>
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
									<a href="<?=base_url()?>CourseModules/viewCourseModules/<?=$i_value->subject_id?>" class="valign-wrapper"> <i class="material-icons left">visibility</i>View</a>
								</div>
							</div>
						</div>
						<?php $counter == 2 ? "</div>" : "" ?>
						<?php $counter = $counter + 1; ?>
					<?php endforeach ?>

				<?php endif ?>
			<?php else: ?>
				<div class="row valign-wrapper">
					<div class="col s12 col m4 ">
						<h5 class="center" style="text-transform: uppercase; text-align: justify-all;">Uh oh,</h5>
					</div>
					<div class="col s12 col m4">
						<img src="<?=base_url()?>assets/chibi/Chibi_crying.svg " alt="">
					</div>	
					<div class="col s12 col m4">
						<h5 class="center" style="text-transform: uppercase; text-align: justify-all;">You are not enrolled in this class</h5>
					</div>
				</div>
			<?php endif ?>
		</div>
	</div>
