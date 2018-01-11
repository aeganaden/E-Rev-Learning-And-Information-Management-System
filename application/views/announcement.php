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
		<form action="<?=base_url()?>Admin/addAnnouncement" method="post">
			<div class="row">
				<div class="input-field col s8">
					<input placeholder="Announcement Title" name="title" id="ann_title" type="text" class="validate">
					<label for="ann_title">Title</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<textarea id="ann_content" name="content" class="materialize-textarea"></textarea>
					<label for="ann_content">Content</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field">
					<select name="ann_audience">
						<option value="1" selected>General</option>
						<option value="2">Civil Engineering</option>
						<option value="3">Electronics and Communication Engineering</option>
						<option value="4">Electrical Engineering</option>
						<option value="5">Mechanical Engineering</option>

					</select>
					<label>Audience Selection</label>
				</div>
			</div>
			<button class="btn waves-light waves-effect right">Post</button>
		</form>

	</div>
	<div class="col s4"></div>
</div>
<div class="row">
	
	<table>
		<thead>
			<tr>
				<td>ID</td>
				<td>Title</td>
				<td>Content</td>
				<td>Created at</td>
				<td>Edited At</td>
				<td>Status</td>
				<td>Audience</td>
				<td>Announced by</td>
				<td>Actions</td>
			</tr>
		</thead>
		<tbody>
			<?php if ($announcement): ?>
				<?php foreach ($announcement as $key => $value): ?>
					<?php 
					$is_active = $value->announcement_is_active == 1 ? "ACTIVE"  : "INACTIVE";
					$is_active_color = $value->announcement_is_active == 1 ? "color-green"  : "color-red";
					$audience = "";
					switch ($value->announcement_audience) {
						case '1':
						$audience = "General";
						break;
						case '2':
						$audience = "Civil Engineering";
						break;
						case '3':
						$audience = "Electrical and Electronics Engineering";
						break;
						case '4':
						$audience = "Electrical Engineering";
						break;
						case '5':
						$audience = "Mechanical Engineering";
						break;

						default:
						# code...
						break;
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
						<td><?=date("M d, Y - h:i A",$value->announcement_created_at)?></td>
						<td><?=date("M d, Y - h:i A",$value->announcement_edited_at)?></td>
						<td class="<?=$is_active_color?>"><?=$is_active?></td>
						<td><?=$audience?></td>
						<td><?=$value->announcement_announcer?></td>
						<td><i data-id="<?=$value->announcement_id?>" class="ann-modal-btn material-icons color-primary-green modal-trigger waves-effect waves-light" href="#ann_modal" style="cursor: pointer;">edit</i></td>
						<td><i class="material-icons color-red btn_modal_delete" data-id="<?=$value->announcement_id?>" style="cursor: pointer;">delete</i></td>
					</tr>
				<?php endforeach ?>
			<?php else: ?>
				
			<?php endif ?>
		</tbody>
	</table>
</div>


<!--===================================
=            Modal Section            =
====================================-->

<div id="ann_modal" class="modal">
	<div class="modal-content">
		<h4>Edit Announcement</h4>
		<div class="row">
			<div class="input-field">
				<input type="text" value="" placeholder="" id="ann_modal_title" class="validate" name="">
				<label for="ann_title">Announcement Title</label>
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
			<div class="col s4"></div>
			<div class="col s4">
				<center>
					<div class="switch">
						<p class="color-green">STATUS</p>
						<label>
							Deactivated
							<input type="checkbox" id="ann_modal_status">
							<span class="lever"></span>
							Activated
						</label>
					</div>
				</center>
			</div>
			<div class="col s4"></div>
		</div>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-action modal-close waves-effect left waves-light red btn">Cancel</a>
		<a href="#!" id="btn_modal_update" class="modal-action modal-close waves-effect right waves-light green btn">Update</a>
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
					// console.log(data[0].announcement_id);	
					$("#ann_modal_title").val(data[0].announcement_title);
					$("#ann_modal_content").val(data[0].announcement_content);
					if (data[0].announcement_is_active == 1) {
						$("#ann_modal_status").attr( "checked", true );
					}else{
						$("#ann_modal_status").attr( "checked", false );

					}
				},
				error: function(data){

				}
			});
			});

			$("#btn_modal_update").click(function(event) {
				$title = $("#ann_modal_title").val();
				$content = $("#ann_modal_content").val();
				$status = 0;
				if ($("#ann_modal_status").prop("checked") == true) {
					$status = 1;
				}else{
					$status = 0;
				}
				$.ajax({
					url:"<?=base_url()?>Admin/updateAnnouncement",
					type:"post",
					dataType:"json",
					data:{
						title: $title,
						content: $content,
						status : $status, 
						id: $(this).attr("data-id"),
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

