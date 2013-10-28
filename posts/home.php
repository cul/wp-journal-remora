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
	<article>
		<section id="introduction">
			<?php
			$the_query = new WP_Query( 'pagename=introduction' );
			while ( $the_query->have_posts() ) :
				$the_query->the_post();
			?>
			<header>
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>
			<?php 
			the_content();
			endwhile;
			wp_reset_postdata();
			?>
		</section>
		<section id="featured" class="featured">
			<?php

			global $wp_query;
			$wp_query = new WP_Query( array( 'post_type' => 'feature', 'orderby' => 'meta_value', 'meta_key' => 'current_feature' ) );

			cfct_template_file('content', 'type-feature');

			?>
		</section>
		<div class="clearfix">
			<?php
			cfct_loop();
			cfct_misc('nav-posts');
			?>

		</div>
	</article>
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
?>