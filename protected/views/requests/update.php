<?php
/* @var $this RequestsController */
/* @var $model RequestManagement */

$this->breadcrumbs=array(
	'Request Managements'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RequestManagement', 'url'=>array('index')),
	array('label'=>'Create RequestManagement', 'url'=>array('create')),
	array('label'=>'View RequestManagement', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RequestManagement', 'url'=>array('admin')),
);
?>

<h1>Update RequestManagement <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>