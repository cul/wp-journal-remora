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
	<pre>
		I am a magic page.
	</pre>
	<?php
	// For the loop used, look in /loops
	//cfct_loop();
	//comments_template();
	echo ($article_id = $remoraOJS->get_requested_article()) ? $remoraOJS->fetch_ojs_article_by_id($article_id) : 'Invalid article id: '.$_GET['article_id'];
	?>
</div><!-- #primary -->

<?php 
get_sidebar();
get_footer();
?>