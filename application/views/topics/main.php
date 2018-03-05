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
            <h3 class="color-black">Topic Management</h3>
        </blockquote>
    </div>
    <div class="col s4"></div>
    <div class="col s4"></div>
</div>
<div class="row container">
    <pre>
        <?php // print_r($topic_list); ?>
    </pre>

    <?php if (isset($topic_list) && !empty($topic_list)): ?>
        <table class="data-table responsive-table" id="tbl-feedback" style="table-layout:auto;">
            <thead>
                <tr>
                    <th>Topic Name</th>
                    <th>Topic Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topic_list as $key => $res): ?>
                    <tr class="bg-color-white">
                        <td><?= $res->topic_list_name ?></td>
                        <td><?= $res->topic_list_description ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

    <?php else: ?>
        <center style="margin-top:20vh;">
            <h3>No data to show</h3>
        </center>
    <?php endif; ?>
</div>