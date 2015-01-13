<?php
/* @var $this MadhooController */
/* @var $model Callees */

$this->menu=array(
	array('label'=>'Manage Callees', 'url'=>array('mymadhoo')),
);
?>

<h1>Create Madhoo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>