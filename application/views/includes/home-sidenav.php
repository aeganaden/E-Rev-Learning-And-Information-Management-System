
<!--======================================
=            Side-Nav Section            =
=======================================-->

<?php
$ident = $info['identifier'];
$ident.="_department";
$program = "";

switch ($info['user']->$ident) {
    case 'CE':
    $program = "Civil Engineering";
    break;
    case 'EE':
    $program = "Electrical Engineering";
    break;
    case 'ECE':
    $program = "Electronics and Electrical Engineering";
    break;
    case 'ME':
    $program = "Mechanical Engineering";
    break;

    default:
# code...
    break;
}
// echo "<pre>";
// print_r($info);
?>

<ul id="slide-out" class="side-nav bg-color-white ">
    <li>
        <div class="user-view">
            <div class="background" style="background-color: #F2A900">

            </div>
            <div class="row valign-wrapper" style="margin-bottom: 0px !important">
                <div class="col s2">
                    <div class="row" style="margin-bottom: 0 !important">
                        <a href="#!user"><img style=" object-fit: cover;" class="circle" src="<?= base_url() ?>assets/img/profiles/profile.jpg "></a>
                    </div>
                </div>
                <div class="col s2"></div>
                <div class="col s8">
                    <div class="row " style="margin-bottom: 0 !important">
                        <h5><span class="color-black"><?= ucwords($info["user"]->firstname) . " " . ucwords($info["user"]->lastname) ?></span></h5>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 0px !important">
                <blockquote class="color-primary-green">
                    <h5 class="color-black"><?= $info["identifier"] != 'fic' ? strtoupper($info["identifier"]) : "FACULTY IN CHARGE" ?></h5>
                </blockquote>
            </div>

            <div class="row" style="margin-top: 0px !important; border-bottom: 2px solid #007A33;">

            </div>
            <div class="row">
                <?php
                if ($info['identifier'] != "professor" && $info['identifier'] != "fic") {
                    $section = $this->Crud_model->fetch("offering", array("offering_id" => $info['user']->offering_id));
                    $section = $section[0];
                }
                ?>
                <blockquote class="color-primary-green" style="margin: 0">
                    <h5 class="color-black" >ABOUT</h5>
                </blockquote>
                <h6  style="text-transform: capitalize; margin: 0; margin-left: 10%;" class="color-black valign-wrapper" ><i class="material-icons color-primary-green">chevron_right</i><?= $program ?></h6>
                <?php if ($info['identifier'] != "professor" && $info['identifier'] != "fic"): ?>
                    <h6  style="text-transform: capitalize; margin: 0; margin-left: 10%;" class="color-black valign-wrapper" ><i class="material-icons color-primary-green">chevron_right</i><?= $section->offering_name ?></h6>
                <?php endif ?>

            </div>
            <div class="row">
                <!-- <a href="#!email"><span class="color-black"><?= $info["user"]->email ?></span></a> -->
            </div>
        </div>
    </li>

    <li class="<?= $s_h ?>">
        <a clas href="<?= base_url() ?>Home" class="color-black"><i class="material-icons color-black">home</i>Home</a> <!--mark - naglagay-->
    </li>
    <?php if ($info["identifier"] == "fic"): ?>
        <li class="color-black <?= $s_a ?>">
            <a href="<?= base_url() ?>Home/Activity" class="color-black"><i class="material-icons color-black">remove_from_queue</i>Activity</a>
        </li>
    <?php endif ?>

    <?php if ($info["identifier"] == "student"): ?>
        <li class="color-black">
            <a href="<?= base_url() ?>CourseModules" class="color-black"><i class="material-icons color-black">import_contacts</i>Course Modules</a>
        </li>
    <?php endif ?>
    <?php if ($info["identifier"] == "fic" || $info["identifier"] == "professor"): ?>
        <li class="color-black">
            <a href="<?= base_url() ?>ManageCourseModules" class="color-black"><i class="material-icons color-black">import_contacts</i>Manage Course Modules</a>
        </li>
    <?php endif ?>

    <?php if ($info["identifier"] == "student"): ?>
        <?php if ($info['user']->student_is_blocked == 1): ?>
            <li class="color-black <?= $s_c ?> tooltipped" data-position="right" data-tooltip="Must take remedial courses first before unlocking this.">
                <a href="" class="color-black subheader grey color-grey">
                    <i class="material-icons color-grey">not_interested</i>Practice Exams
                </a>
            </li>
        <?php else: ?>
            <li class="color-black <?= $s_c ?>">
                <a href="<?= base_url() ?>Coursewares" class="color-black "><i class="material-icons color-black">book</i>Practice Exams</a>
            </li>
        <?php endif ?>

    <?php endif ?>

    <?php if ($info['identifier'] == "student" && $info['user']->student_is_blocked == 1): ?>
        <li class="<?= $s_rc ?>">
            <a href="<?= base_url() ?>RemedialCoursewares" class=" color-black"><i class="material-icons color-black">book</i>Remedial Practice Exams</a> <!--mark - naglagay-->
        </li>
    <?php endif ?>



    <?php if ($info["identifier"] == "professor"): ?>
        <li class="color-black <?= $s_s ?>">
            <a href="<?= base_url() ?>SubjectArea" class="color-black"><i class="material-icons color-black">assignment</i>Subject Area/Topics</a>
        </li>
    <?php endif ?>

    <?php if ($info['identifier'] != "professor"): ?>
        <li class="<?= $s_f ?>">
            <a href="<?= base_url() ?>Feedback" class=" color-black"><i class="material-icons color-black">feedback</i>Feedback</a> <!--mark - naglagay-->
        </li>
    <?php endif ?>

    <?php if ($info['identifier'] == "student"): ?>
        <li class="<?= $s_ga ?>">
            <a href="<?= base_url() ?>GradeAssessment " class="color-black "><i class="material-icons color-black">assessment</i>Grade Assessment</a> <!--mark - naglagay-->
        </li>
    <?php endif ?>


    <?php if ($info["identifier"] == "professor"): ?>
        <li class="color-black <?= $s_co ?>">
            <a href="<?= base_url() ?>Course" class="color-black"><i class="material-icons color-black">format_list_bulleted</i>Courses</a>
        </li>
    <?php endif ?>

    <li>
        <div class="divider"></div>
    </li>

    <?php if ($info["identifier"] == "fic"): ?>
        <li class="no-padding <?= $s_t ?> <?= $s_s ?>"  id="btn_click_feed">
            <ul class="collapsible collapsible-accordion">
                <li>
                    <a class="collapsible-header">Initial Setup<i class="material-icons" id="btn_click_feed_i"  >keyboard_arrow_right</i></a>
                    <div class="collapsible-body bg-color-white">
                        <ul>
                            <?php if ($info["identifier"] == "fic"): ?>
                                <li class="color-black <?= $s_t ?>">
                                    <a href="<?= base_url() ?>Topics" class="color-black"><i class="material-icons color-black">title</i>Topics</a>
                                </li>
                            <?php endif ?>
                            <?php if ($info['identifier'] == "fic"): ?>
                                <li class="<?= $s_f ?>">
                                    <a href="<?= base_url() ?>Sections" class=" color-black"><i class="material-icons color-black">format_list_bulleted</i>Sections</a> <!--mark - naglagay-->
                                </li>
                            <?php endif ?>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
    <?php endif; ?>

    <?php if ($info["identifier"] == "professor"): ?>
        <li class="no-padding <?= $s_f ?>"  id="btn_click_feed">
            <ul class="collapsible collapsible-accordion">
                <li>
                    <a class="collapsible-header">Feedback<i class="material-icons" id="btn_click_feed_i"  >keyboard_arrow_right</i></a>
                    <div class="collapsible-body bg-color-white">
                        <ul>
                            <li><a href="<?= base_url() ?>Feedback "><i class="material-icons">visibility</i>View Feedback</a></li>
                            <li>
                                <a href="<?= base_url() ?>Feedback/activateFeedback">
                                    <i class="material-icons">hdr_strong</i>Toggle Feedback Submission
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
    <?php endif ?>
    <?php if ($info["identifier"] == "fic"): ?>
        <li class="no-padding <?= $s_c ?> " id="btn_click_feed_ss">
            <ul class="collapsible collapsible-accordion">
                <li>
                    <a class="collapsible-header">Practice Exams<i class="material-icons" id="btn_click_feed_i_ss">keyboard_arrow_right</i></a>
                    <div class="collapsible-body bg-color-white">
                        <ul>
                            <li class="color-black ">
                                <a href="<?= base_url() ?>Coursewares_fic" class="color-black"><i class="material-icons color-black">book</i>Practice Exams</a>
                            </li>
                            <li>
                                <a href="<?= base_url() ?>Coursewares_fic/ToggleCourseware">
                                    <i class="material-icons">hdr_strong</i>Toggle Practice Exams
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url() ?>ImportQuestions">
                                    <i class="material-icons">backup</i>Import Questions
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
    <?php endif ?>

    <?php if ($info["identifier"] == "fic"): ?>
        <li class="no-padding <?= $s_ss ?>"  id="btn_click_feed">
            <ul class="collapsible collapsible-accordion">
                <li>
                    <a class="collapsible-header">Student Scores<i class="material-icons" id="btn_click_feed_i">keyboard_arrow_right</i></a>
                    <div class="collapsible-body bg-color-white">
                        <ul>
                            <li class="color-black ">
                                <a href="<?= base_url() ?>Student_scores" class="color-black"><i class="material-icons color-black">description</i>Import Scores</a>
                            </li>
                            <li class="color-black ">
                                <a href="<?= base_url() ?>Student_scores/view_scores" class="color-black"><i class="material-icons color-black">remove_red_eye</i>View Scores</a>
                            </li>
                        </div>
                    </li>
                </ul>
            </li>
        <?php endif ?>

        <li>
            <div class="divider"></div>
        </li>
        <li>
            <a class="waves-effect color-black" href="<?= base_url() ?>Login/logout ">Log Out</a>
        </li>
    </ul>


    <!--====  End of Side-Nav Section  ====-->



    <script type="text/javascript">

        jQuery(document).ready(function ($) {

            $("#btn_click_feed").click(function (event) {
                if ($("#btn_click_feed_i").html() == "keyboard_arrow_right") {
                    $("#btn_click_feed_i").html("keyboard_arrow_down");
                } else {
                    $("#btn_click_feed_i").html("keyboard_arrow_right");
                }
            });
            $("#btn_click_feed_ss").click(function (event) {
                if ($("#btn_click_feed_i_ss").html() == "keyboard_arrow_right") {
                    $("#btn_click_feed_i_ss").html("keyboard_arrow_down");
                } else {
                    $("#btn_click_feed_i_ss").html("keyboard_arrow_right");
                }
            });
        });
    </script>
