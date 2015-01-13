<?php
/* @var $this MadhooController */
/* @var $model Callees */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'callees-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php if(isset($_GET["madhooexists"]) && $_GET["madhooexists"]) { ?>
		<div class="flash-error">This madhoo is present in the system already</div>
	<?php } ?>
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->hiddenField($model,'caller_id',array('size'=>20,'maxlength'=>20,'value'=>Yii::app()->user->id)); ?>
		<?php echo $form->hiddenField($model,'owned_by',array('size'=>20,'maxlength'=>20,'value'=>NULL)); ?>
	</div>

	<div class="profileForm">

		<div class="pfPersonalInformation">
			<fieldset>
				<legend>Personal Information</legend>
					<div class="hint"><span class="required">*</span> Information contained in this section will be sent to your mail</div>
					<table>
						<tr>
							<td><?php echo $form->labelEx($model,'first_name', array("name"=>"PersonalInfo[first_name]", "for"=>"PersonalInfo_first_name")); ?></td>
							<td><?php echo $form->labelEx($model,'last_name', array("name"=>"PersonalInfo[last_name]", "for"=>"PersonalInfo_last_name")); ?></td>
						</tr>
						<tr>
							<td>
								<?php echo CHtml::activeTextField($model, 'first_name', array("name"=>"PersonalInfo[first_name]",'size'=>60,'maxlength'=>255, 'class'=>'fields textFieldMedium')); ?>
								<?php echo $form->error($model,'first_name'); ?>
							</td>
							<td>
								<?php echo CHtml::activeTextField($model,'last_name',array("name"=>"PersonalInfo[last_name]", 'size'=>60,'maxlength'=>255, 'class'=>'fields textFieldMedium')); ?> 
								<?php echo $form->error($model,'last_name'); ?>
							</td>
						</tr>
						<tr>
							<td><?php echo $form->labelEx($model,'family_name',array("name"=>"PersonalInfo[family_name]", "for"=>"PersonalInfo_family_name")); ?></td>
							<td><?php echo $form->labelEx($model,'nick_name',array("name"=>"PersonalInfo[nick_name]", "for"=>"PersonalInfo_nick_name")); ?></td>
						</tr>
						<tr>
							<td>
								<?php echo CHtml::activeTextField($model,'family_name',array("name"=>"PersonalInfo[family_name]", 'size'=>60,'maxlength'=>255, 'class'=>'fields textFieldMedium')); ?> 
								<?php echo $form->error($model,'family_name'); ?>
							</td>
							<td>
								<?php echo CHtml::activeTextField($model,'nick_name',array("name"=>"PersonalInfo[nick_name]", 'size'=>60,'maxlength'=>255, 'class'=>'fields textFieldMedium')); ?> 
								<?php echo $form->error($model,'nick_name'); ?>
							</td>
						</tr>
						<tr>
							<td><?php echo $form->labelEx($model,'profession',array("name"=>"PersonalInfo[profession]", "for"=>"PersonalInfo_profession")); ?></td>
							<td></td>
						</tr>
						<tr>
							<td>
								<?php echo CHtml::activeTextField($model,'profession',array("name"=>"PersonalInfo[profession]", 'size'=>60,'maxlength'=>255, 'class'=>'fields textFieldMedium')); ?> 
								<?php echo $form->error($model,'profession'); ?>
							</td>
							<td></td>
						</tr>
						<tr>
							<td><?php echo $form->labelEx($model,'house_no',array("name"=>"PersonalInfo[house_no]", "for"=>"PersonalInfo_house_no")); ?></td>
							<td><?php echo $form->labelEx($model,'street',array("name"=>"PersonalInfo[street]", "for"=>"PersonalInfo_street")); ?></td>
						</tr>
						<tr>
							<td>
								<?php echo CHtml::activeTextField($model,'house_no',array("name"=>"PersonalInfo[house_no]", 'size'=>60,'maxlength'=>255, 'class'=>'fields textFieldMedium')); ?> 
								<?php echo $form->error($model,'house_no'); ?>
							</td>
							<td>
								<?php echo CHtml::activeTextField($model,'street',array("name"=>"PersonalInfo[street]", 'size'=>60,'maxlength'=>255, 'class'=>'fields textFieldMedium')); ?> 
								<?php echo $form->error($model,'street'); ?>
							</td>
						</tr>
						<tr>
							<td><?php echo $form->labelEx($model,'email_id',array("name"=>"PersonalInfo[email_id]", "for"=>"PersonalInfo_email_id")); ?></td>
							<td><?php echo $form->labelEx($model,'phone_number',array("name"=>"PersonalInfo[phone_number]", "for"=>"PersonalInfo_phone_number")); ?></td>
						</tr>
						<tr>
							<td>
								<?php echo CHtml::activeTextField($model,'email_id',array("name"=>"PersonalInfo[email_id]", 'size'=>60,'maxlength'=>255, 'class'=>'fields textFieldMedium')); ?> 
								<?php echo $form->error($model,'email_id'); ?>
							</td>
							<td>
								<?php echo CHtml::activeTextField($model,'phone_number',array("name"=>"PersonalInfo[phone_number]", 'size'=>60,'maxlength'=>255, 'class'=>'fields textFieldMedium')); ?> 
								<?php echo $form->error($model,'phone_number'); ?>
							</td>
						</tr>
						<tr>
							<td>
								<label>Social Network Ids</label>
							</td>
							<td>
								<label>Messenger Ids</label>
							</td>
						</tr>
						<tr>
							<td>
								<div class="social-network">
									<select name="PersonalInfo[social_network_ids][][social_network_id]" class="fields">
										<option value="Facebook">Facebook</option>
										<option value="Twitter">Twitter</option>
										<option value="Google Plus">Google +</option>
									</select>
									<input name="PersonalInfo[social_network_ids][][social_network_value]" type="text" class="fields" />
									<button type="button" class="addsn" onclick="addRow(this)">+</button>
									<button type="button" class="dltsn" onclick="dltRow(this)">X</button>
								</div>
							</td>
							<td>
								<div class="messenger">
									<select name="PersonalInfo[messenger_ids][][messenger_id]" class="fields">
										<option value="Skype">Skype</option>
										<option value="Hotmail Messenger">Hotmail Messenger</option>
										<option value="Yahoo Messenger">Yahoo Messenger</option>
									</select>
									<input name="PersonalInfo[messenger_ids][][messenger_value]" type="text" class="fields" />
									<button type="button" class="addsn" onclick="addRow(this)">+</button>
									<button type="button" class="dltsn" onclick="dltRow(this)">X</button>
								</div>
							</td>
						</tr>
					</table>
			</fieldset>
		</div>
		
		<div class="pfGenderDOB">
			<fieldset>
				<legend>Gender &amp; Age</legend>
					<table>
						<tr>
							<td><?php echo $form->labelEx($model,'gender'); ?></td>
							<td><?php echo $form->labelEx($model,'age'); ?></td>
						</tr>
						<tr>
							<td>
								<?php echo $form->dropDownList($model,'gender', array('MALE'=>'Male', 'FEMALE'=>'Female', 'OTHER'=>'Other'), array('empty'=>'Select', 'class'=>'reqd selectDD selectSmall')) ?> 
								<?php echo $form->error($model,'gender'); ?>
							</td>
							<td>
								<?php $ageArr = array(); 
									for($i=5;$i<100;$i++) {
										$ageArr[$i] = $i;
									}
								?>
								<?php echo $form->dropDownList($model,'age', $ageArr, array('empty'=>'Select', 'class'=>'reqd selectDD selectSmall')) ?>
								<?php echo $form->error($model,'age'); ?>
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
							<td><?php echo $form->labelEx($model,'area'); ?></td>
							<td><?php echo $form->labelEx($model,'city'); ?><span class="required">*</span></td>
						</tr>
						<tr>
							<td>
								<?php echo $form->textField($model,'area',array('size'=>60,'maxlength'=>255, 'class'=>'fields textFieldMedium')); ?>
								<?php echo $form->error($model,'area'); ?>
							</td>
							<td>
								<?php echo $form->textField($model,'city',array('size'=>60,'maxlength'=>255, 'class'=>'city ctreqd fields textFieldMedium')); ?>
								<?php echo $form->error($model,'city'); ?>						
							</td>
						</tr>
						<tr>
							<td><?php echo $form->labelEx($model,'state'); ?></td>
							<td><?php echo $form->labelEx($model,'country'); ?><span class="required">*</span></td>
						</tr>
						<tr>
							<td>
								<?php echo $form->textField($model,'state',array('size'=>60,'maxlength'=>255, 'class'=>'fields textFieldMedium')); ?>
								<?php echo $form->error($model,'state'); ?>
							</td>
							<td>
								<?php echo $form->textField($model,'country',array('size'=>60,'maxlength'=>255, 'class'=>'country ctreqd fields textFieldMedium')); ?>
								<?php echo $form->error($model,'country'); ?>								
							</td>
						</tr>
						<tr>
							<td><?php echo $form->labelEx($model,'zip'); ?></td>
							<td></td>
						</tr>
						<tr>
							<td>
								<?php echo $form->textField($model,'zip',array('size'=>60,'maxlength'=>255, 'class'=>'fields textFieldDate')); ?>
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
							<td><?php echo $form->labelEx($model,'highest_qualification'); ?></td>
						</tr>
						<tr>
							<td>
								<?php echo $form->textField($model,'highest_qualification',array('size'=>60,'maxlength'=>255, 'class'=>'reqd fields textFieldMedium')); ?>
								<?php echo $form->error($model,'highest_qualification'); ?>
							</td>
						</tr>
					</table>
			</fieldset>
		</div>
		
		<div class="pfLanguages">
			<fieldset>
				<legend>Languages, Religion &amp; Status</legend>
					<table>
						<tr>
							<td><?php echo $form->labelEx($model,'language_read'); ?></td>
							<td><?php echo $form->labelEx($model,'language_write'); ?></td>
						</tr>
						<tr>
							<td>
								<?php echo $form->textField($model,'language_read',array('size'=>60,'maxlength'=>255, 'class'=>'reqd fields textFieldMedium')); ?>
								<?php echo $form->error($model,'language_read'); ?>
							</td>
							<td>
								<?php echo $form->textField($model,'language_write',array('size'=>60,'maxlength'=>255, 'class'=>'reqd fields textFieldMedium')); ?>
								<?php echo $form->error($model,'language_write'); ?>								
							</td>
						</tr>
						<tr>
							<td><?php echo $form->labelEx($model,'language_speak'); ?></td>
							<td><?php echo $form->labelEx($model,'religion'); ?></td>
						</tr>
						<tr>
							<td>
								<?php echo $form->textField($model,'language_speak',array('size'=>60,'maxlength'=>255, 'class'=>'reqd fields textFieldMedium')); ?>
								<?php echo $form->error($model,'language_speak'); ?>
							</td>
							<td>
								<?php echo $form->textField($model,'religion',array('size'=>60,'maxlength'=>255, 'class'=>'reqd fields textFieldMedium')); ?>
								<?php echo $form->error($model,'religion'); ?>								
							</td>
						</tr>
						<tr>
							<td colspan="2"><?php echo $form->labelEx($model,'status'); ?></td>
						</tr>
						<tr>
							<td colspan="2">
								<?php echo $form->dropDownList($model,'status', array('PARTIALLY_CONVINCED'=>'Partially Convinced','ACCEPTED'=>'Accepted', 'CONVINCED'=>'Convinced', 'NO_INTERACTION_YET'=>'No interaction yet', 'DISAGREED'=>'Disagreed'), array('empty'=>'Select', 'class'=>'reqd selectDD selectMedium')) ?>
								<?php echo $form->error($model,'status'); ?>
							</td>
						</tr>
					</table>
			</fieldset>
		</div>		
		
		<div class="pfLanguages">
			<fieldset>
				<legend>Additional Information</legend>
					<table>
						<tr>
							<td><?php echo $form->labelEx($model,'note'); ?></td>
						</tr>
						<tr>
							<td><?php echo $form->textArea($model,'note', array('rows'=>10, 'cols'=>100, 'class'=>'fields')); ?></td>
						</tr>
					</table>
			</fieldset>
		</div>		
		
	</div> <!-- Profile Form -->
	
	
	<div class="row">
		<?php if( $model->isNewRecord ) { ?>
			<?php echo $form->hiddenField($model,'created_at', array('value'=>date('Y-m-d H:i:s'))); ?>
		<?php } else {?>
			<?php echo $form->hiddenField($model,'created_at'); ?>
		<?php }?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'updated_at', array('value'=>date('Y-m-d H:i:s'))); ?>
	</div>

	<div class="row buttons tac profile_submit">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save Changes', array('class'=>'grayButtons p5')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
function addRow(thisref) {
	var flag = true;
	$('input[type="text"], select',$(thisref).parent()).each(function(){
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

$(document).ready(function() {
	$('#Callees_gender').focus();
	$('input[type="submit"]').click(function(e) {
		var validMadhooFlag = true;
		e.preventDefault();
		$('.reqd').each(function(){
			if( '' == $(this).val() ) {
				validMadhooFlag = false;
				$(this).addClass('errorClass');
				$('html, body').animate({scrollTop: $(".errorClass").offset().top - 35}, 'slow');
			} else {
				$(this).removeClass('errorClass');
			}
		});
		if(validMadhooFlag) {
			//email or phone or city and country is mandatory
			if(!$(".city").val().trim() || !$(".country").val().trim()) {
				validMadhooFlag = false;
				$(".city").addClass("errorClass");
			} else {
				$(this).removeClass('errorClass');
			}
		}
		if($('.errorClass').length > 0) {
			$('html, body').animate({scrollTop: $(".errorClass").offset().top - 35}, 'slow');
		}
		if(validMadhooFlag) {
			$('#callees-form .grayButtons').prop('disable', true).addClass('opacityp5');
			$(this).parents('form').submit();
		}
	});
});
</script>