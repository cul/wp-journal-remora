jQuery(document).ready(function($){
	responsive_sidebar();

	$(window).resize(function(){
		responsive_sidebar();
	});

	function responsive_sidebar(){
		// Node names
		var node_id = 'secondary';
		var nav_id = 'nav-main';
		
		// Bootstrap standard sizes
		var screen_xs = 480;
		var screen_sm = 768;
		var screen_md = 992;
		var screen_lg = 1200;

		// Toggling width
		var max_width = screen_lg;
		var std_width = screen_xs;

		$('.navbar-toggle').collapse('show');
		// If it's larger than the standard width, send it to the normal nav instead
			if($(window).width > std_width) {
				var nav_target = $('<li class="btn-sidebar"/>').appendTo($('#'+nav_id+' .nav').last());
				console.debug('Target: nav ul');
			} else {
				var nav_target = $('#'+nav_id+' .navbar-header');
				console.debug('Target: navbar-header');
			}

		// If it's smaller than the max width create if required
		if($(window).width() <= max_width) {

			// Create the collapse button if necessary
			if($('#collapse-'+node_id).length == 0) {
				var btn_collapse = '<button id="collapse-'+node_id+'" type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-'+node_id+'"><span class="sr-only">Toggle asides</span><i class="glyphicon-star-empty glyphicon"></i></button>';
				$(btn_collapse).appendTo(nav_target);
			}

			// Move the sidebar widgets to the navbar
			if($('#'+nav_id+' #'+node_id).length == 0 && $('.nav-'+node_id).length == 0) {
				var navCollapse = $('<div class="nav-'+node_id+' collapse navbar-nav"/>').append($('<ul id="widgets-'+node_id+'" />'));
				$('#nav-main').append(navCollapse);

				// Change the nodes to <li>
				$('#'+node_id+' .widget').each(function(){
					$(this).changeElementType('li');
				});

				// Add them to the navbar. We have
				$('#'+node_id+' .widget').each(function(){
					$('#widgets-'+node_id).append( $(this) );
				});

			}
		}
		else {
			$('.nav-'+node_id+' .widget').appendTo('#'+node_id);
			$('.nav-'+node_id).remove();

			// Change the nodes to <aside>
				$('#'+node_id+' .widget').each(function(){
					$(this).changeElementType('aside');
				});
		}
	}
});

// Type change jQuery plugin
(function($) {
	$.fn.changeElementType = function(newType) {
		var attrs = {};

		$.each(this[0].attributes, function(idx, attr) {
			attrs[attr.nodeName] = attr.nodeValue;
		});

		this.replaceWith(function() {
			return $("<" + newType + "/>", attrs).append($(this).contents());
		});
	};
})(jQuery);
