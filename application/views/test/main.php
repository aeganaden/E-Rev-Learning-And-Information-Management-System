<!DOCTYPE html>
↵<html lang="en">
↵<head>
	↵<meta charset="utf-8">
	↵<title>Database Error</title>
	↵<style type="text/css">
	↵
	↵::selection { background-color: #E13300; color: white; }
	↵::-moz-selection { background-color: #E13300; color: white; }
	↵
	↵body {
		↵	background-color: #fff;
		↵	margin: 40px;
		↵	font: 13px/20px normal Helvetica, Arial, sans-serif;
		↵	color: #4F5155;
		↵}
		↵
		↵a {
			↵	color: #003399;
			↵	background-color: transparent;
			↵	font-weight: normal;
			↵}
			↵
			↵h1 {
				↵	color: #444;
				↵	background-color: transparent;
				↵	border-bottom: 1px solid #D0D0D0;
				↵	font-size: 19px;
				↵	font-weight: normal;
				↵	margin: 0 0 14px 0;
				↵	padding: 14px 15px 10px 15px;
				↵}
				↵
				↵code {
					↵	font-family: Consolas, Monaco, Courier New, Courier, monospace;
					↵	font-size: 12px;
					↵	background-color: #f9f9f9;
					↵	border: 1px solid #D0D0D0;
					↵	color: #002166;
					↵	display: block;
					↵	margin: 14px 0 14px 0;
					↵	padding: 12px 10px 12px 10px;
					↵}
					↵
					↵#container {
						↵	margin: 10px;
						↵	border: 1px solid #D0D0D0;
						↵	box-shadow: 0 0 8px #D0D0D0;
						↵}
						↵
						↵p {
							↵	margin: 12px 15px 12px 15px;
							↵}
						↵</style>
					↵</head>
					↵<body>
						↵	<div id="container">
							↵		<h1>A Database Error Occurred</h1>
							↵		<p>Error Number: 1451</p><p>Cannot delete or update a parent row: a foreign key constraint fails (`engineering`.`subject`, CONSTRAINT `fk_subject_subject_list1` FOREIGN KEY (`subject_list_id`) REFERENCES `subject_list` (`subject_list_id`) ON DELETE NO ACTION ON UPDATE NO ACTION)</p><p>DELETE FROM `subject_list`↵WHERE `subject_list_id` = '2'↵AND `year_level_id` = '3'</p><p>Filename: C:/xampp/htdocs/Engineering/system/database/DB_driver.php</p><p>Line Number: 691</p>	</div>
						↵</body>
						↵</html>