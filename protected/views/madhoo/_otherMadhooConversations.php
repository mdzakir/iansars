<?php Yii::app()->clientScript->registerCssFile(
	Yii::app()->clientScript->getCoreScriptUrl().
	'/jui/css/base/jquery-ui.css'
); ?>
<div id="conversation-madhoo" class="madhoo-conversation otherMadhooConversation">
<h2>Madoo Conversation</h2>
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl('/madhoo/othermadhooview').'/'.$model->id,
	'method'=>'POST',
)); ?>
	<div class="conversation-container">
		<?php if(count($conversations) > 0) {
			foreach($conversations as $conversation) { 
			$owner_loggedIn = $conversation->owner_id == YII::app()->user->id ? 1 : 0;
			//echo "<pre>";print_r($conversation->owner);
			?>
			<div class="conversation_wrap">
				<div class="name_date_conv fl">
					<div class="name_date">
						<div class="name fl"><a href="<?php echo $owner_loggedIn ? "/profile/dashboard" : "/daee/view/1"; ?>"><?php echo $owner_loggedIn ? Yii::app()->user->name : $this->getName($conversation->owner_id); ?></a></div>
						<div data-created_at="<?php echo $conversation->created_at; ?>" class="date fr"><?php echo date("d/m/Y", strtotime($conversation->updated_at)); ?></div>
					</div>
					<hr class="hrsep">
					<div class="conversation_text"><?php echo $conversation->conversation; ?></div>
				</div>
				<!-- <div class="edit_delete">
					<?php if($owner_loggedIn) { ?>
						<input type="button" data-convid="<?php echo $conversation->id; ?>" class="rfloat grayButtons editConv mb5" value="Edit" />
						<input type="button" data-convid="<?php echo $conversation->id; ?>" class="rfloat grayButtons deleteConv" value="Delete" />
					<?php } ?>
				</div> -->
			</div>
		<?php } 
		} else { ?>
			<div class="no-conv">No conversation happened</div>
		<?php } ?>
		<!-- <div class="conversation_wrap">
			<div class="name_date_conv fl">
				<div class="name_date">
					<div class="name fl"><a href="<?php echo "/profile/dashboard"; ?>"><?php echo Yii::app()->user->name; ?></a></div>
					<div class="date fr"><?php echo date("d/m/Y"); ?></div>
				</div>
				<hr class="hrsep">
				<textarea rows="10" cols="40" class="conv_textarea"></textarea>
			</div>
			<div class="edit_delete">
				<input type="button" data-convid="" class="add_conv fr grayButtons" value="Add" />
			</div>
		</div> --> 
	</div>
<?php $this->endWidget();?>
<div id="dialog"></div>
<div id="editForm"></div>
</div>