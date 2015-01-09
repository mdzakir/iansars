<!-- Notifications -->
<table class="notify notifications messagesTable" cellpadding="0" cellspacing="0" style="display:none;">
	<?php if($messages && count($messages) > 0) { ?>
	<thead>
		<tr>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($messages as $mod => $model) { ?>
		<tr class="showDesc <?php echo ($model->receiver_status == "READ") ? "read" : "unread"; ?>">
			<td class="msgCB"><input data-req="msg" data-value="<?php echo $model->id; ?>" type="checkbox" class="msgCheckBox" /></td>
			<td class="msgSender"><div class="fwb"><?php echo $this->getName($model->sender_id);?></div></td>
			<td class="msgSubject">
				<div><?php echo $model->title; ?></div>
				<div class="dNone description"><?php echo $this->parseMessages($model->description); ?></div>
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