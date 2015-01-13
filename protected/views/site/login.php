<?php Yii::app()->clientScript->scriptMap['common.js'] = false; ?>
<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
?>

<style>
	.errorMessage{position:absolute;color:red;}
</style>

<div class="container">
	<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
		<div class="panel panel-info" >
			<div class="panel-heading">
				<div class="panel-title">Login</div>
			</div>
			<div style="padding-top:30px" class="panel-body" >
				<?php
				    foreach(Yii::app()->user->getFlashes() as $key => $message) {
				        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
				    }
				?>	

				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'login-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true,
					),
				)); ?>

				<div style="margin-bottom: 25px" class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<?php echo $form->textField($model,'username',array('class'=>'form-control','autocomplete'=>'off', 'placeholder'=>'Email')); ?>
					<?php echo $form->error($model,'username'); ?>
				</div>
				
				<div style="margin-bottom: 25px" class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<?php echo $form->passwordField($model,'password',array('class'=>'form-control','autocomplete'=>'off', 'placeholder'=>'Password')); ?>
					<?php echo $form->error($model,'password'); ?>
				</div>
				
				<div class="form-group">
					<label class="checkbox-inline">
						<?php echo $form->checkBox($model,'rememberMe',array('class'=>'rememberMeCB')); ?>
						<?php echo $form->label($model,'rememberMe',array('class'=>'fwni rememberMeLabel')); ?>
						<?php echo $form->error($model,'rememberMe'); ?>
			        </label>
			        <a href="<?php echo $this->createUrl('/site/forgotpassword');?>" class="forgotPasswordLink checkbox-inline">Forgot Password?</a>
				</div>
				<?php echo CHtml::submitButton('Login',array('class'=>'btn btn-primary btn-block')); ?>
				<?php $this->endWidget(); ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

/*<![CDATA[*/
	jQuery(function($) {
		$('.form-control').first().focus();
	});
/*]]>*/
</script>
