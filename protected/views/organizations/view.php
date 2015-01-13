<div>
	<h2>View Organization : <em><?php echo $model->name; ?></em></h2>
	<?php echo $links; ?>
</div>

<div class="dashBoard">
	<div class="dashBoardName leftDB">
		<div class="dbBoxContainer">
			<fieldset>
				<legend>Basic Information</legend>
				<table>
					<tr>
						<th class="dbLabel"><label>Name: </label></th>
						<td class="dbData"><span><?php echo $model->name; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Type: </label></th>
						<td class="dbData"><span><?php echo $model->type; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Address: </label></th>
						<td class="dbData"><span><?php echo $model->address; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Contact number: </label></th>
						<td class="dbData"><span><?php echo $model->contact_number; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>State: </label></th>
						<td class="dbData"><span><?php echo $model->state; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Country: </label></th>
						<td class="dbData"><span><?php echo $model->country; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Created by: </label></th>
						<td class="dbData"><span><?php echo $model->created_by ? $model->getName($model->created_by): ''; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Created on: </label></th>
						<td class="dbData"><span><?php echo date("d/m/Y", strtotime($model->created_at)); ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Updated on: </label></th>
						<td class="dbData"><span><?php echo date("d/m/Y", strtotime($model->updated_at)); ?></span></td>
					</tr>
				</table>
			</fieldset>
		</div>
	</div>
</div>
