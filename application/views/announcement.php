<?php $this->load->view('includes/navbar-admin'); ?>
<?php  date_default_timezone_set("Asia/Manila")?>
<div class="row">
	<div class="col s8">
		<blockquote>
			<h3>Manage Announcements</h3>
		</blockquote>
	</div>
</div>
<div class="row">
	<div class="col s4"></div>
	<div class="col s4">
		<form action="<?=base_url()?>Admin/addAnnouncement" id="form_ann" method="post">
			<div class="row">
				<div class="input-field col s8">
					<input required placeholder="Announcement Title" name="title" id="ann_title" type="text" class="validate">
					<label for="ann_title">Title</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<textarea required id="ann_content" name="content" class="materialize-textarea"></textarea>
					<label for="ann_content">Content</label>
				</div>
			</div>
			<div class="row" required>
				<p>
					<input type="checkbox" id="ce" name="audience[]" value="1"  />
					<label for="ce">Civil Engineering</label>
				</p>
				<p>
					<input type="checkbox" id="ece" name="audience[]" value="2" />
					<label for="ece">Electronics and Communication Engineering</label>
				</p>
				<p>
					<input type="checkbox" id="ee" name="audience[]" value="3" />
					<label for="ee">Electrical Engineering</label>
				</p>
				<p>
					<input type="checkbox" id="me" name="audience[]" value="4" />
					<label for="me">Mechanical Engineering</label>
				</p>
				
			</div>
			<div class="row">
				<p><b>End Date</b></p>
				<input name="end_time" type="text" class="datepicker">
			</div>
			<button id="btn_add_ann" class="btn bg-primary-green waves-effect right">Post</button>
		</form>
		
	</div>
	<div class="col s4"></div>
</div>
<div class="row">
	<div class="col s1"></div>
	<div class="col s10">
		<div class="row">
			
			<table class="data-table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Title</th>
						<th>Content</th>
						<th>Active Until</th>
						<th>Created at</th>
						<th>Edited At</th>
						<th>Status</th>
						<th>Audience</th>
						<th>Announced by</th>
						<th>Actions</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php if ($announcement): ?>
						<?php foreach ($announcement as $key => $value): ?>
							<?php 
							$is_active = $value->announcement_is_active == 1 ? "ACTIVE"  : "INACTIVE";
							$is_active_color = $value->announcement_is_active == 1 ? "color-green"  : "color-red";
							$str_aud = "";
							$audience = explode( ',', $value->announcement_audience );
							$seconds = $value->announcement_end_datetime - $value->announcement_start_datetime;
							$days = ceil($seconds/(3600*24));
							$i = 0;
							$len = count($audience);
							foreach ($audience as $key => $aud) {
								$c = " | ";
								if ($i == $len - 1) {
									$c = "";
								}

								switch ($aud) {
									case '1':
									$str_aud .= "CE".$c;
									break;
									case '2':
									$str_aud .= "ECE".$c;
									break;
									case '3':
									$str_aud .= "EE".$c;
									break;
									case '4':
									$str_aud .= "ME".$c;
									break;

									default:
						# code...
									break;
								}
								$i++;
							}
							?>
							<tr>
								<script type="text/javascript">
									jQuery(document).ready(function($) {
										
										shorten_text("<?=$value->announcement_content?>","<?=$value->announcement_id?>");
									});
								</script>
								<td><?=$value->announcement_id?></td>
								<td><?=$value->announcement_title?></td>
								<td ><h6 class="ann_content_truncate<?=$value->announcement_id?>"></h6></td>
								<td><?=date("M d, Y",$value->announcement_end_datetime)?> - (<?=$days?>) Days Left</td>
								<td><?=date("M d, Y - h:i A",$value->announcement_created_at)?></td>
								<td><?=date("M d, Y - h:i A",$value->announcement_edited_at)?></td>
								<td class="<?=$is_active_color?>"><?=$is_active?></td>
								<td><?=$str_aud?></td>
								<td><?=$value->announcement_announcer?></td>
								<td><i data-id="<?=$value->announcement_id?>" class="ann-modal-btn material-icons color-primary-green modal-trigger waves-effect waves-light" href="#ann_modal" style="cursor: pointer;">edit</i></td>
								<td><i class="material-icons color-red btn_modal_delete" data-id="<?=$value->announcement_id?>" style="cursor: pointer;">delete</i></td>
							</tr>
						<?php endforeach ?>
					<?php else: ?>
						<td colspan="10"><h4 class="center">No data, add some.</h4></td>
					<?php endif ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col s1"></div>
</div>


<!--===================================
=            Modal Section            =
====================================-->

<div id="ann_modal" class="modal bg-color-white modal-fixed-footer">
	<div class="modal-content">
		<h4  class="color-black center"><span style="border-bottom: 3px solid #F2A900;">Edit Announcement</span></h4>
		<br>
		<div class="row">
			<div class="input-field">
				<input type="text" value="" placeholder="" id="ann_modal_title" class="validate" name="">
				<label for="ann_modal_title">Announcement Title</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field">
				<textarea id="ann_modal_content" class="materialize-textarea">

				</textarea>
				<label for="ann_modal_title">Content</label>
			</div>
		</div>	
		<div class="row">
			<p><b>End Date</b></p>
			<input id="modal_end_time" name="modal_end_time" type="text" class="datepicker">
		</div>
		<div class="row">
			<h5 class="center color-black"><span style="border-bottom: 3px solid #F2A900;">Audience</span></h5>
			<div class="col s3"></div>
			<div class="col s9">
				<p>
					<input class="aud_1" type="checkbox" id="mod_ce" name="modal_audience" value="1"  />
					<label for="mod_ce">Civil Engineering</label>
				</p>
				<p>
					<input class="aud_2" type="checkbox" id="mod_ece" name="modal_audience" value="2" />
					<label for="mod_ece">Electronics and Communication Engineering</label>
				</p>
				<p>
					<input class="aud_3" type="checkbox" id="mod_ee" name="modal_audience" value="3" />
					<label for="mod_ee">Electrical Engineering</label>
				</p>
				<p>
					<input class="aud_4" type="checkbox" id="mod_me" name="modal_audience" value="4" />
					<label for="mod_me">Mechanical Engineering</label>
				</p>

			</div>
		</div>

	</div>
	<div class="modal-footer bg-color-white">
		<a href="#!" class="modal-action modal-close waves-effect left waves-light red btn">Cancel</a>
		<a href="#!" id="btn_modal_update" class=" right bg-primary-green waves-effect btn">Update</a>
	</div>
</div>


<!--====  End of Modal Section  ====-->


<!--==================================
=            Ajax Section            =
===================================-->

<script type="text/javascript">

	// determine checkbox status = ($('input.checkbox_check').is(':checked')) {
		jQuery(document).ready(function($) {

			$(".ann-modal-btn").click(function(event) {
				$("#btn_modal_update").attr("data-id", $(this).attr("data-id"));
				$.ajax({
					url: "<?=base_url()?>Admin/fetchAnnouncement",
					type:"post",
					dataType: "json",
					data: {
						id: $(this).attr("data-id"),
					},
					success: function(data){
						// console.log(data);
						var aud = data.announcement_audience;	
						var result = aud.split(',');
						for (i = 0; i < 4; i++) {
							if (i+1 == parseInt(result[i])) {
								$(".aud_"+result[i]).prop('checked', true);
							}else{
								$(".aud_"+(i+1)).prop('checked', false); 
							}
						}
						$("#ann_modal_title").val(data.announcement_title);					
						$("#ann_modal_content").val(data.announcement_content);		
						$('#modal_end_time').val(data.end_time).pickadate();	

						console.log(data);	
					},
					error: function(data){

					}
				});

			});

			$("#btn_add_ann").click(function(event) {
				checked = $("input[type=checkbox]:checked").length;

				if(!checked) {
					alert("You must check at least one checkbox.");
					return false;
				}
			});
			$('form').one('submit', function(e) {
				e.preventDefault();
				swal("Poof! announcement has been added!", {
					icon: "success",
				}).then(function(){
					$("#form_ann").submit();
				});
			});



			$("#btn_modal_update").click(function(event) {
				$title = $("#ann_modal_title").val();
				$content = $("#ann_modal_content").val();
				$date = $("#modal_end_time").val();
				$audience = "";
				var x = ",";
				$("input:checkbox[name=modal_audience]:checked").each(function (index, value) {
					var isLastElement = index == $("input:checkbox[name=modal_audience]:checked").length -1;
					if (isLastElement) {
						x = "";
					}

					$audience += $(this).val() + x;
				});
				console.log($audience);	
				$.ajax({
					url:"<?=base_url()?>Admin/updateAnnouncement",
					type:"post",
					dataType:"json",
					data:{
						title: $title,
						content: $content,
						audience : $audience, 
						id: $(this).attr("data-id"),
						date: $date
					},
					success: function(data){
						if (data) {
							swal("Done!", "Successfully edited", "success").then(function(){
								window.location.reload(true);

							});
						}
					},
					error: function(data){

					}
				});	
			});

			$(".btn_modal_delete").click(function(event) {
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
							url:"<?=base_url()?>Admin/deleteAnnouncement ",
							type: "post",
							dataType: "json",
							data:{
								id:$(this).attr("data-id")
							},
							success: function(data){
								swal("Poof! announcement has been deleted!", {
									icon: "success",
								}).then(function(){
									window.location.reload(true);
								});
							},
							error: function(data){
								// console.log(data);	
							}

						});

					} 
				});

			});


		});


		function shorten_text(text,id) {
			var ret = text;
			if (ret.length > 20) {
				ret = ret.substr(0,20-3) + "...";
			}

			$(".ann_content_truncate"+id).html(ret);
		}

	</script>

	<!--====  End of Ajax Section  ====-->

