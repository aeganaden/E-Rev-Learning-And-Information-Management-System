<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>

<div class="row container">
	<div class="col s12">
		<blockquote class="color-primary-green">
			<h3 class="color-black">Edit Topic <br></h3>
		</blockquote>
	</div>
</div>

<div class="row container">
	<div class="col s2"></div>
	<div class="col s8">
		<div class="input-field col s12 m12">
			<input  id="topicName" placeholder="topic_name_here" type="text" class="validate">
			<label for="topicName">Topic Name</label>
		</div> 
		<div class="input-field col m12">
			<textarea id="topicDescription" placeholder="topic_description_here" class="materialize-textarea"></textarea>
			<label for="topicDescription">Topic Description</label>
		</div>
		<dic class="row">
			<a href="<?= base_url() ?>Topic" class="waves-effect waves-light btn left red">Cancel</a>
			<button class="btn right bg-primary-green waves-effect waves-light">EDIT</button>
		</dic>
	</div>
	<div class="col s2"></div>
</div>