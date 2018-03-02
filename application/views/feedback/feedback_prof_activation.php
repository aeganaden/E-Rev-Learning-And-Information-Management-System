<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>

<!--====  End of Navigation Top  ====<--></-->
<?php
$this->load->view('includes/home-sidenav');
?>
<!--ABOVE IS PERMA-->

<div class="row ">
	<div class="col s1"></div>
	<div class="col s11">
		<blockquote class="color-primary-green">
			<h3 class="color-black">Toggle Feedback</h3>
		</blockquote>
	</div>
</div>
<div class="container" style="height:80vh;">
	<div class="row" style="margin-top: 50px">
		<div class="col s2"></div>
		<div class="col s8">

			<div class="col">
				<div class="card-panel col s12 bg-primary-green" style="padding-bottom: 4%;">
					<h3 class="white-text">Feedback</h3>
					<hr>
					<div class="valign-wrapper">
						<div class="col s9" style="">
							<span class="white-text">
								Activation of module, if activated, will give the students the privilage to submit feedback to their respective lecturers. 
							</span>
							<br>
							<span class="color-primary-yellow">
								Please verify your credential before toggling the Feedback Module status.
							</span>
						</div>
						<div class="col s3">
							<button class="btn waves-effect waves-light bg-primary-yellow right modal-trigger" data-target="modal1">verify</button>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="col s2"></div>

	</div>

</div>

<!-- Modal Structure -->
<div id="modal1" class="modal bg-color-white">
	<div class="modal-content center">
		<h4 class="color-primary-green">VERIFICATION</h4>
		<div class="row">
			<div class="col s2"></div>
			<div class="col s8">
				<div class="input-field valign-wrapper">
					<i class="material-icons prefix">account_circle</i>
					<input id="feed_username" type="text" class="validate">
					<label for="first_name">USERNAME</label>
				</div>
				<div class="input-field valign-wrapper">
					<i class="material-icons prefix">lock_open</i>
					<input id="feed_password" type="password" class="validate">
					<label for="password">PASSWORD</label>
				</div>
			</div>
			<div class="col s2"></div>
		</div>
	</div>
	<div class="modal-footer bg-color-white">
		<a href="#!" id="btn_feedback_verify" class="modal-action modal-close waves-effect waves-light btn bg-primary-green">submit</a>
	</div>
</div>

<script>
	$(document).ready(function() {
		$("#btn_feedback_verify").click(function(event) {
			$username = $("#feed_username").val();
			$password = $("#feed_password").val();

			$.ajax({
				url: '<?=base_url()?>Feedback/credentialChecking ',
				type: 'post',
				dataType: 'json',
				data: {
					username: $username,
					password: $password,
				},
				success:function(data){
					console.log(data);	
					$("#feed_username").val("");
					$("#feed_password").val("");
				}
			});
			

		});
	});
</script>