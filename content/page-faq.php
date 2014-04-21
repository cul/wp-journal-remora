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
$content = qa_to_html( get_the_content() );
?>
<article id="post-<?php the_ID() ?>" <?php post_class(); ?>>
	<div class="entry-header">
		<?php the_title('<h1 class="entry-title">', '</h1>') ?>
	</div>
	<div class="entry-content">
		<?php
			echo $content;
			$args = array(
				'before' => '<p class="pages-link">'. __('Pages: ', 'carrington-blueprint'),
				'after' => "</p>\n",
				'next_or_number' => 'number'
			);
			wp_link_pages($args);
		?>
	</div><!--.entry-content-->
</article>