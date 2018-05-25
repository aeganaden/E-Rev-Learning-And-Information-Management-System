<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>

<div class="row container">
	<div class="col s12">
		<blockquote class="color-primary-green">
			<h3 class="color-black">Edit Topic <br></h3>
		</blockquote>
		<?php if((isset($error_message) && !empty($error_message)) || !empty(form_error('topic_name')) || !empty(form_error('topic_desc'))) :?>
			<blockquote class="color-red">
				<h6><b>ERROR:</b></h6>
				<?php foreach ($error_message as $err): ?>
					<h6><?= $err; ?></h6>
				<?php endforeach; ?>
				<?php echo form_error('topic_name'); ?>
				<?php echo form_error('topic_desc'); ?>
			</blockquote>
		<?php endif;?>
	</div>
</div>

<div class="row container">
	<div class="col s2"></div>
	<div class="col s8">
		<form action="<?php echo base_url() . "Topic/submit_editTopic/". $topic_id; ?>" method="POST">
			<div class="input-field col m12">
				<?php if(!empty(set_value("topic_name"))) :?>
					<input type="text" name="topic_name" value='<?=set_value("topic_name")?>' autofocus required>
				<?php else:?>
					<input type="text" name="topic_name" value='<?=$topic_name?>' autofocus required>
				<?php endif;?>
				<label for="topicName">Topic Name</label>
			</div> 
			<div class="input-field col m12">
				<?php if(!empty(set_value("topic_desc"))) :?>
					<textarea class="materialize-textarea" name="topic_desc" required><?=set_value("topic_desc")?></textarea>
				<?php else:?>
					<textarea class="materialize-textarea" name="topic_desc" required><?=$topic_desc?></textarea>
				<?php endif;?>
				<label for="topicDescription">Topic Description</label>
			</div>
			<dic class="row">
				<a href="<?= base_url() ?>Topic" class="waves-effect waves-light btn left red">Cancel</a>
				<button class="btn right bg-primary-green waves-effect waves-light">Update</button>
			</dic>
		</form>
	</div>
	<div class="col s2"></div>
</div>