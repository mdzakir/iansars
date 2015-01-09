<?php
/* @var $this DaeeController */
/* @var $model CallersProfile */

/* $this->breadcrumbs=array(
	'Callers Profiles'=>array('index'),
	$model->id,
); */

$this->menu=array(
	array('label'=>'List CallersProfile', 'url'=>array('index')),
	array('label'=>'Create CallersProfile', 'url'=>array('create')),
	array('label'=>'Update CallersProfile', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CallersProfile', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CallersProfile', 'url'=>array('admin')),
);
?>

<h1><strong>Daee: <?php echo $model->first_name.' '.$model->last_name; ?></strong></h1>

<div class="dashBoard">
	<div class="dashBoardName leftDB">
		<div class="dbBoxContainer">
			<fieldset>
				<legend>Basic Information</legend>
				<table>
					<tr>
						<th class="dbLabel"><label>First Name: </label></th>
						<td class="dbData"><span><?php echo $model->first_name; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Last Name: </label></th>
						<td class="dbData"><span><?php echo $model->last_name; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Family Name: </label></th>
						<td class="dbData"><span><?php echo $model->family_name; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Nick Name: </label></th>
						<td class="dbData"><span><?php echo $model->nick_name; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Gender: </label></th>
						<td class="dbData"><span class="capiCase"><?php echo $model->gender; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Age: </label></th>
						<td class="dbData capiCase"><span><?php echo $model->date_of_birth; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Languages Known:</label></th>
						<?php $language = $model->languages_known ? json_decode($model->languages_known, true) : array(); ?>
						<td class="dbData capiCase">
							<span>
								<?php if(count($language) > 0) {
										foreach($language as $key => $lang) { 
											echo $lang; 
											echo ($key != count($language)-1) ? ', ':''; 
										}
									}
								?>
							</span>
						</td>
					</tr>
				</table>
			</fieldset>
		</div>
		
		<div class="dbBoxContainer mt10i">
			<fieldset>
				<legend>Mailing Address</legend>
				<table>
					<tr>
						<th class="dbLabel"><label>Address: </label></th>
						<td class="dbData">
							<span>
								<?php echo $model->house_no ? $model->house_no.', ' : "";
									echo $model->street ? $model->street.', ' : "";
									echo $model->area; ?>
							</span>
						</td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>City: </label></th>
						<td class="dbData"><span><?php echo $model->city; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>State: </label></th>
						<td class="dbData"><span><?php echo $model->state; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Country: </label></th>
						<td class="dbData"><span><?php echo $model->country; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Postal Code: </label></th>
						<td class="dbData"><span><?php echo $model->zip; ?></span></td>
					</tr>				
				</table>
			</fieldset>
		</div>
		
	</div>
	<div class="dashBoardName rightDB">
		<div class="dbBoxContainer mt10i">
			<fieldset>
				<legend>Contact Details</legend>
				<table>
					<tr>
						<th class="dbLabel"><label>Primary Phone: </label></th>
						<td class="dbData"><span><?php echo $model->primary_phone; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Secondary Phone: </label></th>
						<td class="dbData"><span><?php echo $model->secondary_phone; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Email: </label></th>
						<td class="dbData"><span><?php echo $model->email_id; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Social Network ID: </label></th>
						<?php $socialNetwork = $model->social_network_id ? json_decode($model->social_network_id,true) : array();  ?>
						<td class="dbData">
							<span>
								<?php if(count($socialNetwork) > 0) { 
										$i=1; 
										foreach($socialNetwork as $key => $sn) { 
											echo $key ? $key .' : '. $sn : ''; 
											echo $i != count($socialNetwork) ? ' , ':''; 
											$i++; 
										} 
									}
								?>
							</span>
						</td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Messenger ID: </label></th>
						<?php  $messenger = $model->messenger_id ? json_decode($model->messenger_id,true) : array();  ?>
						<td class="dbData">
							<span>
								<?php if(count($messenger) > 0) {
										$i=1; 
										foreach($messenger as $key => $mess) { 
											echo $key ? $key .' : '. $mess : ''; 
											echo $i != count($messenger) ? ' , ':''; 
											$i++; 
										}
									} 
								?>
							</span>
						</td>
					</tr>				
				</table>
			</fieldset>
		</div>
		
		<div class="dbBoxContainer mt10i">
			<fieldset>
				<legend>Education &amp; Profession</legend>
				<table>
					<tr>
						<th class="dbLabel"><label>Highest Education: </label></th>
						<td class="dbData"><span><?php echo $model->highest_education; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Profession: </label></th>
						<td class="dbData"><span><?php echo $model->profession; ?></span></td>
					</tr>
				</table>
			</fieldset>
		</div>
	</div>
</div>
<div class="controlsandButtons">
	<?php if($model->id !== $this->_ADMINID && $model->id !== Yii::app()->user->id) { ?>
		<a id="spammer" href="javascript:void(0);" class="fl grayButtons">Report Spam</a>
	<?php } ?>
	<?php if($model->id !== YII::app()->user->id) { ?>
		<a id="send-message" href="javascript:void(0);" class="fl grayButtons">Send Message</a>
	<?php } ?>
	<div class="admin-ctrls fl w100">
		<div class="colL fl">
			<?php if($model->checkControlVisibility($model->can_invite == 1, $model->caller->active_status == 1)) { ?>
			<a class="w80 canInvite put0" title="Stop Invite" href="javascript:void(0);">Stop Invite</a>
			<?php } ?>
			<?php if($model->checkControlVisibility($model->can_invite == 0, $model->caller->active_status == 1)) { ?>
			<a class="w80 canInvite put1" title="Can Invite" href="javascript:void(0);">Can Invite</a>
			<?php } ?>
			<?php if($model->checkControlVisibility($model->can_hide == 0, $model->caller->active_status == 1)) { ?>
			<a class="w80 canHide put1" title="Can Hide" href="javascript:void(0);">Can Hide</a>
			<?php } ?>
			<?php if($model->checkControlVisibility($model->can_hide == 1, $model->caller->active_status == 1)) { ?>
			<a class="w80 canHide put0" title="Cannot Hide" href="javascript:void(0);">Cannot Hide</a>
			<?php } ?> 
			<?php if($model->checkControlVisibility(true, $model->caller->active_status == 1)) { ?>
			<a class="w80 madhoocount" title="Madhoo Count" href="javascript:void(0);">Madhoo Count</a>
			<?php } ?>
			
		</div>
		<div class="colR fr">
			<?php if($model->checkControlVisibility(true, $model->caller->active_status == 1)) { ?>
			<a class="fr w80 warndaee" data-req="warn" title="Warn" href="javascript:void(0);">Warn</a>
			<?php } ?>
			<?php if($model->checkControlVisibility(true, $model->caller->active_status != 2)) { ?>
			<a class="fr w80 deletedaee" data-req="delete" title="Delete" href="javascript:void(0);">Delete</a>
			<?php } ?>
			<?php if($model->checkControlVisibility(true, $model->caller->active_status == 1)) { ?>
			<a class="fr w80 blockdaee" data-req="block" title="Block" href="javascript:void(0);">Block</a>
			<?php } ?>
			<?php if($model->checkControlVisibility(true, $model->caller->active_status != 1)) { ?>
			<a class="fr w80 unblockdaee" data-req="unblock" title="Unblock" href="javascript:void(0);">Unblock</a>
			<?php } ?>
		</div>
	</div>
	<?php if($model->id != YII::app()->user->id && Yii::app()->user->getState("role") == "super_admin" && $model->caller->role == null && $model->caller->active_status == 1) { ?>
	<a class="makeAdmin put1 grayButtons" title="Make Admin" href="javascript:void(0);">Make Admin</a>
	<?php } ?>
	<?php if($model->id != YII::app()->user->id && Yii::app()->user->getState("role") == "super_admin" && $model->caller->role == "admin" && $model->caller->active_status == 1) { ?>
	<a class="makeAdmin put1 grayButtons" title="Revoke Admin" href="javascript:void(0);">Revoke Admin</a>
	<?php } ?>
	<div class="fl section-owned-created">
		<h3 class="grayButtons">Madhoo Created</h3>
		<div>
		<?php if($created && count($created) > 0) { ?>
			<ul>
				<?php foreach ($created as $value) { ?>
				<li>
					<a target="_blank" href="/madhoo/viewmadhoo/<?php echo $value->id ?>"><?php echo $value->first_name." ".$value->last_name ?></a>
				</li>
				<?php } ?>
			</ul>
		<?php } else { ?>
			No Madhoos Created
		<?php } ?>
		</div>
		<h3 class="grayButtons">Madhoo Owned</h3>
		<div>
		<?php if($owned && count($owned) > 0) { ?>
			<ul>
				<?php foreach ($owned as $value) { ?>
				<li>
					<a target="_blank" href="/madhoo/viewmadhoo/<?php echo $value->id ?>"><?php echo $value->first_name." ".$value->last_name ?></a>
				</li>
				<?php } ?>
			</ul>
		<?php } else { ?>
			No Madhoos Owned
		<?php } ?>
		</div>

	</div>
</div>
<div class="clear"></div>

<script type="text/javascript">
$(document).ready(function(){
	$(".section-owned-created").accordion({active:false, collapsible: true});
	window.Daee = window.Daee || {};
	Daee.getID = function() {
		return <?php echo $model->id; ?>;
	}
	//Send message to a Daee
	$('#send-message').click(function(){
		var id = Daee.getID(), thisref = $(this);
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

	//Report spammer
	$('#spammer').click(function(event) {
		event.preventDefault();
		$('<div id="dialog" />').appendTo('body');
		var thisref = $(this);
		$('#dialog').html('<div class="msg-spam">If you are sure about it, fill the reason and send it to Admin.<br /><br />Reason: <br /></div><textarea class="reason"></textarea>');
		$("#dialog").dialog({
			title: 'Report Spam!',
			modal: true,
			width: 335,
			resizable: true,
			buttons: [
				{ 	
					text: 'Send!',
					click: function() {
						var selectedVal = $('#dialog .reason').val();
						if($.trim(selectedVal) != "") {
							var xhr = $.ajax({
								type: "POST",
								url: "/daee/reportspam",
								data: {isAjaxRequest:1, msg: $.trim(selectedVal), daeeId: Daee.getID()}
							});
							xhr.done(function(data) {
								if(data == 'success') {
									$('<div id="dialog-msg" />').appendTo('body');
									$("#dialog-msg").html("Spam Reported. We will investigate and block the user if he/she is really a spammer. Thank you for your concern. May Allah be with you!");
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
					    		$('#dialog .reason').before("<div class=\"error\">Please enter a reason!</div>");
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

	//Can invite or cannot invite call
	$('.canInvite').click(function(){
		var id = Daee.getID(), put, thisref = $(this);
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
		        } else {
		        	thisref.addClass("put0").removeClass("put1");
		        	thisref.html("Stop Invite");
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
	$('.canHide').click(function(){
		var id = Daee.getID(), put, thisref = $(this);
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
		        } else {
		        	thisref.addClass("put0").removeClass("put1");
		        	thisref.html("Cannot Hide");
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
	$(".deletedaee, .blockdaee, .unblockdaee").click(function(evt){
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
		var id = Daee.getID();
		evt.preventDefault();
		$('#dialog').remove();
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
								//notify the user
						        window.location.reload();
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

	//increment or decrement madhoo count
	$('.madhoocount').click(function(event) {
		var id = Daee.getID();
		event.preventDefault();
		$('<div id="dialog" />').appendTo('body');
		var can_own_cnt = <?php echo $model->can_own_cnt ?>;
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

	$('.warndaee').click(function(event) {
		var id = Daee.getID();
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
									Iansar.dialog.inform("Sent!", "Warning Sent");
							    } else {
							    	Iansar.dialog.failure();
								}
					        }).fail(function() {
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
	$('.makeAdmin').click(function(event) {
		var id = Daee.getID();
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
				        }).fail(function() {
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