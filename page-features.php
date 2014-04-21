<?php

// This file is part of the Carrington Blueprint Theme for WordPress
//
// Copyright (c) 2013 Center for Digital Research and Scholarship at Columbia University Libraries/Information Services
// http://cdrs.columbia.edu
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// **********************************************************************
//
// The purpose of this page is to display a table of contents for journal issues.
// It can easily be adapted to display other taxonomical indices
//
// To use this template for another taxonomy:
// 1. Change the name to tax-[taxonomy name].php
// 2. In the query_posts method, change the value of 'post_type' to your custom content type name
// 3. In the checking if it's the current issue, change 'Current Issue' to whatever the name of your current issue tag is

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }
if (CFCT_DEBUG) { cfct_banner(__FILE__); }

get_header();
?>
<div id="primary" class="c1-8 toc">
	<h1 class="section-title">Issues</h1>
	<?php



$query_args = array(
		'order' => 'ASC',
		'post_type' => 'feature',
		'orderby' => 'title',
    'meta_query' => array(
        array(
            'key' => 'featured_article_1',
            'compare' => '=',
            'value' => 'null'
        )
    )
);


	global $wp_query;
	$wp_query = new WP_Query( $query_args );

	cfct_template_file('loop', 'loop-features');
	?>
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
?>
