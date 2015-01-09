<div class="form">
	<?php
	$this->beginWidget('CActiveForm', array(
		'id'=>'change-password-form',
		'enableAjaxValidation'=>false,
	));

    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>	
	
	<table class="changePasswordTable">
		<tr>
			<th><?php echo CHtml::label('New Password','pwd1',array('size'=>60,'maxlength'=>255));?><span class="required">*</span></th>
			<td><?php echo CHtml::passwordField('Callers[password]','',array('size'=>40,'maxlength'=>255, 'class'=>'reqd fields textFieldMedium', 'id'=>'pwd1')); ?></td>
		</tr>
		<tr>
			<th><?php echo CHtml::label('Password Again','pwd2',array('size'=>60,'maxlength'=>255));?><span class="required">*</span></th>
			<td><?php echo CHtml::passwordField('Callers[password_again]','',array('size'=>40,'maxlength'=>255, 'class'=>'reqd fields textFieldMedium', 'id'=>'pwd2')); ?></td>
		</tr>
		<tr>
			<td></td>
			<td><?php echo CHtml::submitButton('Submit',array('id'=>'submit-pwd','class'=>'grayButtons')); ?></td>
		</tr>
	</table>	
	<div class="errorMessage errorMessage1">Pasword did not match</div>
	<div class="errorMessage errorMessage2">New Pasword cannot be empty</div>
	<div class="errorMessage errorMessage3">Pasword Again cannot be empty</div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.errorMessage').hide();
		$('#submit-pwd').click(function(e) {
			e.preventDefault();
			var flag1 = true;
			var flag3 = true;
			var flag2 = true;
			
			if($('#pwd1').val() == '') {
				$('.errorMessage2').show();
				flag1 = false;	
			} else {
				$('.errorMessage2').hide();
				flag1 = true;
			}
			if($('#pwd2').val() == '') {
				$('.errorMessage3').show();
				flag2 = false;	
			} else {
				$('.errorMessage3').hide();
				flag2 = true;
			}
			if($('#pwd1').val() == $('#pwd2').val()) {
				$('.errorMessage1').hide();
				flag3 = true;
			} else {
				$('.errorMessage1').show();
				flag3 = false;
			}

			if(flag1 && flag2 && flag3) {
				$('#change-password-form').submit();
			}
		});
	});
</script>