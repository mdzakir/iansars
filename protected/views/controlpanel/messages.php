
<h1>Manage Admin Messages</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'admin-messages-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        array(
			'name' => 'sender_id',
			'type' => 'raw',
			'value'=>function($data) {
				return '<a target="_blank" href="/daee/'.$data->sender_id.'">'.YII::app()->controller->getName($data->sender_id).'</a>';
			}
		),
        //'type',
        //'status',
        array(
			'name' => 'target_caller_id',
			'type' => 'raw',
			'value'=>function($data) {
				return '<a target="_blank" href="/daee/'.$data->target_caller_id.'">'.YII::app()->controller->getName($data->target_caller_id).'</a>';
			}
		),
        //'title',
        'message',
        //'read_by',
        array(
			'header' => 'Created Date',
			'name' => 'created_at',
			'value'=>function($data) {
				return date("d-m-Y H:i:s", strtotime($data->created_at));
			}
		),
        /*'updated_at',
        */
        array(
            'header'=>'Action',
			'class'=>'CButtonColumn',
		    'template'=>'YII::app()->controller->isSuperAdmin()'?'{remove}' : '',
		    'buttons'=>array(
	    		'remove' => array (
    				'label'=>'Delete',
    				'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',
		        	'options'=>array("class"=>"deleteMsg"),
	    		)
	    	)
        ),
    ),
)); ?>
<script type="text/javascript">
<?php if(YII::app()->controller->isSuperAdmin()) { ?>
$(document).ready(function() {
	var Messages = {};
	Messages.getID = function($this){
		var ID = $this.parents('.grid-view').prop('id');
		var row = $this.parents('tr').prevAll('tr').length;
		return $('#'+ID).children('.keys').children('span').eq(row).text();
	};
	$('.fullWidthLayout').delegate('.deleteMsg', 'click', function(event) {
		var id = Messages.getID($(this));
		var xhr = $.ajax({
			url: '/controlpanel/deletespam/'+id,
			type: 'POST',
		})
		xhr.done(function(data) {
			if(data == "success") {
				$.fn.yiiGridView.update('admin-messages-grid');
			} else {
				Iansar.dialog.failure();
			}
		})
		.fail(function() {
			Iansar.dialog.failure();
		});
	});
});
<?php } ?>
</script>