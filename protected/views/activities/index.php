<?php
/* @var $this ActivitiesController */
/* @var $model Activities */
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('activities-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Activities Log</h1>
<!-- <?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?> -->
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>
<div style="height: 20px">&nbsp;</div>
<a href="javascript:void(0);" id="hard-delete-all" data-type="hard" class="grayButtons">Hard Delete Selected</a>
<a href="javascript:void(0);" id="soft-delete-all" data-type="soft" class="grayButtons">Soft Delete Selected</a>
<?php if(YII::app()->user->getState("role") == "super_admin") { ?>
	<!-- Super admin view with controls -->
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'activities-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'selectableRows'=>20,
		'columns'=>array(
			//'id',
			array(
				'header' => 'Activity',
				'type' => 'raw',
				'value' => function($data) {
					return $data->parseMessages($data->message);
				},
				'sortable'=>FALSE,
				'name'=> 'message',
				'htmlOptions'=>array('width'=>'75%'),
			),
			//'viewer',
			//'is_deleted',
			array(
				'header' => 'Created At',
				'value' => function($data) {
					return date("d/m/Y", strtotime($data->created_at));
				},
				'sortable'=>TRUE,
				'name'=> 'created_at'
			),
			//'updated_at',
			array(
				'header'=>'Delete',
				'class'=>'CButtonColumn',
			    'template'=>'{hdlt}{sdlt}',
			    'buttons'=>array(
			        'sdlt' => array
			        (
			            'label'=>'Soft',
			            'url'=>'"javascript:void(0);"',
			        	'visible'=>'YII::app()->user->getState("role") == "super_admin" && $data->is_deleted == 0',
			        	'options'=>array("class"=>"soft-delete", "data-type"=>"soft"),
			        ),
		    		'hdlt' => array (
	    				'label'=>'Hard',
	    				'url'=>'"javascript:void(0);"',
	    				'visible'=>'YII::app()->user->getState("role") == "super_admin"',
	    				'options'=>array("class"=>"hard-delete", "data-type"=>"hard"),
		    		)
			    )
			)
		)
	)); ?>
<?php } else { ?>
	<!-- Admin view without controls -->
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'activities-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'columns'=>array(
			'message',
			array(
				'header' => 'Created At',
				'value' => function($data) {
					return date("d/m/Y", strtotime($data->created_at));
				},
				'sortable'=>TRUE,
				'name'=> 'created_at'
			),
		),
	)); ?>
<?php } ?>
<?php if(YII::app()->user->getState("role") == "super_admin") { ?>
<script type="text/javascript">
$(document).ready(function() {
	var Activities = {};
	Activities.getID = function($this){
		var ID = $this.parents('.grid-view').prop('id');
		var row = $this.parents('tr').prevAll('tr').length;
		return $('#'+ID).children('.keys').children('span').eq(row).text();
	};
	$("#content").delegate('.hard-delete, .soft-delete', 'click', function(event) {
		var $thisref = $(this);
		var type = $thisref.attr("data-type");
		var removedItem;
		var xhr = $.ajax({
			url: '/activities/deleteactivity',
			type: 'POST',
			data: {isAjaxRequest: true, id: Activities.getID($thisref), type: type},
			beforeSend :function() {
				removedItem = $thisref.hasClass('hard-delete') ? 'hard-delete' : 'soft-delete';
			}
		});
		xhr.done(function() {
			$.fn.yiiGridView.update('activities-grid');
		})
		.fail(function() {
			Iansar.dialog.failure();
			$thisref.addClass(removedItem);
		});
	});
	$("#hard-delete-all, #soft-delete-all").click(function(event) {
		var $thisref = $(this);
		var type = $thisref.attr("data-type");
		var ids = $("#activities-grid").yiiGridView('getSelection');
		if(!(ids || []).length) {
			Iansar.dialog.inform("Message", "You have not selected any rows to delete.");
			return false;
		}
		$('#dialog').length ? $('#dialog').remove() : $.noop();
		$("body").append('<div id="dialog">Are you sure about your action?</div>');
		$('#dialog').dialog({
			title: "Delete Selection!",
			modal:true,
			buttons: [
				{
					text:'Yes!',
					click: function(){
						var xhr = $.ajax({
							url: '/activities/deleteactivity',
							type: 'POST',
							data: {isAjaxRequest: true, id: ids.join(","), type: type, isMultiple: true},
						})
						.done(function() {
							$.fn.yiiGridView.update('activities-grid');
						})
						.fail(function() {
							Iansar.dialog.failure();
						});	
						$( this ).dialog( "close" );
						$('#dialog').remove();
					}
				},
				{
					text: 'Cancel',
					click: function(){
						$(this).dialog('close');
						$('#dialog').remove();
					}
				}
			]
		});
	});
});
</script>
<?php } ?>