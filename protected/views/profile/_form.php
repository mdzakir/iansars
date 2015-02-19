<?php
/* @var $this ProfileController */
/* @var $model CallersProfile */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'callers-profile-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->hiddenField($model,'caller_id',array('size'=>20,'maxlength'=>20, 'value'=>YII::app()->user->id)); ?>
	</div>

	<div class="profileForm">
		<div class="pfName">
			<fieldset>
				<legend>Name</legend>
					<table class="uiNameTable">
						<tr>
							<td><?php echo $form->labelEx($model,'first_name'); ?></td>
							<td><?php echo $form->labelEx($model,'last_name'); ?></td>
						</tr>
						<tr>
							<td>
								<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>255, 'class'=>'reqd fields textFieldMedium')); ?>
								<?php echo $form->error($model,'first_name'); ?>
							</td>
							<td>
								<?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>255, 'class'=>'reqd fields textFieldMedium')); ?>
								<?php echo $form->error($model,'last_name'); ?>
							</td>
						</tr>
						<tr>
							<td><?php echo $form->labelEx($model,'family_name'); ?></td>
							<td><?php echo $form->labelEx($model,'nick_name'); ?></td>
						</tr>
						<tr>
							<td>
								<?php echo $form->textField($model,'family_name',array('size'=>60,'maxlength'=>255, 'class'=>'fields textFieldMedium')); ?>
								<?php echo $form->error($model,'family_name'); ?>
							</td>
							<td>
								<?php echo $form->textField($model,'nick_name',array('size'=>60,'maxlength'=>255, 'class'=>'fields textFieldMedium')); ?>
								<?php echo $form->error($model,'nick_name'); ?>
							</td>
						</tr>
					</table>
			</fieldset>
		</div>
		
		<div class="pfGenderDOB">
			<fieldset>
				<legend>Gender &amp; Date of Birth</legend>
					<table>
						<tr>
							<td><?php echo $form->labelEx($model,'gender'); ?></td>
							<td><?php echo $form->labelEx($model,'date_of_birth'); ?></td>
						</tr>
						<tr>
							<td>
								<?php echo $form->dropDownList($model,'gender', array('MALE'=>'Male', 'FEMALE'=>'Female', 'OTHER'=>'Other'), array('empty'=>'Select', 'class'=>'reqd fields')) ?> 
								<?php echo $form->error($model,'gender'); ?>
							</td>
							<td>
								<?php echo $form->textField($model,'date_of_birth',array('size'=>60,'maxlength'=>255, 'class'=>'fields textFieldMedium')); ?> 
								<?php echo $form->error($model,'date_of_birth'); ?>
							</td>
						</tr>
					</table>
			</fieldset>
		</div>
		
		<div class="pfContact">
			<fieldset>
				<legend>Contact Details</legend>
					<table>
						
						<tr>
							<td><?php echo $form->labelEx($model,'primary_phone'); ?></td>
							<td><?php echo $form->labelEx($model,'secondary_phone'); ?></td>
						</tr>
						<tr>
							<td>
								<?php echo $form->textField($model,'primary_phone',array('size'=>60,'maxlength'=>20, 'class'=>'reqd fields textFieldMedium')); ?>
								<?php echo $form->error($model,'primary_phone'); ?>
							</td>
							<td>
								<?php echo $form->textField($model,'secondary_phone',array('size'=>20,'maxlength'=>20, 'class'=>'fields textFieldMedium')); ?>
								<?php echo $form->error($model,'secondary_phone'); ?>
							</td>
						</tr>
						<tr>
							<td>
								<p class="hint">Either Social Networking id or Messenger id is mandatory</p>
							</td>
						</tr>
						<tr>
							<td colspan="2"><?php echo $form->labelEx($model,'social_network_id'); ?></td>
						</tr>
						<tr>
							<td colspan="2">
								<?php if($model->social_network_id) $socialnetwork = $this->objectToArray(json_decode($model->social_network_id)); ?>
									<?php if(!$model->isNewRecord && count($socialnetwork)>0) {
											$i=0;
											foreach($socialnetwork as $name => $value) { ?>
											<div class="social-network">
												<?php echo $form->dropDownList($model,'social_network_name[]',array(
														'facebook'=>'Facebook',
														'Twitter'=>'Twitter',
														'MySpace'=>'MySpace',
														'GooglePlus'=>'Google plus',
														'Orkut'=>'Orkut',
														'LinkedIn' => 'LinkedIn',
														'Pinterest' => 'Pinterest',
														'Tagged' => 'Tagged'
														),
														$htmlOptions=array(
															'empty'=>'- Social Network -',
															'options'=>array($name=>array('selected'=>'selected')), 
															'id'=>'',
															'class' => 'reqdsn fields'));
													?>
												<?php // echo $form->textField($model,'social_network_name[]',array('id'=>'', 'class'=>'reqdsn fields textFieldMedium', 'value'=>$name)); ?>
												<?php echo $form->textField($model,'social_network_id[]',array('id'=>'', 'class'=>'reqdsn fields textFieldMedium', 'value'=>$value)); ?>
												<?php if(count($socialnetwork) == 1) { ?>
													<input type="button" value="+" onClick="addRow(this);" class="addsn">
													<input type="button" value="-" onClick="dltRow(this);" style="display:none;" class="dltsn">
												<?php } else if ($i == count($socialnetwork)-1) { ?>
													<input type="button" value="+" onClick="addRow(this);" class="addsn">
													<input type="button" value="-" onClick="dltRow(this);" class="dltsn">
												<?php } else { ?>
													<input type="button" value="+" onClick="addRow(this);" style="display:none;" class="addsn">
													<input type="button" value="-" onClick="dltRow(this);" class="dltsn">
												<?php } ?>
											</div>
									<?php $i++; } 
								} else {?>
									<div class="social-network">
												<?php echo $form->dropDownList($model,'social_network_name[]',array(
														'facebook'=>'Facebook',
														'Twitter'=>'Twitter',
														'MySpace'=>'MySpace',
														'GooglePlus'=>'Google plus',
														'Orkut'=>'Orkut',
														'LinkedIn' => 'LinkedIn',
														'Pinterest' => 'Pinterest',
														'Tagged' => 'Tagged',
														
														), 
														$htmlOptions=array(
															'empty'=>'- Social Network -',
															//'options'=>array($name=>array('selected'=>'selected')),
															'id'=>'',
															'class' => 'reqdsn fields'));
												?>
														
										<?php echo $form->textField($model,'social_network_id[]',array('id'=>'', 'class'=>'reqdsn fields textFieldMedium')); ?>
										<input type="button" value="+" onClick="addRow(this);" class="addsn">
										<input type="button" value="-" onClick="dltRow(this);" style="display:none;" class="dltsn">
									</div>
								<?php } ?>
								<?php echo $form->error($model,'social_network_id'); ?>
							</td>
						</tr>
						
						<tr>
							<td colspan="2"><?php echo $form->labelEx($model,'messenger_id'); ?></td>
						</tr>
						<tr>
							<td colspan="2">
								<?php if($model->messenger_id) $messenger = $this->objectToArray(json_decode($model->messenger_id)); ?>
									<?php if(!$model->isNewRecord && count($messenger)>0) { 
											$i=0;
											foreach($messenger as $name => $value) { ?>
											<div class="messenger">
												<?php echo $form->dropDownList($model,'messenger_name[]',array(
														'yahoomessenger'=>'Yahoo',
														'hotmailmessenger'=>'Hotmail / MSN',
														'gtalk'=>'Google Talk',
														'skypeid' => 'Skype',
														'bonjour' => 'Bonjour',
														'AIM' => 'AIM',	
														), 
														$htmlOptions=array(
															'empty'=>'- Messenger ID -',
															'options'=>array($name=>array('selected'=>'selected')),
															'id'=>'',
															'class' => 'reqdmn fields'));
												?>
											
												<?php echo $form->textField($model,'messenger_id[]',array('id'=>'', 'class'=>'reqdmn fields textFieldMedium', 'value'=>$value)); ?>
												<?php if(count($messenger) == 1) { ?>
													<input type="button" value="+" onClick="addRow(this);" class="addsn">
													<input type="button" value="-" onClick="dltRow(this);" style="display:none;" class="dltsn">
												<?php } else if ($i == count($messenger)-1) { ?>
													<input type="button" value="+" onClick="addRow(this);" class="addsn">
													<input type="button" value="-" onClick="dltRow(this);" class="dltsn">
												<?php } else { ?>
													<input type="button" value="+" onClick="addRow(this);" style="display:none;" class="addsn">
													<input type="button" value="-" onClick="dltRow(this);" class="dltsn">
												<?php } ?>
											</div>
									<?php $i++; } 
								} else {?>
									<div class="messenger">
										<?php echo $form->dropDownList($model,'messenger_name[]',array(
												'yahoomessenger'=>'Yahoo',
												'hotmailmessenger'=>'Hotmail / MSN',
												'gtalk'=>'Google Talk',
												'skypeid' => 'Skype',
												'bonjour' => 'Bonjour',
												'AIM' => 'AIM',												
												), 
												$htmlOptions=array(
													'empty'=>'- Messenger ID -',
													//'options'=>array($name=>array('selected'=>'selected')),
													'id'=>'',
													'class' => 'reqdmn fields'));
										?>
										<?php echo $form->textField($model,'messenger_id[]',array('id'=>'', 'class'=>'reqdmn fields textFieldMedium')); ?>
										<input type="button" value="+" onClick="addRow(this);" class="addsn">
										<input type="button" value="-" onClick="dltRow(this);" style="display:none;" class="dltsn">
									</div>
								<?php } ?>
								<?php echo $form->error($model,'messenger_id'); ?>
							</td>
						</tr>
					</table>
			</fieldset>
		</div>
		
		<div class="pfMailingAddress">
			<fieldset>
				<legend>Mailing Address</legend>
					<table>
						<tr>
							<td><?php echo $form->labelEx($model,'house_no'); ?></td>
							<td><?php echo $form->labelEx($model,'street'); ?></td>
						</tr>
						<tr>
							<td>
								<?php echo $form->textField($model,'house_no',array('size'=>60,'maxlength'=>255, 'class'=>'fields textFieldMedium')); ?>
								<?php echo $form->error($model,'house_no'); ?>
							</td>
							<td>
								<?php echo $form->textField($model,'street',array('size'=>60,'maxlength'=>255, 'class'=>'fields textFieldMedium')); ?>
								<?php echo $form->error($model,'street'); ?>								
							</td>
						</tr>
						<tr>
							<td><?php echo $form->labelEx($model,'area'); ?></td>
							<td><?php echo $form->labelEx($model,'city'); ?></td>
						</tr>
						<tr>
							<td>
								<?php echo $form->textField($model,'area',array('size'=>60,'maxlength'=>255, 'class'=>'fields textFieldMedium')); ?>
								<?php echo $form->error($model,'area'); ?>
							</td>
							<td>
								<?php echo $form->textField($model,'city',array('size'=>60,'maxlength'=>255, 'class'=>'reqd fields textFieldMedium')); ?>
								<?php echo $form->error($model,'city'); ?>								
							</td>
						</tr>
						<tr>
							<td><?php echo $form->labelEx($model,'state'); ?></td>
							<td><?php echo $form->labelEx($model,'country'); ?></td>
						</tr>
						<tr>
							<td>
								<?php echo $form->textField($model,'state',array('size'=>60,'maxlength'=>255, 'class'=>'reqd fields textFieldMedium')); ?>
								<?php echo $form->error($model,'state'); ?>
							</td>
							<td>
								<?php echo $form->textField($model,'country',array('size'=>60,'maxlength'=>255, 'class'=>'reqd fields textFieldMedium')); ?>
								<?php echo $form->error($model,'country'); ?>								
							</td>
						</tr>
						<tr>
							<td><?php echo $form->labelEx($model,'zip'); ?></td>
							<td></td>
						</tr>
						<tr>
							<td>
								<?php echo $form->textField($model,'zip',array('size'=>60,'maxlength'=>255, 'class'=>'reqd fields textFieldDate')); ?>
								<?php echo $form->error($model,'zip'); ?>								
							</td>
							<td></td>
						</tr>
					</table>
			</fieldset>
		</div>

		<div class="pfOtherDetails">
			<fieldset>
				<legend>Education &amp; Profession</legend>
					<table>
						<tr>
							<td><?php echo $form->labelEx($model,'highest_education'); ?></td>
							<td><?php echo $form->labelEx($model,'profession'); ?></td>
						</tr>
						<tr>
							<td>
								<?php echo $form->textField($model,'highest_education',array('size'=>60,'maxlength'=>255, 'class'=>'reqd fields textFieldMedium')); ?>
								<?php echo $form->error($model,'highest_education'); ?>
							</td>
							<td>
								<?php echo $form->textField($model,'profession',array('size'=>60,'maxlength'=>255, 'class'=>'reqd fields textFieldMedium')); ?>
								<?php echo $form->error($model,'profession'); ?>								
							</td>
						</tr>
						<tr>
							<td><?php echo $form->labelEx($model,'languages_known'); ?></td>
							<td><?php echo $form->labelEx($model,'organization'); ?><div class="hint">Hold Ctrl to select multiple</div></td>
						</tr>
						<tr>
							<td>
								<?php $languages = json_decode($model->languages_known); ?>
									<?php if(!$model->isNewRecord && count($languages)>0) {
											for($i=0; $i<count($languages); $i++) {
									?>
											<div class="languages">
												<?php echo $form->textField($model,'languages_known[]',array('id'=>'', 'class'=>'reqd fields textFieldMedium', 'value'=>$languages[$i])); ?>
												<?php if(count($languages) == 1) {?>
												<input type="button" value="+" onClick="addRow(this);" class="addsn">
												<input type="button" value="-" onClick="dltRow(this);" style="display:none;" class="dltsn">
												<?php } else if ($i == count($languages)-1) {?>
												<input type="button" value="+" onClick="addRow(this);" class="addsn">
												<input type="button" value="-" onClick="dltRow(this);" class="dltsn">
												<?php } else { ?>
													<input type="button" value="+" onClick="addRow(this);" style="display:none;" class="addsn">
													<input type="button" value="-" onClick="dltRow(this);" class="dltsn">
												<?php }?>
											</div>
									<?php } 
								} else {?>
									<div class="languages">
										<?php echo $form->textField($model,'languages_known[]',array('id'=>'', 'class'=>'reqd fields textFieldMedium')); ?>
										<input type="button" value="+" onClick="addRow(this);" class="addsn">
										<input type="button" value="-" onClick="dltRow(this);" style="display:none;" class="dltsn">
									</div>
								<?php } ?>	
								<?php echo $form->error($model,'languages_known'); ?>
							</td>
							<td style="vertical-align: top;">
								<select multiple="multiple" style="width:80%; max-height: 140px;" name="CallersProfile[organization][]">
									<option value="">Select</option>
									<?php 
									if($model->organization) {
										$selectedOrgs = json_decode($model->organization);
									} else {
										$selectedOrgs = array();
									}
									//print_r($selectedOrgs);
									if($organizations) {
										foreach ($organizations as $value) { ?>
										<option value="<?php echo $value['id']; ?>" <?php echo in_array($value['id'], $selectedOrgs) ? 'selected="selected"' : '' ?>><?php echo $value['type'].': '.$value['name']; ?></option>
										<?php }
									} ?>
								</select>
							</td>
						</tr>
					</table>
			</fieldset>
		</div>		
	</div>
	<div class="row buttons submitButton">
		<?php echo CHtml::button($model->isNewRecord ? 'Submit' : 'Save', array('onClick'=>'submitProfile()', 'class'=>'grayButtons')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
function addRow(thisref) {
	var flag = true;
	$('input[type="text"]',$(thisref).parent()).each(function(){
		if($(this).val() == '') {
			$(this).addClass('errorClass');
			$('html, body').animate({scrollTop: $(".errorClass").offset().top - 35}, 'slow');
			flag = false;
		} else {
			$(this).removeClass('errorClass');
		}
	});
	if(flag) {
		var clone = $(thisref).parent().clone();
		clone.find('.dltsn').show();
		clone.find('input[type="text"]').val('');
		$(thisref).hide().next('.dltsn').show();
		clone.insertAfter($(thisref).parent());
	}
}

function dltRow(thisref) {
	var scope = '.'+$(thisref).parent().attr('class');
	if($(scope).length <= 2) {
		if($(thisref).parent(scope).index() == 0) {
			$(thisref).parent(scope).next(scope).find('.dltsn').hide();
			$(thisref).parent(scope).next(scope).find('.addsn').show();
		} else {
			$(thisref).parent(scope).prev(scope).find('.dltsn').hide();
			$(thisref).parent(scope).prev(scope).find('.addsn').show();
		}
	} else {
		if($(thisref).parent(scope).index() == Number($(scope).length)-1) {
			$(thisref).parent(scope).prev(scope).find('.addsn').show().find('.dltsn').show();
		}
	}
	$(thisref).parent().remove();
}

function submitProfile() {
	var flag = true;
	var flagSN = true;
	var flagChoice = false;
	var flagMN = true;
	var flagtmp = true;
	$('input.reqd, select.reqd', '#callers-profile-form').each(function() {
		if( $(this).prop('tagName') == 'INPUT') {
			if($(this).val() == '') {
				$(this).addClass('errorClass');
				$('html, body').animate({scrollTop: $(".errorClass").offset().top - 35}, 'slow');
				flag = false;
			} else {
				$(this).removeClass('errorClass');
			}
		} else {
			if($('option:selected', this).val() == '') {
				$(this).addClass('errorClass');
				$('html, body').animate({scrollTop: $(".errorClass").offset().top - 35}, 'slow');
				flag = false;
			} else {
				$(this).removeClass('errorClass');
			}
		}
	});
	if($('.reqdsn', '#callers-profile-form').length > 2) {
		flagChoice = true;
		$('.reqdsn', '#callers-profile-form').each(function() {
			if($(this).val() == '') {
				$(this).addClass('errorClass');
				$('html, body').animate({scrollTop: $(".errorClass").offset().top - 35}, 'slow');
				flagSN = false;
			} else {
				$(this).removeClass('errorClass');
			}
		});
	} else if ($('.reqdsn', '#callers-profile-form').length == 2) {
		$('.reqdsn', '#callers-profile-form').removeClass('errorClass');
		$('.reqdmn', '#callers-profile-form').each(function() {
			if($(this).val() == '') {
				flagtmp = false;
			}
		});
		if(!flagtmp) {
			$('.reqdsn', '#callers-profile-form').each(function() {
				if($(this).val() == '') {
					$(this).addClass('errorClass');
					$('html, body').animate({scrollTop: $(".errorClass").offset().top - 35}, 'slow');
					flagSN = false;
				} else {
					$(this).removeClass('errorClass');
				}
			});
		}
		if(flagSN) {
			flagChoice = true;
		}
	}
	if($('.reqdmn', '#callers-profile-form').length > 2) {
		flagChoice = true;
		$('.reqdmn', '#callers-profile-form').each(function() {
			if($(this).val() == '') {
				$(this).addClass('errorClass');
				$('html, body').animate({scrollTop: $(".errorClass").offset().top - 35}, 'slow');
				flagMN = false;
			} else {
				$(this).removeClass('errorClass');
			}
		});
	} else if($('.reqdmn', '#callers-profile-form').length == 2) {
		$('.reqdmn', '#callers-profile-form').removeClass('errorClass');
		if(!flagChoice) {
			$('.reqdmn', '#callers-profile-form').each(function() {
				if($(this).val() == '') {
					$(this).addClass('errorClass');
					$('html, body').animate({scrollTop: $(".errorClass").offset().top - 35}, 'slow');
					flagMN = false;
				} else {
					$(this).removeClass('errorClass');
				}
			});
			if(flagMN) {
				flagChoice = true;
			}
		}
	}
	if(flag && flagSN && flagMN && flagChoice) {
		$('.submitButton .grayButtons').prop('disable', true).addClass('opacityp5');
		$('#callers-profile-form').submit();
	}
}
$(document).ready(function(){
	$('#ytCallersProfile_profile_pic').val('<?php echo $model->profile_pic;?>');
	//alert($('#ytCallersProfile_profile_pic').val());
});
</script>