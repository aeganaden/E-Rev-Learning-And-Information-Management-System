<?php date_default_timezone_set("Asia/Manila"); ?>
<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>

<!--====  End of Navigation Top  ====<-->
<?php $this->load->view('includes/home-sidenav'); ?>
<!--ABOVE IS PERMA-->

<div class="row container">
    <div class="col s4">
        <blockquote class="color-primary-green">
            <h3 class="color-black">Add Section</h3>
        </blockquote>
    </div>
    <div class="col s4"></div>
    <div class="col s4"></div>
</div>
<div class="row container">
    <pre>
        <?php // print_r($course2); ?>
    </pre>
    <center><h4><?= $course2[0]->course_course_title ?> (<?= $course2[0]->course_course_code ?>)</h4></center>
    <br>
    <?php
    echo "<h5>" . $subject_year_course[0]->year_level_name . ":</h5>";
    foreach ($subject_year_course as $syc) {
        echo "<h5>—" . $syc->subject_list_name . "</h5>";
    }
    ?>
    <br>
    <div class="row">
        <form enctype="multipart/form-data" action="<?= base_url() . "Sections/add/" . $this->uri->segment(3) ?>" method="POST" class="col s12">
            <blockquote class="color-red">
                <?php if (isset($_POST["submit"])): ?>
                    <?php if (isset($error_message)): ?>
                        <h6><b>ERROR:</b></h6>
                        <?php foreach ($error_message as $err): ?>
                            <h6 class="color-red">
                                <?php echo $err; ?>
                            </h6>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </blockquote>
            <div class="row">
                <div class="input-field col s12">
                    <?php if (!empty(form_error('section_name'))): ?>
                        <label class="red-text" for="section_name">Course Code</label>
                        <input style="border-bottom: 1px solid #e24646;box-shadow: none;" name="section_name" value="<?= set_value('section_name') ?>" type="text">
                        <span class="red-text"><?php echo form_error('section_name'); ?></span>
                    <?php else: ?>
                        <label for="section_name">Section Name</label>
                        <input name="section_name" value="<?= set_value('section_name') ?>" type="text">
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="file-field input-field s12">
                    <?php if ("" == form_error('excel') && !empty(form_error('excel'))): ?>
                        <div class="btn">
                            <span>File</span>
                            <input type="file" id="input_excel" name="excel_file" value="<?= set_value('excel_file') ?>" required>
                        </div>
                        <div class="file-path-wrapper">
                            <input style="border-bottom: 1px solid #e24646;box-shadow: none;" class="file-path validate" type="text" name="excel_text" value="<?= set_value('excel_text') ?>" required>
                        </div>
                        <span class="red-text"><?php echo form_error('excel_text'); ?></span>
                    <?php else: ?>
                        <div class="btn">
                            <span>File</span>
                            <input type="file" id="input_excel" name="excel_file" value="<?= set_value('excel_file') ?>" required>
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" name="excel_text" required>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <select name ="lect_id">
                        <?php foreach ($lecturer as $lect): ?>
                            <option value="<?php echo $lect->lecturer_id; ?>"><?= $lect->firstname . " " . $lect->midname . " " . $lect->lastname ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Lecturers</label>
                </div>
            </div>
            <div class="input-field">
                <button class="btn waves-effect waves-light right green" type="submit" name="submit">Add</button>
                <a href="<?= base_url() ?>Sections" class="waves-effect waves-light btn left red">Cancel</a>
            </div>
        </form>
    </div>
</div>

