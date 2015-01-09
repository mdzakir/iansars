<!-- Requests received -->
<table class="reqrxd req4meTable messagesTable" cellpadding="0" cellspacing="0" style="display:none;">
	<?php if($requests && count($requests)) { ?>
	<thead>
		<tr>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($requests as $mod => $model) { ?>
	<tr class="showDesc <?php echo ($model->status == "READ") ? "read" : "unread"; ?>">
		<td class="msgCB"><input data-req="req" data-value="<?php echo $model->id; ?>" type="checkbox" class="msgCheckBox" /></td>
		<td class="msgSender"><div class="fwb"><?php echo $this->getName($model->requested_by);?></div></td>
		<td class="msgSubject">
			<div>Madhoo Assignment Request</div>
			<div class="dNone description button-column">
				<?php if($model->approved_ignored == Controller::$REQ_MGMT_APPROVED) { ?>
					The request for the <strong>Madhoo <a target="_blank" href="/madhoo/viewmadhoo/<?php echo $model->callee_id ?>"><?php echo $this->getMadhooName($model->callee_id); ?></a></strong> 
					has been <strong>approved</strong> by 
					<?php if($model->responded_by == YII::app()->user->id) { ?>
						You
					<?php } else { ?>
						<strong><a target="_blank" href="/daee/<?php echo $model->responded_by ?>"><?php echo $this->getName($model->responded_by); ?></a></strong>
					<?php } ?>
				<?php } else if($model->approved_ignored == Controller::$REQ_MGMT_IGNORED) { ?>
					The request for the <strong>Madhoo <a target="_blank" href="/madhoo/viewmadhoo/<?php echo $model->callee_id ?>"><?php echo $this->getMadhooName($model->callee_id); ?></a></strong> 
					has been <strong>ignored</strong> by 
					<?php if($model->responded_by == YII::app()->user->id) { ?>
						You
					<?php } else { ?>
						<strong><a target="_blank" href="/daee/<?php echo $model->responded_by ?>"><?php echo $this->getName($model->responded_by); ?></a></strong>
					<?php } ?>
				<?php } else if($model->approved_ignored == Controller::$REQ_STATUS_CANT_OWN_CNT) { ?>
					The request to the <strong>Madhoo <a target="_blank" href="/madhoo/viewmadhoo/<?php echo $model->callee_id ?>"><?php echo $this->getMadhooName($model->callee_id); ?></a></strong> is <strong>aborted</strong> because the requested Daee cannot hold anymore Madhoo.
				<?php } else { ?>
					I am interested in the <strong>Madhoo <a target="_blank" href="/madhoo/viewmadhoo/<?php echo $model->callee_id ?>"><?php echo $this->getMadhooName($model->callee_id); ?></a></strong>
					<br />
					Please assign the madhoo to me.
					<br />
					<br />
					<a class="fwb approveMadhoo" href="javascript:void(0)" data-act="approve" data-value="<?php echo $model->id ?>">Approve</a>
					<br />
					<br />
					<a class="fwb rejectMadhoo" href="javascript:void(0)" data-act="reject" data-value="<?php echo $model->id ?>">Ignore</a>
				<?php } ?>
			</div>
		</td>
		<td class="msgActions">
			<?php echo date("d/M/Y", strtotime($model->created_at)); ?>
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