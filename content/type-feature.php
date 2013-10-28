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

the_post(); // Doing this here because of the strange ways we call this file
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix', 'featured'); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink() ?>"  title="<?php printf( esc_attr__( 'Permalink to %s', 'carrington-blueprint' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title() ?></a></h1>
	</header>

	<section id="entry-content" class="entry-content">
		<?php
		the_content();
		?>
	</section> <!-- #entry-content -->

	<section id="features">
		<?php
		$features = get_post_features();
		if(is_array($features))
			foreach($features as $feature) {
				$data = array(
					'title' => $feature->post_title,
					'link' => get_permalink($feature->ID),
					'excerpt' => ($feature->post_excerpt) ? $feature->post_excerpt : truncate_string($feature->post_content, array('length'=>55, 'collapse'=>true, 'strip_tags'=>true, 'no_escape'=>true)).' [&hellip;]',
					'thumbnail' => get_the_post_thumbnail($feature->ID, 'thumbnail')
					);

				cfct_template_file('excerpt', 'type-feature', $data);
			}
			?>
		</section> <!-- #features -->
	</article><!-- #featured -->

</article><!-- .post -->
