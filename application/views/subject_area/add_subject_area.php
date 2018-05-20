<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>

<!--====  End of Navigation Top  ====<--></-->
<?php $this->load->view('includes/home-sidenav'); ?>
<!--ABOVE IS PERMA-->

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
				<input name="subject_area" type="text" value="<?= set_value('subject_area'); ?>" required>
				<label class="color-black" for="input_fields">Subject Area</label>
			</div>
			<div class="input-field col s12">
				<textarea name="subject_description" class="materialize-textarea" required><?= set_value('subject_description'); ?></textarea>
				<label class="color-black" for="textarea1">Subject Area Description</label>
			</div>
			<div class="input-field col s12">
				<select name="year_level">
					<option value="" disabled selected>Year Level</option>
					<?php foreach($option_select as $each):?>
						<option value="<?=$each->year_level_id?>" <?=set_select('year_level', $each->year_level_id); ?>><?=$each->year_level_name?></option>
					<?php endforeach;?>
				</select>
				<label class="color-black">Assign to:</label>
			</div>
			<div class=" col s12" style="margin-top: 20px;">
				<h5 class="center">Select Topics</h5>
				<table class="data-table" id="table-topics-add">
					<thead>
						<tr>
							<th>Topic</th>
							<th>Description</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody> 
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