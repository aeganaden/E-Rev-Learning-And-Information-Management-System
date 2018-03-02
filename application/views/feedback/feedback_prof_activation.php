<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>

<!--====  End of Navigation Top  ====<--></-->
<?php
$this->load->view('includes/home-sidenav');
?>
<!--ABOVE IS PERMA-->

<div class="row " >
	<div class="col s1"></div>
	<div class="col s11">
		<blockquote class="color-primary-green">
			<h3 class="color-black">Toggle Feedback</h3>
		</blockquote>
	</div>
</div>
<div class="container" style="height:80vh;">
	<div class="row" style="margin-top: 50px" id="div_verify">
		<div class="col s2"></div>
		<div class="col s8">

			<div class="col s12">
				<div class="card-panel col s12 bg-primary-green" style="padding-bottom: 4%;">
					<h3 class="white-text">Feedback</h3>
					<hr>
					<div class="valign-wrapper">
						<div class="col s9" style="">
							<span class="white-text a-roboto-cond">
								Activation of module, if activated, will give the students the privilage to submit feedback to their respective lecturers. 
							</span>
							<br>
							<span class="color-primary-yellow">
								*Please verify your credential before toggling the Feedback Module status.
							</span>
						</div>
						<div class="col s3">
							<button class="btn waves-effect waves-light bg-primary-yellow right modal-trigger"  data-target="modal1">verify</button>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="col s2"></div>

	</div>

	<div class="row" style="margin-top: 50px; display: none;" id="div_activation">
		<div class="col s2"></div>
		<div class="col s8">

			<div class="col s12">
				<div class="card-panel col s12 bg-primary-green" style="padding-bottom: 4%;">
					<h3 class="white-text">Feedback</h3>
					<hr>
					<div class="valign-wrapper">
						<div class="col s2"></div>
						<div class="col s8 center">
							<h4 class="color-white">FEEDBACK MODULE</h4>
							<span class="color-primary-yellow">Note: The feedback module to be activated will only be on your respective department.</span>
							<div class="switch " style="padding-top: 5%;">
								<label class="color-white">
									Deactivate
									<input type="checkbox" class="chk_feedback_status" data-id="<?=$info['user']->professor_id?>">
									<span class="lever" ></span>
									Activate
								</label>
							</div>
						</div>
						<div class="col s2"></div>
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
		<a href="#!" id="btn_feedback_verify" class="modal-action modal-close waves-effect waves-light btn bg-primary-green" data-id="<?=$info['user']->professor_id?>">submit</a>
	</div>
</div>

<script>
	$(document).ready(function() {
		$("#btn_feedback_verify").click(function(event) {
			$username = $("#feed_username").val();
			$password = $("#feed_password").val();
			$prof_id = $(this).data("id");
			$.ajax({
				url: '<?=base_url()?>Feedback/credentialChecking ',
				type: 'post',
				dataType: 'json',
				data: {
					username: $username,
					password: $password,
				},
				success:function(data){
					// console.log($prof_id);	
					$("#feed_username").val("");
					$("#feed_password").val("");

					$.ajax({
						url: '<?=base_url()?>Feedback/check_status_feedback ',
						type: 'post',
						dataType: 'json',
						data: {
							prof_id: $prof_id
						},
						success: function(data){
							if (data == 1) {
								console.log(data);	
								$(".chk_feedback_status").prop('checked', true);
							}else{
								$(".chk_feedback_status").prop('checked', false);
							}

							$('#div_verify').animateCss('zoomOut', function() {
								$("#div_verify").css('display', 'none');
								$('#div_activation').addClass('animated zoomIn');
								$("#div_activation").css('display', 'block');
							});
						}
					});
					



					
				}
			});
			

		});


		$(".chk_feedback_status").change(function (event) {
			var value = $(this).prop("checked") ? 1 : 0;
			var prof_id = $(this).data("id");
			var value_status = value == 1 ? "Activated" : "Deactivated";
			$.ajax({
				url: '<?=base_url()?>Feedback/update_status_feedback ',
				type: 'post',
				dataType: 'json',
				data: {
					prof_id: prof_id,
					value: value
				},
				success: function(data){
					if (data == true) {
						var $toastContent = $('<span>Feedback Module has been '+value_status+'</span>');
						Materialize.toast($toastContent, 2000);
					}else{
						var $toastContent = $('<span> '+data+'</span>');
						Materialize.toast($toastContent, 2000);
					}
				}
			});
			
		});



		/*==========================================
		=            jQuery Animate Css            =
		==========================================*/

		$.fn.extend({
			animateCss: function(animationName, callback) {
				var animationEnd = (function(el) {
					var animations = {
						animation: 'animationend',
						OAnimation: 'oAnimationEnd',
						MozAnimation: 'mozAnimationEnd',
						WebkitAnimation: 'webkitAnimationEnd',
					};

					for (var t in animations) {
						if (el.style[t] !== undefined) {
							return animations[t];
						}
					}
				})(document.createElement('div'));

				this.addClass('animated ' + animationName).one(animationEnd, function() {
					$(this).removeClass('animated ' + animationName);

					if (typeof callback === 'function') callback();
				});

				return this;
			},
		});

		/*=====  End of jQuery Animate Css  ======*/

	});
</script>