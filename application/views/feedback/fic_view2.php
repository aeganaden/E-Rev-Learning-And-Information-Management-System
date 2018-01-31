<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>

<!--====  End of Navigation Top  ====<--></-->
<?php $this->load->view('includes/home-sidenav'); ?>
<!--ABOVE IS PERMA-->

<div class="row">
    <div class="col s4">
        <blockquote class="color-primary-green">
            <h1 class="color-black">Feedback</h1>
        </blockquote>
    </div>
    <div class="col s4"></div>
    <div class="col s4"></div>
</div>
<div class="container">
    <form method="post" action="<?= base_url() ?>feedback/content">
        <div class="row">
            <div class="input-field col s6">
                <select name="section">
                    <option value="" disabled selected>Section</option>
                    <?php foreach ($sections as $section): ?>
                        <option value="<?= $section->offering_name ?>"><?= $section->offering_name ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="input-field col s6">
                <select name="section">
                    <option value="" disabled selected>Lecturer</option>
                    <?php foreach ($lecturers as $lecturer): ?>
                        <option value="<?= $lecturer->lecturer_id ?>" data-icon="<?= $lecturer->image_path ?>" class="left circle"><?= ucwords($lecturer->firstname . ' ' . $lecturer->midname . ' ' . $lecturer->lastname) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="center-align">
            <button class="btn waves-effect waves-light" type="submit" name="action">
                Show Feedback
                <i class="material-icons right">send</i>
            </button>
        </div>
    </form>

    <?php
    if (isset($feedback)) {
        echo $feedback;
    }
    ?>
</div>