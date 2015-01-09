<?php
/* @var $this RequestsController */
/* @var $model RequestManagement */

$this->breadcrumbs=array(
	'Request Managements'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RequestManagement', 'url'=>array('index')),
	array('label'=>'Manage RequestManagement', 'url'=>array('admin')),
);
?>

<h1>Create RequestManagement</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>