<!-- Messages Sent -->
<table class="msgsnt mymsgreqTable messagesTable" cellpadding="0" cellspacing="0" style="display:none;">
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
	<tr class="showDesc read">
		<td class="msgCB"><input data-value="<?php echo $model->id; ?>" type="checkbox" class="msgCheckBox" /></td>
		<td class="msgSender"><div class="fwb"><?php echo $this->getName($model->receiver_id);?></div></td>
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