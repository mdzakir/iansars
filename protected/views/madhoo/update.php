<?php
/* @var $this MadhooController */
/* @var $model Callees */

/* $this->breadcrumbs=array(
	'Callees'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
); */

$this->menu=array(
	array('label'=>'List Callees', 'url'=>array('index')),
	array('label'=>'Create Callees', 'url'=>array('create')),
	array('label'=>'View Callees', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Callees', 'url'=>array('mymadhoo')),
);
?>

<h1>Update Callees <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>