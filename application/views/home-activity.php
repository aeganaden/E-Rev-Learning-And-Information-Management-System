

<?php $this->load->view('includes/home-navbar'); ?>
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
								<p> <?=date("M d, Y | h:i A", $value->activity_date_time)?></p>
								<p><?=strtoupper($value->activity_venue)?></p>
							</blockquote>
							<div class="row div-edit" style="display: none">
								<input type="text" class="timepicker time_data" value="Change Time">
								<input type="text" class="datepicker date_data" value="Change Date">
								<textarea id="txtarea" class="materialize-textarea desc_data"><?=$value->activity_description?></textarea>
								<label for="txtarea">Description</label>
								<button class="btn waves-effect waves-light right btn_update_activity" data-id="<?=$value->activity_id?>">Update</button>
							</div>
						</div>
						<div class="col s4">

							<i class="material-icons right color-white tooltipped btn_delete_activity" data-tooltip="Delete Activity" data-id="<?=$value->activity_id?>" style="cursor: pointer;">delete</i>
							<i class="tooltipped btn_edit_activity material-icons right color-primary-yellow" data-id="<?=$value->activity_id?>" href="#modal_activity" style="cursor: pointer;" data-tooltip="Edit Activity">edit</i>
						</div>
					</div>
					<h5 style="display: block;" class="activity_paragraph_desc"><?=$value->activity_description?></h5>
				</div>
				
			</div>
		</div>
	<?php endforeach ?>
</div>



<script type="text/javascript">
	$(".btn_edit_activity").click(function(event) {
		$(".div-edit").toggle("slow");
		if ($(".activity_paragraph_desc").css("display")=="block") {
			$(".activity_paragraph_desc").fadeOut();
			$(".activity_paragraph_desc").css("display","none");
		}else{
			$(".activity_paragraph_desc").fadeIn();
			$(".activity_paragraph_desc").css("display","block");
		}

	});

	$(".btn_update_activity").click(function(event) {
		$time = $(".time_data").val();
		$date = $(".date_data").val();
		$desc = $(".desc_data").val();
		$.ajax({
			url: '<?=base_url()?>Home/updateActivity ',
			type: 'post',
			dataType: 'json',
			data: {
				id: $(this).attr("data-id"),
				time: $time,
				date: $date,
				desc: $desc
			},
			success: function(data){

				swal("Done!", "Successfully edited", "success").then(function(){
					// console.log(data);	
					window.location.reload(true);
				});
				
			}
		});

	});

	$(".btn_delete_activity").click(function(event) {
		
	});
</script>