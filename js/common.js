/* Common JS for Iansar */
$(function(){
	window.Iansar = window.Iansar || {};
	window.Iansar.dialog = window.Iansar.dialog || {};
	window.Iansar.madhooListCnt = 1;
	
	function format(state) {
		var originalElem = state.element;
		var str = '<div class="madhoo-names">'+state.text+'</div>';
		if(state.id == "") {
			return str;
		}
		if($(originalElem).data('owned_by') == $(originalElem).data('logged_in')) {
			str += '<div class="assigned-tag">Assigned</div>';
		} else {
			str += '<div class="created-tag">Created</div>';
		}
	    return str;
	}
	if($('.madhoolistmenu').length) {
		$('.madhoolistmenu').show();
		$('.madhoolistmenu').select2({ formatResult: format});
		$(".madhoolistmenu").on("change", function(e) { window.location.href = "/madhoo/viewmadhoo/"+e.val; });
	}

	$(document).ajaxStart(function() {
		Iansar.loader();
	});
	$(document).ajaxComplete(function() {
		Iansar.loader("hide");
	});

	//Dialog please wait.
	Iansar.dialog.wait = function () {
		if($('#dialog').length > 0) {
			$('#dialog').remove();
		}
		$('<div id="dialog" />').appendTo('body');
		$('#dialog').html('<div class="wait_pls">Please wait ...</div>');
		$("#dialog").dialog({
			title: 'Please wait..',
			modal: true,
			resizable: false,
			buttons: {
		        Ok: function() {
	          		$( this ).dialog( "close" );
	          		$( "#dialog" ).remove();
		    	}
		    }
		});
	};

	Iansar.loader = function(action) {
		action = action || "show";
		var loaderSelector = "loading";
		if(!$("#"+loaderSelector).length) {
			$('body').prepend("<div id='"+loaderSelector+"'>Loading</div>");
		}
		if(action == "show") {
			$('#'+loaderSelector).fadeIn('fast');
			//$('#overlay_loader').fadeIn('fast');
		} else {
			$('#'+loaderSelector).fadeOut('fast');
			//$('#overlay_loader').fadeOut('fast');
		}
		//Fade out if loader shows more than 1 min
		setTimeout(function(){
			$('#'+loaderSelector).fadeOut('fast');
			//$('#overlay_loader').fadeOut('fast');	
		}, 1000*60);
	};

	//Dialog ajax failure.
	Iansar.dialog.failure = function () {
		if($("#dialog").length > 0) {
			$("#dialog").remove();
		}
		$('<div id="dialog" />').appendTo('body');
		$("#dialog").html('<div class="something_wend_wrong">Something went wrong. Will be fixed soon</div>');
		$("#dialog").dialog({
			title: 'Error!',
			modal: true,
			resizable: false,
			buttons: {
		        Ok: function() {
	          		$( this ).dialog( "close" );
	          		$( "#dialog" ).remove();
		    	}
		    }
		});
	};
	
	//Dialog information.
	Iansar.dialog.inform = function (title, msg) {
		if($('#dialog').length > 0) {
			$('#dialog').remove();
		}
		$('<div id="dialog" />').appendTo('body');
		$('#dialog').html('<div class="dialog_information">'+msg+'</div>');
		$("#dialog").dialog({
			title: title,
			modal: true,
			resizable: false, 
			buttons: {
		        Ok: function() {
	          		$( this ).dialog( "close" );
	          		$( "#dialog" ).remove();
		    	}
		    }
		});
	};
	
	(function() {

		var incbrsr = '<style>img{border:0;} li{cursor: pointer;float: left;width: 120px;height: 122px;margin: 0 10px 10px 10px;padding: 0;text-align: center;}</style><div style="padding:20px;overflow:hidden;margin:10% auto; width:800px;border:1px solid #ccc;background-color:#f6f6f6;"><div class="list">'
		+'<h3 style="text-align:center">Your browser is old. Please switch to any of the below listed browsers</h3><ul style="list-style: none;">'
		+'<li style="display: inline;"><a href="https://www.google.com/intl/en/chrome/browser/" data-bypass = "true" target = "_blank"><img src="images/chrome.png" alt="Chrome" /><br>Google Chrome</a></li>'
		+'<li style="display: inline;"><a href = "http://www.mozilla.org/en-US/firefox/new/" data-bypass = "true" target = "_blank"><img src="images/ff.png" alt="Mozilla Firefox" /><br>Mozilla Firefox</a></li>'
	    +'<li style="display: inline;"><a href = "http://www.apple.com/in/safari/" data-bypass="true" target = "_blank"><img src="images/safari.png" alt="Safari" /><br>Safari</a></li>'
	    +'<li style="display: inline;"><a href = "http://www.opera.com/" data-bypass = "true" target = "_blank"><img src="images/opera.png" alt="Opera" /><br>Opera</a></li>'
	    +'<li style="display: inline;"><a href = "http://windows.microsoft.com/en-us/internet-explorer/download-ie" data-bypass = "true" target = "_blank"><img src="images/ie.png" alt="IE" /><br>Internet Explorer</a></li>'
		+'</ul>'
		+'</div></div>';
		
		if( !document.addEventListener ) {
			$('body').html('');
			$('body').append(incbrsr);
	        //Iansar.dialog.inform("Incompatible Browser", "Please use a modern browser. Many interesting features are not supported by the version of the browser you are using.");
	    }
	})();
});