<?php foreach ($data as $key => $value): ?>
	<div class="row">
		<div class="col s12">
			<div class="card bg-primary-yellow">
				<div class="card-content white-text">
					<div class="row">
						<div class="col s6">
							<span class="card-title color-black"><span class="valign-wrapper"><i class="material-icons">apps</i>Question 1</span></span>
							<blockquote class="bq-primary-green">
								<div id="question1" class="color-black" contenteditable="true">
									<span class="color-black">
										<?=$value->courseware_question_question?>
									</span>
								</div>
							</blockquote>
						</div>
						<div class="col s6">

							<div>
								<input class="with-gap" name="group1" type="radio" id="ans_1"   />
								<label for="ans_1" class="color-black" >Green</label>
							</div>

							<div>
								<input class="with-gap" name="group1" type="radio" id="ans_2"  />
								<label for="ans_2" class="color-black">Green</label>
							</div>

							<div>
								<input class="with-gap" name="group1" type="radio" id="ans_3"  />
								<label for="ans_3" class="color-black">Green</label>
							</div>

							<div>
								<input class="with-gap" name="group1" type="radio" id="ans_4"  />
								<label for="ans_4" class="color-black">Green</label>
							</div>
						</div>

						<script type="text/javascript">
							CKEDITOR.disableAutoInline = true;
							CKEDITOR.inline( 'question1' );
						</script>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endforeach ?>