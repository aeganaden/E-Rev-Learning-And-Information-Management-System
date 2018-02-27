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
            <h3 class="color-black">Subject Area Management</h3>
        </blockquote>
    </div>
    <div class="col s4"></div>
    <div class="col s4"></div>
</div>
<div class="row container">
    <pre>
        <?php //print_r($result); ?>
    </pre>
    <?php if (isset($result) && !empty($result)): ?>
        <table class="data-table responsive-table" id="tbl-feedback" style="table-layout:auto;">
            <thead>
                <tr>
                    <th>Subject Area</th>
                    <th>Year Level</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $res): ?>
                    <tr class="bg-color-white">
                        <td><?= $res->subject_list_name ?></td>
                        <td><?= $res->year_level_name ?></td>
                        <td><a class="waves-effect waves-dark btn green" onclick="alert('test')">View</a></td>
                        <td><a class="waves-effect waves-dark btn yellow">Edit</a></td>
                        <td><a class="waves-effect waves-dark btn red">Delete</a></td>
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