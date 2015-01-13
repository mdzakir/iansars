<?php Yii::app()->clientScript->registerCssFile(
	Yii::app()->clientScript->getCoreScriptUrl().
	'/jui/css/base/jquery-ui.css'
); ?>
<div id="conversation-madhoo" class="madhoo-conversation myMadhooConversation">
<h2>Madoo Conversation</h2>
<?php Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' ); ?>
<script type="text/javascript">
	function conversationTemplate(conversation) {
		var template = '<div class="conversation_wrap">';
		template += '<div class="name_date_conv fl">';
		template += '<div class="name_date">';
		template += '<div class="name fl"><a href="/profile/dashboard"><?php echo Yii::app()->user->name; ?></a></div>';
		template += '<div class="status" data-status="'+conversation.interaction_status+'">'+conversation.interaction_status_text+'</div>';
		template += '<div class="edit_delete">';
		template += '<input type="button" data-convid="'+conversation.id+'" class="rfloat deleteConv" title="Delete" />';
		template += '<input type="button" data-convid="'+conversation.id+'" class="rfloat editConv" title="Edit" />';
		template += '</div>';
		template += '<div data-created_at="'+conversation.created_at+'" class="date fr"><?php echo date("d/m/Y"); ?></div>';
		template += '</div>';
		template += '<hr class="hrsep">';
		template += '<div class="conversation_text">'+conversation.conversation+'</div>';
		template += '</div>';
		template += '</div>';
		return template;
	}
	function dialogCall(text, title, buttonText) {
		title = title || "Confirmation Dialog";
		text = text || "";
		buttonText = buttonText || "OK";
		$( "#dialog" ).html(text);
		$( "#dialog" ).dialog({
			title: title,
			modal: true,
			resizable: false,
			buttons: [
				{ text: buttonText, click: function() { $( this ).dialog( "close" );$( "#dialog" ).empty(); } }
			]
		});
	}
	$(document).ready(function(){
		function addEditConversation(mode, $thisref) {
			var errorFlag = true; var scope;
			if(mode == "add") {
				scope = $thisref.parents('.conversation_wrap'); 
			} else {
				scope = $("#editForm");
			}
			var textareaVal = $('.conv_textarea', scope).val();
			if($.trim(textareaVal) == '') {
				$('.conv_textarea', scope).addClass('errorClass');
				var errorMsg = '<div id="errorMsgConv" class="errorMsg">Please write a comment</div>';
				$('.conv_textarea', scope).parents(".name_date_conv").find('.name_date').find('.name').after(errorMsg);
				errorFlag = false;
			} else {
				$('.conv_textarea', scope).removeClass('errorClass');
				$('#errorMsgConv', scope).fadeOut(400, function(){$(this).remove();});
				errorFlag = true;
			}
			if(errorFlag) {
				var Conversations = {};
				Conversations.id = $thisref.attr("data-convid");
				Conversations.callee_id = <?php echo $model->id; ?>;
				Conversations.conversation = textareaVal;
				Conversations.owner_id = <?php echo Yii::app()->user->id; ?>;
				Conversations.status = 1;
				if(mode=="edit") {
					Conversations.interaction_status = $('#editForm').find('select option:selected').val();
					Conversations.interaction_status_text = $('#editForm').find('select option:selected').text();
				} else {
					Conversations.interaction_status = $thisref.parent().find('select option:selected').val();
					Conversations.interaction_status_text = $thisref.parent().find('select option:selected').text();
				}
				if(mode == "edit") {
					Conversations.created_at = $thisref.parents('.conversation_wrap').find(".date").attr("data-created_at");  
				} else {
					Conversations.created_at = "<?php echo date("Y-m-d H:i:s"); ?>";
				}
				Conversations.updated_at = "<?php echo date("Y-m-d H:i:s"); ?>";
				var xhrPromise = $.post("/madhoo/conversationsave", {Conversations:Conversations});
				xhrPromise.done(function(response){
					if(response != "failed") {
						if(mode == "add") {
							Conversations.id = response;
							$thisref.parents('.conversation_wrap').before(conversationTemplate(Conversations));
						} else {
							$thisref.parents('.conversation_wrap').replaceWith(conversationTemplate(Conversations));
						}
					} else {
						dialogCall("Saving Failed. Please try again later");
					}
				}).fail(function(response, status, error){
					dialogCall("Failed. Internal Server Error");
				});
			}
		}
		$('.add_conv').click(function(evt){
			addEditConversation("add", $(this));
			$(".conv_textarea").val("");
			$('.no-conv').hide();
		});
		$(".conversation-container").delegate(".deleteConv", "click", function(){
			var targetObj = $(this);
			targetObj.removeClass("deleteConv");
			var deleteId = $(this).attr('data-convid');
			var promiseXhr = $.get("/madhoo/conversationsave", {deleteid:deleteId});
			promiseXhr.done(function(response){
				if(response != "failed") {
					targetObj.parents('.conversation_wrap').remove();
					if($('.conversation_wrap').length <= 1){
						$('.no-conv').show();
					}
				} else {
					dialogCall("Saving Failed. Please try again later");
				}
			}).fail(function(response, status, error){
				dialogCall("Failed. Internal Server Error");
			}).always(function(){
				targetObj.addClass("deleteConv");
			});
			
		});
		$(".conversation-container").delegate(".editConv", "click", function(){
			var convId = $(this).attr("data-convid");
			var thisref = $(this);
			var text = thisref.parents('.conversation_wrap').find('.conversation_text').text();
			$( "#editForm" ).empty();
			var convClone = $(".conversation_wrap").last().clone();
			convClone.find(".edit_delete").remove();
			convClone.find("hr").remove();
			var status = thisref.parents('.conversation_wrap').find(".name_date .status").attr('data-status');
			var selectBox = '';
			selectBox += '<select class="statusdialog">';
			selectBox += '<option ';
			selectBox += status == "<?php echo Controller::$CONV_STATUS_PARTIALLY_CONVINCED; ?>" ? 'selected="selected"' : '';
			selectBox += ' value="<?php echo Controller::$CONV_STATUS_PARTIALLY_CONVINCED; ?>"><?php echo Controller::$CONV_STATUS_VIEW[Controller::$CONV_STATUS_PARTIALLY_CONVINCED]; ?></option>';
			selectBox += '<option '
			selectBox += status == "<?php echo Controller::$CONV_STATUS_ACCEPTED; ?>" ? 'selected="selected"' : ''
			selectBox += ' value="<?php echo Controller::$CONV_STATUS_ACCEPTED; ?>"><?php echo Controller::$CONV_STATUS_VIEW[Controller::$CONV_STATUS_ACCEPTED]; ?></option>';
			selectBox += '<option '
			selectBox += status == "<?php echo Controller::$CONV_STATUS_CONVINCED; ?>" ? 'selected="selected"' : '' 
			selectBox += ' value="<?php echo Controller::$CONV_STATUS_CONVINCED; ?>"><?php echo Controller::$CONV_STATUS_VIEW[Controller::$CONV_STATUS_CONVINCED]; ?></option>';
			selectBox += '<option '
			selectBox += status == "<?php echo Controller::$CONV_STATUS_NO_INTERACTION_YET; ?>" ? 'selected="selected"' : ''
			selectBox += ' value="<?php echo Controller::$CONV_STATUS_NO_INTERACTION_YET; ?>"><?php echo Controller::$CONV_STATUS_VIEW[Controller::$CONV_STATUS_NO_INTERACTION_YET]; ?></option>';
			selectBox += '<option '
			selectBox += status == "<?php echo Controller::$CONV_STATUS_DISAGREED; ?>" ? 'selected="selected"' : ''
			selectBox += ' value="<?php echo Controller::$CONV_STATUS_DISAGREED; ?>"><?php echo Controller::$CONV_STATUS_VIEW[Controller::$CONV_STATUS_DISAGREED]; ?></option>';
			selectBox += '</select>';
			convClone.find(".name_date .name").after(selectBox);
			convClone.find("textarea").val(text);
			convClone.appendTo("#editForm");
			$( "#editForm" ).dialog({
				title: "Edit Conversation",
				modal: true,
				resizable: false,
				minWidth:500,
				maxWidth:500,
				position: [$(window).width()-450, $(window).height()-350],
				buttons: {
					"Save": function() {
						addEditConversation("edit", thisref);
			        	$( this ).dialog( "close" );
			        	$( "#editForm" ).empty();
			        },
					Cancel: function() {
				    	$( this ).dialog( "close" );
				    	$( "#editForm" ).empty();
				    }
			    }
			});
		});
	});
</script>
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl('/madhoo/viewmadhoo').'/'.$model->id,
	'method'=>'POST',
)); ?>
	<div class="conversation-container">
		<?php if(count($conversations) > 0) {
			foreach($conversations as $conversation) { 
			$owner_loggedIn = $conversation->owner_id == YII::app()->user->id ? 1 : 0;
			//echo "<pre>";print_r($conversation);
			?>
			<div class="conversation_wrap">
				<div class="name_date_conv fl">
					<div class="name_date">
						<div class="name fl"><a href="<?php echo $owner_loggedIn ? "/profile/dashboard" : "/daee/view/1"; ?>"><?php echo $owner_loggedIn ? Yii::app()->user->name : $this->getName($conversation->owner_id); ?></a></div>
						<div class="status" data-status="<?php echo $conversation->interaction_status; ?>"><?php echo Controller::$CONV_STATUS_VIEW[$conversation->interaction_status]; ?></div>
						<div class="edit_delete">
							<?php if($owner_loggedIn) { ?>
								<input type="button" title="Delete" data-convid="<?php echo $conversation->id; ?>" class="rfloat deleteConv" value="" />
								<input type="button" title="Edit" data-convid="<?php echo $conversation->id; ?>" class="rfloat editConv" value="" />
							<?php } ?>
						</div>
						<div data-created_at="<?php echo $conversation->created_at; ?>" class="date fr"><?php echo date("d/m/Y H:i:s", strtotime($conversation->updated_at)); ?></div>
					</div>
					<hr class="hrsep">
					<div class="conversation_text"><?php echo $conversation->conversation; ?></div>
				</div>
			</div>
		<?php } 
		} else { ?>
			<div class="no-conv">No conversation happened</div>
		<?php } ?>
		<?php if(Yii::app()->user->id == $model->owned_by || Yii::app()->user->id == $model->caller_id){ ?>
		<div class="conversation_wrap addConversation">
			<div class="name_date_conv fl">
				<div class="name_date">
					<div class="name fl"><a href="<?php echo "/profile/dashboard"; ?>"><?php echo Yii::app()->user->name; ?></a></div>
					<div class="date fr"><?php echo date("d/m/Y"); ?></div>
				</div>
				<hr class="hrsep">
				<div class="textAreaAdd">
					<textarea rows="10" cols="40" class="conv_textarea"></textarea>
					<div class="edit_delete">
						<select class="selectDD status">
							<option value="<?php echo Controller::$CONV_STATUS_PARTIALLY_CONVINCED; ?>">Partially Convinced</option>
							<option value="<?php echo Controller::$CONV_STATUS_ACCEPTED; ?>">Accepted</option>
							<option value="<?php echo Controller::$CONV_STATUS_CONVINCED; ?>">Convinced</option>
							<option value="<?php echo Controller::$CONV_STATUS_NO_INTERACTION_YET; ?>">No Interaction Yet</option>
							<option value="<?php echo Controller::$CONV_STATUS_DISAGREED; ?>">Disagreed</option>
						</select>
						<input type="button" data-convid="" class="add_conv fr grayButtons" value="Add" />
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
<?php $this->endWidget(); ?>
<div id="dialog"></div>
<div id="editForm"></div>
</div>
