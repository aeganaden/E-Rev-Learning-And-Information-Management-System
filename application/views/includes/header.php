<!DOCTYPE html>
<html>
<head>
	<title><?= $title ?></title>
	<link rel="shortcut icon" type="image/png" href="<?=base_url()?>assets/img/favicon.png"/>

	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<!--Import Google Icon Font-->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<!--Import jQuery before materialize.js-->
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/materialize.min.js"></script>

	<!--Import materialize.css-->
	<link type="text/css" rel="stylesheet" href="<?= base_url(); ?>assets/css/materialize.min.css"  media="screen,projection"/>

	<!-- Primary Css -->
	<link rel="stylesheet" type="text/css" href='<?= base_url(); ?>assets/css/primary.css?v=<?= time(); ?>'>

	<!-- Primary Css -->
	<link rel="stylesheet" type="text/css" href='<?= base_url(); ?>assets/css/timetablejs.css?v=<?= time(); ?>'>

	<!-- Circle Css -->
	<link rel="stylesheet" type="text/css" href='<?= base_url(); ?>assets/css/circle.css?v=<?= time(); ?>'>

	<!-- Error Css -->
	<link rel="stylesheet" type="text/css" href='<?= base_url(); ?>assets/css/error.css?v=<?= time(); ?>'>

	<!-- Data tables CSS-->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">

	<!-- MARK'S CSS!!! -->
	<link rel="stylesheet" type="text/css" href='<?= base_url(); ?>assets/css/mark_css.css?v=<?= time(); ?>'>

	<!-- Animate Css -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

	<!-- Global base_url for js files -->
	<script>var base_url = '<?php echo base_url() ?>'; </script>

	<!-- SweetAlert2 -->
	<script src="<?= base_url(); ?>assets/js/sweetalert2.all.js"></script> 
	
	<!-- Easy Timer -->
	<script src="<?= base_url(); ?>assets/js/easytimer.min.js"></script> 

	<!-- ckeditor -->
	<script src="<?= base_url(); ?>ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>ckeditor/plugins/ckeditor_wiris/plugin.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>ckeditor/plugins/ckeditor_wiris/integration/WIRISplugins.js"></script>
	
	<script type="text/javascript">
		var unsavedChanges = true;
		function createCookie(name,value,days) {
			if (days) {
				var date = new Date();
				date.setTime(date.getTime()+(days*24*60*60*1000));
				var expires = "; expires="+date.toUTCString();
			}
			else var expires = "";
			document.cookie = name+"="+value+expires+"; path=/";
		}

		function readCookie(name) {
			var nameEQ = name + "=";
			var ca = document.cookie.split(';');
			for(var i=0;i < ca.length;i++) {
				var c = ca[i];
				while (c.charAt(0)==' ') c = c.substring(1,c.length);
				if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
			}
			return null;
		}

		function eraseCookie(name) {
			createCookie(name,"",-1);
		}

		function store(id) {
			ident = "div-" + id;
			createCookie('div_visible', ident);
		}
		
		jQuery(document).ready(function($) {

			var x = readCookie('div_visible');
			if (!x) {
				$("#div-card-chart").css('display', 'block');
			}else{
				$("#div-card-chart").css('display', 'none');
				$("#"+x).css('display', 'block');
			}

		});
		var BASE_URL = "<?=base_url()?>";
	</script>
</head>
<body>
	<noscript>
		<h1>Your browser does not support JavaScript.</h1>
	</noscript>


	<div class="progress bg-primary-yellow" style="margin: 0; padding: 0; display: none;" id="preloader">
		<div class="indeterminate bg-primary-green"></div>
	</div>

	<div id="body" style="display: none;"> 