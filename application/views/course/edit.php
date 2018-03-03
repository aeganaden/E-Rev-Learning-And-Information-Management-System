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
            <h3 class="color-black">Edit Course</h3>
        </blockquote>
    </div>
    <div class="col s4"></div>
    <div class="col s4"></div>
</div>
<div class="row container">
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
            <div class="input-field">
                <button class="btn waves-effect waves-light right green" type="submit" name="submit">Submit</button>
                <a href="<?= base_url() ?>Course" class="waves-effect waves-light btn left red">Cancel</a>
            </div>
        </form>
    </div>
</div>

