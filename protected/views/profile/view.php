<?php
/* @var $this ProfileController */
/* @var $model CallersProfile */
?>
<!-- <h1>View Profile</h1>  -->

<div class="daeeHome">
	<div class="daeeDashBoardItems">
		<ul class="dbList">
			<li class="dbListItem"><a href="<?php echo $this->createUrl('/profile/profileview');?>"><span class="icon-user" ></span><span class="icontext">My Profile</span></a></li>
			<!-- <li class="dbListItem"><a href="<?php echo $this->createUrl('/madhoo/mymadhoo');?>"><span class="icon-users" ></span><span class="icontext">My Madoos</span></a></li> -->
			<li class="dbListItem"><a href="<?php echo $this->createUrl('/madhoo/madhoos');?>"><span class="icon-users-2" ></span><span class="icontext">Madhoos List</span></a></li>
			<li class="dbListItem"><a href="<?php echo $this->createUrl('/daee/daees');?>"><span class="icon-group" ></span><span class="icontext">Da'ees List</span></a></li>
			<li class="dbListItem"><a href="<?php echo $this->createUrl('/madhoo/addmadhoo');?>"><span class="icon-user-add" ></span><span class="icontext">Create a Madoo</span></a></li>
		</ul>
	</div>
</div>
<div class="clear"></div>
<div class="inboxandMadhoos">
	<div class="inboxGist">
		<div class="madhoosGistWrap">
			<div class="headingGradient"><h4>Inbox Gist</h4></div>
			<div class="sectionContent inboxSection">
				<?php if(($model && count($model) > 0) || ($requests && count($requests) > 0)) { ?>
				<div class="inboxContainer">
					<table>
						<thead>
							<tr>
								<th class="col1">Sender</th>
								<th class="col2">Message</th>
								<th class="col3">Date</th>
							</tr>
						</thead>
						<tbody>
							<?php if($model) { ?>
								<?php foreach ($model as $key => $value) { ?>
									<tr>
										<td class="col1"><?php echo $this->getName($value->sender_id); ?></td>
										<?php if($value->type == Controller::$MSG_TYPE_MESSAGE) { ?>
										<td class="col2"><a href="/profile/mymessages"><?php echo $value->title; ?></a></td>
										<?php } else { ?>
										<td class="col2"><a href="/profile/mymessages#notifications"><?php echo $value->title; ?></a></td>
										<?php } ?>
										<td class="col3"><?php echo date('d/M/Y', strtotime($value->created_at)); ?></td>
									</tr>	
								<?php } ?>
							<?php } ?>
							<?php if($requests) { ?>
								<?php foreach ($requests as $key => $value) { ?>
									<tr>
										<td class="col1"><?php echo $this->getName($value->requested_by); ?></td>
										<td class="col2"><a href="/profile/mymessages#requests"><?php echo "Request for the madhoo <strong>".$this->getMadhooName($value->callee_id)."</strong>"; ?></a></td>
										<td class="col3"><?php echo date('d/M/Y', strtotime($value->created_at)); ?></td>
									</tr>	
								<?php }?>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<?php } else { ?>
				<div class="tac dNone">No messages</div>
				<?php } ?>
			</div>
		</div>
	</div>
	
	<div class="madhoosGist">
		<div class="madhoosGistWrap">
			<div class="headingGradient"><h4>Madhoos Gist</h4></div>
			<div class="sectionContent madhoosSection">
				<?php if($madhoos && count($madhoos) > 0) { ?>
					<a href="javascript:void(0);" data-filter="all" class="all selected madhoo-list-button">All Madhoos (<?php echo $madhooCount; ?>)</a>
					<a href="javascript:void(0);" data-filter="unassinged" class="unasigned madhoo-list-button">Unassigned Madhoos (<?php echo $unassignedMadhooCount; ?>)</a>
					<a href="javascript:void(0);" data-filter="assigned" class="assinged madhoo-list-button">Assigned Madhoos (<?php echo $assignedMadhooCount; ?>)</a>
					<ul class="madhoo-list">
						<?php foreach ($madhoos as $idx => $madhoo) { ?>
							<li data-type="<?php echo $madhoo->owned_by ? 'assigned' : 'unassinged'; ?>">
								<a href="/madhoo/viewmadhoo/<?php echo $madhoo->id; ?>">
									<?php echo $madhoo->id.' : '.$madhoo->city.', (Can speak: '.$madhoo->language_speak.')'; ?>
								</a>
							</li>
						<?php } ?>
					</ul>
				<?php } else { ?>
					<div class="tac">No madhoos</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$('ul.madhoo-list').scroll(function() {
	  	var div = $(this);
	  	var total = <?php echo $madhooCount ? $madhooCount : 0; ?>;
	  	if (div[0].scrollHeight - div.scrollTop() == Math.round(div.height()) 
	  			|| ((div[0].scrollHeight - div.scrollTop()) - Math.round(div.height()) >= -2 
	  			&& (div[0].scrollHeight - div.scrollTop()) - Math.round(div.height()) <= 2 )) {
	  		if ((Iansar.madhooListCnt*30)+1 > total){
	            return false;
	        }else{
	            Iansar.getMadhooList();
	        }  
	        Iansar.madhooListCnt++;  
	  	}
	});

	Iansar.getMadhooList = function(){
		var xhr = $.ajax({  
			url: "/profile/getMadhooList",  
			type:'GET',
			data: {'offset':Iansar.madhooListCnt}
		});
		xhr.done(function(data){
			$('ul.madhoo-list').append(data);
		}).fail(function(data, error){
			Iansar.dialog.failure();
		});
	}

	$('a.madhoo-list-button').click(function(evt){
		$(this).addClass("selected").siblings('a.madhoo-list-button').removeClass("selected");
		var filter = $(evt.target).attr('data-filter');
		if($('ul.madhoo-list').length > 0) {
			$('ul.madhoo-list li').hide();
			if(filter != 'all') {
				$('ul.madhoo-list li[data-type="'+filter+'"]').show();
			} else {
				$('ul.madhoo-list li').show();
			}	
		}
		
	});
});
</script>
