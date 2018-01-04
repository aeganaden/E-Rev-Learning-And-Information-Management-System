<?php $this->load->view('includes/navbar'); ?>





<!--=================================
=            Modal Login            =
==================================-->
<div id="a-login-modal" class="modal">

	<h3 style="margin: 2%;" class="primary-color-green center">LOGIN</h3>
	<hr>

	<div class="modal-content">
		<div class="row">
			<div class="col s2"></div>
			<div class="col s8">
				<center>
					<img src="<?=base_url()?>assets/img/feu-seal.png" style="width: 8vh; margin: 2%;">
				</center>
				<form>
					<div class="row">
						<div class="input-field">
							<input id="last_name" type="text" class="validate">
							<label for="last_name" >Last Name</label>
						</div>
					</div>
				</form>
				<a href="#!" class="modal-action modal-close waves-effect waves-light btn primary-bg-green" style="color: white !important">Agree</a>
			</div>
			<div class="col s2"></div>
		</div>
	</div>
	<div class="modal-footer">
		
	</div>
</div>


<!--====  End of Modal Login  ====-->
