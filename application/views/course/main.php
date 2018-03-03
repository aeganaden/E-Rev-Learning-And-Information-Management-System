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
            <h3 class="color-black">Course Management <a href="<?= base_url() ?>course/add" class="waves-effect waves-light btn"><i class="material-icons left">add</i>Add Course</a></h3>
        </blockquote>
    </div>
    <div class="col s4"></div>
    <div class="col s4"></div>
</div>
<div class="row container">
    <pre>
        <?php // print_r($result); ?>
    </pre>

    <?php // echo '<script>alert("Successful insertion");</script>';        //LAST LAST ?>
    <?php if (isset($result) && !empty($result)): ?>
        <table class="data-table responsive-table" id="tbl-feedback" style="table-layout:auto;">
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Course Title</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $key => $res): ?>
                    <tr class="bg-color-white">
                        <td><?= $res->course_course_code ?></td>
                        <td><?= $res->course_course_title ?></td>
                        <td><a data-id="<?= $res->course_id_sha ?>" class="waves-effect waves-dark btn green btn_view">View</a></td>
                        <td><a data-id="<?= $res->course_id_sha ?>" class="waves-effect waves-dark btn yellow btn_edit">Edit</a></td>
                        <td><a data-id="<?= $res->course_id_sha ?>" class="waves-effect waves-dark btn red btn_delete">Delete</a></td>
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
            window.location.href = "<?= base_url() . "Course/view/" ?>" + $data;
        });
        $(".btn_edit").click(function () {
            $data = $(this).data('id');
            window.location.href = "<?= base_url() . "Course/edit/" ?>" + $data;
        });
        $(".btn_delete").click(function () {
            $data = $(this).data('id');
            window.location.href = "<?= base_url() . "Course/view/" ?>" + $data;
        });
    });
</script>