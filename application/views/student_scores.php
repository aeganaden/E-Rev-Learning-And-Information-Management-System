<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>


<div class="container row">
    <div class="col s1"></div>
    <div class="col s11">
        <div class="row">
            <blockquote class="color-primary-green">
                <h5 class="color-black">Import Student Scores</h5>
            </blockquote>
        </div>
        <?php
        $course = $this->Crud_model->fetch("course", array("course_department" => $info['user']->fic_department));
        // echo $info['user']->$ident;
        // echo "<pre>";
        // print_r($course);
        $count = 1;
        ?>
        <?php if ($course): ?>
            <?php foreach ($course as $key => $value): ?>
                <?php if ($count == 3): ?><?= "<div class='row'>" ?><?php endif ?>
                    <div class="col s12 m4" >
                        <div class="row">
                            <div class="col s12">
                                <div class="card bg-primary-green">
                                    <div class="card-content white-text">
                                        <span class="card-title"><?= $value->course_course_code ?></span>
                                        <p><?= $value->course_course_title ?>.</p>
                                    </div>
                                    <div class="card-action ">
                                        <a href="<?= base_url() ?>Student_scores/importData/<?= $value->course_id ?>" class="valign-wrapper">Multiple Topics</a>
                                        <a href="<?= base_url() ?>Student_scores/importDataSpecific/<?= $value->course_id ?>" class="valign-wrapper">Specific Topics</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($count == 3): ?><?= "</div>" ?><?php endif ?>
                    <?php $count++; ?>
                <?php endforeach ?>
            <?php else: ?>
                <?php
                $data = array(
                    "message_l" => "no courses avaiable",
                    "message_r" => ""
                );
                ?>
                <?php $this->load->view('chibi/err-sad', array("data" => $data), FALSE); ?>
            <?php endif ?>
        </div>
    </div>