

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
							<i class="material-icons color-citrus modal-trigger btn_upload" data-subj="<?=$subject->subject_id?>" data-id="<?=$j_value->topic_id?>" href="#modal_coursemodule" style="cursor: pointer;">file_upload</i> 
							<i class="material-icons color-primary-yellow">title</i><?=$j_value->topic_name?>
							<?php 
							$courseware_count = $this->Crud_model->countResult("course_modules",array(
								"topic_id"=>$j_value->topic_id,
								"course_modules_status"=>1
							)); 
							?>
							<?php if ($courseware_count == 0): ?>
								<span class="new badge red" data-badge-caption="empty"></span>
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
													

													<span class="new badge bg-primary-green btn_edit_name modal-trigger"
													href="#mdl_edit_cname"
													data-badge-caption="Edit" 
													data-name = "<?=$k_value->course_modules_name?>"
													data-cmid="<?=$k_value->course_modules_id?>"
													data-subj="<?=$subject->subject_id?>"
													style="margin-right: 1%; cursor: pointer;"></span>

													<span class="new badge bg-color-red btn_delete_cm"
													data-badge-caption="Delete"
													data-id="<?=$k_value->course_modules_id?>"
													style="margin-right: 1%; cursor: pointer;"></span>

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

		<div id="modal_coursemodule" class="modal bg-color-white">
			<form id="cm_upload" action="" method="post" enctype="multipart/form-data">
				<div class="modal-content"> 
					<blockquote class="color-primary-green" >
						<h5 class="color-black">Upload Course Modules</h5>
					</blockquote>
					<br><br>
					<div class="input-field" >
						<input placeholder="Placeholder" name="cm_name" id="cm_name" type="text" class="validate" required="">
						<label for="cm_name">Course Module Title</label>
					</div>
					<div class="file-field input-field">
						<div class="btn">
							<span>File</span>
							<input id="cm_file" type="file" required name="cm_file">
						</div>
						<div class="file-path-wrapper">
							<input class="file-path" type="text" disabled>
						</div>
					</div>
				</div>
				<div class="modal-footer bg-color-white">

					<button type="submit" id="submit" name="submit" class=" waves-effect waves-green btn bg-primary-green valign-wrapper">upload</button>
				</div>
			</form>
		</div>

		<div id="mdl_edit_cname" class="modal bg-color-white">
			<div class="modal-content">
				<h4>Edit Course Module Title</h4>
				<div class="row valign-wrapper">
					<div class="col s8">
						<div class="input-field">
							<input placeholder="" id="mdl_cname" type="text" class="validate">
							<label for="mdl_cname">Course Module Name</label>
						</div>
					</div>
					<div class="col s4">
						<a href="#!" id="mdl_btn_edit_cname" disabled class="waves-effect waves-green btn bg-primary-green right">Update</a>
					</div>

				</div>
			</div> 
		</div>

		<script type="text/javascript">
			jQuery(document).ready(function($) {

				var initial_data = "";
				$(".btn_upload").click(function(event) {
					$("#cm_upload").attr("action",'<?=base_url()?>ManageCourseModules/uploadCourseModule/'+$(this).data("subj")+"/"+$(this).data("id"));
				});
				$(".btn_edit_name").click(function(event) {
					$("#mdl_cname").val($(this).data("name"));
					initial_data = $(this).data("name");
					$cm_id = $(this).data("cmid");
					$subj_id = $(this).data("subj");
					$("#mdl_btn_edit_cname").attr({
						"data-subj": $subj_id,
						"data-cmid": $cm_id
					});
				});
				$('#mdl_cname').keyup(function(){
					if($(this).val().length !=0)
						$('#mdl_btn_edit_cname').attr('disabled', false);            
					else
						$('#mdl_btn_edit_cname').attr('disabled',true);
				}) 

				$("#mdl_btn_edit_cname").click(function(event) {
					$title = $("#mdl_cname").val();
					$cm_id = $(this).data("cmid");
					$subj_id = $(this).data("subj");
					$.ajax({
						url: '<?=base_url()?>ManageCourseModules/editCourseModuleName',
						type: 'post',
						dataType: 'json',
						data: {
							cm_id: $cm_id,
							title: $title,
						},
						success: function(data){
							if (data == true) {
								swal("Poof! Coursware name has been edited!", {
									icon: "success",
								}).then(function () {
									location.reload();
								});
							}
						}
					});

				});

				$(".btn_delete_cm").click(function(event) {
					$cm_id = $(this).data("id");
					swal({
						title: "Delete Course Module?",
						text: "This will never be recovered by you!",
						icon: "error",
						buttons: {
							cancel: true,
							confirm: "Delete",
						},
					})
					.then((deleteCM) => { 
						if (deleteCM) {
							$.ajax({
								url: '<?=base_url()?>ManageCourseModules/deleteCourseModule',
								type: 'post',
								dataType: 'json',
								data: {
									cm_id: $cm_id
								},
								success:function(data){
									if (data == true) {
										$toast = '<span>Deleted!</span>'
										Materialize.toast($toast,1500,'',function(){
											location.reload();
										});
									}
								}
							});

						}
					});
				});



			});
		</script>