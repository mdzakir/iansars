
<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type
	="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/profile.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/select2.css" />
	<?php Yii::app()->clientScript->registerCssFile(
		Yii::app()->clientScript->getCoreScriptUrl().
		'/jui/css/base/jquery-ui.css'
	); ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' ); ?>
	<script type="text/javascript" src="/js/common.js"></script>
	<script type="text/javascript" src="/js/select2.min.js"></script>
</head>

<body>
<div id="loader"><img src="/images/ajax-loader.gif" /></div>
<div id="overlay_loader"></div>
<div class="fullContainer" id="page">

	<div id="header">
		<div id="logo">
			<a title="<?php echo CHtml::encode(Yii::app()->name); ?>" href="/"></a>
		</div>
	<?php if(!Yii::app()->user->isGuest) { ?>
		<div class="welcomeCard">
			<?php if($this->messageCount) { ?>
				<a href="/profile/mymessages"><div class="notification_count"><?php echo $this->messageCount; ?> <span class="icon-mail"></span></div></a>
			<?php } ?>
			<div>
				Assalaamualaikum, 
				<br />
				<a href="/profile/dashboard">
					<?php echo Yii::app()->user->name; ?>
					<?php echo Yii::app()->user->getState("role") == "admin" ? "(Moderator)" : ""; ?>
					<?php echo Yii::app()->user->getState("role") == "super_admin" ? "(Admin)" : ""; ?>
				</a>
			</div>
		</div>
	<?php } ?>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				//array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'Register', 'url'=>array('/site/register'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Home', 'url'=>array('/profile/dashboard'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Inbox', 'url'=>array('/profile/mymessages'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Invite', 'url'=>array('/profile/invite'), 'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->can_invite),
				//array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
		<?php echo $this->getMyMadhoos; ?>
		<span class="settingsMenu"><span class="settingsIcon"></span></span>
		<?php echo $this->quickLinks; ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<div class="fullWidthLayout">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
		<div class="clear"></div>
	</div>
	<a href="/madhoo/madhoos" id="madhoolist-qlink" title="Madhoos List" class="floating_qlinks">Madhoos</a>
	<a href="/daee/daees" id="daeelist-qlink" title="Da'ees List List" class="floating_qlinks">Daees</a>
	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by iAnsars.<br/>
		All Rights Reserved.<br/>
		<?php // echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

<script type="text/javascript">

	$('document').ready(function(){
		$('.settingsMenu').on('click', function(event){
			if($(this).hasClass('smOpened')){
				$(this).removeClass('smOpened');
				$(this).next().slideUp('fast');
			}else{
				$('.settingsMenu').removeClass('smOpened');
				$(this).addClass('smOpened');
				$('.settingsMenuList').slideUp('fast');
				$(this).next().slideDown('fast');
			}
			event.stopPropagation();
		});

		$('html').on('click', function(){
			$('.settingsMenuList').slideUp('fast');
			$('.settingsMenu').removeClass('smOpened');
		});

		//set min height to page
		$("#content").css("minHeight", $(window).height()-190);
	});
		
</script>

</body>
</html>
