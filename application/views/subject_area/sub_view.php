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
            <h3 class="color-black">View Topics</h3>
        </blockquote>
        <blockquote class="color-primary-green">
            <h6 class="color-black">These are the topics inside the subject area</h6>
        </blockquote>
    </div>
</div>
<div class="row container">
    <?php foreach($dissect as $subj_id => $sub_dissect): ?>
        <ul class="collapsible">
            <li>
                <!-- LAST! - need button to the right of collapsible -->
                <div class="collapsible-header"><i class="material-icons">assignment</i><?php echo $sub_dissect["subj_name"] ?></div>
                <div class="collapsible-body"><span>
                    Description: <?php echo $sub_dissect["subj_desc"] ?>
                    <br>
                    <br>
                    <br>
                    <?php if (!empty($sub_dissect["values"])): ?>
                        <table class="data-table" id="tbl-feedback" style="table-layout:auto;">
                            <thead>
                                <tr>
                                    <th>Topic</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sub_dissect["values"] as $sub_values): ?>
                                    <tr class="bg-color-white">
                                        <td><?= $sub_values["topic_list_name"] ?></td>
                                        <td><?= $sub_values["topic_list_desc"] ?></td>
                                        <td><a data-id="<?= $sub_values['topic_list_id'] ?>" class="waves-effect waves-dark btn red btn_remove">REMOVE</a></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <center style="margin-top:20vh;">
                            <h3>No data to show</h3>
                        </center>
                    <?php endif; ?>
                </span></div>
            </li>
        </ul>
    <?php endforeach ?>
</div>

<script>
    $(document).ready(function () {
        $(".btn_remove").click(function () {
            $data = $(this).data('id');
            window.location.href = "<?= base_url() . "SubjectArea/remove_topic/" + $data ?>";
        });
    });
</script>