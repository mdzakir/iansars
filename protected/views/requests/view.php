<?php
/* @var $this RequestsController */
/* @var $model RequestManagement */

$this->breadcrumbs=array(
	'Request Managements'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RequestManagement', 'url'=>array('index')),
	array('label'=>'Create RequestManagement', 'url'=>array('create')),
	array('label'=>'Update RequestManagement', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RequestManagement', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RequestManagement', 'url'=>array('admin')),
);
?>

<h1>View RequestManagement #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'callee_id',
		'caller_id',
		'owner_id',
		'requested_by',
		'responded_by',
		'approved_ignored',
		'created_at',
		'updated_at',
	),
)); ?>
