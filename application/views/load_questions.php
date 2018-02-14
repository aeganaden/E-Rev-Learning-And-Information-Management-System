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
							<button class="btn bg-primary-green btn-edit-question" data-id="<?=$value->courseware_question_id?>" style="cursor: pointer;">mode_edit</button>
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
	jQuery(document).ready(function($) {

		// $( '.editor' ).click( function(){
		// 	alert();
		// 	$( this ).ckeditor( function() {
		// 		console.log( 'Instance ' + this.name + ' created' );
		// 	}, {
		// 		on: {
		// 			blur: function( evt ) {
		// 				console.log( 'Instance ' + this.name + ' destroyed' );
		// 				this.destroy();
		// 			}
		// 		}
		// 	} );
		// } );
		$(".btn-edit-question").click(function(data) {
			$q_id = 'question'+$(this).data('id');
			var shit = 'question'+$(this).data('id');
			if ($(this).html()!="close") {
				// initialization
				// alter the icon
				$(this).html("close");
				$(this).addClass('color-red');
				// make it editable
				$("#"+$q_id).attr("contenteditable",true);
				// add focus
				$("#"+$q_id).focus();
				// make ck editor appear
				CKEDITOR.inline($q_id);								
			}else{
				// alter the icon
				$(this).html("mode_edit");
				$(this).removeClass('color-red');
				// make it editable
				$("#"+$q_id).attr("contenteditable",false);
				// alert($q_id);
				// CKEDITOR.instances.$q_id.destroy();
				// CKEDITOR.inline(this.destroy());			
				CKEDITOR.instances[shit].destroy();

				// // if (CKEDITOR.instances.[shit]) {
				// // 	alert();
				// // }else{
				// // 	alert("putangina diba?!?!");
				// }			
				// CKEDITOR.instances.$q_id.destroy(false);

			}

		});

	});
	CKEDITOR.inline( 'ans_'+<?=$i_value->choice_id?> );	
</script>

<!-- @snippet 
<input class="with-gap" name="group<?=$value->courseware_question_id?>" type="radio" id="ans_<?=$i_value->choice_id?>" contenteditable="true"  />
									<label for="ans_<?=$i_value->choice_id?>" class="color-black" ><?=$i_value->choice_choice?></label>
 -->