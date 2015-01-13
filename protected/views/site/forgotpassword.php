
<style>
	.errorMessage{position:absolute;color:red;}
</style>
   
    <div class="container">    
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
				<div class="panel-heading">
					<div class="panel-title">Forgot password</div>
				</div>
				<div style="padding-top:30px" class="panel-body" >

					<?php
						$this->beginWidget('CActiveForm', array(
							'id'=>'forgot-password-form',
							'enableAjaxValidation'=>false,
						));
					
					    foreach(Yii::app()->user->getFlashes() as $key => $message) {
					        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
					    }
					?>
					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<?php echo CHtml::textField('Callers[email]','',array('size'=>40,'maxlength'=>255, 'class'=>'reqd fields form-control', 'id'=>'email_id', 'placeholder'=>'Enter your Email ID')); ?>
					</div>
					<div class="errorMessage form-group">Invalid Email</div>
					<div style="margin-top:10px" class="form-group">
						<div class="col-sm-12 controls">
							<button id="btn-forgot-password" type="submit" class="btn btn-success">Submit</button>
						</div>
					</div>
				<?php $this->endWidget(); ?>
				</div>
			</div>  
        </div>
    </div>
	

<script type="text/javascript">
	$(document).ready(function(){
		$('.errorMessage').hide();
		$('#submit-mail').click(function(e) {
			e.preventDefault();
			var email = $('#email_id').val();
			if( email == '') {
				$('.errorMessage').show();
			} else {
				var pattern = /^([0-9a-zA-Z]([-\.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/;
				if(pattern.test(email) == true) {
					$('.errorMessage').hide();
					$('#forgot-password-form').submit();
				} else {
					$('.errorMessage').show();
				}
			}
		});
	});
</script>