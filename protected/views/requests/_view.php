<?php
/* @var $this RequestsController */
/* @var $model RequestManagement */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('callee_id')); ?>:</b>
	<?php echo CHtml::encode($data->callee_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('caller_id')); ?>:</b>
	<?php echo CHtml::encode($data->caller_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('owner_id')); ?>:</b>
	<?php echo CHtml::encode($data->owner_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requested_by')); ?>:</b>
	<?php echo CHtml::encode($data->requested_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('responded_by')); ?>:</b>
	<?php echo CHtml::encode($data->responded_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approved_ignored')); ?>:</b>
	<?php echo CHtml::encode($data->approved_ignored); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	*/ ?>

</div>