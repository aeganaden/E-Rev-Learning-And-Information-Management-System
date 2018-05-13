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
            <h4 class="color-black"><?= $section[0]->course_course_code . " - " . $section[0]->offering_name ?></h4>
            <h4 class="color-black">Section Details</h4>
            <a href="<?= base_url() ?>Sections/add_student/<?php echo $this->uri->segment(3); ?>" class="waves-effect waves-light btn">
                <i class="material-icons left">add</i>
                Add Student
            </a>
        </blockquote>
    </div>
    <div class="col s4"></div>
    <div class="col s4"></div>
</div>
<div class="row container">
    <a href="<?= base_url() ?>Sections/view_sections/<?= $this->uri->segment(3) ?>" class="waves-effect waves-light btn red"><i class="material-icons left">arrow_back</i>BACK</a>
    <pre>
        <?php // print_r($student); ?>
    </pre>
    <?php if (isset($student) && !empty($student)): ?>
        <table class="data-table responsive-table" id="tbl-feedback" style="table-layout:auto;">
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Course Title</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($student as $res): ?>
                    <tr class="bg-color-white">
                        <td><?= $res->student_num ?></td>
                        <td><?= $res->full_name ?></td>
                        <td><a data-id="<?= $res->student_num ?>" class="waves-effect waves-dark btn red btn_view">REMOVE</a></td>
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
            swal({
                title: "This student will be removed. Do you want to continue?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                closeOnClickOutside: true,
                closeOnEsc: true,
            }).then((willDelete) <?= "=>" ?> {
                if (willDelete) {
                    window.location.href = "<?= base_url() . "Sections/remove_student/" . $this->uri->segment(3) . "/" ?>" + $data;
                }
            }
            );
        });
    });
</script>