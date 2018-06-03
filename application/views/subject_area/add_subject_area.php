<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>

<!--====  End of Navigation Top  ====<--></-->
<?php $this->load->view('includes/home-sidenav'); ?>
<!--ABOVE IS PERMA-->

<?php 


if ($this->session->userdata('title') || $this->session->userdata('desc')) {
	$title_place = $this->session->userdata('title');
	$desc_place = $this->session->userdata('desc');
}elseif(set_value('subject_area') || set_value('subject_description')){
	$title_place = set_value('subject_area');
	$$desc_place = set_value('subject_description');
}
else{
	$title_place = "";
	$desc_place =  "";
}
?>

<div class="row container">
	<div class="col s12">
		<blockquote class="color-primary-green">
			<h3 class="color-black">Add Subject Area <br></h3>
		</blockquote>
		
		<?php if((isset($error) && $error == true) || (isset($error_message) && !empty($error_message))) :?>
		<blockquote class="color-red">
			<h6><b>ERROR:</b></h6>
			<?php foreach ($error_message as $err): ?>
				<h6><?= $err; ?></h6>
			<?php endforeach; ?>
			<?php echo validation_errors(); ?>
		</blockquote>
	<?php endif;?>
</div>
</div>
<div class="row container">
	<div class="col s1"></div>
	<div class="col s10">
		<form method="post" action="<?php echo base_url() . "SubjectArea/add_submit/" ?>" style="margin-top: 20px;">
			<div class="input-field col s12">
				<input name="subject_area" type="text" value="<?= $title_place ?>" required>
				<label class="color-black" for="input_fields">Subject Area</label>
			</div>
			<div class="input-field col s12">
				<textarea name="subject_description" class="materialize-textarea" required><?= $desc_place ?></textarea>
				<label class="color-black" for="textarea1">Subject Area Description</label>
			</div>
			<div class="input-field col s12">
				<select name="year_level">
					<option value="" disabled selected>Year Level</option>
					<?php foreach($option_select as $key => $each):?>
						<?php $key++; ?>
						<!-- <script>console.log(<?php echo $key ?>)</script> -->
						<?php if ($key == $this->uri->segment(3)): ?>
							<option selected value="<?=$each->year_level_id?>" <?=set_select('year_level', $each->year_level_id); ?>><?=$each->year_level_name?></option>
							<?php else: ?>
								<option value="<?=$each->year_level_id?>" <?=set_select('year_level', $each->year_level_id); ?>><?=$each->year_level_name?></option>
							<?php endif ?>

						<?php endforeach;?>
					</select>
					<label class="color-black">Assign to:</label>
				</div>
				<div class=" col s12" style="margin-top: 20px;">
					<h5 class="center">Select Topics</h5>
					<table class="data-table">
						<thead>
							<tr>
								<th>Topic</th>
								<th>Description</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>   
							<?php if ($this->uri->segment(3)): ?>
								<?php if ($topics): ?>
									<?php foreach ($topics as $key => $top): ?>
										<tr class="bg-color-white">
											<td><?= $top['topic_list_name'] ?></td>
											<td><?= $top['topic_list_description'] ?></td>
											<td>
												<p>
													<input type="checkbox" id="chk<?=$key?>" value="<?=$key?>" name="topic_list[]" 
													<?=set_checkbox('topic_list', $key); ?>> <!--set_checkbox para selected ulit yung naselect ng user-->
													<label for="chk<?=$key?>"> </label>
												</p>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php endif ?>
								<?php else: ?>
									<?php if ($topics): ?>
										<?php foreach ($topics as $key => $top): ?>
											<tr class="bg-color-white">
												<td><?= $top->topic_list_name ?></td>
												<td><?= $top->topic_list_description ?></td>
												<td>
													<p>
														<input type="checkbox" id="chk<?=$key?>" value="<?=$key?>" name="topic_list[]" 
														<?=set_checkbox('topic_list', $key); ?>> <!--set_checkbox para selected ulit yung naselect ng user-->
														<label for="chk<?=$key?>"> </label>
													</p>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php endif ?>
								<?php endif ?>
							</tbody>
						</table> 
					</div>
					<div class="input-field">
						<button class="btn waves-effect waves-light right green" type="submit" name="submit">Submit</button>
						<a href="<?= base_url() ?>SubjectArea" class="waves-effect waves-light btn left red">Cancel</a>
					</div>
				</form>
			</div>
			<div class="col s1"></div>
		</div>


		<script>
			jQuery(document).ready(function($) { 
				$('select[name=year_level]').on('change', function() {
					$title = $("input[name=subject_area]").val();
					$desc = $("textarea[name=subject_description]").val(); 
					$id = this.value;
					window.location = "<?=base_url()?>SubjectArea/add_subject_area/"+$id;
					$.ajax({
						url: '<?=base_url()?>SubjectArea/form_data',
						type: 'post',
						data: {
							title: $title,
							desc: $desc,
						}, 
					});

				});
			});
		</script>