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
            <h3 class="color-black">Feedback</h3>
        </blockquote>
    </div>
    <div class="col s4"></div>
    <div class="col s4"></div>
</div>
<div class="row container" style="height:100vh;">
    <form method="post" action="<?= base_url() ?>feedback/">
        <div class="row">
            <div class="input-field col s6">
                <h5>Sections</h5>
                <select name="section">
                    <?php if (isset($sections) && !empty($sections)): ?>
                        <option value="all" selected>ALL</option>
                        <?php foreach ($sections as $section): ?>
                            <option value="<?= $section->offering_id ?>"><?= $section->offering_name ?></option>
                        <?php endforeach ?>
                    <?php else: ?>
                        <option value="" selected disabled>No sections.</option>
                    <?php endif; ?>
                </select>
            </div>
            <div class="input-field col s6">
                <h5>Lecturers</h5>
                <select name="lecturer">
                    <?php if (isset($lecturers) && !empty($lecturers)): ?>
                        <option value="all" selected>ALL</option>
                        <?php foreach ($lecturers as $lecturer): ?>
                            <option value="<?= $lecturer->lecturer_id ?>" data-icon="<?= base_url() . $lecturer->image_path ?>" class="left circle"><?= ucwords($lecturer->firstname . ' ' . $lecturer->midname . ' ' . $lecturer->lastname) ?></option>
                        <?php endforeach ?>
                    <?php else: ?>
                        <option value="" selected disabled>No lecturers.</option>
                    <?php endif; ?>
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

    <?php if (isset($feedback) && !empty($feedback)): ?>
        <table class="data-table" id="tbl-feedback" style="table-layout:auto;">
            <thead>
                <tr>
                    <th></th>
                    <th>Lecturer</th>
                    <th>Section</th>
                    <th>Feedback</th>
                    <th>Time/Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($feedback as $res): ?>
                    <tr class="bg-color-white">
                        <td><img style="object-fit: cover;height:50px;width:50px;" class="circle" src="<?= base_url() . $res->image_path ?>"></td>
                        <td><?= $res->lecturer_id ?></td>
                        <td><?= $res->offering_id ?></td>
                        <td><?= $res->lecturer_feedback_comment ?></td>
                        <td><?= date("M d, Y | h:i A", $res->lecturer_feedback_timedate) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php else: ?>
        <center style="margin-top:20vh;">
            <h3>No data to show</h3>
        </center>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <center style="margin-top:10vh;">
            <h3 class="color-red">Invalid input</h3>
        </center>
    <?php endif; ?>
</div>