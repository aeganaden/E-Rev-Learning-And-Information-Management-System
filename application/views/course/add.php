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
            <h3 class="color-black">Add Course</h3>
        </blockquote>
    </div>
    <div class="col s4"></div>
    <div class="col s4"></div>
</div>
<div class="row container">
    <pre>
        <?php // print_r($hold); ?>
    </pre>
    <?php // echo form_open('form');   ?>
    <div class="row">
        <form action="" method="POST" class="col s12">
            <div class="row">
                <div class="input-field col s6">
                    <?php if (!empty(form_error('course_code'))): ?>
                        <label class="red-text" for="course_code">Course Code</label>
                        <input style="border-bottom: 1px solid #e24646;box-shadow: none;" name="course_code" value="<?= set_value('course_code') ?>" type="text">
                        <span class="red-text"><?php echo form_error('course_code'); ?></span>
                    <?php else: ?>
                        <label for="course_code">Course Code</label>
                        <input name="course_code" value="<?= set_value('course_code') ?>" type="text">
                    <?php endif; ?>
                </div>
                <div class="input-field col s6">
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
                <div class="input-field col s12">
                    <select name="subject-area">
                        <?php
                        foreach ($hold as $key => $value):
                            ?>
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

