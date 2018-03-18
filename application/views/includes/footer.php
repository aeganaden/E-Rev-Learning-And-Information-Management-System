</div>
<?php 
$info = $this->session->userdata('userInfo');

if ($info['identifier']=='student') {
	$sess = $this->Crud_model->fetch('login_sessions',array("login_sessions_id"=>$info['sess_id']));
	$sess = $sess[0];
	if ($sess->login_sessions_status == 0) {
		session_destroy();
		redirect('Welcome','refresh');
	}
}
?>
</body>
<script type="text/javascript">
	$("#body").css("display","block");
</script>
<!-- main js -->
<script type="text/javascript" src="<?=base_url()?>assets/js/main.js?v=<?=time();?>"></script>

<!-- sweet alert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- time table -->
<script src="<?=base_url()?>assets/js/timetable.min.js"></script>

<!-- Data tables JS -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

<!-- charts.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<!-- percent.js -->
<script src="https://rawgit.com/kimmobrunfeldt/progressbar.js/master/dist/progressbar.js"></script>
<!-- fittext.js -->
<script src="<?=base_url()?>assets/js/jquery.fittext.js"></script>
<!-- sticky.js -->
<script src="<?=base_url()?>assets/js/jquery.sticky.js"></script>
</html>