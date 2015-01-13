<?php
/* @var $this DaeeController */
/* @var $dataProvider CActiveDataProvider */

/* $this->breadcrumbs=array(
	'Callers Profiles',
);
 */
$this->menu=array(
	array('label'=>'Create CallersProfile', 'url'=>array('create')),
	array('label'=>'Manage CallersProfile', 'url'=>array('admin')),
);
?>

<h1>Callers Profiles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
