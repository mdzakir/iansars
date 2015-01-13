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
		<?php if($personalInfo["social_network_ids"] && is_array($personalInfo["social_network_ids"]) && $personalInfo["social_network_ids"][0]["social_network_value"]) { ?>
		<tr>
			<td>Socail Network Ids:</td><td></td>
		</tr>
		<?php foreach ($personalInfo["social_network_ids"] as $key => $value) { ?>
		<tr>
			<td><?php echo $personalInfo["social_network_ids"][$key]["social_network_id"]; ?></td>
			<td><?php echo $personalInfo["social_network_ids"][$key]["social_network_value"]; ?></td>
		</tr>
		<?php }
		}
		?>
		<?php if($personalInfo["messenger_ids"] && is_array($personalInfo["messenger_ids"]) && $personalInfo["messenger_ids"][0]["messenger_value"]) { ?>
		<tr>
			<td>Messenger Ids:</td><td></td>
		</tr>
		<?php foreach ($personalInfo["messenger_ids"] as $key => $value) { ?>
		<tr>
			<td><?php echo $personalInfo["messenger_ids"][$key]["messenger_id"]; ?></td>
			<td><?php echo $personalInfo["messenger_ids"][$key]["messenger_value"]; ?></td>
		</tr>
		<?php }
		}
		?>
	</table>
</div>