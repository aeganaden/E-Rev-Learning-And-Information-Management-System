<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>

<div class="row container">
	<div class="col s12">
		<blockquote class="color-primary-green">
			<h3 class="color-black">Add Topic <br></h3>
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
	<div class="col s1"></div>
	<div class="col s10">
		<form action="<?php echo base_url() . "Topic/submit_addTopic/" ?>" method="POST">
			<div class="input-field col m12">
				<input id="topicName" type="text" name="topic_name" value="<?=set_value('topic_name');?>" autofocus required>
				<label for="topicName">Topic Name</label>
			</div> 
			<div class="input-field col m12"> 
				<textarea id="topicDescription" class="materialize-textarea" name="topic_desc" required><?=set_value('topic_desc');?></textarea>
				<label for="topicDescription">Topic Description</label>
			</div>
			<dic class="row">
				<a href="<?= base_url() ?>Topic" class="waves-effect waves-light btn left red">Cancel</a>
				<button type="submit" name="submit" class="btn right bg-primary-green waves-effect waves-light">ADD</button>
			</dic>
		</form>
	</div>
	<div class="col s1"></div>
</div>