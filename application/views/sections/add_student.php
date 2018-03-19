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
            <h4 class="color-black">Add Student</h4>
        </blockquote>
    </div>
    <div class="col s4"></div>
    <div class="col s4"></div>
</div>
<div class="row container">
    <a href="<?= base_url() ?>Sections/section_detail/<?= $this->uri->segment(3) ?>" class="waves-effect waves-light btn red"><i class="material-icons left">arrow_back</i>BACK</a>
    <pre>
        <?php // print_r($not_enrolled); ?>
    </pre>
    <blockquote class="color-red">
        <?php if (isset($error_message) && !empty($error_message)): ?>
            <h6><b>ERROR:</b></h6>
            <?php foreach ($error_message as $err): ?>
                <h6 class="color-red">
                    <?php echo $err; ?>
                </h6>
            <?php endforeach; ?>
        <?php endif; ?>
    </blockquote>
    <div class="row">
        <center>
            <h4>Upload set of students using excel</h4>
            <h5>(Addition by batch)</h5>
        </center>
    </div>
    <form enctype="multipart/form-data" action="<?= base_url() . "Sections/add_student_process_by_batch/" . $this->uri->segment(3) ?>" method="POST">
        <div class="row">
            <div class="file-field input-field s12">
                <div class="btn">
                    <span>Choose</span>
                    <input type="file" id="input_excel" name="excel_file" required>
                </div>
                <div class="file-path-wrapper">
                    <input placeholder="Choose excel file" class="file-path validate" type="text" name="excel_text" required>
                </div>
            </div>
        </div>
        <div class="input-field">
            <button class="btn waves-effect waves-light right green" type="submit" name="submit">Upload</button>
        </div>
    </form>
    <br><br><br><br>
    <div class="row">
        <center>
            <h4>List of unenrolled students</h4>
            <h5>(Addition individually)</h5>
        </center>
    </div>
    <?php if (isset($not_enrolled) && !empty($not_enrolled)): ?>
        <table class="data-table responsive-table" id="tbl-feedback" style="table-layout:auto;">
            <thead>
                <tr>
                    <th>Student Number</th>
                    <th>Full Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($not_enrolled as $val): ?>
                    <tr class="bg-color-white">
                        <td><?= $val->student_id ?></td>
                        <td><?= $val->full_name ?></td>
                        <td><a data-id="<?= $val->student_id ?>" class="waves-effect waves-dark btn green btn_view">ADD</a></td>
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
            title: "This student will be added to <?= $section[0]->offering_name ?>. Do you want to proceed?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    closeOnClickOutside: false,
                    closeOnEsc: false,
            }).then((willDelete) <?= "=>" ?> {
            if (willDelete) {
                window.location.href = "<?= base_url() . "Sections/add_student_process_by_one/" . $this->uri->segment(3) . "/" ?>" + $data;
            }
        }
        );
    });
    });
</script>