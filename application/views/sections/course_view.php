<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>

<!--====  End of Navigation Top  ====<--></-->
<?php $this->load->view('includes/home-sidenav'); ?>
<!--ABOVE IS PERMA-->

<div class="row container">
    <div class="col s4">
        <blockquote class="color-primary-green">
            <h3 class="color-black">View Sections<a href="<?= base_url() ?>Sections/add/<?php echo $this->uri->segment(3); ?>" class="waves-effect waves-light btn"><i class="material-icons left">add</i>Add Section</a></h3>
        </blockquote>
    </div>
    <div class="col s4"></div>
    <div class="col s4"></div>
</div>
<div class="row container">
    <a href="<?= base_url() ?>Sections" class="waves-effect waves-light btn red"><i class="material-icons left">arrow_back</i>BACK</a>
    <pre>
        <?php // print_r($course); ?>
    </pre>
    <center><h5><?= $course[0]->course_course_title ?> (<?= $course[0]->course_course_code ?>)</h5></center>
    <br>
    <?php
    echo "<h6>" . $subject_year_course[0]->year_level_name . ":</h6>";
    foreach ($subject_year_course as $syc) {
        echo "<h6>—" . $syc->subject_list_name . "</h6>";
    }
    ?>
    <br>
    <?php if (isset($offering) && !empty($offering)): ?>
        <table class="data-table responsive-table" id="tbl-feedback" style="table-layout:auto;">
            <thead>
                <tr>
                    <th>Section</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($offering as $key => $res): ?>
                    <tr class="bg-color-white">
                        <td><?= $res->offering_name ?></td>
                        <td><a data-id="<?= $res->offering_id ?>" class="waves-effect waves-dark btn bg-primary-green btn_view">View</a></td>
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

<script>
    $(document).ready(function () {
        $(".btn_view").click(function () {
            $data = $(this).data('id');
            window.location.href = "<?= base_url() . "Sections/section_detail/" ?>" + $data;
        });

    });

</script>