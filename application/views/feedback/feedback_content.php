<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>

<!--====  End of Navigation Top  ====<--></-->
<?php
$this->load->view('includes/home-sidenav');
?>
<!--ABOVE IS PERMA-->
<div class="row">
    <div class="col s2"></div>
    <div class="col s8">
        <blockquote class="color-primary-green">
            <h1 class="color-black">Feedback</h1>
        </blockquote>
    </div>
    <div class="col s2"></div>
</div>
<div class="container" style="height:80vh;">
    <div class="row" style="margin-top: 50px">
        <div class="col s3"></div>
        <div class="col s2">
            <img style="height:120px;width:120px;object-fit: cover;" class="circle responsive-img" src="<?= base_url() . $lect->image_path ?>">
        </div>
        <div class="col s5">
            <h4 class='black-text'><?= $lect->firstname ?> <?= $lect->midname ?> <?= $lect->lastname ?></h4>
            <br>
            <h5 class='black-text'>Expertise:<br><?= $lect->lecturer_expertise ?> </h5>
        </div>
        <div class="col s2"></div>
    </div>
    <form method="post" action="<?= base_url() ?>Feedback/submit/<?= $this->uri->segment(3) ?>">
        <div class="row" style="margin-top: -50px">
            <div class="col s3"></div>
            <div class="col s8">
                <div class="input-field col s12">
                    <textarea name="feedback_content" class="materialize-textarea" data-length="500" value="<?= set_value('feedback_content') ?>" maxlength="500" required></textarea>
                    <label for="textarea1">Write your feedback here</label>
                    <span class="red-text"><?php echo form_error('feedback_content'); ?></span>
                </div>
            </div>
            <div class="col s1"></div>
        </div>
        <center>
            <button class="btn waves-effect waves-light bg-primary-green" type="submit" style="margin-top:50px;">
                <i class="material-icons right ">send</i>
                Submit
            </button>
        </center>
    </form>
</div>