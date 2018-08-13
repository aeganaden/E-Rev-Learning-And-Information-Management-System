<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');
use PhpOffice\PhpSpreadsheet\IOFactory;

class Importdata extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Crud_model');
		$this->load->library('form_validation');
		$this->load->library('Excelfile');
		$this->load->library('session');
	}

	public function index() {
		$this->session->unset_userdata('insertion_info');
		$userInfo = $this->session->userdata('userInfo')['user'];
		$temp = array('username' => $userInfo->username, 'password' => $userInfo->password);
		$temp = $this->Crud_model->fetch('admin', $temp);
		if ($temp) {
			$data = array(
				'title' => "Import Excel",
			);
			$this->load->view('includes/header', $data);
			$this->load->view('excel_reader/index');
			$this->load->view('includes/footer');
		} else {
			//kapag di naka login
			redirect("");
		}
	}

	public function credentialcheck() {
		$this->session->unset_userdata('insertion_info');
		$userInfo = $this->session->userdata('userInfo')['user'];
		$temp = array('username' => $userInfo->username, 'password' => $userInfo->password);
		$temp = $this->Crud_model->fetch('admin', $temp);
		if ($temp) {
			$data = array(
				'username' => $this->input->post('username'),
			);
			$userInfo = $this->Crud_model->fetch('admin', $data);
			if (!$userInfo) {
				$data = array(
					'error' => 'Invalid account. Please try again.',
					'title' => "Import Excel",
				);
				$this->load->view('includes/header', $data);
				$this->load->view('excel_reader/index');
				$this->load->view('includes/footer');
			} else {
				$userInfo = $userInfo[0];

//            if ($userInfo->password == sha1($this->input->post('password'))) {
				if ($userInfo->password == $this->input->post('password')) {
					$insertion_info = array('logged_in' => true);
					$this->session->set_userdata('insertion_info', $insertion_info);
					redirect('importdata/uploadfile');
				} else {
					$data = array(
						'error' => 'Invalid account. Please try again.',
					);

					$this->load->view('includes/header', $data);
					$this->load->view('excel_reader/index');
					$this->load->view('includes/footer');
				}
			}
			$this->load->view('includes/footer');
		} else {
			//kapag di naka login
			redirect("");
		}
	}

	public function filecheck() {
		if (!empty($this->session->userdata('insertion_info')['logged_in']) && $this->session->userdata('insertion_info')['logged_in'] == 1) {
			$config['upload_path'] = './assets/uploads/';
			$config['allowed_types'] = 'xls|csv|xlsx';
			$config['max_size'] = '10000';
			$stack_hold = array();

			$this->load->library('upload', $config);
			$data = array(
				'title' => "Import Excel",
			);
			$this->load->view('includes/header', $data);
			if ($this->upload->do_upload('userfile')) {
				$data[] = array('upload_data' => $this->upload->data());
				$obj = PHPExcel_IOFactory::load($this->upload->data()["full_path"]);
				$sheetnames = $obj->getSheetNames();

				$counter = 0;
				include './application/views/excel_reader/custom1.php';

				$tab_names = $this->Crud_model->table_names();
				$error_counter = 0; //for checking field/column names
				$alphas = range('A', 'Z'); //array for A-Z
				foreach ($sheetnames as $sheet) {
					if (in_array($sheet, $tab_names)) {
						//found the table names are correct
						$worksheet = $obj->getSheet($counter);
						$hold[$sheet] = $worksheet->toArray(null, true, true, false);
						$col_names = $this->Crud_model->col_names($sheet);
						$name_counter = 0;
						foreach ($hold[$sheet][0] as $col_hold) {
							//check field/column names
							if (!in_array($col_hold, $col_names) && empty($col_hold)) {
								echo "There is no \"" . $col_hold . "\", located at 1" . $alphas[$name_counter] . ", field in the database table \"" . $sheet . "\" (missing column)<br>";
								$error_counter++;
							}
							$name_counter++;
						}
						if ($error_counter == 0) {
							for ($z = 1; $z < count($hold[$sheet]); $z++) {
								//loop base on row on excel 2 and beyond
								$inner_counter = 0;
								foreach ($hold[$sheet][$z] as $col_hold) {
									//getting values
									$col_data_hold = get_object_vars($this->Crud_model->col_data($sheet)[$inner_counter]);

									$col_type = $col_data_hold['type'];
									$col_length = $col_data_hold['max_length'];

									if ($col_type === "bigint" || $col_type === "tinyint" || $col_type === "int") {
										//check data types
										if (($this->is_this_string_an_integer($col_hold) && $col_length >= strlen($col_hold) && !empty($col_hold)) || $col_hold == 0) {
											//kapag tinanggal rightmost, bawal ang 0
											$inner_counter == 0 ? $stack_hold = array($col_data_hold['name'] => $col_hold) : $stack_hold = $stack_hold + array($col_data_hold['name'] => $col_hold);
										} else {
											echo "The value \"" . $col_hold . "\", located at " . ($z + 1) . $alphas[$inner_counter] . " of table '$sheet', does not qualify to \"" . $col_type . "\"<br>";
											$error_counter++;
											//break;
										}
									} else if (strtolower($col_type) == "varchar" || strtolower($col_type) == "text") {
										//check data types
										if (is_string($col_hold) == 1 && $col_length >= strlen($col_hold) && !empty($col_hold)) {
											$inner_counter == 0 ? $stack_hold = array($col_data_hold['name'] => $col_hold) : $stack_hold = $stack_hold + array($col_data_hold['name'] => $col_hold);
										} else if (strtolower($col_type) == "text") {
											$inner_counter == 0 ? $stack_hold = array($col_data_hold['name'] => $col_hold) : $stack_hold = $stack_hold + array($col_data_hold['name'] => $col_hold);
										} else {
											if ($col_hold === null) {
												echo "this is empty";
											}
											echo "The value \"" . $col_hold . "\", located at " . ($z + 1) . $alphas[$inner_counter] . " of table '$sheet', does not qualify to \"" . $col_type . "\"<br>";
											$error_counter++;
											//break;
										}
									}
									$inner_counter++;
								}
								$batch_holder[$sheet][] = $stack_hold;
							}
						} else {
							$error_message_last = "The data from the file was not imported to the database due to the errors.<br>";
						}
					} else {
						//no found table name like that
						echo "There is no \"" . $sheet . "\" table in the database.<br>";
						$error_counter++;
						break;
					}
					$counter++;
				}
				if (!empty($error_message_last)) {
					//error
					echo "----------<br>";
					echo $error_message_last;
					$this->load->view('excel_reader/sample'); //changes text to error
					if (file_exists($this->upload->data()["full_path"])) {
						unlink($this->upload->data()["full_path"]);
						echo "<b>The file is deleted.</b>";
					}
				} else {
					//success magiinsert na
					include './application/views/excel_reader/custom2.php';
					$temp_counter = 0;
					$this->db->trans_begin();
					foreach ($sheetnames as $sheet) {
						$temp = $this->Crud_model->insert_batch($sheet, $batch_holder[$sheet])['message'];
						if ($this->db->trans_status() === FALSE && !empty($temp)) {
							echo "<br>***" . $temp . " on '$sheet' table";
							$temp_counter++;
							include './application/views/excel_reader/custom4.php';
						} else {
							echo "<br>Insertion success on table '$sheet'";
						}
					}
					if ($temp_counter > 0) {
						$this->db->trans_rollback();
						echo "<br><b>Insertion fail. Transaction rollback.</b>";
						if (file_exists($this->upload->data()["full_path"])) {
							unlink($this->upload->data()["full_path"]) or die('failed deleting: ' . $this->upload->data()["full_path"]);
						}
					} else {
						$this->db->trans_commit();
					}
					include './application/views/excel_reader/custom3.php';
					include './application/views/excel_reader/custom5.php';
				}
				$this->load->view('includes/footer');
			} else {
				$error = array('error' => $this->upload->display_errors());
				$this->load->view('includes/header', $data);
				$this->load->view('excel_reader/upload_file', $error);
				$this->load->view('includes/footer');
			}
		} else {
			redirect("");
		}
	}

	public function uploadfile() {

		if (!empty($this->session->userdata('insertion_info')['logged_in']) && $this->session->userdata('insertion_info')['logged_in'] == 1) {
			//fetch sched and offering
			$col = "sch.schedule_id as sched_id, sch.schedule_start_time as start_time, sch.schedule_end_time as end_time, UCASE(CONCAT(lec.firstname, ' ', lec.midname, ' ', lec.lastname)) as fullname, lec.id_number as lec_id";
			$join = array(
				array("schedule as sch", "sch.lecturer_id = lec.lecturer_id"),
				array("offering as off", "sch.offering_id = off.offering_id"),
			);
			$where = array(
				"lec.lecturer_status" => 1,
			);
			$lects = $this->Crud_model->fetch_join2("lecturer as lec", $col, $join, NULL, $where);
			// echo "<pre>";
			// print_r($lects);
			$data = array(
				'title' => "Import Excel",
				"lects" => $lects,
			);
			$this->session->set_flashdata('credentialadmin', '1');
			$this->load->view('includes/header', $data);
			$this->load->view('excel_reader/upload_file');
			$this->load->view('includes/footer');
		} else {
			redirect("");
		}
	}

	public function sha1it() {
		echo sha1('on');
	}

	public function attendanceUpload() {
		if (!empty($this->session->userdata('insertion_info')['logged_in']) && $this->session->userdata('insertion_info')['logged_in'] == 1) {
			$config['upload_path'] = './assets/uploads/';
			$config['allowed_types'] = 'xls|csv|xlsx';
			$config['max_size'] = '10000';
			$this->form_validation->set_error_delimiters('', ''); // remove p tag
			$this->form_validation->set_rules('sched', 'Schedule', 'required');
			if ($this->form_validation->run() == FALSE) {
				echo json_encode(validation_errors());
			} else {
				$input = $this->input->post('sched');
				$col = "sch.schedule_id, sch.offering_id, lec.id_number, lec.lecturer_id";
				$where = array("sch.schedule_id" => $input);
				$join = array(
					array("lecturer as lec", "lec.lecturer_id = sch.lecturer_id"),
				);
				$fetchSched = $this->Crud_model->fetch_join2("schedule as sch", $col, $join, NULL, $where)[0];
				$lect_id = $fetchSched->id_number;

				if (!empty($fetchSched)) {
					$this->load->library('upload', $config);
					if ($this->upload->do_upload("userfile")) {
						$upload_data = $this->upload->data();
						$file_name = './assets/uploads/' . $upload_data['file_name'];
						require "./application/vendor/autoload.php";
						$spreadsheet = IOFactory::load($file_name);
						$spreadsheet->setActiveSheetIndex(0);
						$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
						$hold;
						$counter = 0;

						$orderby = array("attendance_in_id", "DESC");
						$last_in = $this->Crud_model->fetch_select("attendance_in", "attendance_in_id", NULL, NULL, NULL, NULL, NULL, NULL, $orderby, 1)[0]->attendance_in_id;
						$last_in = $last_in == FALSE ? 0 : $last_in;
						$orderby = array("attendance_out_id", "DESC");
						$last_out = $this->Crud_model->fetch_select("attendance_out", "attendance_out_id", NULL, NULL, NULL, NULL, NULL, NULL, $orderby, 1)[0]->attendance_out_id;
						$last_out = $last_out == FALSE ? 0 : $last_out;
						$orderby = array("lecturer_attendance_id", "DESC");
						$last_attend = $this->Crud_model->fetch_select("lecturer_attendance", "lecturer_attendance_id", NULL, NULL, NULL, NULL, NULL, NULL, $orderby, 1)[0]->lecturer_attendance_id;
						$last_attend = $last_attend == FALSE ? 0 : $last_attend;

						for ($i = 1; $i <= count($sheetData); $i++) {
							if ($i != 1) {
								$check1 = !empty($sheetData[$i]['A']) ? TRUE : FALSE;
								$check2 = !empty($sheetData[$i]['B']) ? TRUE : FALSE;
								$check3 = !empty($sheetData[$i]['C']) ? TRUE : FALSE;
								$check4 = !empty($sheetData[$i]['D']) ? TRUE : FALSE;

								if ($check1 && $check2 && $check3 && $check4) {
									//convert to shorter
									if (!is_numeric($valA = $sheetData[$i]['A']) || strlen($valA) != 9 || strcmp($lect_id, strval($valA)) != 0) {
										//9 exact digits of empid
										echo json_encode('Wrong format in EmpID (Column A, row ' . $i . '), or selected lecturer does not match the ID. Should be 9-digit ID.');
										break;
									} else if (!$this->checkmydate($valB = $sheetData[$i]['B'])) {
										echo json_encode('Wrong format in Date (Column B, row ' . $i . '). Should be in YYYY-MM-DD format.');
										break;
									} else if (!$this->checkmytime($valC = $sheetData[$i]['C'])) {
										echo json_encode('Wrong format in Time In (Column C, row ' . $i . '). Should be in HH:MM:SS military format.');
										break;
									} else if (!$this->checkmytime($valD = $sheetData[$i]['D'])) {
										echo json_encode('Wrong format in Time Out (Column D, row ' . $i . '). Should be in HH:MM:SS military format.');
										break;
									} else {
										if (!strtotime($valB)) {
											echo json_encode('Wrong format in Date (Column B, row ' . $i . '). Should be in YYYY-MM-DD format.');
											break;
										} else if (!strtotime($valB . " " . $valC)) {
											echo json_encode('Wrong format in Time In (Column C, row ' . $i . '). Should be in HH:MM:SS military format without AM or PM.');
											break;
										} else if (!strtotime($valB . " " . $valD)) {
											echo json_encode('Wrong format in Time Out (Column D, row ' . $i . '). Should be in HH:MM:SS military format without AM or PM.');
											break;
										}
										$array_attend[$i]["lecturer_attendance_id"] = ++$last_attend;
										$array_attend[$i]["lecturer_attendance_date"] = strtotime($valB);
										$array_attend[$i]["lecturer_id"] = $fetchSched->lecturer_id;
										$array_attend[$i]["offering_id"] = $fetchSched->offering_id;
										$array_attend[$i]["schedule_id"] = $fetchSched->schedule_id;

										$array_in[$i]["attendance_in_id"] = ++$last_in;
										$array_in[$i]["attendance_in_time"] = strtotime($valB . " " . $valC);
										$array_in[$i]["lecturer_attendance_id"] = $last_attend;

										$array_out[$i]["attendance_out_id"] = ++$last_out;
										$array_out[$i]["attendance_out_time"] = strtotime($valB . " " . $valD);
										$array_out[$i]["lecturer_attendance_id"] = $last_attend;

										$counter++;
									}
								} else if (!$check1 && !$check2 && !$check3 && !$check4) {
									$counter++;
								} else {
									echo json_encode('There is/are empty cell/s in row ' . $i . '. Please edit and re-upload the file.');
									break;
								}
							} else {
								$check1 = !empty($sheetData[$i]['A']) && strcasecmp('empid', $sheetData[$i]['A']) == 0 ? TRUE : FALSE;
								$check2 = !empty($sheetData[$i]['B']) && strcasecmp('date', $sheetData[$i]['B']) == 0 ? TRUE : FALSE;
								$check3 = !empty($sheetData[$i]['C']) && strcasecmp('in', $sheetData[$i]['C']) == 0 ? TRUE : FALSE;
								$check4 = !empty($sheetData[$i]['D']) && strcasecmp('out', $sheetData[$i]['D']) == 0 ? TRUE : FALSE;

								if (!$check1 || !$check2 || !$check3 || !$check4) {
									echo json_encode('row1');
									break;
								} else {
									$counter++;
								}
							}
						}

						// make sure all of the rows got read
						if ($counter == count($sheetData)) {
							$this->db->trans_begin();
							$this->Crud_model->insert_batch("lecturer_attendance", $array_attend);
							$this->Crud_model->insert_batch("attendance_in", $array_in);
							$this->Crud_model->insert_batch("attendance_out", $array_out);

							if ($this->db->trans_status() === FALSE) {
								$this->db->trans_rollback();
								echo json_encode("An unexpected error occured while processing the data. Try refreshing this webpage and try again.");
							} else {
								// $this->db->trans_rollback();
								$this->db->trans_commit();
								// echo json_encode(array($array_attend, $array_in, $array_out));
								echo json_encode("true");
							}
						}
					} else {
						echo json_encode($this->upload->display_errors('', ''));
					}
				} else {
					//there's no such sched id
					echo json_encode("EmpID (Column A) do not match with the selected lecturer.");
				}
			}
		} else {
			echo json_encode('not_admin');
		}
	}

	function formatTime($date) {
		$tempDate = explode('-', strval($date));
		$date = new DateTime($tempDate[1] . "/" . $tempDate[2] . "/" . $tempDate[0]); /*mm/dd/yyyy*/
		return $date->format('U');
	}

	function checkmydate($date) {
		try {
			$tempDate = explode('-', strval($date));
			$isit = checkdate($tempDate[1], $tempDate[2], $tempDate[0]);
			return $isit;
		} catch (Exception $e) {
			return false;
		}
	}

	function checkmytime($date) {
		try {
			$tempDate = explode(':', $date);
			$check1 = $tempDate[0] >= 0 && $tempDate[0] < 24 ? TRUE : FALSE;
			$check2 = $tempDate[1] >= 0 && $tempDate[1] < 60 ? TRUE : FALSE;
			$check3 = $tempDate[2] >= 0 && $tempDate[2] < 60 ? TRUE : FALSE;
			return $check1 && $check2 && $check3;
		} catch (Exception $e) {
			return false;
		}
	}

	function is_this_string_an_integer($string) {

		// Assume from the start that the string IS an integer.
		// If we hit any problems, we'll bail out and say it's NOT an integer.
		$is_integer = true;

		// Convert the string into an array of characters.
		$array_of_chars = str_split($string);

		// If there are no characters, we don't have an integer.
		if (empty($array_of_chars)) {
			$is_integer = false;
		}

		// If the first character is a zero, we don't have an integer.
		// Instead, we have a string with leading zeros.
		if ($is_integer && $array_of_chars[0] == '0') {
			$is_integer = false;
		}
		// If we still think it might be an integer,
		// step through each char and see if it's a legitimate digit.
		if ($is_integer) {
			foreach ($array_of_chars as $i => $char) {

				// Use PHP's ctype_digit() function to see if this
				// character is a digit. If not, we can bail.
				if (!ctype_digit($char)) {
					$is_integer = false;
					break;
				}
			}
		}

		// Finally, do we have an integer string or not?
		return $is_integer;
	}

}
