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
            <h3 class="color-black">Section Management</h3>
        </blockquote>
    </div>
    <div class="col s4"></div>
    <div class="col s4"></div>
</div>
<div class="row container">
    <pre>
        <?php // print_r($course); ?>
    </pre>
    <?php if (isset($course) && !empty($course)): ?>
        <table class="data-table responsive-table" id="tbl-feedback" style="table-layout:auto;">
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Course Title</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($course as $key => $res): ?>
                    <tr class="bg-color-white">
                        <td><?= $res->course_course_code ?></td>
                        <td><?= $res->course_course_title ?></td>
                        <td><a data-id="<?= $res->course_id ?>" class="waves-effect waves-dark btn bg-primary-green btn_view">View</a></td>
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
            window.location.href = "<?= base_url() . "Sections/view_sections/" ?>" + $data;
        });

    });
</script>