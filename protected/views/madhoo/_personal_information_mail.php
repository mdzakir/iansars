<div>
	<table>
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
		<?php if($personalInfo["social_network_ids_id"] && is_array($personalInfo["social_network_ids_id"]) && $personalInfo["social_network_ids_value"] && is_array($personalInfo["social_network_ids_value"]) { ?>
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
	</table>
</div>
