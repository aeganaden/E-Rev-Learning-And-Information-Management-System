<?php $x = 0; ?>
<div id="imageContainer">
	<?php foreach ($data as $key => $value): ?>
		<div class="row">
			<div class="col s12">
				<div class="card bg-primary-yellow">
					<i class="material-icons right small btn-del-q color-red" style="margin-top: 1%; margin-right: 2%; cursor: pointer;" data-cwid="<?=$value->courseware_id?>" data-id="<?=$value->courseware_question_id?>">delete</i>
					<div class="card-content white-text">
						<div class="row">
							<div class="col s6">
								<span class="card-title color-black">
									<span class="valign-wrapper">
										<i class="material-icons">apps</i>Question <?=++$x?>
									</span>
								</span>
								<blockquote class="bq-primary-green">
									<!-- QUESTIONS -->
									<div id="question<?=$value->courseware_question_id?>" class="color-black editor disabled" >
										<span class="color-black" id="question_div_css">
											<?=$value->courseware_question_question?>
										</span>
									</div>
								</blockquote>
								<button class="btn bg-primary-green btn-edit-question left" data-id="<?=$value->courseware_question_id?>">EDIT</button>
								<button class="btn bg-primary-green right" id="btn-update-question<?=$value->courseware_question_id?>" data-id="<?=$value->courseware_question_id?>" style="display: none;">UPDATE</button>
							</div>
							<div class="col s6">
								<!-- ANSWERS -->
								<?php 
								$answers = $this->Crud_model->fetch("choice",array("courseware_question_id"=>$value->courseware_question_id));
								?>
								<?php if ($answers): ?>
									<h5 class="color-black">Answers</h5>
									<?php foreach ($answers as $key => $i_value): ?>
										<div class="row">
											<div class="col s1">
												<i class="material-icons color-white tooltipped" id="i_<?=$i_value->choice_id?>" data-position="left" data-tooltip="Correct Answer">
													<?=$i_value->choice_is_answer==1 ? "star" : ""?>
												</i>
											</div>
											<div class="valign-wrapper color-black col s8 disabled" id="ans_<?=$i_value->choice_id?>"
												style="border-bottom: 3px solid #007A33">
												<?=$i_value->choice_choice?>
											</div>
											<div class="col s3 valign-wrapper">
												<i class="material-icons color-primary-green btn-edit-answer" data-id="<?=$i_value->choice_id?>" style="cursor: pointer;">border_color</i>
												<i class="material-icons color-primary-green"  id="btn-update-answer<?=$i_value->choice_id?>" data-id="<?=$i_value->choice_id?>" style="cursor: pointer; display: none;">navigation</i>
												<?php if ($i_value->choice_is_answer == 1): ?>
													<?php $is_answer = 1; ?>
												<?php else: ?>
													<?php $is_answer = 0; ?>
												<?php endif ?>
												<i class="material-icons color-white" id="btn-mark-answer<?=$i_value->choice_id?>" data-id="<?=$i_value->choice_id?>" data-a="<?=$is_answer?>" data-qid="<?=$value->courseware_question_id?>" style="cursor: pointer; display: none;">star</i>
											</div>
										</div>
									<?php endforeach ?>
								<?php else: ?>
									<h5 class="color-black valign-wrapper">No Answers</h5>
									<!-- id="div_answer_<?=$value->courseware_question_id?>" -->
								<?php endif ?>


							</div>

						</div>
					</div>
				</div>
			</div>
		</div>

	<?php endforeach ?>

</div>



<script type="text/javascript">


	jQuery(document).ready(function($) {
		
		$('.tooltipped').tooltip({delay: 50});
		var getDivId = document.getElementById("imageContainer");
		var images = getDivId.getElementsByTagName("img");
		var i;
		for(i = 0; i < images.length; i++) {
			images[i].className += "materialboxed";
		}

		$('.materialboxed').materialbox();


		
		/*=========================================
		=            EDIT QUESTION BTN            =
		=========================================*/
		
		// Edit Question
		$initial_data_q = "";
		$initial_data_a = "";
		
		$(".btn-edit-question").click(function(data) {
			$q_id = 'question'+$(this).data('id');
			$id = $(this).data('id');
			if ($(this).html()=="EDIT") {
				$initial_data_q = $("#"+$q_id).html();
				// initialization
				// alter the icon
				$(this).html("CANCEL");
				$(this).addClass('bg-color-red');
				// make it editable
				$("#"+$q_id).attr("contenteditable",true);
				// add focus
				$("#"+$q_id).focus();
				// make ck editor appear
				CKEDITOR.inline($q_id);		
				$("#btn-update-question"+$id).css('display', 'block');
				$(".btn-edit-question").not(this).css("display", "none");


				
			}else{
				// alter the icon
				$(this).html("EDIT");
				$(this).removeClass('bg-color-red');
				// make it uneditable
				$("#"+$q_id).attr("contenteditable",false);
				$("#"+$q_id).html($initial_data_q);
				CKEDITOR.instances[$q_id].destroy();
				$("#btn-update-question"+$id).css('display', 'none');
				$(".btn-edit-question").css("display", "block");


			}

			
			// update question
			$("#btn-update-question"+$id).click(function(event) {
				$q_id = 'question'+$(this).data('id');
				$id = $(this).data('id');
				$content = $("#"+$q_id).html();
				// console.log($content);	
				$.ajax({
					url: '<?=base_url()?>/Coursewares_fic/updateQuestion',
					type: 'post',
					dataType: 'json',
					data: {
						q_id: $id,
						content: $content,
					},
					success: function(data){
						if (true) {
							$toastContent = $('<span>Successfully Updated Question</span>');
							Materialize.toast($toastContent, 5000);

							// return to default state
							$(".btn-edit-question").html("EDIT");
							$(".btn-edit-question").removeClass('bg-color-red');
							// make it uneditable
							$("#"+$q_id).attr("contenteditable",false);
							CKEDITOR.instances[$q_id].destroy();
							$("#btn-update-question"+$id).css('display', 'none');
							$(".btn-edit-question").css("display", "block");


						}else{
							$toastContent = $('<span>Error Updating</span>').add($('<button class="btn-flat toast-action" onClick="window.location.reload()" >Refresh</button>'));
							Materialize.toast($toastContent, 10000);
						}		
					}
				});
				
			});

		});

		
		/*=====  End of EDIT QUESTION BTN  ======*/
		



		/*===================================
		=            EDIT ANSWER            =
		===================================*/
		
		// edit answer
		$(".btn-edit-answer").click(function(event) {
			$a_id = "ans_"+$(this).data('id');
			$id = $(this).data('id');
			// console.log($a_id);	
			if ($(this).html()=="border_color") {
				$initial_data_a = $("#"+$a_id).html();
				// initialization
				// alter the icon
				$(this).html("cancel");
				$(this).addClass('color-red');
				// $(".btn-edit-answer").css('display', 'none');
				$(".btn-edit-answer").not(this).css("display", "none");
				// make it editable
				$("#"+$a_id).attr("contenteditable",true);
				// add focus
				$("#"+$a_id).focus();
				// make ck editor appear
				CKEDITOR.inline($a_id);		
				$("#btn-update-answer"+$id).css('display', 'block');
				if ($("#btn-mark-answer"+$id).data('a')==0) {
					$("#btn-mark-answer"+$id).css('display', 'block');
				}else{
					$("#btn-mark-answer"+$id).css('display', 'none');
				}

			}else{
				// alter the icon
				$(this).html("border_color");
				$(this).removeClass('color-red');
				// make it uneditable
				$("#"+$a_id).attr("contenteditable",false);
				$("#"+$a_id).html($initial_data_a);
				CKEDITOR.instances[$a_id].destroy();
				$("#btn-update-answer"+$id).css('display', 'none');
				$("#btn-mark-answer"+$id).css('display', 'none');
				$(".btn-edit-answer").css("display", "block");



			}



			// update answer content
			$("#btn-update-answer"+$id).click(function(event) {
				// alert();
				$a_id = 'ans_'+$(this).data('id');
				$id = $(this).data('id');
				$content = $("#"+$a_id).html();
				// console.log($content);	
				$.ajax({
					url: '<?=base_url()?>/Coursewares_fic/updateAnswer',
					type: 'post',
					dataType: 'json',
					data: {
						a_id: $id,
						content: $content,
					},
					success: function(data){
						// console.log(data);	
						if (true) {
							$toastContent = $('<span>Successfully Updated Answer</span>');
							Materialize.toast($toastContent, 5000);

							// return to default state
							$(".btn-edit-answer").html("border_color");
							$(".btn-edit-answer").removeClass('color-red');
							$("#btn-mark-answer"+$id).css('display', 'none');
							$(".btn-edit-answer").css("display", "block");


							// make it uneditable
							$("#"+$a_id).attr("contenteditable",false);
							CKEDITOR.instances[$a_id].destroy();
							$("#btn-update-answer"+$id).css('display', 'none');

						}else{
							$toastContent = $('<span>Error Updating</span>').add($('<button class="btn-flat toast-action" onClick="window.location.reload()" >Refresh</button>'));
							Materialize.toast($toastContent, 10000);
						}		
					}
				});
				
			});

			var click = function (e) {
				$q_id = $(this).data('qid');
				unsavedChanges = false;
				// fetch the answer
				// then configure it base on return value from ajax
				// console.log($q_id);	
				$.ajax({
					url: '<?=base_url()?>Coursewares_fic/fetchCorrectAnswer',
					type: 'post',
					dataType: 'json',
					data: {
						q_id: $q_id,
						a_id: $id,
					},
					success: function(data){
						if (data) {
							console.log(data);	
							$("#i_"+$id).html("star");
							$("#i_"+data).html("");

							$("#btn-mark-answer"+$id).css("display","none");
							$("#btn-mark-answer"+data).data('a', 0);
							$("#btn-mark-answer"+$id).data('a', 1);
							$toastContent = $('<span>Correct Answer Changed</span>');
							Materialize.toast($toastContent, 2000);

						}else{
							$("#i_"+$id).html("star")
							$("#btn-mark-answer"+$id).css("display","none");
							$("#btn-mark-answer"+$id).data('a', 1);
							$toastContent = $('<span>Correct Answer Changed</span>');
							Materialize.toast($toastContent, 2000);							
						}
					}
				});

				e.stopImmediatePropagation();
				return false;

			}
			// mark as answer 
			$("#btn-mark-answer"+$id).one('click', click);




		});
		
		/*=====  End of EDIT ANSWER  ======*/
		

	});
</script>

<!-- @snippet 
<input class="with-gap" name="group<?=$value->courseware_question_id?>" type="radio" id="ans_<?=$i_value->choice_id?>" contenteditable="true"  />
									<label for="ans_<?=$i_value->choice_id?>" class="color-black" ><?=$i_value->choice_choice?></label>
 -->