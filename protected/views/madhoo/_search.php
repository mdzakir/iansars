<?php
/* @var $this MadhooController */
/* @var $model Callees */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'GET',
)); ?>

  	<div class="row search_mymadhoo lfloat">
		<div class="rowchild">
			<?php echo CHtml::Label('Madhoo Filter','madhoo_filter',array('class'=>'fltlft madhoo_filter')); ?>
			<?php
				$selected = isset($_GET['Callees[madhoo_filter]']) ? $_GET['Callees[madhoo_filter]'] : null;  
				echo $form->dropDownList($model,'madhoo_filter',array(
					//'allmadhoos'=>'All Madhoos',
					//'assignedmadhoos'=>'Assigned Madhoos',
					//'unassignedmadhoos'=>'Unassigned Madhoos',
					'created'=>'Madhoo Created By Me',
					'cno'=>'Madhoo Created By Me But Not owned',
					'onc'=>'Madhoo Owned By Me But Not Created',
					'assigned'=>'Madhoo Created And Owned By Me',
					'unassigned'=>'Madhoo Created And Unassigned By Me'
				),
				$htmlOptions=array(
					'empty'=>'- Select an option -',
					'options'=>array($selected=>array('selected'=>'selected')), 
					'id'=>'madhoo_filter',
					'class'=> 'selectDD selectBig lfloat'
				));
			?>
			<?php echo CHtml::submitButton('Search',array('class'=>'grayButtons lfloat ml10i')); ?>
		</div>
		
		<div class="rfloat">
			<a class="grayButtons lfloat" href="/madhoo/addmadhoo">
				<span class="plusIcon"></span><span class="textbyIcon">Create a Madhoo</span>
			</a>
		</div>
	</div>
<?php $this->endWidget(); ?>

</div><!-- search-form -->