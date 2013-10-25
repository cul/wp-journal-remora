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
	<article id="post-<?php the_ID() ?>" <?php post_class(); ?>>
		<div class="entry-header">
			<?php the_title('<h1 class="entry-title">', '</h1>') ?>
		</div>
		<div class="entry-content">
			<?php
			the_content();
			?>
			<ul>
				<?php
				foreach(get_past_issues() as $issue) {
					switch($issue->type) {
						case 'issue':
						?><li><a href="<?php echo home_url('/'); ?>journal/issue/<?php echo $issue->id; ?>"><?php echo $issue->title; ?></a></li><?php
						break;

						case 'heading':
						?>
					</ul>
					<h2><?php echo $issue->title; ?></h2>
					<ul>
						<?
						break;
					}
				}
				?>
			</ul>
		</div><!--.entry-content-->
	</article>
</div>
<?php 
get_sidebar();
get_footer();
?>