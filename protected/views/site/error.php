<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
/* $this->breadcrumbs=array(
	'Error',
); */
?>
<div class="errorBlock">
	<h2>Error <?php echo $code; ?></h2>
	
	<div class="error">
	<?php echo CHtml::encode($message); ?>
	</div>
</div>