<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>


<div class="container row">
	<div class="col s1"></div>
	<div class="col s11">
		<blockquote class="color-primary-green">
			<h5 class="color-black">Import Student Scores</h5>
		</blockquote>
		<!-- <?php echo $course_id; ?> -->

		<ul class="collection"  style="margin-bottom: 5%;">
			<li class="collection-item" id="li_s1" style="padding: 5%; margin-bottom: 1%;">
				<div class="row  ">
					<h5 class="valign-wrapper">Step
						<i class="material-icons" style="padding-left: 1%;">filter_1</i>
					</h5> 
					<blockquote class="color-primary-green">
						<h6 class="color-black">
							Upload Student Info Using Excel with column of 
							<i class="color-primary-green">STUDENT_NUMBER</i> and <i class="color-primary-green">SCORE</i> 
						</h6>
					</blockquote>
				</div>
				<div class="row">
					<div class="col s2"></div>
					<div class="col s8">
						<form action="#">
							<div class="file-field input-field">
								<div class="btn">
									<span>File</span>
									<input type="file" id="input_excel">
								</div>
								<div class="file-path-wrapper">
									<input class="file-path validate" type="text">
								</div>
							</div>
						</form>
					</div>
					<div class="col s2"></div>
				</div>
			</li>
			<li class="collection-item white" id="li_s2" style="padding: 5%; margin-bottom: 1%; display: none;">
				<div class="row">
					<h5 class="valign-wrapper">Step
						<i class="material-icons" style="padding-left: 1%;">filter_2</i>
					</h5> 
					<blockquote class="color-primary-green">
						<h6 class="color-black">
							Specify the Total Score, Passing Score and Type of Score Source 
						</h6>
					</blockquote>

					<div class="col s1"></div>
					<div class="col s9">
						<div class="row">
							<div class="input-field col s2">
								<input placeholder="" id="input_ts" type="number" min="1" class="validate" required>
								<label for="input_ts">Total Score</label>
							</div>
							<div class="input-field col s2">
								<input placeholder="" id="input_ps" type="number" min="1" class="validate" required>
								<label for="input_ps">Passing Score</label>
							</div>
							<div class="input-field col s2"></div>

							<div class="input-field col s6">
								<div class="col s10">
									<select id="select_ss" required>
										<option value="" disabled selected>Choose Type</option>
										<option value="1">Long Quiz</option>
										<option value="2">Short Quiz</option>
										<option value="3">Seatwork</option>
										<option value="3">Exam</option>
									</select>
								</div>
							</div>
						</div>

						<div class="row" id="add_ss_div"> 
							<button class="right btn waves-light waves-effect bg-primary-green" id="btn_submit_ss">SUBMIT</button>
						</div>

					</div>
					<div class="col s2"></div>
				</div> 
			</li>
			<li class="collection-item white" id="li_s3" style="padding: 5%; margin-bottom: 1%;  display: none;">
				<div class="row  ">
					<h5 class="valign-wrapper">Step
						<i class="material-icons" style="padding-left: 1%;">filter_3</i>

					</h5> 
					<blockquote class="color-primary-green">
						<h6 class="color-black">
							Submit
						</h6>
					</blockquote>
					<div class="col s4"></div>
					<div class="col s4">
						<button class="btn bg-primary-green center waves-effect waves-light">IMPORT SCORES</button>
					</div>
					<div class="col s4"></div>
				</div> 
			</li>
		</ul>

	</div>
</div>


<script type="text/javascript">
	jQuery(document).ready(function($) {
		var o_ex = false;
		window.onbeforeunload = function() { 
			if (o_ex==true) {
				return 'Leave the exam? This exam will not be recorded if you leave.';
			}
		}


		$("#btn_add_ss").click(function(event) {
			if ($("#add_ss_div").css('display') == "none") {
				$(this).html("remove");
				$("#add_ss_div").fadeIn('slow', function() {
					$("#add_ss_div").css('display', 'block');
				});
			}else{
				$(this).html("add_circle");
				$("#add_ss_div").fadeOut('slow', function() {
					$("#add_ss_div").css('display', 'none');
				});
			}
		});

		// onchange file input

		$("#input_excel").change(function(event) {
			/* Act on the event */
			if ($("#input_excel").val() != "") { 
				// console.log(true);	
				o_ex = true;
				$('#li_s2').fadeIn('fast', function() {
					$("#li_s2").css('display', 'block');
				});
			}else{
				$('#li_s2').fadeOut('fast', function() {
					$("#li_s2").css('display', 'none');
				});
				$('#li_s3').fadeOut('fast', function() {
					$("#li_s3").css('display', 'none');
				});
			}
		});


		$("#btn_submit_ss").click(function(event) { 
			$total_s = $("#input_ts").val();
			$passing_s = $("#input_ps").val();
			$select =$("#select_ss").val();

			$.ajax({
				url: '<?=base_url()?>Student_scores/insertScore ',
				type: 'post',
				dataType: 'json',
				data: {
					total_s : $total_s,
					passing_s : $passing_s,
					select : $select,
				},
				success:function(data){
					if (data == true) { 
						var $toastContent = $('<span>Added Successfully </span>');
						Materialize.toast($toastContent, 2000);

						$('#li_s3').fadeIn('fast', function() {
							$("#li_s3").css('display', 'block');
						});
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