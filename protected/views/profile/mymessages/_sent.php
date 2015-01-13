<!-- Requests sent -->
<table class="reqsnt requestsReceived messagesTable" cellpadding="0" cellspacing="0" style="display:none;">
	<?php if($requests && count($requests) > 0) { ?>
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
	<tr class="showDesc read">
		<td class="msgCB"><input data-req="req" data-value="<?php echo $model->id; ?>" type="checkbox" class="msgCheckBox" /></td>
		<td class="msgSender"><div class="fwb"><?php echo $this->getName($model->requested_by);?></div></td>
		<td class="msgSubject">
			<div>Madhoo Assignment Request</div>
			<div class="dNone description">
				<?php if($model->approved_ignored == Controller::$REQ_MGMT_APPROVED) { ?>
					The requested <strong>Madhoo <a target="_blank" href="/madhoo/viewmadhoo/<?php echo $model->callee_id ?>"><?php echo $this->getMadhooName($model->callee_id); ?></a></strong> has been <strong>assigned</strong> to you.
				<?php } else if($model->approved_ignored == Controller::$REQ_MGMT_IGNORED) { ?>
					The requested <strong>Madhoo <a target="_blank" href="/madhoo/viewmadhoo/<?php echo $model->callee_id ?>"><?php echo $this->getMadhooName($model->callee_id); ?></a></strong> is <strong>not assigned</strong> to you.
				<?php } else if($model->approved_ignored == Controller::$REQ_STATUS_CANT_OWN_CNT) { ?>
					The request to the <strong>Madhoo <a target="_blank" href="/madhoo/viewmadhoo/<?php echo $model->callee_id ?>"><?php echo $this->getMadhooName($model->callee_id); ?></a></strong> is <strong>aborted</strong> because you cannot hold anymore Madhoo.
					<br />If you want to take up the madhoo, unassign one of your madhoos and make the request again.
				<?php } else { ?>
					Your request to the <strong>Madhoo <a target="_blank" href="/madhoo/viewmadhoo/<?php echo $model->callee_id ?>"><?php echo $this->getMadhooName($model->callee_id); ?></a></strong> is <strong>pending</strong> still.
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