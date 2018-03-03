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
			<li class="collection-item" style="padding: 5%; margin-bottom: 1%;">
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
									<input type="file">
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
			<li class="collection-item white" style="padding: 5%; margin-bottom: 1%;">
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
						<div class="input-field col s2">
							<input placeholder="" id="first_name" type="text" class="validate">
							<label for="first_name">Total Score</label>
						</div>
						<div class="input-field col s2">
							<input placeholder="" id="first_name" type="text" class="validate">
							<label for="first_name">Passing Score</label>
						</div>
						<div class="input-field col s2"></div>

						<div class="input-field col s6">
							<div class="col s10">
								<select>
									<option value="" disabled selected>Choose Type</option>
									<?php 
									$data_scores = $this->Crud_model->fetch("data_scores");
									?>
									<?php if ($data_scores): ?>
										<?php foreach ($data_scores as $key => $value): ?>
											<option value="<?=$value->data_scores_type?>"></option>
										<?php endforeach ?>
									<?php else: ?>
										<option disabled="" value="">No Score Source Yet</option>
									<?php endif ?>
								</select>
							</div>
							<div class="input-field col s2">
								<i class="material-icons right color-primary-green tooltipped" data-position="right" data-tooltip="Add Score Source" style="cursor: pointer;">add_circle</i>
							</div>
						</div>

					</div>
					<div class="col s2"></div>
				</div> 
			</li>
			<li class="collection-item white" style="padding: 5%; margin-bottom: 1%;">
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