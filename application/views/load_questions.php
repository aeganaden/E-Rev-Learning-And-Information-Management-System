<?php $x = 0; ?>
<?php foreach ($data as $key => $value): ?>
	<div class="row">
		<div class="col s12">
			<div class="card bg-primary-yellow">
				<div class="card-content white-text">
					<div class="row">
						<div class="col s6">
							<span class="card-title color-black"><span class="valign-wrapper"><i class="material-icons">apps</i>Question <?=++$x?></span></span>
							<blockquote class="bq-primary-green">
								<div id="question<?=$value->courseware_question_id?>" class="color-black" contenteditable="true">
									<span class="color-black">
										<?=$value->courseware_question_question?>
									</span>
								</div>
							</blockquote>
						</div>
						<div class="col s6">
							<h5 class="color-black">Answers</h5>
							<?php 
							$answers = $this->Crud_model->fetch("choice",array("courseware_question_id"=>$value->courseware_question_id));
							?>
							<?php foreach ($answers as $key => $i_value): ?>
								<i class="material-icons">drag_handle</i><div class="valign-wrapper color-black" id="ans_<?=$i_value->choice_id?>" contenteditable="true"><?=$i_value->choice_choice?></div>
								<script type="text/javascript">
									CKEDITOR.inline( 'ans_'+<?=$i_value->choice_id?> );									
								</script>
							<?php endforeach ?>
							
						</div>

						<script type="text/javascript">
							CKEDITOR.inline( 'question'+<?=$value->courseware_question_id?> );
						</script>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endforeach ?>


<!-- @snippet 
<input class="with-gap" name="group<?=$value->courseware_question_id?>" type="radio" id="ans_<?=$i_value->choice_id?>" contenteditable="true"  />
									<label for="ans_<?=$i_value->choice_id?>" class="color-black" ><?=$i_value->choice_choice?></label>
 -->