<div>
	<h1>Manage Organizations</h1>
	<?php echo $links; ?>
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'organizations-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'name',
		'type',
		'address',
		'state',
		'country',
		'contact_number',
		array(
			'header' => 'Created By',
			'value' => function($data) {
				return $data->created_by ? $data->getName($data->created_by): '';
			},
			'sortable'=>TRUE,
			'name'=> 'created_by'
		),
		array(
			'header'=>'Is Deleted',
			'value'=> function($data) {
				return $data->is_deleted == 1 ? "yes" : "no";
			},
			"visible"=>'YII::app()->user->getState("role") == "super_admin"'
		),
		array(
			'header'=>'Deleted By',
			'value'=> function($data) {
				return $data->deleted_by ? $data->getName($data->deleted_by) : "";
			},
			"visible"=>'YII::app()->user->getState("role") == "super_admin"'
		),
		array(
			'header' => 'Created At',
			'value' => function($data) {
				return date('d/m/Y', strtotime($data->created_at));
			}
		),
		array(
			'header' => 'Updated At',
			'value' => function($data) {
				return date('d/m/Y', strtotime($data->updated_at));
			}
		),
		array(
			'header'=>'Action',
			'class'=>'CButtonColumn',
		    'template'=>'{view}{update}{softdelete}{harddelete}',
		    'buttons'=>array(
	    		'view' => array(
    				'label'=>'View',
    				'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png'
	    		),
	    		'update' => array(
    				'label'=>'Edit',
    				'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png'
	    		),
	    		'softdelete' => array(
    				'label'=>'Delete',
    				'url'=>'Yii::app()->createUrl("/organizations/softdelete", array("id"=>$data["id"]))',
    				'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',
    				'options' => array('class'=>"softdelete")
	    		),
	    		'harddelete' => array(
    				'label'=>'Hard Delete',
    				'url'=>'Yii::app()->createUrl("/organizations/harddelete", array("id"=>$data["id"]))',
		        	'visible'=>'Yii::app()->user->getState("role") == "super_admin"',
					'options' => array('class'=>"harddelete")
	    		)
			)
		)
	),
)); ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$("#organizations-grid").delegate('.softdelete', 'click', function(event) {
		event.preventDefault();
		var id = $(event.currentTarget).attr("href").split("/")[3];
		$.ajax({
			url: '/organizations/softdelete/'+id,
			type: 'POST'
		})
		.done(function(response) {
			if(response == 'success') {
				$.fn.yiiGridView.update('organizations-grid');	
			} else {
				Iansar.dialog.failure();
			}
		})
		.fail(function() {
			Iansar.dialog.failure();
		});
	});
	$("#organizations-grid").delegate('.harddelete', 'click', function(event) {
		event.preventDefault();
		var id = $(event.currentTarget).attr("href").split("/")[3];
		$.ajax({
			url: '/organizations/delete/'+id,
			type: 'POST'
		})
		.done(function(response) {
			if(response == 'success') {
				$.fn.yiiGridView.update('organizations-grid');	
			} else {
				Iansar.dialog.failure();
			}
		})
		.fail(function() {
			Iansar.dialog.failure();
		});
	});
});
</script>