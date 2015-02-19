
<div>
	<table>
		<tr>
			<td>Madhoo ID:</td><td><a href="<?php echo Yii::app()->getBaseUrl(true) ?>/madhoo/viewmadhoo/<?php echo $id ?>" title="Click here to view madhoo"><?php echo $id ?> - Click here to view this madhoo</a></td>
		</tr>
		<tr>
			<td>First Name:</td><td><?php echo $personalInfo["first_name"] ?></td>
		</tr>
		<tr>
			<td>Last Name:</td><td><?php echo $personalInfo["last_name"] ?></td>
		</tr>
		<tr>
			<td>Family Name:</td><td><?php echo $personalInfo["family_name"] ?></td>
		</tr>
		<tr>
			<td>Nick Name:</td><td><?php echo $personalInfo["nick_name"] ?></td>
		</tr>
		<tr>
			<td>Profession:</td><td><?php echo $personalInfo["profession"] ?></td>
		</tr>
		<tr>
			<td>House No:</td><td><?php echo $personalInfo["house_no"] ?></td>
		</tr>
		<tr>
			<td>Street:</td><td><?php echo $personalInfo["street"] ?></td>
		</tr>
		<tr>
			<td>Email Id:</td><td><?php echo $personalInfo["email_id"] ?></td>
		</tr>
		<tr>
			<td>Phone Number:</td><td><?php echo $personalInfo["phone_number"] ?></td>
		</tr>
		<?php if($personalInfo["social_network_ids_id"] && is_array($personalInfo["social_network_ids_id"]) && $personalInfo["social_network_ids_value"] && is_array($personalInfo["social_network_ids_value"])) { ?>
		<tr>
			<td>Socail Network Ids:</td><td></td>
		</tr>
		<?php foreach ($personalInfo["social_network_ids_id"] as $key => $value) { ?>
		<tr>
			<td><?php echo $personalInfo["social_network_ids_id"][$key]; ?></td>
			<td><?php echo $personalInfo["social_network_ids_value"][$key]; ?></td>
		</tr>
		<?php }
		}
		?>
		<?php if($personalInfo["messenger_ids_id"] && is_array($personalInfo["messenger_ids_id"]) && $personalInfo["messenger_ids_value"] && is_array($personalInfo["messenger_ids_value"])) { ?>
		<tr>
			<td>Messenger Ids:</td><td></td>
		</tr>
		<?php foreach ($personalInfo["messenger_ids_id"] as $key => $value) { ?>
		<tr>
			<td><?php echo $personalInfo["messenger_ids_id"][$key]; ?></td>
			<td><?php echo $personalInfo["messenger_ids_value"][$key]; ?></td>
		</tr>
		<?php }
		}
		?>
		<tr>
			<td>Gender : </td><td><?php echo $callees["gender"] ?></td>
		</tr>
		<tr>
			<td>Age : </td><td><?php echo $callees["age"] ?></td>
		</tr>
		<tr>
			<td>Area : </td><td><?php echo $callees["area"] ?></td>
		</tr>
		<tr>
			<td>City : </td><td><?php echo $callees["city"] ?></td>
		</tr>
		<tr>
			<td>State : </td><td><?php echo $callees["state"] ?></td>
		</tr>
		<tr>
			<td>Country : </td><td><?php echo $callees["country"] ?></td>
		</tr>
		<tr>
			<td>Zip : </td><td><?php echo $callees["zip"] ?></td>
		</tr>
		<tr>
			<td>Highest Qualification : </td><td><?php echo $callees["highest_qualification"] ?></td>
		</tr>
		<tr>
			<td>Language Read : </td><td><?php echo $callees["language_read"] ?></td>
		</tr>
		<tr>
			<td>Language Write : </td><td><?php echo $callees["language_write"] ?></td>
		</tr>
		<tr>
			<td>Language Speak : </td><td><?php echo $callees["language_speak"] ?></td>
		</tr>
		<tr>
			<td>Status : </td><td><?php echo $callees["status"] ?></td>
		</tr>
		<tr>
			<td>Religion : </td><td><?php echo $callees["religion"] ?></td>
		</tr>
		<tr>
			<td>Note : </td><td><?php echo $callees["note"] ?></td>
		</tr>
	</table>
</div>