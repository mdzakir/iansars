<?php
/* @var $this ProfileController */
/* @var $model CallersProfile */

/* $this->breadcrumbs=array(
	'Callers Profiles'=>array('index'),
	'Manage',
); */

$this->menu=array(
	array('label'=>'List CallersProfile', 'url'=>array('index')),
	array('label'=>'Create CallersProfile', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('callers-profile-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Daee Profile</h1>

<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'callers-profile-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'caller_id',
		'first_name',
		'last_name',
		'family_name',
		'nick_name',
		/*
		'gender',
		'date_of_birth',
		'email_id',
		'social_network_id',
		'messenger_id',
		'house_no',
		'street',
		'area',
		'city',
		'state',
		'country',
		'zip',
		'primary_phone',
		'secondary_phone',
		'highest_education',
		'profession',
		'type_of_user',
		'profile_pic',
		'languages_known',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
