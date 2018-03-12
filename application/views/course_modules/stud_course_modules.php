

<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>

<div class="container row">
	<blockquote class="color-primary-green">
		<h5 class="color-black">Manage Course Modules</h5>
	</blockquote>
	<div class="row"> 
		<div class="row">
			<div class="col s12">
				<?php 
				$subject = $this->Crud_model->fetch("subject",array("subject_id"=>$this->uri->segment(3)));
				$subject = $subject[0];
				?>
				<?php if ($subject): ?>
					<h5 class="color-black"><?= $subject->subject_name ?></h5>
				<?php endif ?>
				<?php if ($this->session->flashdata('error') ): ?>
					<blockquote class="color-red">
						<?php foreach ($this->session->flashdata('error') as $key => $e_value): ?>
							<h6 ><?=$e_value?></h6>
						<?php endforeach ?>
					</blockquote>
				<?php endif ?>
				<?php if ($this->session->flashdata('error_s') ): ?>
					<blockquote class="color-red"> 
						<h6 ><?=$this->session->flashdata('error_s')?></h6> 
					</blockquote>

				<?php endif ?>
			</div> 		
		</div>
		<?php if ($topic): ?>
			<ul class="collapsible" data-collapsible="accordion">
				<?php foreach ($topic as $j_key => $j_value): ?>  
					<li>
						<div  style="border-bottom:none !important; text-transform: capitalize;" class="collapsible-header bg-primary-green color-white">

							<i class="material-icons color-primary-yellow">title</i><?=$j_value->topic_name?>
							<?php 
							$courseware_count = $this->Crud_model->countResult("course_modules",array(
								"topic_id"=>$j_value->topic_id,
								"course_modules_status"=>1
							)); 
							?>
							<?php if ($courseware_count == 0): ?>
								<span class="new badge bg-primary-yellow" data-badge-caption="empty"></span>
							<?php else: ?>
								<span class="new badge" data-badge-caption="<?=$courseware_count?> Courseware"></span>
							<?php endif ?>

						</div>
						<div class="collapsible-body">
							<?php $course_modules = $this->Crud_model->fetch("course_modules",
								array(
									"topic_id"=>$j_value->topic_id,
									"course_modules_status"=>1
									)) ?>
									<ul class="collection">
										<?php if ($course_modules): ?> 
											<blockquote class="color-primary-green">
												<h6 class="color-black"><?=$j_value->topic_name?> Course Modules</h6>
											</blockquote>
											<?php foreach ($course_modules as $k_key => $k_value): ?>
												<li class="collection-item bg-color-white" style="text-transform: capitalize;">
													<?=$k_value->course_modules_name?> 

													<a target="_blank" href="<?=base_url()?>assets/pdfjs/web/viewer.html?file=
														<?=base_url()?>assets/modules/<?=$k_value->course_modules_path?>">
														<span class="new badge "
														data-badge-caption="view" 
														style="margin-right: 1%; cursor: pointer;"></span>
													</a>



												</li> 
											<?php endforeach ?>
										<?php else: ?>
											<li class="collection-item bg-color-white center">No Course Modules Yet</li> 
										<?php endif ?>
									</ul>
								</div>
							</li> 
						<?php endforeach ?>
					</ul>
				<?php else: ?>
					<div class="row valign-wrapper">
						<div class="col s4 ">
							<h3 class="center" style="text-transform: uppercase; text-align: justify-all;">No </h3>
						</div>
						<div class="col s4">
							<img src="<?=base_url()?>assets/chibi/Chibi_crying.svg " alt="">
						</div>	
						<div class="col s4">
							<h3 class="center" style="text-transform: uppercase; text-align: justify-all;">Data</h3>
						</div>
					</div>
				<?php endif ?>



			</div>
		</div> 