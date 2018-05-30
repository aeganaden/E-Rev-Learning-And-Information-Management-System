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
			<h3 class="color-black">Edit Subject Area <br></h3>
		</blockquote>
		<?php if((isset($error_message) && !empty($error_message))) :?>
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
	<h5 class="center"><?=$subj[0]->year_level_name ."<br>". $subj[0]->subject_list_name?></h5>
	<div class="col s1"></div>
	<div class="col s10">
		<form method="post" action="<?php echo base_url() . "SubjectArea/edit_submit/" . $subj[0]->year_level_id ."/" .$subj[0]->subject_list_id?>" style="margin-top: 20px;">
			<div class="row valign-wrapper">
				<div class="input-field col s11">
					<input name="subject_area" type="text" value="<?= $subj[0]->subject_list_name ?>" required>
					<label for="input_fields">Subject Area</label>
				</div>
				<div class="col s1">
					<a class="waves-effect waves-light red btn-floating tooltipped btn_reset_name" data-position="top" data-delay="0" data-tooltip="Reset"><i class="material-icons left">clear</i></a>
				</div>
			</div>
			<div class="row valign-wrapper">
				<div class="input-field col s11">
					<textarea name="subject_description" class="materialize-textarea" required><?= $subj[0]->subject_list_description?></textarea>
					<label for="textarea1">Subject Area Description</label>
				</div>
				<div class="col s1">
					<a class="waves-effect waves-light red btn-floating tooltipped btn_reset_desc" data-position="top" data-delay="0" data-tooltip="Reset"><i class="material-icons left">clear</i></a>
				</div>
			</div>
			<div class="input-field">
				<button class="btn waves-effect waves-light right green" type="submit" name="submit">Update</button>
				<a href="<?= base_url() ?>SubjectArea" class="waves-effect waves-light btn left red">Cancel</a>
			</div>
		</form>
	</div>
</div>
<script>
	$(document).ready(function(){
		$(".btn_reset_name").click(function () {
			$default = "<?=$subj[0]->subject_list_name?>";
			$('input[name=subject_area]').val($default);
		});
		$(".btn_reset_desc").click(function () {
			$default = "<?=$subj[0]->subject_list_description?>";
			$('textarea[name=subject_description]').val($default);
		});
	});
</script>