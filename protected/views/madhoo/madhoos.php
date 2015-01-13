<?php
/* @var $this MadhooController */
/* @var $model Callees */

/* $this->breadcrumbs=array(
	'Callees'=>array('index'),
	'Manage',
); */

$this->menu=array(
	array('label'=>'List Callees', 'url'=>array('index')),
	array('label'=>'Create Callees', 'url'=>array('create')),
);

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

<h1>All Madhoos</h1>

<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_otherMadhooSearch',array(
	'model'=>$model,
	'callerModel'=>$callerModel
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'callees-grid',
	'dataProvider'=>$model->searchAllMadhoo($queryString),
	'filter'=>$model,
	'columns'=>array(
		/*'id',
		'caller_id',*/
		//'first_name',
		//'last_name',
		//'family_name',
		//'nick_name',
		'gender',
		'age',
		/*
		'highest_qualification',
		'profession',
		'house_no',
		'street',*/
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
		'language_speak',*/
		'religion',
		'email_id',
		/*'phone_number',
		'social_network_id',
		'messenger_id',*/
		array(
			'header' => 'Status',
			'value' => function($data) {
				if($data->status == "NO_INTERACTION_YET") {
					return "No Interaction Yet";
				} elseif($data->status == "PARTIALLY_CONVINCED") {
					return "Partially Convinced";
				}
				return $data->status; 
			},
			'sortable' => TRUE,
			'filter' => FALSE
		),
		array(
			'header' => 'Assigned To',
			'value' => function($data) {
				return $data->owned_by ? $data->getName($data->owned_by): '';
			},
			'sortable'=>TRUE,
			'name'=> 'owned_by',
			'filter'=>FALSE
		),
		array(
			'header' => 'Created At',
			'value' => function($data) {
				return date("d/m/Y", strtotime($data->created_at));
			},
			'sortable'=>TRUE,
			'name'=> 'created_at',
			'filter'=>FALSE
		),
		array(
			'header' => 'Updated At',
			'value' => function($data) {
				return date("d/m/Y", strtotime($data->updated_at));
			},
			'sortable'=>TRUE,
			'name'=> 'updated_at',
			'filter'=>FALSE
		),
		array(
			'header' => 'Action',
			'class'=>'CButtonColumn',
			'template' => '{view}{update}{assign}{reqpending}{remove}',
			'buttons'=>array (
					'view' => array (
						'label'=>'View',
						'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
						'url'=>'$data->owned_by == YII::app()->user->id || $data->caller_id == YII::app()->user->id ? Yii::app()->createUrl("/madhoo/viewmadhoo", array("id"=>$data->primaryKey)) : Yii::app()->createUrl("/madhoo/viewmadhoo", array("id"=>$data->primaryKey))'
					),
					'assign' => array (
						'label'=>"Assign to me",
						'imageUrl'=>Yii::app()->request->baseUrl.'/images/assign.png',
						'url'=>'Yii::app()->createUrl("/madhoo/viewmadhoo", array("owned_by"=>$data->owned_by, "caller_id"=>$data->caller_id, "id"=>$data->id))',
						'options'=>array("class"=>"assign-to-me"),
						'visible'=>'(@$data->owned_by != YII::app()->user->id && !in_array(YII::app()->user->id, is_array(json_decode($data->requested_by, true))?json_decode($data->requested_by, true):array())) ? true:false;'
					),
					'update' => array (
			      		'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
			        	'url'=>'Yii::app()->createUrl("/madhoo/editmadhoo", array("id"=>$data->primaryKey))',
			        	'visible'=>'(@$data->owned_by == YII::app()->user->id || @$data->caller_id == YII::app()->user->id)?true:false;'
			      	),
					'remove' => array (
						'label'=>"Delete",
			      		'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',
			      		'options'=>array("class"=>"deleteMadhoo"),
			      		'url'=>'"javascript:void(0)"',
			      		'visible'=>'YII::app()->user->getState("role") == "super_admin" || YII::app()->user->getState("role") == "admin" ? true:false;',
			      	),
					'reqpending' => array(
						'label'=>"Request pending",
						'imageUrl'=>Yii::app()->request->baseUrl.'/images/assign.png',
						'url'=>'"javascript:void(0)"',
						'options'=>array("class"=>"op5"),
						'visible'=>'(in_array(YII::app()->user->id, is_array(json_decode($data->requested_by, true))?json_decode($data->requested_by, true):array()))?true:false;'
					)
				)
			),
		),
	)
); ?>

<script type="text/javascript">
$(document).ready(function(){
	Madhoo = {};
	$('#callees-grid').delegate('.assign-to-me', 'click',function(e){
		e.preventDefault();
		var thisref = $(this);
		var urlFragment = (thisref.attr('href') || '').split('?');
		var dataFragment = (urlFragment || []).length > 1 ? (urlFragment[1] || "").split('&') : $.noop();
		(dataFragment || "").length > 1 ? dataFragment[0].split("=") : $.noop();
		var ownerSeg, callerSeg, madhooSeg, owned_by, caller_id, loggedinUser, madhooId;
		if((dataFragment || "").length > 1) {
			ownerSeg = dataFragment[0].split("=");
			callerSeg = dataFragment[1].split("=");
			madhooSeg = urlFragment[0].split("/");
		}
		owned_by = ownerSeg[1] ? parseInt(ownerSeg[1]) : "";
		caller_id = parseInt(callerSeg[1]);
		loggedinUser = parseInt(<?php echo YII::app()->user->id; ?>);
		madhooId = parseInt(madhooSeg[3]);
		if(owned_by != undefined && caller_id != undefined) {
			$('#dialog').remove();
			$('body').append("<div id='dialog'></div>");
			$('#dialog').html('Its really good that you came forward to take up this Madhoo. Are you sure about your decision?');
			$("#dialog").dialog({
				title: 'Assign to Me!',
				modal: true,
				resizable: false,
				buttons: [
					{ 	
						text: 'Yes!', 
						click: function() {
							var messageText = "", buttonText = "", data = { isAjaxRequest : 1 };
							data.caller_id = caller_id;
							data.owned_by = owned_by;
							//owned_by-{null} && caller_id-{loggedin user}
							if(caller_id === loggedinUser && !owned_by) {
								data.assigner_id = loggedinUser;
								data.assignee_id = madhooId;
								messageText = "Madhoo is assigned to you. Thank you for your service.";
								buttonText = "Assigned Successfully";
							//owned_by-{null} && caller_id-{not loggedin user}
							} else if (caller_id != loggedinUser && !owned_by) {
								data.sender_id = loggedinUser;
								data.receiver_id = caller_id;
								data.type = "<?php echo Controller::$MSG_TYPE_ASSIGNMENT; ?>";
								data.status = "<?php echo Controller::$MSG_STATUS_UNREAD; ?>";
								data.title = "Assign Madhoo to Me";
								data.description = 'I have interest in Madhoo [[{"href":"/madhoo/viewmadhoo/'+madhooId+'","madhoo":'+madhooId+'}]]. Assign madhoo to me';
								messageText = "Message is conveyed to the OWNER of the Madhoo. <br />Thanks for you service. <br />Let Allah be with You.";
								buttonText = "Request Pending";
							//owned_by-{not null}
							} else if(owned_by) {
								data.sender_id = "<?php echo YII::app()->user->id; ?>";
								data.receivers_id = caller_id+','+owned_by;
								data.type = "<?php echo Controller::$MSG_TYPE_ASSIGNMENT; ?>";
								data.status = "<?php echo Controller::$MSG_STATUS_UNREAD; ?>";
								data.title = "Assign Madhoo to Me";
								data.description = 'I have interest in Madhoo [[{"href":"/madhoo/viewmadhoo/'+madhooId+'","madhoo":"'+madhooId+'"}]]. Assign madhoo to me';
								messageText = "Message is conveyed to the OWNER of the Madhoo. <br />Thanks for you service. <br />Let Allah be with You.";
								buttonText = "Request Pending";
							} else {
								data.condifalse = true;
							}
							var xhr = $.ajax({
								type: "POST",
								url:"/madhoo/assigntome/"+madhooId,
								data:data
							});
							xhr.done(function(data){
								$( "#dialog" ).remove();
								$('body').append("<div id='#dialog'></div>");
								if(data == 'success') {
									$( "#dialog" ).html(messageText);
									thisref.html(buttonText).removeClass('assign-to-me');
									$.fn.yiiGridView.update('callees-grid');
									$( "#dialog" ).dialog({
								      	modal: true,
								      	buttons: {
								        	Ok: function() {
								          		$( this ).dialog( "close" );
								          		$( "#dialog" ).remove();
								        	}
								      	}
								    });
								} else if(data == 'failed') {
									Iansar.dialog.failure();
								}else if(data == 'count_fail') {
									var msg = "You cannot assign any more Madhoo to you. If you really want to assign, unassign one of the Madhoo assigned to you.";
									Iansar.dialog.inform("Cannot add madhoo!", msg);
								}
							}).fail(function(data){
								Iansar.dialog.failure();
							});
							$( this ).dialog( "close" );
						} 
					},
					{ 	text: 'Cancel',
						click: function() { 
							$( this ).dialog( "close" );$( "#dialog" ).remove(); 
						} 
					}
				]
			});	
		}
	});
	<?php if($this->isAdmin()) { ?>
	$('#callees-grid').delegate('.deleteMadhoo','click', function(event){
		event.preventDefault();
		var id = Madhoo.getID($(this));
		$('<div id="deletePopup" />').appendTo('body');
		$('#deletePopup').html('Are you sure, you want to delete this Madhoo?');
		$("#deletePopup").dialog({
			title: 'Delete Madhoo',
			modal: true,
			resizable: false,
			buttons: [
				{ 	
					text: 'Yes!', 
					click: function() {
						var xhr = $.ajax({
					        type:'POST',
					        url:'/madhoo/deleteMadhoo/'+id,
					        data: {isAjaxRequest:1}
					    });
				        xhr.done(function(data) {
					        if(data == 'success') {
					        	$('#madhoo_filter').siblings('input[type="submit"]').click();
					        	$.fn.yiiGridView.update('callees-grid');
					        	Iansar.dialog.inform("Success!", "Madhoo deleted Successfully.");
						    } else {
						    	Iansar.dialog.inform("Failed!", "Unable to delete madhoo.");
							}
				        }).fail(function(XHR) {
				        	Iansar.dialog.failure();
				        });
						$( this ).dialog( "close" );$( "#deletePopup" ).remove(); 
					} 
				},
				{ 	text: 'Cancel', 
					click: function() { 
						$( this ).dialog( "close" );$( "#deletePopup" ).remove(); 
					} 
				}
			]
		});
	});
	<?php } ?>
	Madhoo.getID = function($this){
		var ID = $this.parents('.grid-view').prop('id');
		var row = $this.parents('tr').prevAll('tr').length;
		return $('#'+ID).children('.keys').children('span').eq(row).text();
	}

	//Enabling and disabling owned and unassigned checkboxes
	$("#ownedbyme").change(function(){
		if($(this).is(":checked")) {
			$("#unassigned").attr("disabled", "disabled");
		} else {
			$("#unassigned").removeAttr("disabled");
		}
	});
	$("#unassigned").change(function(){
		if($(this).is(":checked")) {
			$("#ownedbyme").attr("disabled", "disabled");
		} else {
			$("#ownedbyme").removeAttr("disabled");
		}
	})
});
</script>