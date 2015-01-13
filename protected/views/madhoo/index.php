<?php
/* @var $this MadhooController */
/* @var $dataProvider CActiveDataProvider */

/* $this->breadcrumbs=array(
	'Callees',
); */

$this->menu=array(
	array('label'=>'Create Callees', 'url'=>array('create')),
	array('label'=>'Manage Callees', 'url'=>array('admin')),
);
?>

<h1>Callees</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
