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
			<h3 class="color-black">Add Subject Area <br></h3>
		</blockquote>
	</div>
</div>
<div class="row container">
	<div class="col s2"></div>
	<div class="col s8">
		<form method="post" style="margin-top: 20px;">
			<div class="input-field col s12">
				<input name="subject_area" type="text">
				<label class="color-black" for="input_fields">Subject Area</label>
			</div>
			<div class="input-field col s12">
				<textarea name="subject_description" class="materialize-textarea"></textarea>
				<label class="color-black" for="textarea1">Subject Area Description</label>
			</div>
			<div class="input-field col s12">
				<select>
					<option value="" disabled selected>Year Level</option>
					<?php foreach($option_select as $each):?>
						<option value="1"><?=$each->year_level_name?></option>
					<?php endforeach;?>
				</select>
				<label class="color-black">Assigned to:</label>
			</div>
			<div class="input-field col s12">
				<ul class="collapsible">
					<li>
						<div class="collapsible-header">Select topics:</div>
						<div class="collapsible-body"><span>
							<?php foreach($topics as $top):?>
								<div class="col s3">
									<p>
										<label>
											<input type="checkbox" />
											<span><?= $top->topic_list_name ?><br></span>
										</label>
									</p>
								</div>
							<?php endforeach;?>
						</span></div>
					</li>
				</ul>
			</div>
			<div class="input-field">
				<button class="btn waves-effect waves-light right green" type="submit" name="submit">Submit</button>
				<a href="<?= base_url() ?>Course" class="waves-effect waves-light btn left red">Cancel</a>
			</div>
		</form>
	</div>
	<div class="col s2"></div>
</div>