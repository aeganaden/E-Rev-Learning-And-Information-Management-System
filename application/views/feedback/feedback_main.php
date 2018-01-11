<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>

<!--====  End of Navigation Top  ====<--></-->
<?php $this->load->view('includes/home-sidenav'); ?>
<!--ABOVE IS PERMA-->
<div class="container">
    <?php if (!$lecturer): ?>
        <h1>Table is EMPTY</h1>
    <?php else: ?>
        <table class="striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Subject</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lecturer as $lecturer): ?>
                    <tr>
                        <td><?= $lecturer->lecturer_firstname ?> <?= $lecturer->lecturer_lastname ?></td>
                        <td><?= $lecturer->lecturer_expertise ?></td>
                        <td>
                            <a class="waves-effect waves-light btn light-green" onclick="window.location = '<?= base_url() ?>feedback/content/'<?= $lecturer->lecturer_id ?>">feedback</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif ?>
</div>