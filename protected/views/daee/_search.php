<?php
/* @var $this DaeeController */
/* @var $model CallersProfile */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<table>
		<tr>
			<th><?php echo $form->label($model,'gender'); ?></th>
			<td><?php echo $form->textField($model,'gender',array('size'=>6,'maxlength'=>6, 'class'=>'textFieldDate fields')); ?></td>
			<td></td>
			<th><?php echo $form->label($model,'date_of_birth'); ?></th>
			<td><?php echo $form->textField($model,'date_of_birth',array('class'=>'textFieldDate fields')); ?></td>
		</tr>
		<tr>
			<th><?php echo $form->label($model,'area'); ?></th>
			<td><?php echo $form->textField($model,'area',array('size'=>60,'maxlength'=>255, 'class'=>'textFieldSmall fields')); ?></td>
			<td></td>
			<th><?php echo $form->label($model,'city'); ?></th>
			<td><?php echo $form->textField($model,'city',array('size'=>60,'maxlength'=>255, 'class'=>'textFieldSmall fields')); ?></td>
		</tr>
		<tr>
			<th><?php echo $form->label($model,'state'); ?></th>
			<td><?php echo $form->textField($model,'state',array('size'=>60,'maxlength'=>255, 'class'=>'textFieldSmall fields')); ?></td>
			<td></td>
			<th><?php echo $form->label($model,'country'); ?></th>
			<td><?php echo $form->textField($model,'country',array('size'=>60,'maxlength'=>255, 'class'=>'textFieldSmall fields')); ?></td>
		</tr>
		<tr>
			<th><?php echo $form->label($model,'profession'); ?></th>
			<td><?php echo $form->textField($model,'profession',array('size'=>60,'maxlength'=>255, 'class'=>'textFieldSmall fields')); ?></td>
			<td></td>
			<th><?php echo $form->label($model,'languages_known'); ?></th>
			<td><?php echo $form->textArea($model,'languages_known',array('rows'=>6, 'cols'=>50, 'class'=>'textAreaSmall fields')); ?></td>
		</tr>
	</table>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search',array('class'=>'grayButtons lfloat ml10i')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->