

<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>

<div class="row container">
	<blockquote class="color-primary-green">

		<h3 class="color-black">Activity
			<a class="btn waves-effect waves-light bg-primary-green modal-trigger" 
			data-id="<?=$info['user']->id?>" href="#modal_add_activity" id="btn_add_activity">Add Activity</a>
		</h3>
	</blockquote>
</div>

<div class="row container">

	<?php if ($activity): ?>
		<?php foreach ($activity as $key => $value): ?>
			<?php 

		// Activity details
			$details = $this->Crud_model->fetch("activity_details", array("activity_details_id"=>$value->activity_details_id));
			$details = $details[0];
			$offering = $this->Crud_model->fetch("offering", array("offering_id"=>$value->offering_id));
			$offering = $offering[0]; 
			$is_overdue = "";
			$schedule = $this->Crud_model->fetch("activity_schedule",array("activity_id"=>$value->activity_id));
			// echo "<pre>";

			$schedule = $schedule[0];
			// $date = $value->activity_date_time;
			// $now = time();

			// if($date < $now) {
			// 	$is_overdue = "Overdue";
			// }else{
			// 	$is_overdue = "";
			// }	
			?>
			<div class="col s6">
				<div class="card bg-primary-green ">
					<div class="card-content white-text">
						<div class="row" style="margin-bottom: 0 !important;">
							<div class="col s8">
								<blockquote class="color-primary-yellow">
									<span class="card-title color-white"><?=$details->activity_details_name?> 
										- 	<b><?=$offering->offering_name?></b>
									</span>
									<span class="color-red bg-primary-yellow"><?=$is_overdue?></span>
									<p> 
										<?=date("M d, Y", $schedule->activity_schedule_date)?> |
										<?=date("h:i A", $schedule->activity_schedule_start_time)?> -
										<?=date("h:i A", $schedule->activity_schedule_end_time)?>
									</p>
									<p><?=strtoupper($value->activity_venue)?></p>
								</blockquote>
								<div class="row div-edit<?=$value->activity_id?>" style="display: none">
									<div class="col s12">
										<div class="row">
											<div class="col s6 input-field">
												<input type="text"  class="timepicker" id="time_s<?=$value->activity_id?>" value="Change Start Time">
											</div>
											<div class="col s6 input-field">
												<input type="text"  class="timepicker" id="time_e<?=$value->activity_id?>" value="Change End Time">
											</div>
										</div>
										<div class="row">
											<div class="input-field col s6">
												<input type="text" class="datepicker " id="date<?=$value->activity_id?>" value="Change Date">
											</div>
											<div class="input-field col s6">
												<input placeholder="E.g F1102" id="venue<?=$value->activity_id?>" value="<?=strtoupper($value->activity_venue)?>" type="text" class="validate">
												<label for="venue<?=$value->activity_id?>">Venue</label>
											</div>
										</div>
										<div class="input-field">
											<textarea class="materialize-textarea" id="desc_data<?=$value->activity_id?>"><?=$value->activity_description?></textarea>
											<label for="txtarea">Description</label>
										</div>
									</div>
									
									
									
									<button class="btn bg-primary-green waves-effect right btn_update_activity" data-id="<?=$value->activity_id?>">Update</button>
								</div>
							</div>
							<div class="col s4">
								<i class="material-icons right color-white tooltipped btn_delete_activity" data-tooltip="Delete Activity" data-id="<?=$value->activity_id?>" style="cursor: pointer;">delete</i>

								<i class="tooltipped btn_edit_activity material-icons right color-primary-yellow" data-id="<?=$value->activity_id?>" href="#modal_activity" style="cursor: pointer;" data-tooltip="Edit Activity">edit</i>
							</div>
						</div>
						<h5 style="display: block;" class="activity_paragraph_desc<?=$value->activity_id?> a-roboto-cond"><?=$value->activity_description?></h5>
					</div>

				</div>
			</div>
			<!-- SCRIPT FOR SETTING THE TIME -->

		<?php endforeach ?>
	<?php else: ?>
		<h3 class="center">No Data Yet</h3>
	<?php endif ?>
</div>
<?php 
$ident = $info['identifier'];
$ident.="_department";
$program = "";

switch ($info['user']->$ident) {
	case 'CE':
	$program = "Civil Engineering";
	break;
	case 'EE':
	$program = "Electrical Engineering";
	break;
	case 'ECE':
	$program = "Electronics and Computer Engineering";
	break;
	case 'ME':
	$program = "Mechanical Engineering";
	break;

	default:
        # code...
	break;
}
?>

<div id="modal_add_activity" class="modal bg-color-white"  style="height: 100vh">
	<div class="modal-content">
		<h4>Add Activity</h4>
		<div class="input-field col s12">
			<select id="section_area" name="select_section">
				<?php 
				$offering = $this->Crud_model->fetch("offering",array("offering_department"=>$info['user']->$ident));
				?>
				<option value="" disabled selected>Choose Section</option>
				<?php if ($offering): ?>
					<?php foreach ($offering as $key => $value): ?>
						<option value="<?=$value->offering_id?>" style="text-transform: uppercase;"><?=$value->offering_name?></option>
					<?php endforeach ?>
				<?php endif ?>
			</select>
			<label><?=$program?> sections</label>
		</div>
	</div>
	<div class="modal-footer bg-color-white">
		<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
	</div>
</div>



<script type="text/javascript">

	jQuery(document).ready(function($) {


		// $('#section_area').on('change', function() {
		// 	// alert( this.value );
		// 	$.ajax({
		// 		url: '<?=base_url()?>Home/fetchSchedule ',
		// 		type: 'post',
		// 		dataType: 'json',
		// 		data: {id: this.value },
		// 		success: function(data){	
		// 			console.log(data);	
		// 		},
		// 		error: function(data){

		// 		}

		// 	});
		// })







		$(".btn_edit_activity").click(function(event) {
			$id = $(this).attr("data-id");
			$(".div-edit"+$id).toggle("slow");
			if ($(".activity_paragraph_desc"+$id).css("display")=="block") {
				$(".activity_paragraph_desc"+$id).fadeOut();
				$(".activity_paragraph_desc"+$id).css("display","none");
			}else{
				$(".activity_paragraph_desc"+$id).fadeIn();
				$(".activity_paragraph_desc"+$id).css("display","block");
			}

		});


		$('body').on('click', '.btn_update_activity', function() {
			$id = $(this).data("id");
			$time_s = $("#time_s"+$id).val();
			$time_e = $("#time_e"+$id).val();
			$date = $("#date"+$id).val();
			$desc = $("#desc_data"+$id).val();
			$.ajax({
				url: '<?=base_url()?>Home/updateActivity ',
				type: 'post',
				dataType: 'json',
				data: {
					id: $(this).attr("data-id"),
					time_s: $time_s,
					time_e: $time_e,
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
			swal({
				title: "Are you sure?",
				text: "Once deleted, you will not be able to recover this announcement!",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					$.ajax({
						url: '<?=base_url()?>Home/deleteActivity ',
						type: 'post',
						dataType: 'json',
						data: {
							id: $(this).attr("data-id"),
						},
						success: function(data){
							window.location.reload(true);
						},
						error: function(data){

						}
					});

				} 
			});

		});





	});

	function set_date_time(class_name,date_time) {
		$('.'+class_name).val(date_time).pickadate();	
	}
</script>