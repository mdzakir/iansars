<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.dataTables.css">
<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
<div class="span-4b">
	<div class="myMessagesLinksWrap">
		<ul class="myMessagesLinks">
			<li class="msgall mmlSelected"><a data-table="msgrxd" class="msgTabs" href="javascript:void(0);">Messages</a></li>
			<li class="mymsgreq"><a data-table="reqrxd" class="msgTabs" href="javascript:void(0);">Requests</a></li>
			<li class="notifications"><a data-table="notify" class="msgTabs" href="javascript:void(0);">Notifications</a></li>
		</ul>
	</div>
</div>
<div class="span-10">
	<div id="messageContainer" class="messagesListWrap">
		<div class="ctrls-wrapper">
			<div class="messageControls">
				<span class="messageControlButton">
					<label for="selectall" class="selectAllLabel">
						<input id="selectall" type="checkbox" class="selectAllCB"/>
						<span class="selectAllText">Select All</span>
					</label>
				</span>
				<span class="messageControlButton deleteButton fwb" data-req="msg">x</span>
				<ul id="msgall" class="msgrxd msgsnt toggleTabs">
					<li><a data-table="msgrxd" class="msgTabs selected" href="javascript:void(0);">Messages received</a></li>
					<li><a data-table="msgsnt" class="msgTabs" href="javascript:void(0);">Messages sent</a></li>
				</ul>
				<ul id="mymsgreq" class="reqrxd reqsnt toggleTabs" style="display:none">
					<li><a data-table="reqrxd" class="msgTabs" href="javascript:void(0);">Requests received</a></li>
					<li><a data-table="reqsnt" class="msgTabs" href="javascript:void(0);">Requests sent</a></li>
				</ul>
			</div>
		</div>
		
		<table class="msgrxd msgallTable messagesTable show" cellpadding="0" cellspacing="0">
			<?php if($models && count($models)) { ?>
			<thead>
				<tr>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($models as $mod => $model) { ?>
			<tr class="showDesc <?php echo ($model["receiver_status"] == "READ") ? "read" : "unread"; ?>">
				<td class="msgCB"><input data-value="<?php echo $model["id"]; ?>" type="checkbox" class="msgCheckBox" /></td>
				<td class="msgSender"><div class="fwb"><?php echo $this->getName($model["sender_id"]);?></div></td>
				<td class="msgSubject">
					<div><?php echo $model["title"]; ?></div>
					<div class="dNone description"><?php echo $this->parseMessages($model["description"]); ?></div>
				</td>
				<td class="msgActions">
					<?php echo date("d/M/Y", strtotime($model["created_at"])); ?>
				</td>
			</tr>
			<?php } ?>
			</tbody>
			<?php } else { ?>
			<thead>
				<tr>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
			<?php } ?>
		</table>
	</div>
</div>
<div class="messageDisplayBox last">
	<div class="msgBoxTitle">Message</div>
	<div class="msgBoxContainer">
		
	</div>
</div>



<script type="text/javascript">
function showMessage($tr) {
	clearMessageBox();
	var deleteVal = $tr.find("input").attr("data-value");
	var msg_req = $tr.find("input").attr("data-req") || "msg";
	var description = $tr.find('td.msgSubject .description').html();
	var name = $tr.find("td.msgSender").text();
	var date = $tr.find("td.msgActions").text();
	
	var msgTemplate = '<div class="msg-header">'+
						'<div class="sentBy lfloat">'+
							'<div class="labletxt lfloat">Sent By:</div>'+
							'<div class="sentByName lfloat">'+name+'</div>'+
						'</div>'+
						'<div class="sentOn rfloat">'+
							'<div class="labletxt lfloat">Sent On:</div>'+
							'<div class="sentDate lfloat">'+date+'</div>'+
						'</div>'+
					'</div>'+
					'<div class="message-content">'+description+'</div>';
	var deleteButton = '<div class="grayButtons delete rfloat" data-req="'+msg_req+'"" data-value="'+deleteVal+'">Delete Message</div>';
	$(".msgBoxContainer").html(msgTemplate);
	$(".msgBoxTitle").prepend(deleteButton);
}

function clearMessageBox() {
	$(".msgBoxContainer").html("");
	$(".msgBoxTitle .delete").remove();
}

$(document).ready(function(){
	var firstTableInstance = $(".messagesTable:first").dataTable({
		"iDisplayLength": 20,
		"bPaginate": true,
		'bSort': false,
		"oLanguage": {
			"sInfoEmpty": "No Messages",
			"sEmptyTable": "No Messages"
		}
	});
	$(".messagesTable:first").data("datatable", firstTableInstance);
	if(!(firstTableInstance.fnGetData() || []).length) {
		$("#selectall").attr("disabled", "disabled");
	} else {
		$("#selectall").removeAttr("disabled");
	}
	/* Getting other type of messages */
	function getOtherMessages(url, data) {
		var xhr = $.ajax({
			url: url,
			type: 'POST',
			data: data
		})
		.done(function(response) {
			if(response != "failed") {
				$('#messageContainer').append(response);
				var dataTableInstance = $(".messagesTable:last").dataTable({
					"iDisplayLength": 20,
					"bPaginate": true,
					'bSort': false,
					"oLanguage": {
						"sInfoEmpty": "No Messages",
						"sEmptyTable": "No Messages"
					}
				});
				$(".messagesTable:last").data("datatable", dataTableInstance);
				$(".dataTables_wrapper:last").hide();
			} else {
				Iansar.dialog.failure();
			}
		})
		.fail(function(data, response) {
			Iansar.dialog.failure();
		});
		return xhr;
	}
	
	$.when(
		//Sent messages
		getOtherMessages('/profile/mymessages', {isAjaxRequest: 1}), 
		//Received Requests
		getOtherMessages('/profile/myrequests', {isAjaxRequest: 1, myrequests: 'received'}),
		//Sent Requests
		getOtherMessages('/profile/myrequests', {isAjaxRequest: 1, myrequests: 'sent'}),
		//Notification
		getOtherMessages('/profile/mynotifications', {isAjaxRequest: 1, mynotification: true})
	).then(
		function(){
			if(window.location.hash == "#requests") {
				$("a[data-table='reqrxd']").trigger('click');
			} else if(window.location.hash == '#notifications') {
				$("a[data-table='notify']").trigger('click');
			}else {
				$(".dataTables_wrapper").first().show();
			}
		}, 
		function() {
			Iansar.dialog.failure();
		}
	);

	//Tabs functionality
	$(".msgTabs").click(function(){
		var $thisref = $(this);

		//Highlight what is selected
		$(".messageControls ul li a.msgTabs.selected").removeClass('selected');
		$thisref.addClass('selected');

		clearMessageBox();//Remove messages and delete button in message display box
		//remove selection
		$thisref.parents("ul.myMessagesLinks").find("li.mmlSelected").removeClass("mmlSelected");
		
		//add selection if left tabs
		if($thisref.parents(".myMessagesLinks").length) {
			$thisref.parents("li").addClass('mmlSelected');
		}
		//get what to show
		var tableClass = $thisref.attr('data-table');
		
		//hide all tables and sub menus
		$(".messagesTable").hide();
		$(".dataTables_wrapper").hide();
		$(".toggleTabs").hide();

		//hide sub menu container in case of notify
		if(tableClass == "notify") {
			$('.messageControlButton.deleteButton').attr('data-req', 'msg');
			$(".messagesFilters").hide();
		} else {
			$(".messagesFilters").show();
			if(tableClass == "msgrxd") {
				$('.messageControlButton.deleteButton').attr('data-req', 'msg');
				$(".messageControls [data-table='msgrxd']").addClass('selected');
			} else if(tableClass == "reqrxd") {
				$('.messageControlButton.deleteButton').attr('data-req', 'req');
				$(".messageControls [data-table='reqrxd']").addClass('selected');
			}
		}

		//show appropriate table
		$("."+tableClass).show();
		$("."+tableClass).parents(".dataTables_wrapper").show();

		//showing the opened message
		$('.dataTables_wrapper:visible').find("tr.rowSelected").trigger('click');

		//select all checkbox handle
		if(!($("table:visible").data("datatable").fnGetData() || []).length) {
			$("#selectall").attr("disabled", "disabled");
		} else {
			$("#selectall").removeAttr("disabled");
		}
	});

	$('#selectall').on('change', function(){
		if($(this).is(':checked')){
			$(this).siblings('.selectAllText').html('Deselect All');
			$('.msgCheckBox', 'table:visible').attr('checked', true);
			deleteShowHide();
		} else{
			$(this).siblings('.selectAllText').html('Select All');
			$('.msgCheckBox', 'table:visible').attr('checked', false);
			deleteShowHide();
		}
	});

	$("#messageContainer").delegate('.msgCheckBox', 'change', function(e){
		e.stopPropagation();
		deleteShowHide();
		
		if($('.msgCheckBox').length == $('.msgCheckBox:checked').length || $('.msgCheckBox:checked').length > 1){
			$('.selectAllLabel').find('.selectAllText').html('Deselect All');
			$('.selectAllLabel').find('.selectAllCB').attr('checked', true);
		} else {
			$('.selectAllLabel').find('.selectAllText').html('Select All');
			$('.selectAllLabel').find('.selectAllCB').attr('checked', false);			
		}
	});

	function deleteShowHide(){
		if($('.msgCheckBox:checked').length > 0){
			$('.deleteButton').css('display','block');
		} else{
			$('.deleteButton').css('display','none');
		}
		
	}

	$("#messageContainer").delegate('tr.showDesc', 'click', function(event) {
		var thisref = $(this);
		thisref.parents("tbody").find("tr.rowSelected").removeClass('rowSelected');
		thisref.addClass('rowSelected');
		var msgId = $(this).find("input").attr("data-value");
		var msg_req = thisref.find("input").attr("data-req") || "msg";
		showMessage(thisref);
		if(thisref.hasClass("unread")) {
			var xhr = $.ajax({
				type: "POST",
				url: "/profile/msgstatus/"+<?php echo YII::app()->user->id; ?>,
				data: {isAjaxRequest:1, status: "READ", msgId: msgId, msg_req:msg_req}
			});
			xhr.done(function(data){
				if(data == "success") {
					thisref.removeClass("unread").addClass("read");
				} else {
					//Iansar.dialog.failure();
				}
			}).fail(function(data){
				//Iansar.dialog.failure();
			});
		}
	});

	$(".messageDisplayBox").delegate('.delete', 'click', function(event) {
		var thisref = $(this);
		var deleteVal = thisref.attr("data-value");
		var msg_req = thisref.attr("data-req") || "msg";
		thisref.removeClass('delete');
		var xhr = $.ajax({
			url: "/profile/deletemsg",
			data: { ids:deleteVal, isAjaxRequest: true, msg_req: msg_req },
			type: "POST"
		});
		xhr.done(function(response){
			if(response == 'success') {
				var oTable = $("table.messagesTable:visible").data("datatable");
				oTable.fnDeleteRow( $('input[data-value="'+deleteVal+'"]').parents('tr')[0] );
				clearMessageBox();
			} else {
				Iansar.dialog.failure();
			};
		}).fail(function(){
			Iansar.dialog.failure();
		}).always(function(){
			thisref.addClass('delete');
		});
	});

	$(".deleteButton").click(function(){
		var thisref = $(this);
		if(!$( "#dialog" ).length) {
			$( "body" ).append('<div id="dialog"></div>');
		}
		$( "#dialog" ).html("Are you sure you want to delete all messages?");
		$( "#dialog" ).dialog({
	      	modal: true,
	      	buttons: {
	        	Ok: function() {
	        		var checkedMsg = $('table:visible').find('input[type=checkbox]:checked');
					if(checkedMsg.length > 0) {
						var deleteMsg = [], msg_req = thisref.attr('data-req') || "msg";
						checkedMsg.each(function(){
							deleteMsg.push($(this).attr('data-value'));
							//msg_req = $(this).attr("data-req");
						});
						thisref.removeClass('deleteButton');
						var xhr = $.ajax({
							url: "/profile/deletemsg",
							data: { ids:deleteMsg.join(','), isAjaxRequest: true, msg_req: msg_req},
							type: "POST"
						});
						xhr.done(function(response){
							if(response == 'success') {
								var oTable = $('table:visible').data("datatable");
								$.each(deleteMsg, function(idx, val){
									var $tr = $('input[data-value="'+val+'"]').parents('tr');
									oTable.fnDeleteRow($tr[0]);
								});
								$("#selectall").attr('checked', false);
								if($('tbody tr', oTable).length < 1){
									$("#selectall").attr("disabled", 'disabled');
								}
								deleteShowHide();
							} else {
								Iansar.dialog.failure();
							};
						}).fail(function(){
							Iansar.dialog.failure();
						}).always(function(){
							thisref.addClass('deleteButton');
						});
					}
	          		$( this ).dialog( "close" );
	          		$( "#dialog" ).remove();
	        	},
	        	Cancel: function() {
	        		$( this ).dialog( "close" );
	          		$( "#dialog" ).remove();	
	        	}
	      	}
	    });
		
	});

	$(".messageDisplayBox").delegate('.rejectMadhoo', 'click', function(event) {
		var thisref = $(this);
		thisref.removeClass('rejectMadhoo');
		var id = thisref.attr("data-value");
		//rejected
		var xhr = $.ajax({
			url: "/madhoo/rejectRequest/"+id,
			data: { isAjaxRequest: true, status: 'no'},
			type: "POST"
		});
		xhr.done(function(response){
			if(response != 'failed') {
				Iansar.dialog.inform("Message", response);//showing dialog
				thisref.parents(".message-content").html(response);//updating msg container
				$("input[data-value='"+id+"']", '.dataTables_wrapper:visible').parents('tr.showDesc').find('.description').html(response);
			} else {
				Iansar.dialog.failure();
			};
		}).fail(function(){
			Iansar.dialog.failure();
		}).always(function(){
			thisref.addClass('rejectMadhoo');
		});
	});

	$(".messageDisplayBox").delegate('.approveMadhoo', 'click', function(event) {
		var thisref = $(this), responseObj;
		thisref.removeClass('approveMadhoo');
		var id = thisref.attr("data-value");
		var xhr = $.ajax({
			url: "/madhoo/approveRequest/"+id,
			data: { isAjaxRequest: true, status: 'yes'},
			type: "POST"
		});
		xhr.done(function(response){
			try {
				responseObj = JSON.parse(response);
			} catch(e) {
				console.log(response);
				responseObj = {"failed":"failed"}
			}
			if(responseObj.success) {
				Iansar.dialog.inform("Message!", "Request approved. Thank you");
				$(".message-content", '.messageDisplayBox').html("The request for the <strong>Madhoo</strong> has been <strong>approved</strong> by You");
				$("input[data-value='"+id+"']", '.dataTables_wrapper:visible').parents('tr.showDesc').find('.description').html("The request for the <strong>Madhoo</strong> has been <strong>approved</strong> by You");
			} else if(response["cant_do"]) {
				Iansar.dialog.inform("Messaage!", response["cant_do"]);
			} else if(response["cant_own"]) {
				Iansar.dialog.inform("Messaage!", response["cant_own"]);
				$(".message-content", '.messageDisplayBox').html("The requested Daee cannot hold any more madhoo. So the request is aborted.");
				$("input[data-value='"+id+"']", '.dataTables_wrapper:visible').parents('tr.showDesc').find('.description').html("The request for the <strong>Madhoo</strong> has been <strong>approved</strong> by You");
			} else if(response["app_already"]) {
				Iansar.dialog.inform("Messaage!", response["app_already"]);
			} else {
				Iansar.dialog.failure();
			};
		}).fail(function(){
			Iansar.dialog.failure();
		}).always(function(){
			thisref.addClass('approveMadhoo');
		});
	});
});
</script>