<?php
/* @var $this DaeeController */
/* @var $model CallersProfile */

/* $this->breadcrumbs=array(
	'Callers Profiles'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
); */

$this->menu=array(
	array('label'=>'List CallersProfile', 'url'=>array('index')),
	array('label'=>'Create CallersProfile', 'url'=>array('create')),
	array('label'=>'View CallersProfile', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CallersProfile', 'url'=>array('admin')),
);
?>

<h1>Update CallersProfile <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>