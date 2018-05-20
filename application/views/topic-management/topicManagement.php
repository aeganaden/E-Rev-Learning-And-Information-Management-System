
<?php $this->load->view('includes/home-navbar'); ?>
<?php $this->load->view('includes/home-sidenav'); ?>
<div class="row container">
    <div class="col s12">
        <blockquote class="color-primary-green">
            <h3 class="color-black">Topic Management <br><a href="<?= base_url() ?>TopicManagement/addTopic" class="waves-effect waves-dark btn bg-primary-green"><i class="material-icons left">add</i>Add Topic</a></h3>
        </blockquote>
    </div>
</div>
<div class="row container">   
    <?php if (!$topic_holder): ?>
        <table class="data-table" id="tbl-feedback"">
            <thead>
                <tr>
                    <th>Topic Name</th>
                    <th>Topic Description</th>
                    <th></th> 
                    <th></th>
                </tr>
            </thead>
            <tbody> 
                <tr class="bg-color-white">
                    <td>Name</td>
                    <td>desc</td> 
                    <td><a href="<?= base_url() ?>TopicManagement/editTopic" class="waves-effect waves-dark btn bg-primary-yellow btn_edit_b">Edit</a></td>
                    <td><a class="waves-effect waves-dark btn red btn_delete_b" data-id="PutIDHERE">Delete</a></td>
                </tr> 
            </tbody>
        </table>
        <?php else: ?>
            <h5 class="center">No list of topics</h5>
        <?php endif ?>  
    </div>


    <script>
        jQuery(document).ready(function($) {
            $(".btn_delete_b").click(function(event) { 
                $id = $(this).data('id');
                alert($id);
                swal({
                    title: "Are you sure?",
                    text: "You are about to delete a topic",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "<?= base_url() ?>yourMethodHere",
                            type: "post",
                            dataType: "json",
                            data: {
                                id: $id
                            },
                            success: function (data) {
                                swal("Poof! Offering has been deleted!", {
                                    icon: "success",
                                }).then(function () {
                                    window.location.reload(true);
                                });
                            },
                            error: function (data) {

                            }

                        });
                    }
                }); 
            });
        });
    </script>