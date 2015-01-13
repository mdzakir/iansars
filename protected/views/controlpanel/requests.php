<h1>Manage Requests</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'request-management-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		// 'id',
		array(
			'header' => 'Madhoo',
			'name' => 'callee_id',
			'type' => 'raw',
			'value'=>function($data) {
				return '<a target="_blank" href="/madhoo/viewmadhoo/'.$data->callee_id.'">'.YII::app()->controller->getMadhooName($data->callee_id).'</a>';
			}
		),
		array(
			'header' => 'Created By',
			'name' => 'caller_id',
			'type' => 'raw',
			'value'=>function($data) {
				return '<a target="_blank" href="/daee/'.$data->caller_id.'">'.YII::app()->controller->getName($data->caller_id).'</a>';
			}
		),
		array(
			'header' => 'Owned By',
			'name' => 'owner_id',
			'type' => 'raw',
			'value'=>function($data) {
				if($data->owner_id) {
					return '<a target="_blank" href="/daee/'.$data->owner_id.'">'.YII::app()->controller->getName($data->owner_id).'</a>';
				} else {
					return "";
				}
			}
		),
		array(
			'header' => 'Requested By',
			'name' => 'requested_by',
			'type' => 'raw',
			'value'=>function($data) {
				return '<a target="_blank" href="/daee/'.$data->requested_by.'">'.YII::app()->controller->getName($data->requested_by).'</a>';
			}
		),
		array(
			'header' => 'Responded By',
			'name' => 'responded_by',
			'type' => 'raw',
			'value'=>function($data) {
				if($data->responded_by) {
					return '<a target="_blank" href="/daee/'.$data->responded_by.'">'.YII::app()->controller->getName($data->responded_by).'</a>';
				} else {
					return '';
				}
			}
		),
		array(
			'header' => 'Approved/Ignored',
			'name' => 'approved_ignored',
			'value'=>function($data) {
				return strtolower($data->approved_ignored);
			}
		),
		array(
			'header' => 'Created Date',
			'name' => 'created_at',
			'value'=>function($data) {
				return date("d-m-Y H:i:s", strtotime($data->created_at));
			}
		),
		array(
			'header' => 'Updated Date',
			'name' => 'updated_at',
			'value'=>function($data) {
				return date("d-m-Y H:i:s", strtotime($data->updated_at));
			}
		),
		array(
			'header'=>'Action',
			'class'=>'CButtonColumn',
		    'template'=>'{approve}{reject}',
		    'buttons'=>array(
	    		'approve' => array (
    				'label'=>'Approve',
    				'url'=>'"javascript:void(0)"',
    				'options'=>array("class"=>"approve-req reqappign"),
    				'visible'=>'$data->approved_ignored==null'
	    		),
		        'reject' => array (
		            'label'=>'Ignore',
    				'url'=>'"javascript:void(0)"',
    				'options'=>array("class"=>"ignore-req reqappign"),
    				'visible'=>'$data->approved_ignored==null'
		        ),
		    )
		)
	),
)); ?>

<script type="text/javascript">
jQuery(document).ready(function($) {
	var Requests = {};
	Requests.getID = function($this){
		var ID = $this.parents('.grid-view').prop('id');
		var row = $this.parents('tr').prevAll('tr').length;
		return $('#'+ID).children('.keys').children('span').eq(row).text();
	};
	$('.fullWidthLayout').delegate('.reqappign', 'click', function(event) {
		var $thisref = $(this);
		var approveignore = $thisref.hasClass('approve-req') ? "<?php echo Controller::$REQ_MGMT_APPROVED; ?>" : "<?php echo Controller::$REQ_MGMT_IGNORED; ?>"
		var id = Requests.getID($(this));
		$('<div id="dialog" />').appendTo('body');
		$('#dialog').html("Are you sure about your action?");
		$("#dialog").dialog({
			title: approveignore == "APPROVED" ? 'Approve Request!' : 'Ignore Request!',
			modal: true,
			resizable: false,
			buttons: [
				{ 	
					text: 'Yes!',
					click: function() {
						var xhr = $.ajax({
							url: '/controlpanel/approveignore/'+id,
							type: 'POST',
							data: { "isAjaxRequest": true, "approved_ignored": approveignore }
						})
						xhr.done(function(data) {
							if(data) {
								var dataRes = JSON.parse(data);
								if(dataRes.success) {
									$.fn.yiiGridView.update('request-management-grid');
									Iansar.dialog.inform("Successfully "+approveignore.toLowerCase(), "Success");
								} else if(dataRes.failed) {
									Iansar.dialog.failure();
								} else if(dataRes.cant_own) {
									Iansar.dialog.inform(dataRes.cant_own, "Limit Exceeded");
								}
							}
						}).fail(function() {
							Iansar.dialog.failure();
						});
				        $( this ).dialog( "close" );$( "#dialog" ).remove();
					}
				},
				{ 	text: 'Cancel', 
					click: function() { 
						$( this ).dialog( "close" );$( "#dialog" ).remove(); 
					} 
				}
			]
		});
	});
});
</script>