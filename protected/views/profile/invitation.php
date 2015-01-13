<?php
/* @var $this InvitationController */
/* @var $model Invitation */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'invitation-invitation-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<?php 
		foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
	?>
	
	<div class="invitationForm">
		<div class="headingGradient"><h4>Invite your fellow Daees</h4></div>
		<div class="formContentBox">
			<p>Invite your friends who are interested in spreading the Message of Peace to the humanity.</p>
			
			<table class="formTable">
				<tr>
					<td><?php echo $form->labelEx($model,'invitee_email'); ?></td>
				</tr>
				<tr>
					<td>
						<?php echo $form->textArea($model,'invitee_email',array('class'=>'fields textArea99', 'value'=>'')); ?>
						<?php echo $form->error($model,'invitee_email'); ?>
					</td>
				</tr>
				<tr>
					<td><label for="invitation_name">Message</label></td>
				</tr>
				<tr>
					<td><textarea class="fields textArea99" id="invitation_message" name="Inivitation[message]"></textarea></td>
				</tr>
				<tr>
					<td>
						<input type="checkbox" class="termsconditions" value="1" id="terms" />
						<label for="terms">I agree the terms and conditions<span class="required">*</span></label>
					</td>
				</tr>
				<tr>
					<td>
						<div class="row buttons">
							<?php echo CHtml::submitButton('Submit', array('id'=>'submitInvite','class'=>'grayButtons')); ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
$(document).ready(function(){
	$("#submitInvite").click(function(e){
		e.preventDefault();
		var invitationEmails = $.trim($("#Invitation_invitee_email").val());
		if(!invitationEmails) {
			$('body').append($('<div id="popup" />'));
			$('#popup').html('Please enter atleast one email address!');
			$("#popup").dialog({
				title: 'Invitation',
				modal: true,
				resizable: false,
				buttons: [
					{ 	
						text: 'OK', 
						click: function() {
							$( this ).dialog( "close" );$( "#popup" ).remove();	 
						} 
					},
				]
			});
			return false;
		}
		if(!$("#terms").is(":checked")) {
			$('body').append($('<div id="popup" />'));
			$('#popup').html('Please accept the terms and conditions');
			$("#popup").dialog({
				title: 'Invitation',
				modal: true,
				resizable: false,
				buttons: [
					{ 	
						text: 'OK', 
						click: function() {
							$( this ).dialog( "close" );$( "#popup" ).remove();	 
						} 
					},
				]
			});
			return false;
		} else {
			$("#invitation-invitation-form").submit();	
		}		
	});
});
</script>