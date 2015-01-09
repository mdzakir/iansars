<?php
/* @var $this CallersController */
/* @var $model Callers */
/* @var $form CActiveForm */
?>

<style>
	.errorMessage{position:absolute;color:red;}
</style>

    <div class="container">    
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
				<div class="panel-heading">
					<div class="panel-title">Register</div>
				</div>
				<div style="padding-top:30px" class="panel-body" >
					<div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
					<?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'callers-RegisterForm-form',
						'enableAjaxValidation'=>false,
					)); ?>
					<?php echo $form->errorSummary($model); ?>

					<?php 
						foreach(Yii::app()->user->getFlashes() as $key => $message) {
				        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
				    }
					?>
						<div style="margin-bottom: 25px" class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<?php echo $form->textField($model,'email',array('class'=>'form-control', 'readonly'=>'readonly' ,'autocomplete'=>'off')); ?>
							<?php echo $form->error($model,'email'); ?>
						</div>
						<div style="margin-bottom: 25px" class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <?php echo $form->passwordField($model,'password',array('class'=>'form-control','autocomplete'=>'off', 'placeholder'=>'Password (Min 8 characters)')); ?>
							<?php echo $form->error($model,'password'); ?>
						</div>
						<div style="margin-bottom: 25px" class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<?php echo $form->passwordField($model,'password_again',array('class'=>'form-control','autocomplete'=>'off', 'placeholder'=>'Confirm Password (Min 8 characters)')); ?>
							<?php echo $form->error($model,'password_again'); ?>
						</div>
						<div style="margin-top:10px" class="form-group">
							<div class="col-sm-12 controls">
								<button id="btn-login" type="submit" class="btn btn-success">Register</button>
							</div>
						</div>
					<?php $this->endWidget(); ?>
				</div>
			</div>  
        </div>
    </div>
    