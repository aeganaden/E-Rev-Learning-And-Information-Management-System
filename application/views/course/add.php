<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>

<!--====  End of Navigation Top  ====<-->
<?php $this->load->view('includes/home-sidenav'); ?>
<!--ABOVE IS PERMA-->

<div class="row container">
    <div class=" col s12 col m4">
        <blockquote class="color-primary-green">
            <h3 class="color-black">Add Course</h3>
        </blockquote>
    </div>
    <div class=" col s12 col m4"></div>
    <div class=" col s12 col m4"></div>
</div>
<div class="row container">
    <pre>
        <?php // print_r($course2); ?>
    </pre>
    <div class="row">
        <form action="<?= base_url() . "Course/add/" . $this->uri->segment(3) ?>" method="POST" class=" col s12 col m12">
            <blockquote class="color-red">
                <?php if (isset($error_message)): ?>
                    <h6><b>ERROR:</b></h6>
                    <?php foreach ($error_message as $err): ?>
                        <h6 class="color-red">
                            <?php echo $err; ?>
                        </h6>
                    <?php endforeach; ?>
                <?php endif; ?>
            </blockquote>
            <div class="row">
                <div class="input-field  col s12 col m6">
                    <?php if (!empty(form_error('course_code'))): ?>
                        <label class="red-text" for="course_code">Course Code</label>
                        <input style="border-bottom: 1px solid #e24646;box-shadow: none;" name="course_code" value="<?= set_value('course_code') ?>" type="text">
                        <span class="red-text"><?php echo form_error('course_code'); ?></span>
                    <?php else: ?>
                        <label for="course_code">Course Code</label>
                        <input name="course_code" value="<?= set_value('course_code') ?>" type="text">
                    <?php endif; ?>
                </div>
                <div class="input-field  col s12 col m6">
                    <?php if (!empty(form_error('course_title'))): ?>
                        <label class="red-text" for="course_title">Course Title</label>
                        <input style="border-bottom: 1px solid #e24646;box-shadow: none;" name="course_title" value="<?= set_value('course_title') ?>" type="text">
                        <span class="red-text"><?php echo form_error('course_title'); ?></span>
                    <?php else: ?>
                        <label for="course_title">Course Title</label>
                        <input name="course_title" value="<?= set_value('course_title') ?>" type="text">
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="input-field  col s12 col m12">
                    <select name="subject-area">
                        <?php foreach ($hold as $key => $value): ?>
                            <option value="<?= $key ?>"><?php echo $value[1]["year_level_name"] . ": " . implode("|", $value[0]); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Year Level</label>
                </div>
            </div>
            <div class="input-field">
                <button class="btn waves-effect waves-light right green" type="submit" name="submit">Add</button>
                <a href="<?= base_url() ?>Course" class="waves-effect waves-light btn left red">Cancel</a>
            </div>
        </form>
    </div>
</div>

