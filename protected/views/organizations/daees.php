<h1>Organizations & Da'ee</h1>
<div><?php echo $links; ?></div>
<div class="clear"></div>
<div id="daee_org_assoc" style="width: 65%;">
	<?php if($orgs_callers != null) {?>
	<?php foreach ($orgs_callers as $orgIds => $callerDetails) { ?>
		<h4>
			<a href="/organizations/<?php echo $orgIds; ?>"><?php echo $callerDetails['type'].' : '.$callerDetails['name']; ?></a>
		</h4>
		<?php foreach ($callerDetails as $key => $caller) { 
			if($key !== 'name' && $key !== 'type') {
			?>
			<div>
				<a href="/daee/<?php echo $caller->id; ?>"><?php echo $caller->name; ?></a>
			</div>
		<?php }
		} ?>
	<?php } } ?>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$("#daee_org_assoc").accordion({active:false, collapsible: true});	
});
</script>