<?php
/* @var $this DaeeController */
/* @var $model CallersProfile */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'callers-profile-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'caller_id'); ?>
		<?php echo $form->textField($model,'caller_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'caller_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>255)); ?>
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
		<?php echo $form->textField($model,'gender',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'gender'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_of_birth'); ?>
		<?php echo $form->textField($model,'date_of_birth'); ?>
		<?php echo $form->error($model,'date_of_birth'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email_id'); ?>
		<?php echo $form->textField($model,'email_id',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'social_network_id'); ?>
		<?php echo $form->textArea($model,'social_network_id',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'social_network_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'messenger_id'); ?>
		<?php echo $form->textArea($model,'messenger_id',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'messenger_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'house_no'); ?>
		<?php echo $form->textField($model,'house_no',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'house_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'street'); ?>
		<?php echo $form->textField($model,'street',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'street'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'area'); ?>
		<?php echo $form->textField($model,'area',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'area'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'state'); ?>
		<?php echo $form->textField($model,'state',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'country'); ?>
		<?php echo $form->textField($model,'country',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'country'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'zip'); ?>
		<?php echo $form->textField($model,'zip'); ?>
		<?php echo $form->error($model,'zip'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'primary_phone'); ?>
		<?php echo $form->textField($model,'primary_phone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'primary_phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'secondary_phone'); ?>
		<?php echo $form->textField($model,'secondary_phone',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'secondary_phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'highest_education'); ?>
		<?php echo $form->textField($model,'highest_education',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'highest_education'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'profession'); ?>
		<?php echo $form->textField($model,'profession',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'profession'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type_of_user'); ?>
		<?php echo $form->textField($model,'type_of_user',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'type_of_user'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'profile_pic'); ?>
		<?php echo $form->textField($model,'profile_pic',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'profile_pic'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'languages_known'); ?>
		<?php echo $form->textArea($model,'languages_known',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'languages_known'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'callee_created'); ?>
		<?php echo $form->textArea($model,'callee_created',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'callee_created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'callee_owned'); ?>
		<?php echo $form->textArea($model,'callee_owned',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'callee_owned'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'can_own_cnt'); ?>
		<?php echo $form->textField($model,'can_own_cnt'); ?>
		<?php echo $form->error($model,'can_own_cnt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unassigned_madhoo'); ?>
		<?php echo $form->textArea($model,'unassigned_madhoo',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'unassigned_madhoo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'can_invite'); ?>
		<?php echo $form->textField($model,'can_invite'); ?>
		<?php echo $form->error($model,'can_invite'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
		<?php echo $form->error($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_at'); ?>
		<?php echo $form->textField($model,'updated_at'); ?>
		<?php echo $form->error($model,'updated_at'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->