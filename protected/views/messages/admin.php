<?php
/* @var $this MessagesController */
/* @var $model Messages */

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'messages-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'sender_id',
		'receiver_id',
		'type',
		'sender_status',
		'receiver_status',
		'title',
		/*
		'description',
		'created_at',
		'updated_at',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
