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

$article_id = $remoraOJS->get_requested_article_id();
$galley = $remoraOJS->get_requested_galley_type();

	// Fetch the galley dom if a galley is requested	
if($article_id && $galley) $journal_page = $remoraOJS->get_galley_by_article_id($article_id, $galley);

	// Or fetch the article DOM if there is just an article id
elseif($article_id) $journal_page = $remoraOJS->get_article_by_id($article_id);

	// If nothing else, fetch the current issue Table of Contents
else $journal_page = $remoraOJS->get_issue_by_id('current');

global $ojsTitle;
$ojsTitle = $journal_page->title;

get_header();

?>

<div id="primary" class="c1-8">
	<?php
	echo $remoraOJS->show_page($journal_page);
	?>
</div><!-- #primary -->

<?php 
get_sidebar();
get_footer();
?>