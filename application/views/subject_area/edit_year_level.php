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
			<h3 class="color-black">Edit <?=$subj[0]->year_level_name?> Level<br> <a href="<?= base_url() ?>SubjectArea/" class="waves-effect waves-dark btn red"><i class="material-icons left">arrow_back</i>Back</a></h3>
		</blockquote>
		<?php if((isset($error_message) && !empty($error_message))) :?>
			<blockquote class="color-red">
				<h6><b>ERROR:</b></h6>
				<?php foreach ($error_message as $err): ?>
					<h6><?= $err; ?></h6>
				<?php endforeach; ?>
				<?php echo validation_errors(); ?>
			</blockquote>
		<?php endif;?>
	</div>
</div>
<div class="row container">
	<div class="col s1"></div>
	<div class="col s10">
		<?php if (isset($subject_area) && !empty($subject_area)): ?>
	        <table class="data-table" id="tbl-feedback">
	            <thead>
	                <tr>
	                    <th>Subject Area</th>
	                    <th>Subject Area Description</th>
	                    <th>Actions</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php foreach ($subject_area as $sub): ?>
                        <tr class="bg-color-white">
                            <td><?= $sub["name"] ?></td>
                            <td><?= $sub["desc"] ?></td>
                            <?php if($sub["included"] == 1): ?>
                            	<td><a data-id="<?= $sub['name'] ?>" class="waves-effect waves-dark btn red btn_remove">Remove</a></td>
                            <?php else: ?>
						        <td><a data-id="<?= $sub['name'] ?>" class="waves-effect waves-dark btn bg-primary-green btn_add">Add</a></td>
						    <?php endif; ?>
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
</div>
<script>
	$(document).ready(function(){
		$(".btn_remove").click(function(event) { 
            $id = $(this).data('id');
            swal({
                title: "Are you sure?",
                text: "You are about to remove this Subject Area ("+$id+") to this Year Level.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "<?= base_url().'SubjectArea/remove_subj_from_year_level/' . $this->uri->segment(3)?>",
                        type: "post",
                        dataType: "json",
                        data: {
                            id: $id
                        },
                        success: function (data) {
                            if (data == "true"){
                            	swal($id+" has been removed!", {
	                                icon: "success",
	                            }).then(function () {
	                                window.location.reload(true);
	                            });
                            } else {
                            	swal("An error occured. Please try again", {
	                                icon: "error",
	                            }).then(function () {
	                                window.location.reload(true);
	                            });
                            }
                        },
                        error: function (data) {
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
		$(".btn_add").click(function(event) { 
            $id = $(this).data('id');
            swal({
                title: "Are you sure?",
                text: "You are about to add this Subject Area ("+$id+") to this Year Level.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "<?= base_url().'SubjectArea/add_subj_from_year_level/' . $this->uri->segment(3)?>",
                        type: "post",
                        dataType: "json",
                        data: {
                            id: $id
                        },
                        success: function (data) {
                            if (data == "true"){
                            	swal($id+" has been removed!", {
	                                icon: "success",
	                            }).then(function () {
	                                window.location.reload(true);
	                            });
                            } else {
                            	swal("An error occured. Please try again", {
	                                icon: "error",
	                            }).then(function () {
	                                window.location.reload(true);
	                            });
                            }
                        },
                        error: function (data) {
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
</script>