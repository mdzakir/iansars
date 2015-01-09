<?php
/* @var $this ProfileController */
/* @var $model CallersProfile */
?>
<!-- <h1>View Profile</h1>  -->

<div class="dashBoard">
	<div class="dashBoardName leftDB">
		<div class="dbBoxContainer">
			<fieldset>
				<legend>Basic Information</legend>
				<table>
					<tr>
						<th class="dbLabel"><label>First Name: </label></th>
						<td class="dbData"><span><?php echo $model->first_name; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Last Name: </label></th>
						<td class="dbData"><span><?php echo $model->last_name; ?></span></td>
						<!-- <td><img src="<?php echo '../uploads/'.$model->profile_pic; ?>"/></td> -->
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Family Name: </label></th>
						<td class="dbData"><span><?php echo $model->family_name; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Nick Name: </label></th>
						<td class="dbData"><span><?php echo $model->nick_name; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Gender: </label></th>
						<td class="dbData"><span class="capiCase"><?php echo $model->gender; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Date of Birth: </label></th>
						<td class="dbData capiCase"><span><?php echo date('d-m-Y', strtotime($model->date_of_birth)); ?></span>
							<?php /* echo array(
								'name'=>'date_of_birth',
								'value'=>date('d-m-Y',strtotime($model->date_of_birth))
							); */ ?> 
						</td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Languages Known: </label></th>
						<?php $language = $model->languages_known ? json_decode($model->languages_known, true) : array(); ?>
						<td class="dbData capiCase">
							<span>
								<?php if(count($language) > 0) {
										foreach($language as $key => $lang) { 
											echo $lang; 
											echo ($key != count($language)-1) ? ' , ':''; 
										}
									}
								?>
							</span>
						</td>
					</tr>
				</table>
			</fieldset>
		</div>
		
		<div class="dbBoxContainer mt10i">
			<fieldset>
				<legend>Mailing Address</legend>
				<table>
					<tr>
						<th class="dbLabel"><label>Address: </label></th>
						<td class="dbData"><span><?php echo $model->house_no.', '.$model->street.', '.$model->area; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>City: </label></th>
						<td class="dbData"><span><?php echo $model->city; ?></span></td>
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
						<th class="dbLabel"><label>Postal Code: </label></th>
						<td class="dbData"><span><?php echo $model->zip; ?></span></td>
					</tr>				
				</table>
			</fieldset>
		</div>
		
	</div>
	<div class="dashBoardName rightDB">
		
		<div class="dbBoxContainer mt7i">
			<fieldset>
				<table>
					<tr>
						<th class="dbLabel"><label>Profile Photo: </label></th>
						<td class="dbData">
							<div class="profilePicWrapper">
								<div class="profilePicHolder">
									<img class="profileImage" src="<?php echo $this->createUrl('/site/viewimages'); ?>" />
								</div>
							</div>
							<span><?php /* echo $model->profile_pic; */ ?></span>
						</td>
					</tr>
				</table>
			</fieldset>
		</div>
		
		<div class="dbBoxContainer mt10i">
			<fieldset>
				<legend>Contact Details</legend>
				<table>
					<tr>
						<th class="dbLabel"><label>Primary Phone: </label></th>
						<td class="dbData"><span><?php echo $model->primary_phone; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Secondary Phone: </label></th>
						<td class="dbData"><span><?php echo $model->secondary_phone; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Email: </label></th>
						<td class="dbData"><span><?php echo $model->email_id; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Social Network ID: </label></th>
						<?php  $socialNetwork = $model->social_network_id ? json_decode($model->social_network_id,true) : array();  ?>
						<td class="dbData">
							<span>
								<?php if(count($socialNetwork) > 0) { 
										$i=1; 
										foreach($socialNetwork as $key => $sn) { 
											echo $key ? $key .' : '. $sn : ''; 
											echo $i != count($socialNetwork) ? ' , ':''; 
											$i++; 
										} 
									}
								?>
							</span>
						</td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Messenger ID: </label></th>
						<?php  $messenger = $model->messenger_id ? json_decode($model->messenger_id,true) : array();  ?>
						<td class="dbData">
							<span>
								<?php if(count($messenger) > 0) {
										$i=1; 
										foreach($messenger as $key => $mess) { 
											echo $key ? $key .' : '. $mess : ''; 
											echo $i != count($messenger) ? ' , ':''; 
											$i++; 
										}
									} 
								?>
							</span>
						</td>
					</tr>				
				</table>
			</fieldset>
		</div>
		
		<div class="dbBoxContainer mt10i">
			<fieldset>
				<legend>Education &amp; Profession</legend>
				<table>
					<tr>
						<th class="dbLabel"><label>Highest Education: </label></th>
						<td class="dbData"><span><?php echo $model->highest_education; ?></span></td>
					</tr>
					<tr class="separatorDB"><td colspan="2"><hr></td></tr>
					<tr>
						<th class="dbLabel"><label>Profession: </label></th>
						<td class="dbData"><span><?php echo $model->profession; ?></span></td>
					</tr>
				</table>
			</fieldset>
		</div>
		
	</div>
	<div>
		<a href="<?php echo $this->createUrl('/madhoo/mymadhoo');?>">My Madhoo</a>
		<a href="<?php echo $this->createUrl('/madhoo/addmadhoo');?>">Add Madhoo</a>
	</div>
</div>

<?php /*
	$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'first_name',
		'last_name',
		'family_name',
		'nick_name',
		'gender',
		array(
			'name'=>'date_of_birth',
			'value'=>date('d-m-Y',strtotime($model->date_of_birth))
		),
		'email_id',
		'social_network_id',
		'messenger_id',
		'house_no',
		'street',
		'area',
		'city',
		'state',
		'country',
		'zip',
		'primary_phone',
		'secondary_phone',
		'highest_education',
		'profession',
		'type_of_user',
		'profile_pic',
		'languages_known',
	),
)); */

?>
