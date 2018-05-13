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
            <h3 class="color-black">View Topics</h3>
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
        <table class="data-table" id="tbl-feedback" style="table-layout:auto;">
            <thead>
                <tr>
                    <th>Topic</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topic_list as $subtopic_list): ?>
                    <tr class="bg-color-white">
                        <td><?= $subtopic_list->topic_list_name ?></td>
                        <td><?= $subtopic_list->topic_list_description ?></td>
                        <td><a data-id="<?= $subtopic_list->topic_list_id ?>" class="waves-effect waves-dark btn red btn_remove">REMOVE</a></td>
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
        $(".btn_remove").click(function () {
            $data = $(this).data('id');
            window.location.href = "<?= base_url() . "SubjectArea/remove_topic/" . $this->uri->segment(3) ?>" + $data;
        });
    });
</script>