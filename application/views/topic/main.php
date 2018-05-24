
<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>
<div class="row container">
    <div class="col s12">
        <blockquote class="color-primary-green">
            <h3 class="color-black">Topic Management <br><a href="<?= base_url() ?>Topic/addTopic" class="waves-effect waves-dark btn bg-primary-green"><i class="material-icons left">add</i>Add Topic</a></h3>
        </blockquote>
    </div>
</div>
<div class="row container">
    <center>
        <h4>Used Topics</h4>
        <h6>These topics were assigned to this department's subject areas</h6>
    </center>
    <?php if (!empty($topic_holder)): ?>
        <table class="data-table" id="tbl-feedback"">
            <thead>
                <tr>
                    <th>Topic Name</th>
                    <th>Topic Description</th>
                    <th>Actions</th> 
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($topic_holder as $top): ?>
                    <tr class="bg-color-white">
                        <td><?=$top->topic_list_name?></td>
                        <td><?=$top->topic_list_description?></td> 
                        <td><a class="waves-effect waves-dark btn bg-primary-yellow btn_edit" data-id="<?= $top->topic_list_id?>">Edit</a></td>
                        <td><a class="waves-effect waves-dark btn red btn_delete" data-id="<?= $top->topic_list_id?>" data-name="<?= $top->topic_list_name?>">Delete</a></td>
                    </tr> 
                <?php endforeach;?>
            </tbody>
        </table>
    <?php else: ?>
        <h5 class="center">No list of topics</h5>
    <?php endif ?>
</div>
<br>
<div class="row">
    <div class="col m3"></div>
    <div class="col m6">
        <center>
            <h4>Unused Topics</h4>
            <h6>These topics were not assigned to any subject areas of your department's correl courses</h6>
        </center>
        <?php if (!empty($unused)): ?>
            <table class="data-table" id="tbl-feedback"">
                <thead>
                    <tr>
                        <th>Topic Name</th>
                        <th>Topic Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($unused as $top): ?>
                        <tr class="bg-color-white">
                            <td><?=$top->topic_list_name?></td>
                            <td><?=$top->topic_list_description?></td>
                        </tr> 
                    <?php endforeach;?>
                </tbody>
            </table>
        <?php else: ?>
            <h5 class="center">No list of topics</h5>
        <?php endif ?>
    </div>
    <div class="col m3"></div>
</div>


<script>
    jQuery(document).ready(function($) {
        $(".btn_delete").click(function(event) { 
            $id = $(this).data('id');
            $name = $(this).data('name');
            swal({
                title: "Are you sure?",
                text: "You are about to remove this topic ("+$name+") to ALL of its Subject Area",
                icon: "error",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "<?= base_url().'Topic/deleteTopic' ?>",
                        type: "post",
                        dataType: "json",
                        data: {
                            id: $id
                        },
                        success: function (data) {
                            console.log(data);
                            swal($name+" has been deleted!", {
                                icon: "success",
                            }).then(function () {
                                window.location.reload(true);
                            });
                        },
                        error: function (data) {
                            console.log(data);
                            swal("An error occured. Please try again", {
                                icon: "error",
                            }).then(function () {
                                window.location.reload(true);
                            });
                        }
                    });
                }
            }); 
        });
    });

    $(document).ready(function () {
        $(".btn_edit").click(function () {
            $data = $(this).data('id');
            window.location.href = "<?= base_url() . "Topic/editTopic/"?>" + $data;
        });
    });
</script>