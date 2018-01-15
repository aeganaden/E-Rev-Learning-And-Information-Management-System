<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>

<!--====  End of Navigation Top  ====<--></-->
<?php $this->load->view('includes/home-sidenav'); ?>
<!--ABOVE IS PERMA-->
<div class="container">
    <?php if (empty($info)): ?>
        <h1 class="center-align">Table is EMPTY</h1>
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
                <?php /* foreach ($info["user"] as $key => $value): */ ?>
                <tr>
                    <td><?= $info["user"]->firstname ?> <?= $info["user"]->lastname ?></td>
                    <td><?= $info["user"]->topic ?></td>
                    <td>
                        <a class="waves-effect waves-light btn light-green" onclick="window.location = '<?= base_url() ?>feedback/content/<?= $info["user"]->id ?>'">feedback</a>
                    </td>
                </tr>
                <?php /* endforeach; */ ?>
            </tbody>
        </table>
    <?php endif ?>
</div>