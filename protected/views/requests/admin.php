<?php
/* @var $this RequestsController */
/* @var $model RequestManagement */

$this->breadcrumbs=array(
	'Request Managements'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List RequestManagement', 'url'=>array('index')),
	array('label'=>'Create RequestManagement', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('request-management-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Request Managements</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'request-management-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'callee_id',
		'caller_id',
		'owner_id',
		'requested_by',
		'responded_by',
		/*
		'approved_ignored',
		'created_at',
		'updated_at',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
