<?php
/* @var $this DaeeController */
/* @var $model CallersProfile */
/* 
$this->breadcrumbs=array(
	'Callers Profiles'=>array('index'),
	'Manage',
);
 */
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

<?php if($this->isAdmin()) { ?>
	<h1>Manage Daees' Profiles</h1>
<?php } else {?>
	<h1>Daees' List</h1>
<?php } ?>

<div class="search-form" style="display: none;">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<div class="admin-ctrls-list">
	<?php if($this->isAdmin()) { ?>
		<a class="fr grayButtons mt10i mr10i" href="/controlpanel/requests">Requests Panel</a>
		<a class="fr grayButtons mt10i mr10i" href="/controlpanel/messages">View Admin Messages</a>
		<a class="fr grayButtons mt10i mr10i" href="/activities">Activities Log</a>
	<?php } ?>
	<?php if($this->isSuperAdmin()) { ?>
		<?php if(file_exists(YII::app()->params["sqlbkppath"])) { ?>
		<a class="fr grayButtons mt10i mr10i" href="/daee/downloadsqlbkp"><span class="icon-arrow-down"></span><span class="sqlBackup">Download SQL Backup</span></a>
		<?php } ?>
		<?php if(file_exists(YII::app()->params["imgbkppath"])) { ?>
		<a class="fr grayButtons mt10i mr10i" href="/daee/downloadimgbkp"><span class="icon-arrow-down"></span><span class="imgBackup">Download Images Backup</span></a>
		<?php } ?>
	<?php } ?>
</div>
<div class="infoBoxes">
	Use the operators &lt;, >, =, &lt;=, >= along with string you would like to search/filter. <br />
	For example: Type &lt;30 to to list all the Daees below the age of 30.  
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'callers-profile-grid',
	'dataProvider'=>$model->search(),
	'rowCssClassExpression'=> '$data->applyColorOnRow()',
	'filter'=>$model,
	'columns'=>array(
		/*'caller_id',
		'first_name',
		'last_name',
		'family_name',
		'nick_name',*/
		array(
			'header'=> "Gender",
			'name'=>'gender',
			'type'=>'raw',
			'value'=>function($data){
				$field = CHtml::hiddenField("can_invite", $data->can_invite, $htmlOptions = array("id"=>"", "class"=>"can_invite"));
				$field .= CHtml::hiddenField("can_own_cnt", $data->can_own_cnt, $htmlOptions = array("id"=>"", "class"=>"can_own_cnt"));
				$field .= CHtml::hiddenField("can_hide", $data->can_hide, $htmlOptions = array("id"=>"", "class"=>"can_hide"));
				$field .= CHtml::hiddenField("make_admin", $data->caller->role, $htmlOptions = array('id' => '', 'class'=>"make_admin"));
				$field .= CHtml::hiddenField("caller_id", $data->caller->id, $htmlOptions = array('id' => '', 'class'=>"caller_id"));
				return $field.$data->gender;
			}
		),
		array(
			'header' => 'Age',
	        'name'=>'date_of_birth',
	        'value'=>array($this,'age_from_dob'),
	        'htmlOptions'=>array('width'=>'40'),
		),
		/*'email_id',
		'social_network_id',
		'messenger_id',
		'house_no',
		'street',*/
		'area',
		'city',
		'state',
		'country',
		/*'zip',
		'primary_phone',
		'secondary_phone',
		'highest_education',*/
		'profession',
		array(
			'header' => 'Active Status',
	        'name'=>'activeStatus',
	        'type'=> 'raw',
			'visible'=>YII::app()->user->getState("role") == "admin" || YII::app()->user->getState("role") == "super_admin",
	        'value'=>function($data) { 
				if($data->caller->active_status == 1) {
					$status = "Active";
				} else if($data->caller->active_status == 0) {
					$status = "Inactive";
				} else if($data->caller->active_status == 2) {
					$status = "Deleted";
				} else if($data->caller->active_status == 3) {
					$status = "Blocked";
				}
				return $status; 
	        },
	        'filter'=>CHtml::dropDownList('CallersProfile[activeStatus]', '',  // you have to declare the selected value
                array(
                	""=>"select",
                    '1'=>'Active',
                    '3'=>'Blocked',
                    '2'=>'Deleted',
                    '0'=>'Inactive'
                )
            ),	
            'htmlOptions'=>array('width'=>'90'),
	        //$data is members row accessible in gridview
	    ),
//		'type_of_user',
//		'profile_pic',
		array(
			'header' => 'Languages',
			'value' => function($data) {
				$language_known = json_decode($data->languages_known, true);
				$lang = '';
				if(count( $language_known) > 0) {
					$count=1;
					foreach( $language_known as $val){
						$lang .= $val;
						if ($count != count($language_known)) {
							$lang .= ', '; $count++;
						}
					}
				}
				return $lang;
			},
		'sortable'=>TRUE,
		'name'=> 'languages_known',
		),
		/*'callee_created',
		'callee_owned',
		'can_own_cnt',
		'unassigned_madhoo',
		'can_invite',
		'created_at',
		'updated_at',
		*/
		array(
			'header'=>'Action',
			'class'=>'CButtonColumn',
		    'template'=>'{view}{dlt}{block}{warn}{unblock}{caninvite}{cannotinvite}{canhide}{cannothide}{makeAdmin}{revokeAdmin}{madhoocount}{message}',
		    'buttons'=>array(
	    		'view' => array (
	    				'label'=>'View',
	    				'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
	    		),
		        'block' => array
		        (
		            'label'=>'Block',
		        	'imageUrl'=>Yii::app()->request->baseUrl.'/images/block_black.png',
		            'url'=>'"javascript:void(0);"',
		        	//'visible'=>'$data->id != YII::app()->user->id && (Yii::app()->user->getState("role") == "admin" || Yii::app()->user->getState("role") == "super_admin") && $data->caller->active_status == 1',
		        	'visible'=>'$data->checkControlVisibility(true, $data->caller->active_status == 1)',
		        	'options'=>array("class"=>"blockdaee", "data-req"=>"block"),
		        ),
		        'unblock' => array
		        (
		            'label'=>'Unblock',
		            'url'=>'"javascript:void(0);"',
		        	//'visible'=>'$data->id !== YII::app()->user->id && (Yii::app()->user->getState("role") == "admin" || Yii::app()->user->getState("role") == "super_admin") && $data->caller->active_status != 1',
		        	'visible'=>'$data->checkControlVisibility(true, $data->caller->active_status != 1)',
		        	'options'=>array("class"=>"unblockdaee", "data-req"=>"unblock"),
		        ),
		        'dlt' => array
		        (
		            'label'=>'Delete',
		        	'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',
		            'url'=>'"javascript:void(0);"',
		            //'visible'=>'$data->id != YII::app()->user->id && (Yii::app()->user->getState("role") == "admin" || Yii::app()->user->getState("role") == "super_admin") && $data->caller->active_status != 2',
		            'visible'=>'$data->checkControlVisibility(true, $data->caller->active_status != 2)',
		        	'options'=>array("class"=>"deletedaee", "data-req"=>"delete"),
		        ),
		        'warn' => array
		        (
		            'label'=>'Warn',
		        	'imageUrl'=>Yii::app()->request->baseUrl.'/images/warn.png',
		            'url'=>'"javascript:void(0);"',
		        	//'visible'=>'$data->id != YII::app()->user->id && (Yii::app()->user->getState("role") == "admin" || Yii::app()->user->getState("role") == "super_admin") && $data->caller->active_status == 1',
		        	'visible'=>'$data->checkControlVisibility(true, $data->caller->active_status == 1)',
		        	'options'=>array("class"=>"warndaee", "data-req"=>"warn"),
		        ),
		        'message' => array
		        (
		            'label'=>'Send Message',
		            'imageUrl'=>Yii::app()->request->baseUrl.'/images/sendmsg.png',
		            'url'=>'"javascript:void(0);"',
		        	'options'=>array("class"=>"send-message"),
		        	'visible'=>'$data->id != Yii::app()->user->id && $data->caller->active_status == 1',
		        ),
		        'cannotinvite' => array
		        (
		            'url'=>'"javascript:void(0);"',
		        	'label'=>'Stop Invite',
		            //'visible'=>'$data->id != YII::app()->user->id && (Yii::app()->user->getState("role") == "admin" || Yii::app()->user->getState("role") == "super_admin") && $data->can_invite == 1 && $data->caller->active_status == 1',
		            'visible'=>'$data->checkControlVisibility($data->can_invite == 1, $data->caller->active_status == 1)',
		        	'options'=>array("class"=>"canInvite put0"),
		        ),
		        'caninvite' => array
		        (
		            'label'=>'Can Invite',
		            'url'=>'"javascript:void(0);"',
		            //'visible'=>'$data->id != YII::app()->user->id && (Yii::app()->user->getState("role") == "admin" || Yii::app()->user->getState("role") == "super_admin") && $data->can_invite == 0 && $data->caller->active_status == 1',
		            'visible'=>'$data->checkControlVisibility($data->can_invite == 0, $data->caller->active_status == 1)',
		        	'options'=>array("class"=>"canInvite put1"),
		        ),
		        'canhide' => array
		        (
		            'label'=>'Can Hide',
		            'url'=>'"javascript:void(0);"',
		            // 'visible'=>'$data->id != YII::app()->user->id && (Yii::app()->user->getState("role") == "admin" || Yii::app()->user->getState("role") == "super_admin") && $data->can_hide == 0 && $data->caller->active_status == 1',
		            'visible'=>'$data->checkControlVisibility($data->can_hide == 0, $data->caller->active_status == 1)',
		        	'options'=>array("class"=>"canHide put1"),
		        ),
		        'cannothide' => array
		        (
		            'label'=>'Cannot Hide',
		            'url'=>'"javascript:void(0);"',
		            // 'visible'=>'$data->id != YII::app()->user->id && (Yii::app()->user->getState("role") == "admin" || Yii::app()->user->getState("role") == "super_admin") && $data->can_hide == 1 && $data->caller->active_status == 1',
		            'visible'=>'$data->checkControlVisibility($data->can_hide == 1, $data->caller->active_status == 1)',
		        	'options'=>array("class"=>"canHide put0"),
		        ),
		        'makeAdmin' => array
		        (
		            'label'=>'Make Admin',
		            'url'=>'"javascript:void(0);"',
		            'visible'=>'$data->id != YII::app()->user->id && Yii::app()->user->getState("role") == "super_admin" && $data->caller->role == null && $data->caller->active_status == 1',
		        	'options'=>array("class"=>"makeAdmin put1"),
		        ),
		        'revokeAdmin' => array
		        (
		            'label'=>'Revoke Admin',
		            'url'=>'"javascript:void(0);"',
		            'visible'=>'$data->id != YII::app()->user->id && Yii::app()->user->getState("role") == "super_admin" && $data->caller->role == "admin" && $data->caller->active_status == 1',
		        	'options'=>array("class"=>"makeAdmin put0"),
		        ),
		        'madhoocount' => array
		        (
		            'label'=>'Madhoo Count',
		            'url'=>'"javascript:void(0);"',
		        	// 'visible'=>'$data->id != YII::app()->user->id && (Yii::app()->user->getState("role") == "admin" || Yii::app()->user->getState("role") == "super_admin") && $data->caller->active_status == 1',
		        	'visible'=>'$data->checkControlVisibility(true, $data->caller->active_status == 1)',
		        	'options'=>array("class"=>"madhoocount"),
		        )
		    ),
		),
	),
)); ?>

<script type="text/javascript">
$(document).ready(function(){
	var Daee = {};
	Daee.getID = function($this){
		var ID = $this.parents('.grid-view').prop('id');
		var row = $this.parents('tr').prevAll('tr').length;
		return $('#'+ID).children('.keys').children('span').eq(row).text();
	};

	//Send message to a Daee
	$(".fullWidthLayout").delegate('.send-message','click', function(){
		var id = Daee.getID($(this)), put, thisref = $(this);
		$('#dialog').remove();
		$('body').append('<div id="dialog"></div>');
		var msgForm = '<form id="msgform"><label>Title<br /><input style="width:407px" class="msgTitle" type="text" value="" /></label><br />';
		msgForm += '<label>Message<br /><textarea rows="12" cols="53" class="msgText" value=""></textarea></label></form>';
		$('#dialog').html(msgForm);
		$('#dialog').dialog({
			title: "Send Message",
			modal:true,
			resizable: true,
			width:440,
			height: 400,
			buttons: [
				{
					text:'Send',
					click: function(){
						var data = {isAjaxRequest: 1};
						data.title = $('.msgTitle').val();
						data.msg = $('.msgText').val();
						var xhr = $.ajax({
							type: "POST",
							url:"/daee/sendmessage/"+id,
							data:data
						});
						xhr.done(function(data){
							if(data == 'success') {
								var messageText = "Message sent successfully!";
								Iansar.dialog.inform("Message Sent", messageText);
							} else if(data == 'failed') {
								Iansar.dialog.failure();
							}
						}).fail(function(data){
							Iansar.dialog.failure();
						});
						$( this ).dialog( "close" );
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

	//Can invite or cannot invite call
	$(".fullWidthLayout").delegate('.canInvite', 'click',function(){
		var id = Daee.getID($(this)), put, thisref = $(this);
		if($(this).hasClass("put0")) {
			put = 0;
		} else {
			put = 1;
		}
		var xhr = $.ajax({
	        type:'POST',
	        url:'/daee/caninvite/'+id,
	        data: {isAjaxRequest:1, put: put},
	        beforeSend: function() {
	        	thisref.removeClass("canInvite");
	        }
	    });
        xhr.done(function(data) {
	        if(data == 'success') {
		        if(put === 0) {
		        	thisref.addClass("put1").removeClass("put0");
		        	thisref.html("Can Invite");
		        	thisref.parents("tr").find('.can_invite').val(0);
		        } else {
		        	thisref.addClass("put0").removeClass("put1");
		        	thisref.html("Stop Invite");
		        	thisref.parents("tr").find('.can_invite').val(1);
			    }
		    } else {
		    	Iansar.dialog.failure();
			}
        }).fail(function(XHR) {
        	Iansar.dialog.failure();
        }).always(function(){
        	thisref.addClass('canInvite');
        });
	});

	//Can hide or cannot hide call
	$(".fullWidthLayout").delegate('.canHide', 'click',function(){
		var id = Daee.getID($(this)), put, thisref = $(this);
		if($(this).hasClass("put0")) {
			put = 0;
		} else {
			put = 1;
		}
		var xhr = $.ajax({
	        type:'POST',
	        url:'/daee/canhide/'+id,
	        data: {isAjaxRequest:1, put: put},
	        beforeSend: function() {
	        	thisref.removeClass("canHide");
	        }
	    });
        xhr.done(function(data) {
	        if(data == 'success') {
		        if(put === 0) {
		        	thisref.addClass("put1").removeClass("put0");
		        	thisref.html("Can Hide");
		        	thisref.parents("tr").find('.can_hide').val(0);
		        } else {
		        	thisref.addClass("put0").removeClass("put1");
		        	thisref.html("Stop Hide");
		        	thisref.parents("tr").find('.can_hide').val(1);
			    }
		    } else {
		    	Iansar.dialog.failure();
			}
        }).fail(function(XHR) {
        	Iansar.dialog.failure();
        }).always(function(){
        	thisref.addClass('canHide');
        });
	});

	//Delete , block, unblock Daee
	$(".fullWidthLayout").delegate(".deletedaee, .blockdaee, .unblockdaee", 'click', function(evt){
		var data, daeeStr;
		var target = $(this);
		if($(this).attr("data-req") == "delete") {
			data = {isAjaxRequest:1, active_status: 2};
			daeeStr = "delete";
		} else if ($(this).attr("data-req") == "block") {
			data = {isAjaxRequest:1, active_status: 3};
			daeeStr = "block";
		} else if ($(this).attr("data-req") == "unblock") {
			data = {isAjaxRequest:1, active_status: 1};
			daeeStr = "activate";
		}
		var id = $(this).parents("tr").find(".caller_id").val();
		evt.preventDefault();
		$('<div id="dialog" />').appendTo('body');
		$('#dialog').html('Are you sure, you want to <b>' + daeeStr + '</b> this Daee?');
		$("#dialog").dialog({
			title: 'Confirmation!',
			modal: true,
			resizable: false,
			buttons: [
				{ 	
					text: 'Yes!', 
					click: function() {
						var xhr = $.ajax({
							type: "POST",
							url: "/daee/activestatus/"+id,
							data: data
						});
						xhr.done(function(data){
							if(data == 'success') {
								$.fn.yiiGridView.update('callers-profile-grid');
						        /*if(daeeStr == "delete") {
							       	target.parents("tr").removeAttr('class').addClass("deletedDaee");
							       	target.parents("tr").children().eq(7).text('Deleted');
							       	var viewButton = target.siblings('.view').clone();
							       	target.siblings().remove();
							       	target.after('<a class="unblockdaee" data-req="unblock" title="Unblock" href="javascript:void(0);">Unblock</a>').after(viewButton);
							       	target.remove();
						        } else if(daeeStr == "block") {
						        	var viewButton = target.siblings('.view').clone();
						        	var deleteButton = target.siblings('.deletedaee').clone();
						        	target.siblings().remove();
							       	target.parents("tr").removeAttr('class').addClass("blockedDaee");
							       	target.parents("tr").children().eq(7).text('Blocked');
							       	target.after('<a class="unblockdaee" data-req="unblock" title="Unblock" href="javascript:void(0);">Unblock</a>').after(deleteButton).after(viewButton);
							       	target.remove();
						        } else if(daeeStr == "activate") {
						        	var buttons = '';
							       	target.parents("tr").removeAttr('class').addClass("daeeRow");
							       	target.parents("tr").children().eq(7).text('Active');
							       	if(target.siblings().length != 2) {
							       		buttons = '<a class="deletedaee" data-req="delete" title="Delete" href="javascript:void(0);"><img src="/images/delete.png" alt="Delete"></a>';
							       	}
							       	buttons += '<a class="blockdaee" data-req="block" title="Block" href="javascript:void(0);"><img src="/images/block_black.png" alt="Block"></a>';
							       	buttons += '<a class="warndaee" data-req="warn" title="Warn" href="javascript:void(0);"><img src="/images/warn.png" alt="Warn"></a>';
							       	if(target.parents("tr").find('.can_invite').val() == 0) {
							       		buttons += '<a class="canInvite put1" title="Can Invite" href="javascript:void(0);">Can Invite</a>';
							       	} else {
							       		buttons += '<a class="canInvite put0" title="Stop Invite" href="javascript:void(0);">Stop Invite</a>';
							       	}
							       	if(target.parents("tr").find('.can_hide').val() == 0) {
							       		buttons += '<a class="canHide put1" title="Can Hide" href="javascript:void(0);">Can Hide</a>';
							       	} else {
							       		buttons += '<a class="canHide put0" title="Stop Hide" href="javascript:void(0);">Cannot Hide</a>';
							       	}
							       	<?php if(Yii::app()->user->getState('role') == 'super_admin') { ?>
							       	if(target.parents("tr").find('.make_admin').val() !== "admin") {
							       		buttons += '<a class="makeAdmin put1" title="Make Admin" href="javascript:void(0);">Make Admin</a>';
							       	} else {
							       		buttons += '<a class="makeAdmin put0" title="Revoke Admin" href="javascript:void(0);">Revoke Admin</a>';
							       	}
							       	<?php } ?>
							       	buttons += '<a class="madhoocount" title="Madhoo Count" href="javascript:void(0);">Madhoo Count</a>';
							       	buttons += '<a class="send-message icon-mail" title="Send Message" href="javascript:void(0);">Send Message</a>';
							       	if(target.siblings().length != 2) {
										target.siblings('.view').after(buttons);							       		
							       	} else {
							       		target.siblings('.deletedaee').after(buttons);
							       	}
							       	target.remove();
						        }*/
						    } else {
						    	Iansar.dialog.failure();
							}
				        }).fail(function(XHR) {
				        	Iansar.dialog.failure();
				        });
						$( this ).dialog( "close" );$( "#dialog" ).remove();
						return false;
					}
				},
				{ 	text: 'Cancel', 
					click: function() { 
						$( this ).dialog( "close" );$( "#dialog" ).remove(); 
					} 
				}
			]
		});
	});

	$('.fullWidthLayout').delegate('.madhoocount', 'click', function(event) {
		var id = Daee.getID($(this));
		event.preventDefault();
		$('<div id="dialog" />').appendTo('body');
		var can_own_cnt = $(this).parents('tr').find('.can_own_cnt').val();
		var thisref = $(this);
		var countSel = "<select class='count_madhoo'>";
		for (var i = can_own_cnt; i <= 50; i++) {
			countSel += "<option value='"+i+"'>"+i+"</option>";
		};
		countSel += "</select>";
		$('#dialog').html('<div class="count-sel-container"><label> Count' + countSel + '</lable></div>');
		$("#dialog").dialog({
			title: 'Increase count!',
			modal: true,
			resizable: false,
			buttons: [
				{ 	
					text: 'Yes!', 
					click: function() {
						var selectedVal = $('#dialog .count_madhoo').find('option:selected').val();
						if(selectedVal != can_own_cnt) {
							var xhr = $.ajax({
								type: "POST",
								url: "/daee/increasecount/"+id,
								data: {isAjaxRequest:1, count: selectedVal}
							});
							xhr.done(function(data){
								if(data == 'success') {
									thisref.parents('tr').find('.can_own_cnt').val(selectedVal);
									thisref.text(thisref.text()+"("+selectedVal+")");
									setTimeout(function(){
										thisref.text("Madhoo Count");
									}, 3000);
							    } else {
							    	Iansar.dialog.failure()
								}
					        }).fail(function(XHR) {
					        	Iansar.dialog.failure()
					        });
					    }
						$( this ).dialog( "close" );$( "#dialog" ).remove();
						return false;
					}
				},
				{ 	text: 'Cancel', 
					click: function() { 
						$( this ).dialog( "close" );$( "#dialog" ).remove(); 
					} 
				}
			]
		});
	});

	$('.fullWidthLayout').delegate('.warndaee', 'click', function(event) {
		var id = Daee.getID($(this));
		event.preventDefault();
		$('<div id="dialog" />').appendTo('body');
		var thisref = $(this);
		$('#dialog').html('<textarea rows="12" cols="34" class="warn-text"></textarea>');
		$("#dialog").dialog({
			title: 'Warn Daee!',
			modal: true,
			resizable: true,
			minHeight: 300,
			minWidth: 300,
			maxHeight: 700,
			maxWidth: 700,
			buttons: [
				{ 	
					text: 'Yes!',
					click: function() {
						var selectedVal = $('#dialog .warn-text').val();
						if($.trim(selectedVal) != "") {
							var xhr = $.ajax({
								type: "POST",
								url: "/daee/warndaee/"+<?php echo YII::app()->user->id; ?>,
								data: {isAjaxRequest:1, receiver_id: id, msg: $.trim(selectedVal)}
							});
							xhr.done(function(data){
								if(data == 'success') {
									$('<div id="dialog-msg" />').appendTo('body');
									$("#dialog-msg").html("Warning Sent");
									$("#dialog-msg").dialog({
										title: 'Sent!',
										modal: true,
										resizable: false,
										buttons: [
											{ 	
												text: 'Ok',
												click: function() {
													$( this ).dialog( "close" );
													$("#dialog-msg").remove();
												}
											}
										]
									});
							    } else {
							    	Iansar.dialog.failure();
								}
					        }).fail(function(XHR) {
					        	Iansar.dialog.failure();
					        });
					        $( this ).dialog( "close" );$( "#dialog" ).remove();
					    } else {
					    	if($('#dialog .error').length <= 0) {
					    		$('#dialog .warn-text').before("<div class=\"error\">Enter a text</div>");
					    	}
					    }
						return false;
					}
				},
				{ 	text: 'Cancel', 
					click: function() { 
						$( this ).dialog( "close" );$( "#dialog" ).remove(); 
					} 
				}
			]
		});
	});
	
	<?php if(YII::app()->user->getState("role") == "super_admin") { ?>
	$('.fullWidthLayout').delegate('.makeAdmin', 'click', function(event) {
		var id = Daee.getID($(this));
		event.preventDefault();
		$('<div id="dialog" />').appendTo('body');
		var thisref = $(this), put, msg;
		if(thisref.hasClass("put0")) {
			put = 0;
			msg = 'Are you sure about revoking admin access to this Daee?';
		} else {
			put = 1;
			msg = 'Are you sure about giving admin access to this Daee?';
		}
		$('#dialog').html(msg);
		$("#dialog").dialog({
			title: put == 1 ? 'Grant Admin Previlege!' : 'Revoke Admin Previlege!',
			modal: true,
			resizable: false,
			buttons: [
				{ 	
					text: 'Yes!',
					click: function() {
						var xhr = $.ajax({
							type: "POST",
							url: "/daee/makeadmin/"+id,
							data: {isAjaxRequest:1, put: put}
						});
						xhr.done(function(data){
							if(data == 'success') {
								if(!put) {
									thisref.removeClass("put0").addClass('put1').html("Make Admin")
									thisref.parents("tr").removeClass('adminDaee').addClass('daeeRow');
								} else {
									thisref.removeClass("put1").addClass('put0').html("Revoke Admin")
									thisref.parents("tr").addClass('adminDaee').removeClass('daeeRow');
								}
						    } else {
						    	Iansar.dialog.failure();
							}
				        }).fail(function(XHR) {
				        	Iansar.dialog.failure();
				        });
				        $( this ).dialog( "close" );$( "#dialog" ).remove();
					}
				},
				{ 	text: 'Cancel', 
					click: function() { 
						$( this ).dialog( "close" );$( "#dialog" ).remove(); 
					} 
				}
			]
		});
	});
	<?php } ?>

});
</script>