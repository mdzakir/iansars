<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- BootStrap CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-theme.css" />
	
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/login.css" />
	<?php Yii::app()->clientScript->registerCssFile(
		Yii::app()->clientScript->getCoreScriptUrl().
		'/jui/css/base/jquery-ui.css'
	); ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' ); ?>
	<?php Yii::app()->clientScript->registerCoreScript('js/common'); ?>
	<script type="text/javascript" src="/js/common.js"></script>
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
</head>

<body id="login">
<div id="loader"><img src="/images/ajax-loader.gif" /></div>
<div id="overlay_loader"></div>
<div class="container" id="page">
	<div id="header">
		<div id="logo">
			<a title="<?php echo CHtml::encode(Yii::app()->name); ?>" href="/"></a>
		</div>
	</div><!-- header -->
	<?php if(!Yii::app()->user->isGuest) { ?>
		<div style="float:right;">Hi <?php echo Yii::app()->user->name; ?></div>
		<div style="float:right;"><a href="/site/logout">Logout</a></div>
	<?php } ?>
	
	<?php if(Yii::app()->user->isGuest) { ?>
		<!-- <?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'Register', 'url'=>array('/site/register'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		));  ?> -->
	<?php } else { ?>
		<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'Register', 'url'=>array('/site/register'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Home', 'url'=>array('/profile/dashboard'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Inbox', 'url'=>array('/profile/mymessages'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Edit Profile', 'url'=>array('/profile/editprofile'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Invite', 'url'=>array('/profile/invite'), 'visible'=>!Yii::app()->user->isGuest),
				//array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
		</div>
	<?php } ?>
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by iAnsars.<br/>
		All Rights Reserved.<br/>
		<?php // echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
