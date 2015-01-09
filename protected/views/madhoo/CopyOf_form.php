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

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->hiddenField($model,'caller_id',array('size'=>20,'maxlength'=>20,'value'=>Yii::app()->user->id)); ?>
		<?php echo $form->hiddenField($model,'owned_by',array('size'=>20,'maxlength'=>20,'value'=>Yii::app()->user->id)); ?>
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
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>255, 'class'=>'reqd')); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>255, 'class'=>'reqd')); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'family_name'); ?>
		<?php echo $form->textField($model,'family_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'family_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nick_name'); ?>
		<?php echo $form->textField($model,'nick_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'nick_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->dropDownList($model,'gender', array('MALE'=>'Male', 'FEMALE'=>'Female', 'OTHER'=>'Other'), array('empty'=>'Select', 'class'=>'reqd selectDD selectSmall')) ?>
		<?php echo $form->error($model,'gender'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'age'); ?>
		<?php $ageArr = array(); 
			for($i=5;$i<100;$i++) {
				$ageArr[$i] = $i;
			}
		?>
		<?php echo $form->dropDownList($model,'age', $ageArr, array('empty'=>'Select', 'class'=>'reqd selectDD selectSmall')) ?>
		<?php echo $form->error($model,'age'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'highest_qualification'); ?>
		<?php echo $form->textField($model,'highest_qualification',array('size'=>60,'maxlength'=>255,'class'=>'reqd')); ?>
		<?php echo $form->error($model,'highest_qualification'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'profession'); ?>
		<?php echo $form->textField($model,'profession',array('size'=>60,'maxlength'=>255,'class'=>'reqd')); ?>
		<?php echo $form->error($model,'profession'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'house_no'); ?>
		<?php echo $form->textField($model,'house_no',array('size'=>60,'maxlength'=>255,'class'=>'reqd')); ?>
		<?php echo $form->error($model,'house_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'street'); ?>
		<?php echo $form->textField($model,'street',array('size'=>60,'maxlength'=>255,'class'=>'reqd')); ?>
		<?php echo $form->error($model,'street'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'area'); ?>
		<?php echo $form->textField($model,'area',array('size'=>60,'maxlength'=>255,'class'=>'reqd')); ?>
		<?php echo $form->error($model,'area'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('size'=>60,'maxlength'=>255,'class'=>'reqd')); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'state'); ?>
		<?php echo $form->textField($model,'state',array('size'=>60,'maxlength'=>255,'class'=>'reqd')); ?>
		<?php echo $form->error($model,'state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'country'); ?>
		<?php echo $form->textField($model,'country',array('size'=>60,'maxlength'=>255,'class'=>'reqd')); ?>
		<?php echo $form->error($model,'country'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'zip'); ?>
		<?php echo $form->textField($model,'zip',array('class'=>'reqd')); ?>
		<?php echo $form->error($model,'zip'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'language_read'); ?>
		<?php echo $form->textField($model,'language_read',array('size'=>60,'maxlength'=>255,'class'=>'reqd')); ?>
		<?php echo $form->error($model,'language_read'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'language_write'); ?>
		<?php echo $form->textField($model,'language_write',array('size'=>60,'maxlength'=>255,'class'=>'reqd')); ?>
		<?php echo $form->error($model,'language_write'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'language_speak'); ?>
		<?php echo $form->textField($model,'language_speak',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'language_speak'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'religion'); ?>
		<?php echo $form->textField($model,'religion',array('size'=>60,'maxlength'=>255,'class'=>'reqd')); ?>
		<?php echo $form->error($model,'religion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email_id'); ?>
		<?php echo $form->textField($model,'email_id',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone_number'); ?>
		<?php echo $form->textField($model,'phone_number',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'phone_number'); ?>
	</div>

	<div class="row">
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
									'class' => 'reqdsn selectDD selectMedium'));
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
									'id'=>'',
									'class' => 'reqdsn selectDD selectMedium'));
						?>
								
				<?php echo $form->textField($model,'social_network_id[]',array('id'=>'', 'class'=>'reqdsn fields textFieldMedium')); ?>
				<input type="button" value="+" onClick="addRow(this);" class="addsn">
				<input type="button" value="-" onClick="dltRow(this);" style="display:none;" class="dltsn">
			</div>
		<?php } ?>
		<?php echo $form->error($model,'social_network_id'); ?>
	</div>

	<div class="row">
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
									'class' => 'reqdmn selectDD selectMedium'));
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
							'id'=>'',
							'class' => 'reqdmn selectDD selectMedium'));
				?>
				<?php echo $form->textField($model,'messenger_id[]',array('id'=>'', 'class'=>'reqdmn fields textFieldMedium')); ?>
				<input type="button" value="+" onClick="addRow(this);" class="addsn">
				<input type="button" value="-" onClick="dltRow(this);" style="display:none;" class="dltsn">
			</div>
		<?php } ?>
		<?php echo $form->error($model,'messenger_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', array('ACCEPTED'=>'Accepted', 'CONVINCED'=>'Convinced', 'IGNORED'=>'Ignore'), array('empty'=>'Select', 'class'=>'reqd selectDD selectSmall')) ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php if( $model->isNewRecord ) { ?>
			<?php echo $form->hiddenField($model,'created_at', array('value'=>date('Y-m-d H:i:s'))); ?>
		<?php } else {?>
			<?php echo $form->hiddenField($model,'created_at'); ?>
		<?php }?>
	</div>

	<div class="row">
		<?php if( $model->isNewRecord ) { ?>
			<?php echo $form->hiddenField($model,'updated_at', array('value'=>date('Y-m-d H:i:s'))); ?>
		<?php } else {?>
			<?php echo $form->hiddenField($model,'updated_at'); ?>
		<?php }?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
function addRow(thisref) {
	var flag = true;
	$('input[type="text"], select',$(thisref).parent()).each(function(){
		if($(this).val() == '') {
			$(this).addClass('errorClass');
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

$(document).ready(function(){
	$('input[type="submit"]').click(function(e){
		var validMadhooFlag = true;
		e.preventDefault();
		$('.reqd').each(function(){
			if( '' == $(this).val() ) {
				validMadhooFlag = false;
				$(this).addClass('errorClass');
			} else {
				$(this).removeClass('errorClass');
			}
		});
		if($('.errorClass').length > 0) {
			$(document).animate({ scrollTop : $('.errorClass').first().offset().top });
		}
		if(validMadhooFlag) {
			$(this).parents('form').submit();
		}
	});
});
</script>