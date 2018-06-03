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
			<h3 class="color-black">Edit Subject Area <br></h3>
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
	<h5 class="center"><?= $subj[0]->subject_list_name?></h5>
	<div class="col s1"></div>
	<div class="col s10">
		<form method="post" action="<?php echo base_url() . "SubjectArea/edit_submit/" . $subj[0]->year_level_id ."/" .$subj[0]->subject_list_id?>" style="margin-top: 20px;">
			<div class="row valign-wrapper">
				<div class="input-field col s11">
					<input name="subject_area" type="text" value="<?= $subj[0]->subject_list_name ?>" required>
					<label for="input_fields">Subject Area</label>
				</div>
				<div class="col s1">
					<a class="waves-effect waves-light red btn-floating tooltipped btn_reset_name" data-position="top" data-delay="0" data-tooltip="Reset"><i class="material-icons left">clear</i></a>
				</div>
			</div>
			<div class="row valign-wrapper">
				<div class="input-field col s11">
					<textarea name="subject_description" class="materialize-textarea"><?= $subj[0]->subject_list_description?></textarea>
					<label for="textarea1">Subject Area Description</label>
				</div>
				<div class="col s1">
					<a class="waves-effect waves-light red btn-floating tooltipped btn_reset_desc" data-position="top" data-delay="0" data-tooltip="Reset"><i class="material-icons left">clear</i></a>
				</div>
			</div>
			<div class="input-field">
				<button class="btn waves-effect waves-light right green" type="submit" name="submit">Update</button>
				<a href="<?= base_url() ?>SubjectArea" class="waves-effect waves-light btn left red">Cancel</a>
			</div>
		</form>
		<div style="padding-top: 100px;"></div>
		<center><h4>List of Topics</h4></center>

		<?php if (isset($top) && !empty($top)): ?>
	        <table class="data-table" id="tbl-feedback">
	            <thead>
	                <tr>
	                    <th>Topic Name</th>
	                    <th>Topic Description</th>
	                    <th>Actions</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php foreach ($top as $sub_top): ?>
                        <tr class="bg-color-white">
                            <td><?= $sub_top->topic_list_name ?></td>
                            <td><?= $sub_top->topic_list_description ?></td>
                            <?php if($sub_top->included == 1): ?>
                            	<td><a data-id="<?= $sub_top->topic_list_id ?>" data-name="<?= $sub_top->topic_list_name ?>" class="waves-effect waves-dark btn red btn_remove">Remove</a></td>
                            <?php else: ?>
						        <td><a data-id="<?= $sub_top->topic_list_id ?>" data-name="<?= $sub_top->topic_list_name ?>" class="waves-effect waves-dark btn bg-primary-green btn_add">Add</a></td>
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
		$(".btn_reset_name").click(function () {
			$default = "<?=$subj[0]->subject_list_name?>";
			$('input[name=subject_area]').val($default);
		});
		$(".btn_reset_desc").click(function () {
			$default = "<?=$subj[0]->subject_list_description?>";
			$('textarea[name=subject_description]').val($default);
		});
		$(".btn_remove").click(function(event) { 
            $id = $(this).data('id');
            $name = $(this).data('name');
            swal({
                title: "Are you sure?",
                text: "You are about to remove this Topic ("+$name+") to this Subject Area.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "<?= base_url().'SubjectArea/remove_topic_to_subj/' . $this->uri->segment(4)?>",
                        type: "post",
                        dataType: "json",
                        data: {
                            id: $id
                        },
                        success: function (data) {
                            if (data == "true"){
                            	console.log("true success");
                            	swal($name+" has been removed!", {
	                                icon: "success",
	                            }).then(function () {
	                                window.location.reload(true);
	                            });
                            } else {
                            	console.log("false success");
                            	swal("An error occured. Please try again", {
	                                icon: "error",
	                            }).then(function () {
	                                window.location.reload(true);
	                            });
                            }
                        },
                        error: function (data) {
                        	console.log("false error");
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
            $name = $(this).data('name');
            swal({
                title: "Are you sure?",
                text: "You are about to add this Topic ("+$name+") to this Subject Area.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "<?= base_url().'SubjectArea/add_topic_to_subj/' . $this->uri->segment(4)?>",
                        type: "post",
                        dataType: "json",
                        data: {
                            id: $id
                        },
                        success: function (data) {
                            if (data == "true"){
                            	swal($name+" has been added!", {
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