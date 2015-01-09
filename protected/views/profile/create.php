<?php
/* @var $this ProfileController */
/* @var $model CallersProfile */
?>

<h1>Complete Profile</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'organizations'=>$organizations)); ?>