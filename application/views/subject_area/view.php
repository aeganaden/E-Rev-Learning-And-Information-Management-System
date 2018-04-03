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
            <h3 class="color-black">View Subject Area</h3>
        </blockquote>
    </div>
    <div class="col s4"></div>
    <div class="col s4"></div>
</div>
<div class="row container">
    <pre>
        <?php print_r($topic_list); ?>
    </pre>
    <?php if (isset($topic_list) && !empty($topic_list)): ?>
        <table class="data-table responsive-table" id="tbl-feedback" style="table-layout:auto;">
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
                <!--LAST - TOPIC FORMAT-->
                <?php foreach ($topic_list as $subtopic_list): ?>
                    <tr class="bg-color-white">
                        <td><?= $key ?></td>
                        <td><?= implode("<br>", $res); ?></td>
                        <td><a data-id="<?= $idkey ?>" class="waves-effect waves-dark btn bg-primary-green btn_view">View</a></td>
                        <td><a class="waves-effect waves-dark btn bg-primary-yellow">Edit</a></td>
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

<script>
    $(document).ready(function () {
        $(".btn_view").click(function () {
            $data = $(this).data('id');
            window.location.href = "<?= base_url() . "SubjectArea/view/" ?>" + $data;
        });

    });
</script>