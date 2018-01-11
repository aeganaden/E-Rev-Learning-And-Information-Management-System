<!--====================================
=            Navigation Top            =
=====================================-->

<div class="row valign-wrapper">
	<div class="col s4 ">

		<a href="#" style="padding-left: 2%" data-activates="slide-out" class="color-black button-collapse valign-wrapper">
			<i class="material-icons small">menu</i> MENU
		</a>
	</div>
	<div class="col s4">
		<center>
			<img src="<?=base_url()?>assets/img/feu-header.png" style="width: 40vh; margin-top: 2%;">
		</center> 
	</div>
	<div class="col s4"></div>
</div>

<!--====  End of Navigation Top  ====<--></-->
<?php $this->load->view('includes/home-sidenav'); ?>

<div class="row">
	<div class="col s4">
		
		<blockquote class="color-primary-green">
			<?php echo strtotime("+1 day") ?>
			<h1 class="color-black">Activity</h1>
		</blockquote>
	</div>
	<div class="col s4"></div>
	<div class="col s4"></div>
</div>

<div class="row">

	<?php foreach ($activity as $key => $value): ?>
		<?php 
		
		// Activity details
		$details = $this->Crud_model->fetch("activity_details", array("activity_details_id"=>$value->activity_details_id));
		$details = $details[0];
		?>
		<div class="col s4">
			<div class="card bg-primary-green ">
				<div class="card-content white-text">
					<div class="row" style="margin-bottom: 0 !important;">
						<div class="col s4">
							<blockquote class="color-primary-yellow">
								<span class="card-title color-white"><?=$details->activity_details_name?></span>
							</blockquote>
						</div>
						<div class="col s4"></div>
						<div class="col s4">
							<i class="material-icons right color-primary-yellow" style="cursor: pointer;">edit</i>
							<i class="material-icons right color-primary-yellow" style="cursor: pointer;">delete</i>
						</div>
					</div>
					<p><i>Added on <?=date("M d, Y", $value->activity_date_time)?></i></p>
					<h5><?=$value->activity_description?></h5>
				</div>
				
			</div>
		</div>
	<?php endforeach ?>
</div>
