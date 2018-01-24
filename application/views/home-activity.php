

<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>

<div class="row">
	<div class="col s4">
		<blockquote class="color-primary-green">

			<h1 class="color-black">Activity
				<a class="btn waves-effect waves-light bg-primary-green modal-trigger" 
				data-id="<?=$info['user']->id?>" href="#modal_add_activity" id="btn_add_activity">Add Activity</a>
			</h1>
		</blockquote>


	</div>
	<div class="col s4"></div>
	<div class="col s4"></div>
</div>

<div class="row">

	<?php if ($activity): ?>
		<?php foreach ($activity as $key => $value): ?>
			<?php 

		// Activity details
			$details = $this->Crud_model->fetch("activity_details", array("activity_details_id"=>$value->activity_details_id));
			$details = $details[0];
			$subject = $this->Crud_model->fetch("subject", array("subject_id"=>$value->subject_id));
			$subject = $subject[0];
			?>
			<div class="col s4">
				<div class="card bg-primary-green ">
					<div class="card-content white-text">
						<div class="row" style="margin-bottom: 0 !important;">
							<div class="col s8">
								<blockquote class="color-primary-yellow">
									<span class="card-title color-white"><?=$details->activity_details_name?></span>
									<i><?=$subject->subject_name?></i>
									<p> <?=date("M d, Y | h:i A", $value->activity_date_time)?></p>
									<p><?=strtoupper($value->activity_venue)?></p>
								</blockquote>
								<div class="row div-edit<?=$value->activity_id?>" style="display: none">
									<input type="text"  class="timepicker time_data time<?=$value->activity_id?>" value="Change Time">
									<input type="text" class="datepicker date_data date<?=$value->activity_id?>" value="Change Date">
									<textarea id="txtarea" class="materialize-textarea desc_data"><?=$value->activity_description?></textarea>
									<label for="txtarea">Description</label>
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

<div id="modal_add_activity" class="modal" style="height: 100vh">
	<div class="modal-content">
		<h4>Add Activity</h4>
		<div class="input-field col s12">
			<select id="section_area" name="select_section">
				<option value="" disabled selected>Choose your option</option>
				<?php if ($offering): ?>
					<?php foreach ($offering as $key => $value): ?>
						<option value="<?=$value->offering_id?>" style="text-transform: uppercase;"><?=$value->offering_course_code." - ".$value->offering_section?></option>
					<?php endforeach ?>
				<?php endif ?>
			</select>
			<label>Materialize Select</label>
		</div>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
	</div>
</div>



<script type="text/javascript">

	jQuery(document).ready(function($) {


		$('#section_area').on('change', function() {
			// alert( this.value );
			$.ajax({
				url: '<?=base_url()?>Home/fetchSchedule ',
				type: 'post',
				dataType: 'json',
				data: {id: this.value },
				success: function(data){	
					console.log(data);	
				},
				error: function(data){

				}

			});
		})







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