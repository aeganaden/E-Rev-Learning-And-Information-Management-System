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
		$topic = $this->Crud_model->fetch("topic", array("topic_id"=>$value->topic_id));
		$topic = $topic[0];
		?>
		<div class="col s4">
			<div class="card bg-primary-green ">
				<div class="card-content white-text">
					<div class="row" style="margin-bottom: 0 !important;">
						<div class="col s8">
							<blockquote class="color-primary-yellow">
								<span class="card-title color-white"><?=$details->activity_details_name?></span>
								<i><?=$topic->topic_name?></i>
							</blockquote>
						</div>
						<div class="col s4">
							<i class="material-icons right color-white" style="cursor: pointer;">delete</i>
							<i class="material-icons right color-primary-yellow modal-trigger" data-id="" href="#modal_activity" style="cursor: pointer;">edit</i>
						</div>
					</div>
					<p><i>Added on <?=date("M d, Y", $value->activity_date_time)?></i></p>
					<h5><?=$value->activity_description?></h5>
				</div>
				
			</div>
		</div>
	<?php endforeach ?>
</div>


<!-- Modal Structure -->
<div id="modal_activity" class="modal">
	<div class="modal-content">
		<h4>Modal Header</h4>
		<p>A bunch of text</p>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
	</div>
</div>
