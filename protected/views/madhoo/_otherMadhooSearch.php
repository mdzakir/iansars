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
			<?php /* echo CHtml::Label('Madhoo Filter','madhoo_filter',array('class'=>'fltlft madhoo_filter')); ?>
			<?php
				$selected = isset($_GET['Callees[madhoo_filter]']) ? $_GET['Callees[madhoo_filter]'] : null;  
				echo $form->dropDownList($model,'madhoo_filter',array(
					'allmadhoos'=>'All Madhoos',
					'assignedmadhoos'=>'Assigned Madhoos',
					'unassignedmadhoos'=>'Unassigned Madhoos',
					'notmymadhoos'=>'Madhoos Not Assigned to Me'
					//'created'=>'Madhoo Created By Me',
					//'cno'=>'Madhoo Created By Me But Not owned',
					//'onc'=>'Madhoo Owned By Me But Not Created',
					//'assinged'=>'Madhoo Created And Owned By Me',
				),
				$htmlOptions=array(
					'empty'=>'- Select an option -',
					'options'=>array($selected=>array('selected'=>'selected')), 
					'id'=>'madhoo_filter',
					'class'=> 'selectDD selectBig lfloat'
				));
			?>
			<?php echo CHtml::submitButton('Search',array('class'=>'grayButtons lfloat ml10i')); */
			?>
			<div class="filter-wrapper">
				<div class="filter">
					<label class="filter-label" for="createdbyme">
						<input id="createdbyme" class="filter-check" type="checkbox" value="createdbyme" name="Callees[madhoo_filter][]" />
						<span>Created By Me</span>
					</label>
				</div>
				<div class="filter">
					<label class="filter-label" for="ownedbyme">
						<input id="ownedbyme" class="filter-check" type="checkbox" value="ownedbyme" name="Callees[madhoo_filter][]" />
						<span>Owned By Me</span>
					</label>
				</div>
				<div class="filter">
					<label class="filter-label largelabel" for="unassigned">
						<input id="unassigned" class="filter-check" type="checkbox" value="unassigned" name="Callees[madhoo_filter][]" />
						<span>All unassigned madhoos</span>
					</label>
				</div>
				<?php if($callerModel->can_hide || $this->isAdmin() || $model->caller_id == YII::app()->user->id) { ?>
				<div class="filter">
					<label class="filter-label largelabel" for="hidden">
						<input id="hidden" class="filter-check" type="checkbox" value="hidden" name="Callees[madhoo_filter][]" />
						<span>Show Hidden Madhoos</span>
					</label>
				</div>
				<?php } ?>
			</div>


				
			<?php ?>
		</div>
		
		<div class="rfloat">
			<a class="grayButtons lfloat" href="/madhoo/addmadhoo">
				<span class="plusIcon"></span><span class="textbyIcon">Create a Madhoo</span>
			</a>
		</div>
	</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
$(document).ready(function() {
	$('.filter-check').change(function() {
		if(!$('.filter-check:checked').length)
			$("#callees-grid").children(".keys").attr('title', "/madhoo/madhoos");

		$.fn.yiiGridView.update('callees-grid', {
			data: $(this).parents('form#yw0').serialize()
		});
		return false;
	});
});
</script>
</div><!-- search-form -->