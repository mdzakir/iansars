<?php
/* @var $this RequestsController */
/* @var $model RequestManagement */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'request-management-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'callee_id'); ?>
		<?php echo $form->textField($model,'callee_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'callee_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'caller_id'); ?>
		<?php echo $form->textField($model,'caller_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'caller_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'owner_id'); ?>
		<?php echo $form->textField($model,'owner_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'owner_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'requested_by'); ?>
		<?php echo $form->textField($model,'requested_by',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'requested_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'responded_by'); ?>
		<?php echo $form->textField($model,'responded_by',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'responded_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'approved_ignored'); ?>
		<?php echo $form->textField($model,'approved_ignored',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'approved_ignored'); ?>
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