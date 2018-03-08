

<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>

<div class="row container">
	<blockquote class="color-primary-green">

		<h5 class="color-black">Activity <br><br>
			<a class="btn waves-effect waves-light bg-primary-green modal-trigger" 
			data-id="<?=$info['user']->id?>" href="#modal_add_activity" id="btn_add_activity">Add Activity</a>
		</h5>
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
			$schedule = $this->Crud_model->fetch("activity_schedule",array("activity_schedule_id"=>$value->activity_schedule_id));
			// echo "<pre>";

			$schedule = $schedule[0];
			$date = $schedule->activity_schedule_date;
			$now = time();

			if($date < $now) {
				$is_overdue = "Overdue";
			}else{
				$is_overdue = "";
			}	
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
									<?php 
									$lecturer = $this->Crud_model->fetch("lecturer",array("lecturer_id"=>$value->lecturer_id));
									$lecturer = $lecturer[0];
									$name_l = ucwords($lecturer->firstname." ". $lecturer->lastname);
									?>
									<h5><?=$name_l?></h5>
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
											<div class="input-field">
												<?php 
												$lecturer = $this->Crud_model->fetch("lecturer",array("lecturer_status"=>1));
												?>
												<select class="icons" id="sel_<?=$value->activity_id?>">
													<option value="" disabled selected>Select Lecturer</option>
													<?php foreach ($lecturer as $key => $i_value): ?>
														<?php 
														$is_assigned = "";
														$name = ucwords($i_value->firstname." ". $i_value->lastname);
														?>
														<?php if ($value->lecturer_id == $i_value->lecturer_id): ?>
															<?php $is_assigned = "selected"; ?>
														<?php endif ?>
														<option value="<?=$i_value->lecturer_id?>" <?=$is_assigned?> data-icon="<?=base_url().$i_value->image_path?>" class="left circle"><?=$name?></option>
													<?php endforeach ?>
												</select>
												<label>Assign Lecturer</label>
											</div>
										</div>
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
									
									
									
									<button class="btn bg-primary-yellow waves-effect right btn_update_activity" data-sched="<?=$value->activity_schedule_id?>" data-offering="<?=$value->offering_id?>" data-id="<?=$value->activity_id?>">Update</button>
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
	case 'EEE':
	$program = "Electrical and Electronics Engineering";
	break;
	case 'ME':
	$program = "Mechanical Engineering";
	break;

	default:
        # code...
	break;
}
?>

<div id="modal_add_activity" class="modal bg-color-white modal-fixed-footer"  style="height: 100vh">
	<div class="modal-content">
		<h4>ADD ACTIVITY</h4>
		<blockquote class="color-primary-green">
			<h5 class="color-black">
				SECTIONS
			</h5>
		</blockquote>
		<div class="input-field">
			<select id="modal_section" name="modal_section">
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
			<label style="text-transform: uppercase;"><?=$program?> sections</label>
		</div>
		<blockquote class="color-primary-green">
			<h5 class="color-black">
				LECTURER
			</h5>
		</blockquote>
		<div class="input-field">
			<select class="icons" id="modal_select">
				<option value="" disabled selected>Choose Lecturer</option>
				<?php 
				$lecturer = $this->Crud_model->fetch("lecturer",array("lecturer_status"=>1));
				?>
				<?php foreach ($lecturer as $key => $j_value): ?>
					<?php  
					$name = ucwords($j_value->firstname." ". $j_value->lastname);
					?>
					<option value="<?=$j_value->lecturer_id?>" data-icon="<?=base_url().$j_value->image_path?>" class="left circle"><?=$name?></option>
				<?php endforeach ?>
			</select>
			<label>ASSIGN LECTURER</label>
		</div>
		<blockquote class="color-primary-green">
			<h5 class="color-black">
				DATE AND VENUE
			</h5>
		</blockquote>
		<div class="row col s12">
			<div class="col s3 input-field">
				<input type="text"  class="datepicker" id="modal_date" value="Add Date">
				<label for="modal_date">DATE</label>
			</div>
			<div class="col s3 input-field">
				<input type="text"  class="timepicker" id="modal_s_time" value="Add Start Time">
				<label for="modal_date">START TIME</label>
			</div>
			<div class="col s3 input-field">
				<input type="text"  class="timepicker" id="modal_e_time" value="Add End Time">
				<label for="modal_date">END TIME</label>
			</div>
			<div class="col s3 input-field">
				<input placeholder="E.g T506" id="modal_venue" type="text" class="validate">
				<label for="modal_venue">VENUE</label>
			</div>
		</div>
		<blockquote class="color-primary-green">
			<h5 class="color-black">
				DESCRIPTION AND TYPE
			</h5>
		</blockquote>
		<div class="row">
			<div class="input-field col s6">
				<textarea id="modal_desciption" class="materialize-textarea"></textarea>
				<label for="modal_desciption">ACTIVITY DESCRIPTION</label>
			</div>
			<div class="input-field  col s6">
				<select id="modal_type">
					<option value="" disabled selected>Choose Type</option>
					<?php 
					$activity_details = $this->Crud_model->fetch("activity_details");
					?>
					<?php foreach ($activity_details as $key => $value): ?>
						<option value="<?=$value->activity_details_id?>"><?=$value->activity_details_name?></option>
					<?php endforeach ?>
				</select>
				<label>CHOOSE ACTIVITY TYPE</label>
			</div>
		</div>

	</div>
	<div class="modal-footer bg-color-white">
		<a href="#!" id="modal_btn_add_activity" class=" waves-effect waves-light btn bg-primary-green">ADD ACTIVITY</a>
	</div>
</div>



<script type="text/javascript">

	jQuery(document).ready(function($) {

		$("#modal_btn_add_activity").click(function(event) {
			$lecturer = $("#modal_select").val();
			$offering = $("#modal_section").val();
			$date = $("#modal_date").val();
			$s_time = $("#modal_s_time").val();
			$e_time = $("#modal_e_time").val();
			$desc = $("#modal_desciption").val();
			$venue = $("#modal_venue").val();
			$type = $("#modal_type").val();
			console.log($type);	
			$.ajax({
				url: '<?=base_url()?>Home/addActivity',
				type: 'post',
				dataType: 'json',
				data: {
					lecturer: $lecturer,
					offering: $offering,
					date: $date,
					s_time: $s_time,
					e_time: $e_time,
					desc: $desc,
					venue: $venue,
					type: $type,
				},
				success: function(data){
					console.log(data);	
					if (data == true) {
						swal("Done!", "Successfully edited", "success").then(function(){
							window.location.reload(true);
						});						
					}else{
						$toastData = '<span>'+data+'</span>';
						Materialize.toast($toastData,2000);
					}
				}
			});
			
		});


		$(".btn_edit_activity").click(function(event) {
			$id = $(this).attr("data-id");
			$(".div-edit"+$id).toggle("slow");
			if ($(".activity_paragraph_desc"+$id).css("display")=="block") {
				$(".activity_paragraph_desc"+$id).fadeOut();
				$(".activity_paragraph_desc"+$id).css("display","none");
				$desc = $("#desc_data"+$id).val();
				$("#desc_data"+$id).val($desc + " ");
			}else{
				$(".activity_paragraph_desc"+$id).fadeIn();
				$(".activity_paragraph_desc"+$id).css("display","block");
			}

		});


		$('body').on('click', '.btn_update_activity', function() {
			$id = $(this).data("id");
			$offering = $(this).attr("data-offering");
			$sched_id = $(this).attr("data-sched");

			$time_s = $("#time_s"+$id).val();
			$time_e = $("#time_e"+$id).val();
			$date = $("#date"+$id).val();
			$desc = $("#desc_data"+$id).val();
			$venue = $("#venue"+$id).val();
			$lecturer_id = $("#sel_"+$id).val(); 
			$.ajax({
				url: '<?=base_url()?>Home/updateActivity ',
				type: 'post',
				dataType: 'json',
				data: {
					id: $id,
					time_s: $time_s,
					time_e: $time_e,
					date: $date,
					venue: $venue,
					desc: $desc,
					offering: $offering,
					sched_id: $sched_id,
					lecturer_id: $lecturer_id
				},
				success: function(data){
					if (data == true) {
						swal("Done!", "Successfully edited", "success").then(function(){
							window.location.reload(true);
						});						
					}else{
						$toastData = '<span>'+data+'</span>';
						Materialize.toast($toastData,2000);
					}


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