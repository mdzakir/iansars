<?php
/* @var $this MadhooController */
/* @var $model Callees */

/*
$this->menu=array(
	array('label'=>'Create Madhoo', 'url'=>array('addmadhoo')),
);
*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('callees-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>My Madhoos</h1>
<!--<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>-->	
<div class="search-form" style="display:block">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>
<div id="madhoo-unassign-success-flash" style="display:none" class="flash-success">Madhoo Unassigned Successfully</div>
<div id="madhoo-unassign-error-flash" style="display:none" class="flash-error">Error in unassigning the Madhoo. Try later.</div>
<div class="madooListWrap">
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'callees-grid',
		'dataProvider'=>$model->searchMadhoo($queryString),
		'filter'=>$model,
		'columns'=>array(
			//'first_name',
			//'last_name',
			//'family_name',
			//'nick_name',
			'gender',
			'age',
			/*'highest_qualification',
			'profession',*/
			/*array(
				'header' => 'Address',
                'value' => function($data) {
                        return $data->street.', '.$data->house_no;      
                },
                'sortable'=>TRUE,
                'name'=> 'address',
            ),	
			'street', */
			'area',
			'city',
			'state',
			'country',
			/* 'zip', */
			array(
				'header' => 'Languages',
				'value' => function($data) {
					return $data->language_read.', '.$data->language_write.', '.$data->language_speak;
				},
				'sortable'=>TRUE,
				'name'=> 'language_speak',
			),
			/*'language_read',
			'language_write',
			'language_speak', */
			'religion',
			/*'email_id',
			'phone_number',
			'social_network_id',
			'messenger_id',
			'status',
			'created_at',
			'updated_at',
			*/
			array(
				'header' => 'Action',
				'class'=>'CButtonColumn',
				'template' => '{view}{update}{unassign}',
				'deleteConfirmation'=>false,
				'buttons'=>array (
			    	'view' => array (
			    		'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
			        	'url'=>'CController::createUrl("/madhoo/viewmadhoo", array("id"=>$data->primaryKey))'
			    	),
			      	'update' => array (
			      		'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
			        	'url'=>'CController::createUrl("/madhoo/editmadhoo", array("id"=>$data->primaryKey))',
			        	'visible'=>'(@$data->owned_by == YII::app()->user->id || @$data->caller_id == YII::app()->user->id)?true:false;'
			      	),
			      	'unassign' => array (
			      		'imageUrl'=>Yii::app()->request->baseUrl.'/images/unassign.png',
			      		'options'=>array("class"=>"unassignMadhoo"),
			      		'visible'=>'(@$data->owned_by == YII::app()->user->id)?true:false;',
			        	'url'=>'CController::createUrl("/madhoo/editmadhoo", array("id"=>$data->primaryKey))'
			      	)
				),
			),
		),
	)); ?>
</div>

<script type="text/javascript">
$(function(){
	var Madhoo = {};
	$('.madooListWrap').delegate('.unassignMadhoo','click', function(event){
		event.preventDefault();
		var id = Madhoo.getID($(this));
		$('<div id="unassignPopup" />').appendTo('body');
		$('#unassignPopup').html('Are you sure, you want to unassign this Madhoo?');
		$("#unassignPopup").dialog({
			title: 'Unassign Madhoo',
			modal: true,
			resizable: false,
			buttons: [
				{ 	
					text: 'Yes!', 
					click: function() {
					    var xhr = $.ajax({
					        type:'POST',
					        url:'/madhoo/unassignmadhoo/'+id,
					        data: {isAjaxRequest:1}
					    });
				        xhr.done(function(data) {
					        if(data == 'success') {
					        	Iansar.dialog.inform("Success!", "Madhoo unassigned Successfully.");
					        	$('#madhoo_filter').siblings('input[type="submit"]').click();
						    } else {
						    	Iansar.dialog.inform("Failed!", "Unable to Unassign the madhoo.");
							}
				        }).fail(function(XHR) {
				        	Iansar.dialog.failure();
				        });
						$( this ).dialog( "close" );$( "#unassignPopup" ).remove();
						return false;
					}
				},
				{ 	text: 'Cancel', 
					click: function() { 
						$( this ).dialog( "close" );$( "#unassignPopup" ).remove(); 
					} 
				}
			]
		});
	});
	Madhoo.getID = function($this){
		var ID = $this.parents('.grid-view').prop('id');
		var row = $this.parents('tr').prevAll('tr').length;
		return $('#'+ID).children('.keys').children('span').eq(row).text();
	}
});
</script>