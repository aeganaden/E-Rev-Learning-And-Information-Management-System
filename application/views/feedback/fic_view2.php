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
    <form method="post" action="<?= base_url() ?>feedback/">
        <div class="row">
            <div class="input-field col s6">
                <h5>Sections</h5>
                <select name="section">
                    <option value="all" selected>ALL</option>
                    <?php foreach ($sections as $section): ?>
                        <option value="<?= $section->offering_id ?>"><?= $section->offering_name ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="input-field col s6">
                <h5>Lecturers</h5>
                <select name="lecturer">
                    <option value="all" selected>ALL</option>
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

    <?php if (isset($feedback)): ?>
        <table class="striped" id="tbl-feedback" style="table-layout:auto;">
            <thead>
                <tr>
                    <th>Time/Date</th>
                    <th>Feedback</th>
                    <th>Lect id</th>
                    <th>offer_id</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($feedback as $res): ?>
                    <tr>
                        <td><?= date("M d, Y | h:i A", $res->lecturer_feedback_timedate) ?></td>
                        <td><?= $res->lecturer_feedback_comment ?></td>
                        <td><?= $res->lecturer_id ?></td>
                        <td><?= $res->offering_id ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <center style="margin-top:10vh;">
            <h3 class="color-red">Invalid input</h3>
        </center>
    <?php endif; ?>
</div>