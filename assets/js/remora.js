jQuery(function($) {
	$( document ).ready(function() {
		// Add all styles into iframes
		$("link[type='text/css']").clone().appendTo($("iframe#remora").contents().find("head"));
		console.debug($("iframe#remora").contents().find("head"));
		$('iframe#remora').load(function() { 
			var iFrameID = document.getElementById('remora');
			if(iFrameID) {
				iFrameID.height = "";
				iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
			}
		});
	});
	
});

