<?php

// This file is part of the Carrington Blueprint Theme for WordPress
//
// Copyright (c) 2008-2013 Crowd Favorite, Ltd. All rights reserved.
// http://crowdfavorite.com
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// **********************************************************************

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }
if (CFCT_DEBUG) { cfct_banner(__FILE__); }

get_header();
?>

<div id="primary" class="c1-8">
	<?php
	$features = get_post_features();

	// For the loop used, look in /loops
	cfct_loop();

	foreach($features as $feature) {
		$title = $feature->post_title;
		$link = $feature->guid;
		$excerpt = $feature->post_excerpt;
		$featured_image;
		?>
		<article class="excerpt">
			<header>
				<img src="<?php echo $featured_image; ?>" />
				<h4 class="excerpt-title">
					<a href="<?php echo $link; ?>"><?php echo $title; ?></a>
				</h4>
			</header>
			<div class="excerpt-text">
				<?php echo $excerpt; ?>
			</div>
	</article>';
	<?
}


?>
</div><!-- #primary -->

<?php 
get_sidebar();
get_footer();
?>