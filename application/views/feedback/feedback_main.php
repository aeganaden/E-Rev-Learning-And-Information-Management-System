<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>

<!--====  End of Navigation Top  ====<--></-->
<?php $this->load->view('includes/home-sidenav'); ?>
<!--ABOVE IS PERMA-->

<div class="row container">
    <div class="col s1"></div>
    <div class="col s7">
        <blockquote class="color-primary-green">
            <h3 class="color-black">Feedback</h3>
        </blockquote>
    </div>
    <div class="col s4"></div>
</div>

<div class="row container">
    <div class="col s1"></div>
    <div class="col s11">
        <div class="row">
            <?php if (empty($lect)): ?>
                <h4 id="message_area" class="center-align" style="margin-top: 20vh;">No list of lecturers to be show<br>(Feedback is not activated or inactive enrollment)</h4>
            <?php else: ?>
                <?php if ($lect == "no lect"): ?>
                    <h4 id="message_area" class="center-align" style="margin-top: 20vh;">No list of lecturers to be show</h4>
                <?php else: ?>
                    <table >
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Subject Area</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lect as $hold): ?>
                                <tr class="bg-color-white">
                                    <td><?= $hold->firstname ?> <?= $hold->lastname ?></td>
                                    <td><?= $hold->topic ?></td>
                                    <td>
                                        <?php if ($hold->sent_feedback == 1): ?>
                                            <a class="waves-effect waves-light btn bg-primary-green" disabled>feedback</a>
                                        <?php else: ?>
                                            <a class="waves-effect waves-light btn bg-primary-green" onclick="window.location = '<?= base_url() ?>feedback/content/<?= $hold->lecturer_id ?>'">feedback</a>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
