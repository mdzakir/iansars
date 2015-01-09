<?php
/* @var $this MadhooController */
/* @var $model Callees */

$this->menu=array(
	array('label'=>'Create Callees', 'url'=>array('addmadhoo')),
	array('label'=>'Update Callees', 'url'=>array('editmadhoo', 'id'=>$model->id)),
	array('label'=>'Manage Callees', 'url'=>array('mymadhoo')),
);
?>

<div class="madhooDetailPage">

	<h1><?php echo $model->first_name. ' ' .$model->last_name; ?></h1>

	<div class="dashBoard">
		<div class="dashBoardName leftDB">
			<div class="dbBoxContainer">
				<fieldset>
					<legend>Basic Information</legend>
					<table>
						<?php if($this->isAdmin()){ ?>
						<tr>
							<th class="dbLabel"><label>Madoo ID: </label></th>
							<td class="dbData"><span><?php echo $model->id; ?></span></td>
						</tr>
						
						<tr class="separatorDB"><td colspan="2"><hr></td></tr>
						<tr>
							<th class="dbLabel"><label>Caller ID: </label></th>
							<td class="dbData"><span><?php echo $model->caller_id; ?></span></td>
						</tr>
						<tr class="separatorDB"><td colspan="2"><hr></td></tr>
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
			<?php if($this->isAdmin()){ ?>
			<div class="dbBoxContainer">
				<fieldset>
					<legend>Contact Details</legend>
					<table>
						<tr>
							<th class="dbLabel"><label>Phone: </label></th>
							<td class="dbData"><span><?php echo $model->phone_number; ?></span></td>
						</tr>
						<tr class="separatorDB"><td colspan="2"><hr></td></tr>
						<tr>
							<th class="dbLabel"><label>Email: </label></th>
							<td class="dbData"><span><?php echo $model->email_id; ?></span></td>
						</tr>
						<tr class="separatorDB"><td colspan="2"><hr></td></tr>
						<tr>
							<th class="dbLabel"><label>Social Network ID: </label></th>
							<?php  $socialNetwork = $model->social_network_id ? json_decode($model->social_network_id,true) : array();  ?>
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
			<?php } ?>
			<?php if($this->isAdmin()){ ?>
			<div class="dbBoxContainer mt10i">
				<fieldset>
					<legend>Mailing Address</legend>
					<table>
						<tr>
							<th class="dbLabel"><label>Address: </label></th>
							<td class="dbData"><span><?php echo $model->house_no.', '.$model->street.', '.$model->area; ?></span></td>
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
					<legend>Education &amp; Profession</legend>
					<table>
						<tr>
							<th class="dbLabel"><label>Highest Education: </label></th>
							<td class="dbData"><span><?php echo $model->highest_qualification; ?></span></td>
						</tr>
						<tr class="separatorDB"><td colspan="2"><hr></td></tr>
						<tr>
							<th class="dbLabel"><label>Profession: </label></th>
							<td class="dbData"><span><?php echo $model->profession; ?></span></td>
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
		<?php if($model->owned_by == NULL || (YII::app()->user->id != $model->caller_id && $model->owned_by != YII::app()->user->id)) {?>
			<?php $requestedByList = $model->requested_by ? json_decode($model->requested_by) : array();
			if(!in_array(YII::app()->user->id, $requestedByList)) { ?>
			<a href="javascript:void(0);" class="assign-to-me grayButtons">Assign to me</a>
			<?php } else { ?> 
			<a class="grayButtons requestPending">Request Pending</a> 
			<?php } ?>
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
			<?php if($model->owned_by) {?>
			<a href="<?php echo $model->owned_by == YII::app()->user->id ? "/profile/dashboard" : "/daee/".$model->owned_by ?>" class="aLinks">
				<?php echo $created_owned['owned'];echo $model->owned_by == YII::app()->user->id ? " (me)" : ""; ?>
			</a>
			<?php } else { ?>
				NIL
			<?php }?>
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
	$('.controlsandButtons').delegate('.assign-to-me', 'click', function(){
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
});
</script>