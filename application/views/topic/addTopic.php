<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>

<div class="row container">
	<div class="col s12">
		<blockquote class="color-primary-green">
			<h3 class="color-black">Add Topic <br></h3>
		</blockquote>
	</div>
</div>

<div class="row container">
	<div class="col s1"></div>
	<div class="col s10">
		<form action="" method="POST">
			<div class="input-field col m12">
				<input id="topicName" type="text" name="topic_name">
				<label class="color-black" for="topicName">Topic Name</label>
			</div> 
			<div class="input-field col m12"> 
				<textarea id="topicDescription" class="materialize-textarea" name="topic_desc"></textarea>
				<label class="color-black" for="topicDescription">Topic Description</label>
			</div>
			<dic class="row">
				<a href="<?= base_url() ?>Topic" class="waves-effect waves-light btn left red">Cancel</a>
				<button type="submit" name="submit" class="btn right bg-primary-green waves-effect waves-light">ADD</button>
			</dic>
		</form>
	</div>
	<div class="col s1"></div>
</div>