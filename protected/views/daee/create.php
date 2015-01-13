<?php
/* @var $this DaeeController */
/* @var $model CallersProfile */

/* $this->breadcrumbs=array(
	'Callers Profiles'=>array('index'),
	'Create',
);
 */
$this->menu=array(
	array('label'=>'List CallersProfile', 'url'=>array('index')),
	array('label'=>'Manage CallersProfile', 'url'=>array('admin')),
);
?>

<h1>Create CallersProfile</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>