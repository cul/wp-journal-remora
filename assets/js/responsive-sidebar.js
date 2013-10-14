jQuery(document).ready(function($){
	responsive_sidebar();

	$(window).resize(function(){
		responsive_sidebar();
	});

	function responsive_sidebar(){
		node_id = 'secondary';
		nav_id = 'nav-main';
		min_width = 768;

		$('.navbar-toggle').collapse('show');
		
		// If it's smaller than the min_width send it to the navbar, otherwise send it back.
		if($(window).width() <= min_width) {
			
			// Create the collapse button if necessary
			if($('#collapse-'+node_id).length == 0) {
				var btn_collapse = '<button id="collapse-'+node_id+'" type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-'+node_id+'"><span class="sr-only">Toggle asides</span><i class="glyphicon-star-empty glyphicon"></i></button>';
				$(btn_collapse).appendTo('#'+nav_id+' .navbar-header');
			}

			// Move the sidebar widgets to the navbar
			if($('#'+nav_id+' #'+node_id).length == 0 && $('.nav-'+node_id).length == 0) {
				var navCollapse = $('<div class="nav-'+node_id+' collapse navbar-nav"/>').append($('<ul id="widgets-'+node_id+'" />'));
				console.debug(navCollapse);
				$('#nav-main').append(navCollapse);

				// Change the nodes to <li>
				$('#'+node_id+' .widget').changeElementType('li');

				// Add them to the navbar. We have
				$('#'+node_id+' .widget').each(function(){
					$('#widgets-'+node_id).append( $(this) );
				});

			}
		}
		else {
			console.debug('Moving '+node_id+' back because window width '+$(window).width()+' is greater than '+min_width);
			$('.nav-'+node_id+' .widget').appendTo('#'+node_id);
			$('.nav-'+node_id).remove();

			// Change the nodes to <aside>
				$('#'+node_id+' .widget').changeElementType('aside');
		}
	}
});

// Type change jQuery plugin
(function($) {
	$.fn.changeElementType = function(newType) {
		console.debug('Changing element to '+newType);
		var attrs = {};

		$.each(this[0].attributes, function(idx, attr) {
			attrs[attr.nodeName] = attr.nodeValue;
		});

		this.replaceWith(function() {
			return $("<" + newType + "/>", attrs).append($(this).contents());
		});
	};
})(jQuery);
