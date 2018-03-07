<?php $this->load->view('includes/navbar-admin'); ?>

<?php 
$enrollment = $this->Crud_model->fetch("enrollment");
?>
<div class="container row">
	<div class="col s12">
		<blockquote class="color-primary-green" style="margin-top: 5%;"> 
			<h5 class="color-black valign-wrapper">Manage Enrollment <i class="material-icons color-primary-green" style="padding-left: 1%; cursor: pointer;">add_circle</i></h5> 
		</blockquote>
		<div class="row" style="padding-top: 5%;">
			<?php if ($enrollment): ?>
				<table class="data-table">
					<thead>
						<tr>
							<th>#</th>
							<th>Enrollment S.Y</th>
							<th>Enrollment Term</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($enrollment as $key => $value): ?>
							<tr>
								<td><?=$value->enrollment_id?></td>
								<td><?=$value->enrollment_sy?></td>
								<td><?=$value->enrollment_term?></td>
								<td>
									<?php 
									$checked = $value->enrollment_is_active == 1 ? "checked" : "";
									?>
									<div class="switch">
										<label>
											Deactivated
											<input type="checkbox" class="chk_admin" data-id="<?=$value->enrollment_id?>" <?=$checked?> >
											<span class="lever"></span>
											Activated
										</label>
									</div>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {

		$(document).on('click','.chk_admin', function(){     
			$('.chk_admin').prop('checked', false);
			$(this).prop('checked', true);       
			$data = $(this).data("id");
			// console.log($data);	 
			$.ajax({
				url: '<?=base_url()?>Enrollment/updateEnrollment ',
				type: 'post',
				dataType: 'json',
				data: {
					e_id: $data,
				},
				success: function(data){
					if (data == true) {
						$toast = "<span>Active Enrollment Updated!</span>";
						Materialize.toast($toast,2000);
					}else{
						$toast = "<span>"+data+"</span>";
						Materialize.toast($toast,2000);
					}
				}
			});

		});

	});
</script>