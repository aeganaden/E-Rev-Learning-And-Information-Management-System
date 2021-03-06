<?php $this->load->view('includes/navbar-admin'); ?>
<?php date_default_timezone_set("Asia/Manila")
?>
<?php if ($active_enrollment): ?>
    <!--===========================
    =            Cards            =
    ============================-->


    <div class="row" >
        <div class="col s12 m3" >
            <div class="row" id="card-chart" onclick="store(this.id)" style="cursor: pointer;">
                <div class="card">
                    <div class="card-content bg-primary-yellow">
                        <p class="a-oswald flow-text">Good Day, Admin!</p>
                        <p class="a-oswald flow-text">TODAY IS</p>
                        <?php
                        $active_enrollment = $this->Crud_model->fetch("enrollment", array("enrollment_is_active" => 1));
                        $active_enrollment = $active_enrollment[0];
                        $t = $active_enrollment->enrollment_term;
                        $sy = $active_enrollment->enrollment_sy;
                        ?>
                        <h4 class="a-oswald color-white center"><?= date("M d, Y", time()) ?></h4>
                        <h4 class="center" style="margin: 0 !important;"><u><?= $t ?>T <?= $sy ?></u></h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <h4>Actions</h4>
                <ul class="collapsible" data-collapsible="accordion">
                 <li>
                    <div class="collapsible-header bg-primary-green color-white" ><i class="material-icons ">chrome_reader_mode</i>Reports</div>
                    <div class="collapsible-body">
                        <div class="card" id="card-cosml" onclick="store(this.id)">
                            <div class="card-content bg-primary-green">
                                <h6 class="a-oswald color-white  valign-wrapper">Course Offering Schedule Master List <i class="material-icons">keyboard_arrow_right</i></h6>
                            </div>
                        </div>
                        <div class="card" id="card-ls" onclick="store(this.id)">
                            <div class="card-content bg-primary-green">
                                <h6 class="a-oswald color-white  valign-wrapper">Lecturers' Schedule <i class="material-icons">keyboard_arrow_right</i></h6>
                            </div>
                        </div>
                        <div class="card" id="card-lahr" onclick="store(this.id)">
                            <div class="card-content bg-primary-green">
                                <h6 class="a-oswald color-white  valign-wrapper">Lecturers' Attendance and Hours Rendered <i class="material-icons">keyboard_arrow_right</i></h6>
                            </div>
                        </div>
                        <div class="card" id="card-lcl" onclick="store(this.id)">
                            <div class="card-content bg-primary-green">
                                <h6 class="a-oswald color-white  valign-wrapper">Lecturers' Class List <i class="material-icons">keyboard_arrow_right</i></h6>
                            </div>
                        </div>
                        <!-- FEEDBACK ADDED BY MARK -->
                        <div class="card" id="card-lf" onclick="store(this.id)">
                            <div class="card-content bg-primary-green">
                                <h6 class="a-oswald color-white  valign-wrapper"> Feedback<i class="material-icons">keyboard_arrow_right</i></h6>
                            </div>
                        </div>
                        <!-- END: FEEDBACK ADDED BY MARK -->
                    </div>
                </li>
                <li>
                    <div class="collapsible-header bg-primary-green color-white"><i class="material-icons">content_paste</i>Class Offering Management</div>
                    <div class="collapsible-body valign-wrapper">
                        <p><i>This section provides some function that manages the course offering, function includes updating and deleting the course offerings</i></p>
                        <center>
                            <button class="btn bg-primary-green waves-effect valign-wrapper" id="card-clof" onclick="store(this.id)">Show List</button>
                        </center>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header bg-primary-green color-white"><i class="material-icons">input</i>Data Insertion</div>
                    <div class="collapsible-body"><p><i>This section provides insertion functions using excel file </i></p>
                        <center>
                            <a class="btn bg-primary-green waves-effect valign-wrapper" href="<?= base_url() ?>importdata ">Insert Data</a>
                        </center>
                    </div>
                </li>

                <li>
                    <div class="collapsible-header bg-primary-green color-white"><i class="material-icons">group</i>Manage Professors' Account</div>
                    <div class="collapsible-body valign-wrapper">
                        <p><i>This section provides the Activating ang Deactivating Professors account</i></p>
                        <center>
                            <button class="btn bg-primary-green waves-effect valign-wrapper" id="card-mpa" onclick="store(this.id)">Show List</button>
                        </center>
                    </div>
                </li>

                <li>
                    <div class="collapsible-header bg-primary-green color-white"><i class="material-icons">group</i>Manage FICs Account</div>
                    <div class="collapsible-body"><p><i>This section provides the updating and managing Faculties in Charge account</i></p>
                        <center>
                            <a class="btn bg-primary-green waves-effect valign-wrapper" id="card-fic"  onclick="store(this.id)" href="#">View Accounts</a>
                        </center>
                    </div>
                </li>
                <!-- ENROLLMENT ADDED BY MARK -->
                <li>
                    <div class="collapsible-header bg-primary-green color-white"><i class="material-icons">date_range</i>Enrollment</div>
                    <div class="collapsible-body"><p><i>This section provides the activation and deactivation of enrollment along with permissions to be granted to other users.</i></p>
                        <center>
                            <a class="btn bg-primary-green waves-effect valign-wrapper" id="card-fic"  onclick="store(this.id)" href="<?= base_url() . "Enrollment" ?>">Enrollment</a>
                        </center>
                    </div>
                </li>
                <!-- END: ENROLLMENT ADDED BY MARK -->
            </ul>
        </div>
    </div>
        <!--============================
        =            CHARTS            =
        =============================-->
        <div class="col s12 m9 valign-wrapper" id="div-card-chart" style="display: none;">
            <h4 class="center">
                <span style="text-transform: uppercase; border-bottom: 2px solid #F2A900" >Total Number Of Students</span>
            </h4>
            <div class="col s12 m3"></div>
            <div class="col s12 m6">
                <br>
                <canvas id="myChart"></canvas>
            </div>
            <div class="col s12 m3 ">

            </div>
        </div>

        <!--====  End of CHARTS  ====-->

        <div class="col s12 m9">


            <!-- Lecturers' Feedback Account -->
            <div class="row" id="div-card-lf" style="display: none; ">
                <blockquote class="color-primary-green">
                    <h2> Feedback</h2>
                </blockquote>

                <?php if (isset($feedback) && !empty($feedback)): ?>
                <table class="data-table"  style="table-layout:auto;">
                    <thead>
                        <tr>
                            <th>Lecturer</th>
                            <th>School ID</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($feedback as $res): ?>
                            <tr class="bg-color-white">
                                <td class="valign-wrapper"><img style="object-fit: cover;height:50px;width:50px; margin-right: 2%;" class="circle " src="<?= base_url() . $res->image_path ?>"><?= $res->full_name ?></td>
                                <td><?= $res->id_number ?></td>
                                <td>
                                    <a href="#modal_feedback" class="btn bg-primary-green btn_mdl_feedback waves-effect waves-light modal-trigger" data-id="<?= $res->lecturer_id ?>"> <i class="material-icons right">remove_red_eye</i>View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <center style="margin-top:20vh;">
                        <h3>No data to show</h3>
                    </center>
                <?php endif; ?>
            </div>


            <!-- Manage FIC's Account -->
            <div class="row" id="div-card-fic" style="display: none; ">
                <?php
                $fic = $this->Crud_model->fetch("fic");
                ?>
                <blockquote class="color-primary-green">
                    <h2>Faculties in Charge</h2>
                </blockquote>
                <?php if ($fic): ?>
                    <table class="data-table">
                        <thead>
                            <th>ID</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </thead>
                        <tbody >
                            <?php foreach ($fic as $key => $value): ?>
                                <?php
                                $status = $value->fic_status == 1 ? "Active" : "Not Active";
                                $status_color = $value->fic_status == 1 ? "color-green" : "color-red";
                                $status_chk = $value->fic_status == 1 ? "checked" : "color-red";
                                ?>
                                <tr class="bg-color-white">
                                    <td><?= $value->fic_id ?></td>
                                    <td><?= $value->lastname ?></td>
                                    <td><?= $value->firstname ?></td>
                                    <td><?= $value->midname ?></td>
                                    <td><?= $value->fic_department ?></td>
                                    <td class="stat<?= $value->fic_id ?> <?= $status_color ?>"><?= $status ?></td>
                                    <td>
                                        <div class="switch">
                                            <label>
                                                Deactivated
                                                <input <?= $status_chk ?> type="checkbox" data-id="<?= $value->fic_id ?>"  class="chk_fic_status">
                                                <span class="lever" ></span>
                                                Activated
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                        <?php
                        $data = array(
                            "message_l" => "Uh oh",
                            "message_r" => "No data yet",
                        );
                        echo $this->load->view('chibi/err-sad.php', array("data" => $data), TRUE);
                        ?>
                    <?php endif ?>
                </div>
                <!-- Class Offering Schedule Master List -->
                <div class="row" id="div-card-cosml" style="display: none;">
                    <blockquote class="color-primary-green">
                        <h2>Course Offering Schedule Master List</h2>
                    </blockquote>
                    <table class="data-table">
                        <thead >
                            <tr>
                                <th>ID</th>
                                <th>Course Code</th>
                                <th>Course Title</th>
                                <th>Section</th>
                                <th>Day</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Venue</th>
                                <th>Assigned Professor</th>
                                <th>Term</th>
                                <th>School Year</th>
                            </tr>
                        </thead>
                        <tbody class="bg-color-white">

                            <?php if ($div_cosml_data): ?>
                                <?php foreach ($div_cosml_data as $key => $value): ?>
                                    <tr class="bg-color-white">
                                        <td><?= $value->schedule_id ?></td>
                                        <td><?= strtoupper($value->course_code) ?></td>
                                        <td><?= ucwords($value->course_title) ?></td>
                                        <td><?= strtoupper($value->course_section) ?></td>
                                        <td><?= date("l", $value->schedule_start_time) ?></td>
                                        <td><?= date("h:i A", $value->schedule_start_time) ?></td>
                                        <td><?= date("h:i A", $value->schedule_end_time) ?></td>
                                        <td><?= strtoupper($value->schedule_venue) ?></td>
                                        <td><?= ucwords($value->professor_name) ?></td>
                                        <td><?= $value->term ?></td>
                                        <td><?= $value->sy ?></td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
                <!-- Lecturer's Schedule -->
                <div class="row " id="div-card-ls" style="display: none;">
                    <blockquote class="color-primary-green">
                        <h2>Lecturers' Schedule</h2>
                    </blockquote>
                    <table class="data-table">
                        <thead >
                            <tr>
                                <th>School ID</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Subject</th>
                                <th>Day</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Venue</th>
                                <th>Expertise</th>
                                <th>Status</th>


                            </tr>
                        </thead>

                        <tbody class="bg-color-white">
                            <?php if ($schedule): ?>
                                <?php foreach ($schedule as $key => $value): ?>
                                    <tr class="bg-color-white">
                                        <td><?= $value->id_number ?></td>
                                        <td><?= ucwords($value->lastname) ?></td>
                                        <td><?= ucwords($value->firstname) ?></td>
                                        <td><?= ucwords($value->midname) ?></td>
                                        <td><?= $value->subject ?></td>
                                        <td><?= date("l", $value->schedule_start_time) ?></td>
                                        <td><?= date("h:i A", $value->schedule_start_time) ?></td>
                                        <td><?= date("h:i A", $value->schedule_end_time) ?></td>
                                        <td><?= $value->schedule_venue ?></td>
                                        <td><?= ucwords($value->expertise) ?></td>
                                        <td>
                                            <?php if ($value->status == 1): ?>
                                                <p class="color-green">Active</p>
                                                <?php else: ?>
                                                    <p class="color-red">Inactive</p>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Lecturers' Attendance and Hours Rendered -->
                    <div class="row" id="div-card-lahr" style="display: none;">
                        <blockquote class="color-primary-green">
                            <h2>Lecturers' Attendance and Hours Rendered</h2>
                        </blockquote>
                        <table id="tbl-card-lahr" class="data-table">
                            <thead >
                                <tr>
                                    <th>ID</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Expertise</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody class="bg-color-white">
                                <?php if ($lecturer): ?>
                                    <?php foreach ($lecturer as $key => $value): ?>
                                        <tr class="bg-color-white">
                                            <td><?= $value->id_number ?></td>
                                            <td><?= ucwords($value->firstname) ?></td>
                                            <td><?= ucwords($value->midname) ?></td>
                                            <td><?= ucwords($value->lastname) ?></td>
                                            <td><?= ucwords($value->lecturer_expertise) ?></td>
                                            <td>
                                                <?php if ($value->lecturer_status == 1): ?>
                                                    <p class="color-green">Active</p>
                                                    <?php else: ?>
                                                        <p class="color-red">Inactive</p>
                                                    <?php endif ?>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url() ?>Admin/viewAttendance/<?= $value->lecturer_id ?>" target="_blank" class="btn bg-primary-green waves-effect ">View</a>
                                                    <a href="<?= base_url() ?>Admin/downloadAttendance/<?= $value->lecturer_id ?>" target="_blank" class="btn bg-primary-green waves-effect ">Download</a>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Lecturers' Class List -->
                            <div class="row" id="div-card-lcl" style="display: none;">
                                <blockquote class="color-primary-green">
                                    <h2>Lecturers' Class List</h2>
                                </blockquote>
                                <table id="tbl-card-lahr" class="data-table">
                                    <thead >
                                        <tr>
                                            <th>School ID</th>
                                            <th>Last Name</th>
                                            <th>First Name</th>
                                            <th>Middle Name</th>
                                            <th>Expertise</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody class="bg-color-white">
                                        <?php if ($lecturer): ?>
                                            <?php foreach ($lecturer as $key => $value): ?>
                                                <tr class="bg-color-white">
                                                    <td><?= $value->id_number ?></td>
                                                    <td><?= ucwords($value->firstname) ?></td>
                                                    <td><?= ucwords($value->midname) ?></td>
                                                    <td><?= ucwords($value->lastname) ?></td>
                                                    <td><?= ucwords($value->lecturer_expertise) ?></td>
                                                    <td>
                                                        <?php if ($value->lecturer_status == 1): ?>
                                                            <p class="color-green">Active</p>
                                                            <?php else: ?>
                                                                <p class="color-red">Inactive</p>
                                                            <?php endif ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url() ?>Admin/viewClassList/<?= $value->lecturer_id ?>" target="_blank" class="btn bg-primary-green waves-effect">View</a>
                                                            <a href="<?= base_url() ?>Admin/downloadClassList/<?= $value->lecturer_id ?>" target="_blank" class="btn bg-primary-green waves-effect">Download</a>
                                                        </tr>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Course Offering -->
                                    <div class="row" id="div-card-clof" style="display: none;">
                                        <blockquote class="color-primary-green">
                                            <h2>Course Offering | <u><?= $t ?>T <?= $sy ?></u></h2>
                                        </blockquote>
                                        <table class="data-table">
                                            <thead>
                                                <tr>
                                                    <td>ID</td>
                                                    <td>Course Code</td>
                                                    <td>Course Title</td>
                                                    <td>Program</td>
                                                    <td>Actions</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($course): ?>

                                                    <?php foreach ($course as $key => $value): ?>
                                                        <tr class="bg-color-white">

                                                            <td><?= $value->course_id ?></td>
                                                            <td><?= strtoupper($value->course_course_code) ?></td>
                                                            <td class="truncate" style="text-transform: capitalize;"><?= $value->course_course_title ?></td>
                                                            <td><?= strtoupper($value->course_department) ?></td>
                                                            <td><i class="material-icons color-primary-green btn_modal_com modal-trigger" data-id="<?= $value->course_id ?>" href="#modal_com" style="cursor: pointer;">edit</i></td>

                                                        </tr>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Manage Professors Account -->
                                    <div class="row" id="div-card-mpa" style="display: none; ">
                                        <?php
                                        $professor = $this->Crud_model->fetch("professor");
                                        ?>

                                        <blockquote class="color-primary-green">
                                            <h2>Professors</h2>
                                        </blockquote>
                                        <?php if ($professor): ?>
                                            <table class="data-table">
                                                <thead>
                                                    <th>ID</th>
                                                    <th>Last Name</th>
                                                    <th>First Name</th>
                                                    <th>Middle Name</th>
                                                    <th>Department</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </thead>
                                                <tbody >
                                                    <?php foreach ($professor as $key => $value): ?>
                                                        <?php
                                                        $status = $value->professor_status == 1 ? "Active" : "Not Active";
                                                        $status_color = $value->professor_status == 1 ? "color-green" : "color-red";
                                                        $status_chk_prof = $value->professor_status == 1 ? "checked" : "color-red";
                                                        ?>
                                                        <tr class="bg-color-white">
                                                            <td><?= $value->professor_id ?></td>
                                                            <td><?= $value->lastname ?></td>
                                                            <td><?= $value->firstname ?></td>
                                                            <td><?= $value->midname ?></td>
                                                            <td><?= $value->professor_department ?></td>
                                                            <td class="statProf<?= $value->professor_id ?> <?= $status_color ?>"><?= $status ?></td>
                                                            <td>
                                                                <div class="switch">
                                                                    <label>
                                                                        Deactivated
                                                                        <input <?= $status_chk_prof ?> type="checkbox" data-id="<?= $value->professor_id ?>"  class="chk_prof_status">
                                                                        <span class="lever" ></span>
                                                                        Activated
                                                                    </label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                            <?php else: ?>
                                                <?php
                                                $data = array(
                                                    "message_l" => "Uh oh",
                                                    "message_r" => "No data yet",
                                                );
                                                echo $this->load->view('chibi/err-sad.php', array("data" => $data), TRUE);
                                                ?>
                                            <?php endif ?>
                                        </div>


                                    </div>
                                </div>

                                <!--====  End of Cards  ====-->

    <!--===========================================
    =            Modal Course Offering            =
    ============================================-->

    <div id="modal_com" class="modal bg-color-white">
        <div class="modal-content">
            <blockquote class="color-primary-green">
                <h4>Edit Class Offering</h4>
            </blockquote>
            <div class="row">
                <div class="row">
                    <div class="col s2"></div>
                    <div class="col s8">
                        <div class="row">
                            <div class="input-field">
                                <input placeholder="" style="text-transform:uppercase" id="" type="text" class="validate correl-code">
                                <label for="correl-code">Course Code</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field">
                                <input placeholder="" style="text-transform:uppercase" id="" type="text" class="validate correl-title">
                                <label for="correl-title">Course Title</label>
                            </div>
                        </div>
                    </div>
                    <div class="col s2"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-color-white">
            <a href="#!" class="modal-action modal-close waves-effect waves-light btn red left">Cancel</a>
            <a href="#!" id="btn_modal_com_update"  class="bg-primary-green waves-effect btn right">Update</a>
        </div>
    </div>

    <!--====  End of Modal Course Offering  ====-->

    <!--==============================================
    =            Modal Lecturers Feedback            =
    ===============================================-->


    <div id="modal_feedback" class="modal modal-fixed-footer bg-color-white">
        <div class="modal-content">
            <div class="row valign-wrapper">
                <div class="col s1 ">
                    <blockquote class="color-green " style="border-radius: 5px;">
                        <img id="mdl_lec_img"  src="<?= base_url() ?>assets/img/profiles/profile-2.jpg" style="width: 60px;height: 60px; object-fit: cover;" class="circle ">
                    </blockquote>
                </div>
                <div class="col s6" style="margin-left: 5%;">
                    <div class="col s12" id="mdl_lec_div">
                        <h5 id="mdl_lec_name" style="margin: 0">Angelo Ganaden Jr</h5>
                        <h6 id="mdl_lec_id" style="margin: 0">201512103</h6>
                        <h6 id="mdl_lec_email" style="margin: 0">rbbabaran@gmail.com</h6>
                    </div>
                </div>
                <div class="col s5">
                    <span style="border-bottom: 3px solid #007A33; font-size:1.5rem">Expertise: </span>
                    <p id="mdl_lec_expertise">  CE graduate
                    </p>
                </div>
            </div>
            <div class="row">
                <h4 class="center" style="border-bottom: 3px solid #F2A900;">Feedbacks - <span><?= $t ?>T <?= $sy ?></span></h4>
                <table id="tbl-mdl-feedback">
                    <thead>
                        <th>Date</th>
                        <th>Message</th>
                    </thead>
                    <tbody id="mdl_lec_content">

                    </tbody>
                </table>
                <div id="msg_error_feedback"></div>
            </div>
        </div>
        <div class="modal-footer bg-primary-yellow">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Done</a>
        </div>
    </div>


    <!--====  End of Modal Lecturers Feedback  ====-->

    <?php else: ?>

        <div class="row ">
            <div class="col s2"></div>
            <div class="col s8 valign-wrapper">
                <div class="col s4 " style="padding-top: 15%">
                    <img src="<?= base_url() ?>assets/img/icons/tools.svg" alt="">
                </div>
                <div class="col s8">
                    <h1 class="center">Hi there!</h1>
                    <h3 class="center">It seems like there is no data yet in the system.</h3>
                    <br><br>
                    <center>
                        <a class="btn bg-primary-green waves-effect waves-light" href="<?= base_url() ?>importdata"><i class="material-icons right">cloud_upload</i>Populate</a>
                    </center>
                </div>
            </div>
            <div class="col s2"></div>
        </div>

    <?php endif ?>

    <script type="text/javascript">

        jQuery(document).ready(function ($) {
// fittext
jQuery("#mdl_lec_div").fitText();

        /*==============================
         =            Charts            =
         ==============================*/

         var ctx = document.getElementById('myChart').getContext('2d');
         $.ajax({
            url: base_url + 'Admin/charts_student',
            type: 'post',
            dataType: 'json',
            success: function (res) {
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ["Mechanical Engineering", "Civil Engineering", "Electrical Engineering", "Electronics and Communication Engineering"],
                        datasets: [{
                            backgroundColor: [
                            "#5A87FF",
                            "#f44336",
                            "#F2A900",
                            "#007A33",
                            ],
                            data: [res[0], res[1], res[2], res[3]]
                        }]
                    }
                });
            }

        });

         /*=====  End of Charts  ======*/


// show feedbacks
$(".btn_mdl_feedback").click(function (event) {
            // alert($(this).data('id'));
            $id = $(this).data('id');
            var html_content = "";
            $.ajax({
                url: '<?= base_url() ?>Admin/fetchLecturer',
                type: 'post',
                dataType: 'json',
                data: {id: $id},
                success: function (data) {
                    $("#mdl_lec_name").html(data.firstname + " " + data.midname + " " + data.lastname);
                    $("#mdl_lec_id").html(data.id_number);
                    $("#mdl_lec_email").html(data.email);
                    $("#mdl_lec_expertise").html(data.lecturer_expertise);
                    $('#mdl_lec_img').attr('src', base_url + data.image_path);

                    // second ajax
                    $.ajax({
                        url: '<?= base_url() ?>Admin/more_feedback',
                        type: 'post',
                        dataType: 'json',
                        data: {id: $id},
                        success: function (data) {
                            if (data != "false") {
                                $("#msg_error_feedback").html(" ");

                                for (var i = 0; i < data.length; i++) {
                                    html_content += ' <tr>' +
                                    '<td>' + data[i].date + '</td>' +
                                    '<td><blockquote>' + data[i].lecturer_feedback_comment + '</blockquote></td>' +
                                    '</tr>';
                                }
                                $("#mdl_lec_content").html(html_content);
                            } else {
                                $("#mdl_lec_content").html(" ");

                                $("#msg_error_feedback").html("<h3 class='center'>No Feedback Recorded Yet</h3>");
                            }
                        }
                    });
                }
            });


        });
        // oncheck fic status
        $(".chk_fic_status").change(function (event) {
            var value = $(this).prop("checked") ? 1 : 0;
            var str_val = $(this).prop("checked") ? "Active" : "Not Active";
            var id = $(this).data('id');
            // alert(value);
            $.ajax({
                url: '<?= base_url() ?>Admin/updateStatus',
                type: 'post',
                dataType: 'json',
                data: {
                    id: id,
                    val: value
                },
                success: function (data) {
                    $(".stat" + id).html(str_val);
                    if (value == 0) {
                        $(".stat" + id).removeClass('color-green');
                        $(".stat" + id).addClass('color-red');
                    } else {
                        $(".stat" + id).removeClass('color-red');
                        $(".stat" + id).addClass('color-green');
                    }

                    $toastContent = $('<span>FIC Status Updated</span>');
                    Materialize.toast($toastContent, 2000);
                }
            });
        });
        // oncheck prof status
        $(".chk_prof_status").change(function (event) {
            var value = $(this).prop("checked") ? 1 : 0;
            var str_val = $(this).prop("checked") ? "Active" : "Not Active";
            var id = $(this).data('id');
            // alert(value);
            $.ajax({
                url: '<?= base_url() ?>Admin/updateStatusProf',
                type: 'post',
                dataType: 'json',
                data: {
                    id: id,
                    val: value
                },
                success: function (data) {
                    $(".statProf" + id).html(str_val);
                    if (value == 0) {
                        $(".statProf" + id).removeClass('color-green');
                        $(".statProf" + id).addClass('color-red');
                    } else {
                        $(".statProf" + id).removeClass('color-red');
                        $(".statProf" + id).addClass('color-green');
                    }

                    $toastContent = $('<span>Professor Status Updated</span>');
                    Materialize.toast($toastContent, 2000);
                }
            });
        });



        $(".btn_modal_com").click(function (event) {
            $("#btn_modal_com_update").attr("data-id", $(this).attr("data-id"));
            $.ajax({
                url: '<?= base_url() ?>Admin/fetchOffering ',
                type: 'post',
                dataType: 'json',
                data: {id: $(this).attr("data-id")},
                success: function (data) {
                    $(".correl-code").val(data[0].course_course_code);
                    $(".correl-title").val(data[0].course_course_title);
                },
                error: function (data) {

                }
            });
        });
        $("#btn_modal_com_update").click(function (event) {
            $.ajax({
                url: '<?= base_url() ?>Admin/updateOffering ',
                type: 'post',
                dataType: 'json',
                data: {
                    id: $(this).attr("data-id"),
                    title: $(".correl-title").val(),
                    code: $(".correl-code").val(),
                },
                success: function (data) {
                    if (data) {
                        swal("Done!", "Successfully edited", "success").then(function () {
                            window.location.reload(true);
                        });
                    }
                },
                error: function (data) {

                }
            });
        });
        $(".btn_delete_com").click(function (event) {

            swal({
                title: "Are you sure?",
                text: "This may cause inconsistency of data in the system!",
                icon: "error",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "<?= base_url() ?>Admin/deleteOffering ",
                        type: "post",
                        dataType: "json",
                        data: {
                            id: $(this).attr("data-id")
                        },
                        success: function (data) {
                            swal("Poof! Offering has been deleted!", {
                                icon: "success",
                            }).then(function () {
                                window.location.reload(true);
                            });
                        },
                        error: function (data) {

                        }

                    });
                }
            });
        });
    });
function shorten_text(text, id) {
    var ret = text;
    if (ret.length > 20) {
        ret = ret.substr(0, 20 - 3) + "...";
    }

    $(".title_trunc" + id).html(ret);
}

</script>




