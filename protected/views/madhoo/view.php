<?php
/* @var $this MadhooController */
/* @var $model Callees */
?>
<div id="madhoo-renew-success-flash" style="display:none" class="flash-success">Renewal successful. Great Job.</div>
<div id="madhoo-renew-error-flash" style="display:none" class="flash-error">Error in renewing the Madhoo. Try later.</div>
<div id="madhoo-unassign-error-flash" style="display:none" class="flash-error">Error in unassigning the Madhoo. Try later.</div>
<div class="madhooDetailPage">

	<h1><strong><?php echo '<span style="color:#999;">Madhoo ID: </span>'.$model->id;?>, <?php if($model->area) echo '<span style="color:#999;">Area: </span>'.$model->area; ?>, <?php echo '<span style="color:#999;">City: </span>'.$model->city; ?></strong></h1>

	<div class="dashBoard">
		<div class="dashBoardName leftDB">
			<div class="dbBoxContainer">
				<fieldset>
					<legend>Basic Information</legend>
					<table>
						<?php if($this->isAdmin() || $model->caller_id == Yii::app()->user->id || $model->owned_by == Yii::app()->user->id){ ?>
						<?php if($this->isAdmin()) { ?>
						<tr>
							<th class="dbLabel"><label>Madoo ID: </label></th>
							<td class="dbData"><span><?php echo $model->id; ?></span></td>
						</tr>
						<?php } ?>
						<tr class="separatorDB"><td colspan="2"><hr></td></tr>
						<?php } ?>
						<tr>
							<th class="dbLabel"><label>Gender: </label></th>
							<td class="dbData"><span class="capiCase"><?php echo $model->gender; ?></span></td>
						</tr>
						<tr class="separatorDB"><td colspan="2"><hr></td></tr>
						<tr>
							<th class="dbLabel"><label>Age: </label></th>
							<td class="dbData capiCase"><span><?php echo $model->age; ?></span></td>
						</tr>
					</table>
				</fieldset>
			</div>
			
			<div class="dbBoxContainer mt10i">
				<fieldset>
					<legend>Languages</legend>
					<table>
						<tr>
							<th class="dbLabel"><label>Languages Read: </label></th>
							<td class="dbData"><span><?php echo $model->language_read; ?></span></td>
						</tr>
						<tr class="separatorDB"><td colspan="2"><hr></td></tr>
						<tr>
							<th class="dbLabel"><label>Languages Write: </label></th>
							<td class="dbData"><span><?php echo $model->language_write; ?></span></td>
						</tr>
						<tr class="separatorDB"><td colspan="2"><hr></td></tr>
						<tr>
							<th class="dbLabel"><label>Languages Speak: </label></th>
							<td class="dbData"><span><?php echo $model->language_speak; ?></span></td>
						</tr>				
					</table>
				</fieldset>
			</div>

			<div class="dbBoxContainer mt10i">
				<fieldset>
					<legend>Additional Information</legend>
					<table>
						<tr>
							<th class="dbLabel"><label>Note: </label></th>
							<td class="dbData"><span><?php echo nl2br($model->note); ?></span></td>
						</tr>
					</table>
				</fieldset>
			</div>
		</div>
		<div class="dashBoardName rightDB">
			<?php if($this->isAdmin() || $model->caller_id == Yii::app()->user->id || $model->owned_by == Yii::app()->user->id) { ?>
			<div class="dbBoxContainer mt10i">
				<fieldset>
					<legend>Mailing Address</legend>
					<table>
						<tr>
							<th class="dbLabel"><label>Area: </label></th>
							<td class="dbData"><span><?php if($model->area) echo $model->area; ?></span></td>
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
			
			<div class="dbBoxContainer mt10i">
				<fieldset>
					<legend>Education</legend>
					<table>
						<tr>
							<th class="dbLabel"><label>Highest Education: </label></th>
							<td class="dbData"><span><?php echo $model->highest_qualification; ?></span></td>
						</tr>
					</table>
				</fieldset>
			</div>
			<?php } else{ ?>
			<div class="dbBoxContainer">
				<fieldset>
					<legend>Location Area</legend>
					<table>
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
			<?php } ?>
		</div>
	</div> <!-- Madoo Profile ENDs -->
	
	
	<div class="controlsandButtons">
		<?php if($model->owned_by === YII::app()->user->id) { ?>
		<a id="unassign-madhoo" href="javascript:void(0);" class="grayButtons">Unassign</a>
		<?php } ?>
		<?php if(!$model->owned_by || (YII::app()->user->id != $model->caller_id && $model->owned_by != YII::app()->user->id)) {?>
			<?php $requestedByList = $model->requested_by ? json_decode($model->requested_by) : array();
			if(!in_array(YII::app()->user->id, $requestedByList)) { ?>
			<a href="javascript:void(0);" class="assign-to-me grayButtons">Assign to me</a>
			<?php } else { ?> 
			<a class="grayButtons requestPending">Request Pending</a> 
			<?php } ?>
		<?php } ?>

		<?php if($callerModel->can_hide) {
			if($model->is_hidden) { ?>
			<a href="javascript:void(0);" data-hide="unhide" class="hidemadhoo grayButtons">Unhide Madhoo</a>
			<?php } else { ?>
			<a href="javascript:void(0);" data-hide="hide" class="hidemadhoo grayButtons">Hide Madhoo</a>
			<?php } 
		}?>
		
		<?php if(YII::app()->user->id == $model->caller_id || $model->owned_by == YII::app()->user->id) { ?>
		<a id="edit-madhoo" href="/madhoo/editmadhoo/<?php echo $_GET['id']; ?>" class="grayButtons">Edit Details</a>
		<?php } ?>

		<?php if($model->owned_by === YII::app()->user->id) { ?>
		<a id="renew-madhoo" href="javascript:void(0);" class="grayButtons">Renew</a>
		<?php } ?>

		<?php if($model->owned_by == $model->caller_id) { ?>
		<fieldset>
			<legend>Created and Owned by</legend>
			<a href="<?php echo $model->caller_id == YII::app()->user->id ? "/profile/dashboard" : "/daee/".$model->caller_id ?>" class="aLinks">
				<?php echo $created_owned['created_owned'];echo $model->caller_id == YII::app()->user->id ? " (me)" : ""; ?>
			</a>
		</fieldset>
		<?php } else { ?>
		<fieldset>
			<legend>Owned by</legend>
			<?php if($model->owned_by) { ?>
			<a href="<?php echo $model->owned_by == YII::app()->user->id ? "/profile/dashboard" : "/daee/".$model->owned_by ?>" class="aLinks">
				<?php echo $created_owned['owned'];echo $model->owned_by == YII::app()->user->id ? " (me)" : ""; ?>
			</a>
			<?php } else { ?>
			NIL
			<?php } ?>
		</fieldset>
		<fieldset>
			<legend>Created by</legend>
			<a href="<?php echo $model->caller_id == YII::app()->user->id ? "/profile/dashboard" : "/daee/".$model->caller_id ?>" class="aLinks">
				<?php echo $created_owned['created'];echo $model->caller_id == YII::app()->user->id ? " (me)" : ""; ?>
			</a>
		</fieldset>
		<fieldset>
			<legend>Status</legend>
			<?php echo Controller::$CONV_STATUS_VIEW[$model->status]; ?>
		</fieldset>
		<?php } ?>
	</div>
	<div class="clear"></div>
</div>
	
<?php 
	$this->renderPartial('_conversation',array(
		'model'=>$model,'conversations'=>$conversations
	)); 
?>
<script type="text/javascript">
$(document).ready(function(){
	<?php if($model->owned_by === YII::app()->user->id) { ?>
	$('#unassign-madhoo').click(function(event){
		event.preventDefault();
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
					        url:'/madhoo/unassignmadhoo/<?php echo $_GET['id']; ?>',
					        data: {isAjaxRequest:1}
					    });
				        xhr.done(function(data) {
					        if(data == 'success') {
					        	window.location.href = '/madhoo/mymadhoo';
						    } else {
						    	$('#madhoo-unassign-error-flash').slideDown('slow');
							}
				        }).fail(function(XHR) {
				        	$('#madhoo-unassign-error-flash').slideDown('slow');
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
	<?php } ?>
	<?php if($model->owned_by === YII::app()->user->id) { ?>
	$('#renew-madhoo').click(function(event){
		event.preventDefault();
		var xhr = $.ajax({
	        type:'POST',
	        url:'/madhoo/renewmadhoo/<?php echo $_GET['id']; ?>',
	        data: {isAjaxRequest:1}
	    });
        xhr.done(function(data) {
	        if(data == 'success') {
	    		$('#madhoo-renew-success-flash').slideDown('slow');
		    } else {
		    	$('#madhoo-renew-error-flash').slideDown('slow');
			}
        }).fail(function(XHR) {
        	$('#madhoo-renew-error-flash').slideDown('slow');
        });
	});
	<?php } ?>
	<?php if($model->owned_by !== YII::app()->user->id) { ?>
	$('.assign-to-me').click(function(){
		var thisref = $(this);
		$('body').append("<div id='#dialog'></div>");
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
						data.caller_id = "<?php echo $model->caller_id; ?>";
						data.owned_by = "<?php echo $model->owned_by; ?>";
						//owned_by-{null} && caller_id-{loggedin user}
						<?php if($model->caller_id === YII::app()->user->id && $model->owned_by == NULL) { ?>
							data.assigner_id = "<?php echo YII::app()->user->id; ?>";
							data.assignee_id = "<?php echo $model->id; ?>";
							messageText = "Madhoo is assigned to you. Thank you for your service.";
							buttonText = "Assigned Successfully";
						//owned_by-{null} && caller_id-{not loggedin user}
						<?php } else if ($model->caller_id != YII::app()->user->id && $model->owned_by == NULL) { ?>
							data.sender_id = "<?php echo YII::app()->user->id; ?>";
							data.receiver_id = "<?php echo $model->caller_id; ?>";
							data.type = "<?php echo Controller::$MSG_TYPE_ASSIGNMENT; ?>";
							data.status = "<?php echo Controller::$MSG_STATUS_UNREAD; ?>";
							data.title = "Assign Madhoo to Me";
							data.description = 'I have interest in Madhoo [[{"href":"/madhoo/viewmadhoo/<?php echo $model->id; ?>","madhoo":<?php echo $model->id; ?>}]]. Assign him to me';
							//data.description = 'I have interest in Madhoo <a target="_blank" class="fancyLink" href="/madhoo/viewmadhoo/<?php echo $model->id; ?>"><b><?php echo $model->first_name.' '.$model->last_name; ?></b></a>. Assign him to me';
							messageText = "Message is conveyed to the OWNER of the Madhoo. <br />Thanks for you service. <br />Let Allah be with You.";
							buttonText = "Request Pending";
						//owned_by-{not null}
						<?php } else if($model->owned_by != NULL) { ?>
							data.sender_id = "<?php echo YII::app()->user->id; ?>";
							data.receivers_id = "<?php echo $model->caller_id.','.$model->owned_by; ?>";
							data.type = "<?php echo Controller::$MSG_TYPE_ASSIGNMENT; ?>";
							data.status = "<?php echo Controller::$MSG_STATUS_UNREAD; ?>";
							data.title = "Assign Madhoo to Me";
							data.description = 'I have interest in Madhoo [[{"href":"/madhoo/viewmadhoo/<?php echo $model->id; ?>","madhoo":<?php echo $model->id; ?>}]]. Assign him to me';
							//data.description = "I have interest in Madhoo <a target=\"_blank\" class=\"fancyLink\" href=\"/madhoo/viewmadhoo/<?php echo $model->id; ?>\"><b><?php echo $model->first_name.' '.$model->last_name; ?></b></a>. Assign him to me";
							messageText = "Message is conveyed to the OWNER of the Madhoo. <br />Thanks for you service. <br />Let Allah be with You.";
							buttonText = "Request Pending";
						<?php } else { ?>
							data.condifalse = true;
						<?php }?>
						var xhr = $.ajax({
							type: "POST",
							url:"/madhoo/assigntome/<?php echo $model->id; ?>",
							data:data
						});
						xhr.done(function(data){
							if(data == 'success') {
								$( "#dialog" ).html(messageText);
								thisref.html(buttonText).removeClass('assign-to-me');
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
						$( "#dialog" ).remove();
					} 
				},
				{ 	text: 'Cancel', 
					click: function() { 
						$( this ).dialog( "destroy" );
						$( "#dialog" ).remove(); 
					} 
				}
			]
		});
	});
	<?php } ?>

	<?php if($callerModel->can_hide) { ?>
	$(".hidemadhoo").click(function() {
		var thisref = $(this), hide = $(this).attr('data-hide');
		var url = "/madhoo/hidemadhoo/<?php echo $model->id; ?>";
		var xhr = $.ajax({
			type: "POST",
			url: url,
			data:{ 	isAjaxRequest:1, hide: hide }
		});
		xhr.done(function(data){
			if(data == 'success') {
				if(hide == 'hide') {
					thisref.attr('data-hide', 'unhide').html("Unhide Madhoo");
				} else {
					thisref.attr('data-hide', 'hide').html("Hide Madhoo");
				}
			} else {
				Iansar.dialog.failure();
			}
		}).fail(function(data){
			Iansar.dialog.failure();
		});
	});
	<?php } ?>
});
</script>