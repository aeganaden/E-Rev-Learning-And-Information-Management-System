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
            <h3 class="color-black">Course Management <br><a href="<?= base_url() ?>Course/add" class="waves-effect waves-dark btn bg-primary-green"><i class="material-icons left">add</i>Add Course</a></h3>
        </blockquote>
    </div>
</div>
<div class="row container">

    <?php if (isset($result) && !empty($result)): ?>
        <table class="data-table" id="tbl-feedback">
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Course Title</th>
                    <th>Actions</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $key => $res): ?>
                    <tr class="bg-color-white">
                        <td><?= $res->course_course_code ?></td>
                        <td><?= $res->course_course_title ?></td>
                        <td><a data-id="<?= $res->course_id_sha ?>" class="waves-effect waves-dark btn bg-primary-green btn_view">View</a></td>
                        <td><a data-id="<?= $res->course_id_sha ?>" class="waves-effect waves-dark btn bg-primary-yellow btn_edit">Edit</a></td>
                        <?php if ($res->course_is_active == 1): ?>
                            <td><a data-id="<?= $res->course_id_sha ?>" class="waves-effect waves-dark btn red btn_delete">Delete</a></td>
                        <?php else: ?>
                            <td><a data-id="<?= $res->course_id_sha ?>" class="waves-effect waves-dark btn red btn_undo">Undo</a></td>
                        <?php endif; ?>
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
            swal({
                title: "Are you sure?",
                text: "This will disable the course you selected. You may undo it later.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) <?= "=>" ?>{
                if (willDelete) {
                    $data = $(this).data('id');
                    window.location.href = "<?= base_url() . "Course/delete/" ?>" + $data + "/0";
                }
            });
        });
        $(".btn_undo").click(function () {
            swal({
                title: "Are you sure?",
                text: "This will activate the course you selected.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete)<?= "=>" ?>{
                if (willDelete) {
                    $data = $(this).data('id');
                    window.location.href = "<?= base_url() . "Course/delete/" ?>" + $data + "/1";
                }
            });
        });
    });

</script>