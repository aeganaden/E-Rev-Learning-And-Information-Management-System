<!--====================================
=            Navigation Top            =
=====================================-->

<?php $this->load->view('includes/home-navbar'); ?>

<!--====  End of Navigation Top  ====<--></-->
<?php $this->load->view('includes/home-sidenav'); ?>
<!--ABOVE IS PERMA-->

<!--
    UNDER DEVELOPMENT
<div class="container row">
    <div class="col s1"></div>
    <div class="col s11">

        <div class="row valign-wrapper" style="padding-top: 10%;">
            <div class="col s4 ">
                <h3 class="center" style="text-transform: uppercase; text-align: justify-all;">UNDER DEVELOPMENT</h3>
            </div>
            <div class="col s4">
                <img src="<?= base_url() ?>assets/chibi/Chibi_crying.svg " alt="">
            </div>
            <div class="col s4">
                <h3 class="center" style="text-transform: uppercase; text-align: justify-all;">COME BACK SOON!</h3>
            </div>
        </div>
    </div>
</div>-->


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
        <?php print_r($year_holder); ?>
    </pre>
    <?php if (isset($year_holder) && !empty($year_holder)): ?>
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
                <?php foreach ($year_holder as $idkey => $subyear_holder): ?>
                    <?php foreach ($subyear_holder as $key => $res): ?>
                        <tr class="bg-color-white">
                            <td><?= $key ?></td>
                            <td><?= implode("<br>", $res); ?></td>
                            <td><a data-id="<?= $idkey ?>" class="waves-effect waves-dark btn bg-primary-green btn_view">View</a></td>
                            <td><a class="waves-effect waves-dark btn bg-primary-yellow">Edit</a></td>
                            <td><a class="waves-effect waves-dark btn red">Delete</a></td>
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

<script>
    $(document).ready(function () {
        $(".btn_view").click(function () {
            $data = $(this).data('id');
            window.location.href = "<?= base_url() . "SubjectArea/view/" ?>" + $data;
        });

    });
</script>