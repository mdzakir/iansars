<div>
	<h1>Update Organizations <em><?php echo $model->name; ?></em></h1>
	<div class="org_links right">
		<a href="/organizations/create" class="grayButtons">Create Organizations</a>
		<a href="/organizations" class="grayButtons">Organizations list</a>
		<a href="/organizations" class="grayButtons">Organizations & D'aee List</a>
	</div>
</div>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>