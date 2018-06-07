<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>

<!--====  End of Navigation Top  ====<--></-->
<?php $this->load->view('includes/home-sidenav'); ?>
<!--ABOVE IS PERMA-->

<div class="row container">
    <div class=" col s12">
        <blockquote class="color-primary-green">
            <h3 class="color-black">View Course</h3>
        </blockquote>
    </div>
</div>
<div class="row container" style="margin-bottom: 100px;">
    <a onclick="window.location.replace('<?= base_url() ?>Course');" class="waves-effect waves-light btn red"><i class="material-icons left">keyboard_backspace</i>Back</a>
    <pre>
        <?php // print_r($subject_year_course); ?>
    </pre>
    <center><h4><?= $course_title ?> (<?= $course_code ?>)</h4></center>
    <br>
    <?php
    echo "<h5>" . $subject_year_course[0]->year_level_name . ":</h5>";
    foreach ($subject_year_course as $syc) {
        echo "<h5>—" . $syc->subject_list_name . "</h5>";
    }
    ?>
    <br>
    <?php if (isset($result) && !empty($result)): ?>
        <table class="data-table responsive-table" id="tbl-course-view" style="table-layout:auto;">
            <thead>
                <tr>
                    <th>Section</th>
                    <th>Time</th>
                    <th>Day</th>
                    <th>Venue</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $key => $res): ?>
                    <tr class="bg-color-white">
                        <td><?= $res->offering_name ?></td>
                        <td><?= $res->format_time ?></td>
                        <td><?= $res->format_day ?></td>
                        <td><?= $res->schedule_venue ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

    <?php else: ?>
        <center style="margin-top:20vh;">
            <h3>No data to show</h3>
        </center>
    <?php endif; ?>
</div>
