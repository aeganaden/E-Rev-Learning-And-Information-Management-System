<?php $x = 0; ?>
<?php foreach ($data as $key => $value): ?>
	<div class="row">
		<div class="col s12">
			<div class="card bg-primary-yellow">
				<div class="card-content white-text">
					<div class="row">
						<div class="col s6">
							<span class="card-title color-black">
								<span class="valign-wrapper">
									<i class="material-icons">apps</i>Question <?=++$x?>
								</span>



							</span>
							<blockquote class="bq-primary-green">
								<div id="question<?=$value->courseware_question_id?>" class="color-black editor" >
									<span class="color-black">
										<?=$value->courseware_question_question?>
									</span>
								</div>
							</blockquote>
							<button class="btn bg-primary-green btn-edit-question" data-id="<?=$value->courseware_question_id?>">EDIT</button>
						</div>
						<div class="col s6">
							<?php 
							$answers = $this->Crud_model->fetch("choice",array("courseware_question_id"=>$value->courseware_question_id));
							?>
							<?php if ($answers): ?>
								<h5 class="color-black">Answers</h5>
								<?php foreach ($answers as $key => $i_value): ?>
									<div class="row">
										<div class="valign-wrapper color-black col s6" id="ans_<?=$i_value->choice_id?>"
											style="border-bottom: 3px solid #007A33">
											<?=$i_value->choice_choice?>
										</div>
										<div class="col s6 valign-wrapper">
											<i class="material-icons color-primary-green btn-edit-answer" data-id="<?=$i_value->choice_id?>" style="cursor: pointer;">border_color</i>
										</div>
									</div>

								<?php endforeach ?>
							<?php else: ?>
								<h5 class="color-black valign-wrapper">Answers
									<i class="material-icons color-primary-green btn_add_answer" data-id="<?=$value->courseware_question_id?>" 
										style="cursor: pointer; margin-left: 3%;" >add_box
									</i>
								</h5>
								<div class="row" id="div_answer_<?=$value->courseware_question_id?>">

								</div>
							<?php endif ?>

						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
<?php endforeach ?>
<!-- contenteditable="true" -->
<script type="text/javascript">
	jQuery(document).ready(function($) {
		// Edit Question
		$initial_data_q = "";
		$initial_data_a = "";
		$(".btn-edit-question").click(function(data) {
			$q_id = 'question'+$(this).data('id');

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
			}else{
				// alter the icon
				$(this).html("EDIT");
				$(this).removeClass('bg-color-red');
				// make it editable
				$("#"+$q_id).attr("contenteditable",false);
				$("#"+$q_id).html($initial_data_q);
				CKEDITOR.instances[$q_id].destroy();

			}

		});
		
		// add answer
		$(".btn_add_answer").click(function(event) {
			
		});
		
		// edit answer
		$(".btn-edit-answer").click(function(event) {
			$a_id = "ans_"+$(this).data('id');
			console.log($a_id);	
			if ($(this).html()=="border_color") {
				$initial_data_a = $("#"+$a_id).html();
				// initialization
				// alter the icon
				$(this).html("cancel");
				$(this).addClass('color-red');
				// make it editable
				$("#"+$a_id).attr("contenteditable",true);
				// add focus
				$("#"+$a_id).focus();
				// make ck editor appear
				CKEDITOR.inline($a_id);								
			}else{
				// alter the icon
				$(this).html("border_color");
				$(this).removeClass('color-red');
				// make it editable
				$("#"+$a_id).attr("contenteditable",false);
				$("#"+$a_id).html($initial_data_a);
				CKEDITOR.instances[$a_id].destroy();

			}

		});

	});
	CKEDITOR.inline( 'ans_'+<?=$i_value->choice_id?> );	
</script>

<!-- @snippet 
<input class="with-gap" name="group<?=$value->courseware_question_id?>" type="radio" id="ans_<?=$i_value->choice_id?>" contenteditable="true"  />
									<label for="ans_<?=$i_value->choice_id?>" class="color-black" ><?=$i_value->choice_choice?></label>
 -->