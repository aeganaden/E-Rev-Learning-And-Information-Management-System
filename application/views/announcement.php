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
			</tr>
		</thead>
		<tbody>
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
					<td><?=$value->announcement_id?></td>
					<td><?=$value->announcement_title?></td>
					<td><?=$value->announcement_content?></td>
					<td><?=date("M d, Y - h:i A",$value->announcement_created_at)?></td>
					<td><?=date("M d, Y - h:i A",$value->announcement_edited_at)?></td>
					<td class="<?=$is_active_color?>"><?=$is_active?></td>
					<td><?=$audience?></td>
					<td><?=$audience?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
