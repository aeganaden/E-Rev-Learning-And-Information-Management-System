<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>

<div class="row container">
	<div class="col s12">
		<blockquote class="color-primary-green">
			<h3 class="color-black">Add Topic <br><a href="<?= base_url() ?>TopicManagement" class="waves-effect waves-dark btn bg-color-red"><i class="material-icons left">arrow_back</i>Return</a></h3>
		</blockquote>
	</div>
</div>

<div class="row container">
	<div class="col s2"></div>
	<div class="col s8">
		<div class="input-field col s12 m12">
			<input  id="topicName" type="text" class="validate">
			<label for="topicName">Topic Name</label>
		</div> 
		<div class="input-field col s12 m12"> 
			<div class="input-field col s12">
				<textarea id="topicDescription" class="materialize-textarea"></textarea>
				<label for="topicDescription">Topic Description</label>
			</div>
		</div>
		<dic class="row">
			<button class="btn right bg-primary-green waves-effect waves-light">ADD</button>
		</dic>
	</div>
	<div class="col s2"></div>
</div>