<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>

<!--====  End of Navigation Top  ====<--></-->
<?php $this->load->view('includes/home-sidenav'); ?>
<!--ABOVE IS PERMA-->

<div class="row container">
    <div class="col s12">
        <blockquote class="color-primary-green">
            <h3 class="color-black">Subject Area Management <br><a href="<?= base_url() ?>SubjectArea/add_subject_area" class="waves-effect waves-dark btn bg-primary-green"><i class="material-icons left">add</i>Add Subject Area</a></h3>
        </blockquote>
    </div>
</div>
<div class="row container">
    <pre>
        <?php // print_r($year_holder); ?>
    </pre>
    <?php if (isset($year_holder) && !empty($year_holder)): ?>
    <table class="data-table" id="tbl-feedback">
        <thead>
            <tr>
                <th>Year Level</th>
                <th>Subject Area</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($year_holder as $idkey => $subyear_holder): ?>
                <?php foreach ($subyear_holder as $key => $res): ?>
                    <tr class="bg-color-white">
                        <td><?= $key ?></td>
                        <td><?= implode("<br>", $res); ?></td>
                        <td><a data-id="<?= $idkey ?>" class="waves-effect waves-dark btn bg-primary-green btn_view_a">View</a></td>
                        <td><a class="waves-effect waves-dark btn bg-primary-yellow btn_vedit_a">Edit</a></td>
                        <td><a class="waves-effect waves-dark btn red btn_delete_a">Delete</a></td>
                    </tr>
                <?php endforeach ?>
            <?php endforeach ?>
        </tbody>
    </table>
    <?php else: ?>
        <center style="margin-top:20vh;">
            <h3>No data to show</h3>
        </center>
    <?php endif; ?>
</div>

<div class="row container">
    <div class="col s12">
        <blockquote class="color-primary-green">
            <h3 class="color-black">Topic Management <br><a href="<?= base_url() ?>SubjectArea/add_subject_area" class="waves-effect waves-dark btn bg-primary-green"><i class="material-icons left">add</i>Add Topic</a></h3>
        </blockquote>
    </div>
</div>
<div class="row container"> 
    <?php if (isset($year_holder) && !empty($year_holder)): ?>
    <?php if ($topic_holder): ?>
        <table class="data-table" id="tbl-feedback"">
            <thead>
                <tr>
                    <th>Topic Name</th>
                    <th>Topic Description</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topic_holder as $idkey => $subyear_holder): ?>
                    <tr class="bg-color-white">
                        <td><?=$subyear_holder->topic_list_name?></td>
                        <td><?=$subyear_holder->topic_list_description?></td>
                        <td><a data-id="<?= $idkey ?>" class="waves-effect waves-dark btn bg-primary-green btn_view_b">View</a></td>
                        <td><a class="waves-effect waves-dark btn bg-primary-yellow btn_edit_b">Edit</a></td>
                        <td><a class="waves-effect waves-dark btn red btn_delete_b">Delete</a></td>
                    </tr>
                <?php endforeach; ?> 
            </tbody>
        </table>
        <?php else: ?>
            <h5 class="center">No list of topics</h5>
        <?php endif ?>
        <?php else: ?>
            <center style="margin-top:20vh;">
                <h3>No data to show</h3>
            </center>
        <?php endif; ?>
    </div>

    <script>
        $(document).ready(function () {
            $(".btn_view_a").click(function () {
                $data = $(this).data('id');
                window.location.href = "<?= base_url() . "SubjectArea/sub_view/" ?>" + $data;
            });

        });
    </script>