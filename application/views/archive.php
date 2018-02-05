<?php $this->load->view('includes/navbar-admin'); ?>
<?php  date_default_timezone_set("Asia/Manila")?>

<ul id="slide-out" class="side-nav fixed bg-color-white">
	<li><h5 style="padding-left: 2%;">ARCHIVE LIST</h5></li>
	<li><a href="#!">Announcements</a></li>
	<li class="no-padding">
		<ul class="collapsible collapsible-accordion">
			<li>
				<a class="collapsible-header">Dropdown<i class="material-icons">arrow_drop_down</i></a>
				<div class="collapsible-body">
					<ul>
						<li><a href="#!">First</a></li>
						<li><a href="#!">Second</a></li>
						<li><a href="#!">Third</a></li>
						<li><a href="#!">Fourth</a></li>
					</ul>
				</div>
			</li>
		</ul>
	</li>
</ul>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$x = $(".nav-admin").height()+3;
		$("#slide-out").css('margin-top', $x);
	});
</script>