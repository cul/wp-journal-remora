jQuery(document).ready(function($){
	responsive_sidebar();

	$(window).resize(function(){
		responsive_sidebar();
	});

	function responsive_sidebar(){
		node_id = 'secondary';
		nav_id = 'nav-main';
		min_width = 768;
		
		// If it's smaller than the min_width send it to the navbar, otherwise send it back.
		if($(window).width() <= min_width) {
			console.debug('Moving '+node_id+' to '+nav_id+' because window width '+$(window).width()+' is less than '+min_width);
			
			// Create the collapse button if necessary
			if($('#collapse-'+node_id).length == 0) {
				var btn_collapse = '<button id="collapse-'+node_id+'" type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-'+node_id+'"><span class="sr-only">Toggle asides</span><i class="icon-th-large"></i>?</button><a class="btn" href="#"><i class="icon-align-left"></i></a>';
				$(btn_collapse).appendTo('#'+nav_id+' .navbar-header');
				collapseBtnExists = true;
			}
			
			// Move the stuff to the place
			if($('#'+nav_id+' #'+node_id).length == 0) {
				$('<div class="nav-'+node_id+' collapse"><ul style="padding-left:0;"></ul></div>').appendTo('#'+nav_id);
				$('#'+node_id+' .widget').appendTo($('<li/>')).appendTo($('.nav-'+node_id+' ul'));
			}
		}
		else {
			console.debug('Moving '+node_id+' back because window width '+$(window).width()+' is greater than '+min_width);
			$('.nav-'+node_id+' .widget').appendTo('#'+node_id);
			//$('.nav-'+node_id+' ul li').append($('#'+node_id)).after('#primary');
		}
	}
});
