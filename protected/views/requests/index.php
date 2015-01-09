<?php
/* @var $this RequestsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Request Managements',
);

$this->menu=array(
	array('label'=>'Create RequestManagement', 'url'=>array('create')),
	array('label'=>'Manage RequestManagement', 'url'=>array('admin')),
);
?>

<h1>Request Managements</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
