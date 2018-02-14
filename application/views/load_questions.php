<?php $x = 0; ?>
<?php foreach ($data as $key => $value): ?>
	<div class="row">
		<div class="col s12">
			<div class="card bg-primary-yellow">
				<div class="card-content white-text">
					<div class="row">
						<div class="col s6">
							<span class="card-title color-black">
								<span class="valign-wrapper"><i class="material-icons">apps</i>Question <?=++$x?></span>
								<i class="material-icons color-primary-green" style="cursor: pointer;">mode_edit</i>


							</span>
							<blockquote class="bq-primary-green">
								<div id="question<?=$value->courseware_question_id?>" class="color-black" >
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
								<div class="row">
									<div class="valign-wrapper color-black col s6" id="ans_<?=$i_value->choice_id?>"
										style="border-bottom: 3px solid #007A33">
										<?=$i_value->choice_choice?>
									</div>
									<div class="col s6 valign-wrapper">
										<i class="material-icons color-primary-green" style="cursor: pointer;">border_color</i>
									</div>
								</div>
								
							<?php endforeach ?>
							
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
<?php endforeach ?>
<!-- contenteditable="true" -->
<script type="text/javascript">
	CKEDITOR.inline( 'ans_'+<?=$i_value->choice_id?> );	
	CKEDITOR.inline( 'question'+<?=$value->courseware_question_id?> );								
</script>

<!-- @snippet 
<input class="with-gap" name="group<?=$value->courseware_question_id?>" type="radio" id="ans_<?=$i_value->choice_id?>" contenteditable="true"  />
									<label for="ans_<?=$i_value->choice_id?>" class="color-black" ><?=$i_value->choice_choice?></label>
 -->