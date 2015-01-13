<?php
/* @var $this ProfileController */
/* @var $model CallersProfile */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('caller_id')); ?>:</b>
	<?php echo CHtml::encode($data->caller_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b>
	<?php echo CHtml::encode($data->first_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b>
	<?php echo CHtml::encode($data->last_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('family_name')); ?>:</b>
	<?php echo CHtml::encode($data->family_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nick_name')); ?>:</b>
	<?php echo CHtml::encode($data->nick_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo CHtml::encode($data->gender); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('date_of_birth')); ?>:</b>
	<?php echo CHtml::encode($data->date_of_birth); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email_id')); ?>:</b>
	<?php echo CHtml::encode($data->email_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('social_network_id')); ?>:</b>
	<?php echo CHtml::encode($data->social_network_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('messenger_id')); ?>:</b>
	<?php echo CHtml::encode($data->messenger_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('house_no')); ?>:</b>
	<?php echo CHtml::encode($data->house_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('street')); ?>:</b>
	<?php echo CHtml::encode($data->street); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('area')); ?>:</b>
	<?php echo CHtml::encode($data->area); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city')); ?>:</b>
	<?php echo CHtml::encode($data->city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('state')); ?>:</b>
	<?php echo CHtml::encode($data->state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country')); ?>:</b>
	<?php echo CHtml::encode($data->country); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('zip')); ?>:</b>
	<?php echo CHtml::encode($data->zip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('primary_phone')); ?>:</b>
	<?php echo CHtml::encode($data->primary_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('secondary_phone')); ?>:</b>
	<?php echo CHtml::encode($data->secondary_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('highest_education')); ?>:</b>
	<?php echo CHtml::encode($data->highest_education); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('profession')); ?>:</b>
	<?php echo CHtml::encode($data->profession); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type_of_user')); ?>:</b>
	<?php echo CHtml::encode($data->type_of_user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('profile_pic')); ?>:</b>
	<?php echo CHtml::encode($data->profile_pic); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('languages_known')); ?>:</b>
	<?php echo CHtml::encode($data->languages_known); ?>
	<br />

	*/ ?>

</div>