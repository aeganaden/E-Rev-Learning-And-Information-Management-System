<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>

<!--====  End of Navigation Top  ====<--></-->
<?php $this->load->view('includes/home-sidenav'); ?>
<!--ABOVE IS PERMA-->
<div class="container">
    <?php if (empty($lect)): ?>
        <h4 id="message_area" class="center-align" style="margin-top: 20vh;">No list of lecturers to be show<br>(Feedback is not activated)</h4>
    <?php else: ?>
        <table class="striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Topic</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lect as $hold): ?>
                    <tr>
                        <td><?= $hold->firstname ?> <?= $hold->lastname ?></td>
                        <td><?= $hold->topic ?></td>
                        <td>
                            <?php if ($hold->sent_feedback == 1): ?>
                                <a class="waves-effect waves-light btn light-green" disabled>feedback</a>
                            <?php else: ?>
                                <a class="waves-effect waves-light btn light-green" onclick="window.location = '<?= base_url() ?>feedback/content/<?= $hold->lecturer_id ?>'">feedback</a>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif ?>
</div>