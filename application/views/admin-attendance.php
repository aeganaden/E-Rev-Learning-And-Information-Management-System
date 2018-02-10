<?php  date_default_timezone_set("Asia/Manila")?>
<?php $status = $lecturer->lecturer_status == 1 ? "ACTIVE" : "INACTIVE" ?>
<?php $status_color = $lecturer->lecturer_status == 1 ? "color-green" : "color-red" ?>
<div class="row">
	<div class="col s8">
		<blockquote class="color-primary-green">
			<h3 class="color-black">Lecturers' Attendance and Hours Rendered</h3>
			<h4 class="color-black"><?=ucwords($lecturer->firstname." ".$lecturer->lastname)?></h4>
			<h5>Rendered Hours: <u><?=$hours_rendered?></u></h5>
			<h6><i><?=$lecturer->email?></i></h6>
			<h6>Expertise: <?=ucwords($lecturer->lecturer_expertise)?></h6>
			<h5  class="<?=$status_color?>"><?= $status?></h5>
		</blockquote>

	</div>

</div>

<div class="row">
	<div class="col s12">


		<?php if ($attendance == false): ?>

			<h1 class="center">No Attendance Recorded Yet</h1>
		<?php else: ?>
			<table class="data-table">
				<thead>
					<tr>
						<td>ID</td>
						<td>Date</td>
						<td>Schedule Start</td>
						<td>Schedule End</td>
						<td>Time In</td>
						<td>Time Out</td>
						<td>Remarks</td>					</tr>
					</thead>
					<tbody>
						<?php 
						?>
						<?php foreach ($attendance as $key => $value): ?>
							<tr class="bg-color-white">
								<td><?=$value['lecturer_attendance_id']?></td>	
								<td><?=date("M d, Y - l", $value['lecturer_attendance_date'])?></td>	
								<td><?=date("h:i A", $value['sched_start'])?></td>	
								<td><?=date("h:i A", $value['sched_end'])?></td>	
								<td><?=date("h:i A", $value['lecturer_attendance_in'])?></td>	
								<td><?=date("h:i A", $value['lecturer_attendance_out'])?></td>
								<td>
									<blockquote class="color-primary-green"><span class="color-black"><?=$value['remarks_s']?></span></blockquote>
									<blockquote class="color-primary-green"><span class="color-black"><?=$value['remarks_e']?></span></blockquote>
								</td>

							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>

		</div>
	</div>