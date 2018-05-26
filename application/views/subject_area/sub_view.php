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
    <ul class="collapsible" data-collapsible = "expandable">
        <?php foreach($dissect as $subj_id => $sub_dissect): ?>
            <li>
                <div class="collapsible-header valign-wrapper">
                    <div class="col s8 valign-wrapper">
                        <i class="material-icons">assignment</i>
                        <?php echo $sub_dissect["subj_name"] ?>
                    </div>
                    <div class="col s4 right-align center">
                        <!-- LAST! - ayaw gumana ng hover -->
                        <a class='dropdown-trigger btn' href='#' data-target='dropdown1'>Drop Me!</a>
                        <!-- Dropdown Structure -->
                        <ul id='dropdown1' class='dropdown-content'>
                            <li><a href="#!">one</a></li>
                            <li><a href="#!">two</a></li>
                            <li class="divider" tabindex="-1"></li>
                            <li><a href="#!">three</a></li>
                            <li><a href="#!"><i class="material-icons">view_module</i>four</a></li>
                            <li><a href="#!"><i class="material-icons">cloud</i>five</a></li>
                        </ul>
                    </div>
                </div>
                <div class="collapsible-body"><span>
                    <h5>Description: <?php echo $sub_dissect["subj_desc"] ?></h5>
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
        <?php endforeach ?>
    </ul>
</div>
<script>
    $(document).ready(function () {
        $(".btn_remove").click(function () {
            $data = $(this).data('id');
            window.location.href = "<?= base_url() . "SubjectArea/remove_topic/" + $data ?>";
        });
        // LAST! - ayaw gumana ng hover
        $('.dropdown-trigger').dropdown({hover:true});
    });
</script>