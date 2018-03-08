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
								<!-- QUESTIONS -->
								<div id="question<?=$value->courseware_question_id?>" data-id="<?=$value->courseware_question_id?>" class="color-black editor disabled question_div" >
									<span class="color-black">
										<?=$value->courseware_question_question?>
									</span>
								</div>
							</blockquote> 
						</div>
						<div class="col s6">
							<!-- ANSWERS -->
							<?php 
							$answers = $this->Crud_model->fetch("choice",array("courseware_question_id"=>$value->courseware_question_id));
							?>
							<?php if ($answers): ?>
								<h5 class="color-black">Choices</h5>
								<?php foreach ($answers as $key => $i_value): ?>
									<div class="row color-black">
										<p>
											<input name="group<?=$value->courseware_question_id?>" type="radio" id="s_a<?=$i_value->choice_id?>" />
											<label for="s_a<?=$i_value->choice_id?>" data-id="<?=$i_value->choice_id?>" class="color-black"><?=$i_value->choice_choice?></label>
										</p>

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




<script type="text/javascript">
	
	jQuery(document).ready(function($) {
		$('.tooltipped').tooltip({delay: 50});

		var images = document.getElementsByTagName("img");
		var i;
		for(i = 0; i < images.length; i++) {
			images[i].className += "materialboxed";
		}

		$('.materialboxed').materialbox();

	});
</script>

<!-- @snippet 
<input class="with-gap" name="group<?=$value->courseware_question_id?>" type="radio" id="ans_<?=$i_value->choice_id?>" contenteditable="true"  />
									<label for="ans_<?=$i_value->choice_id?>" class="color-black" ><?=$i_value->choice_choice?></label>
 -->