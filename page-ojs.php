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
	<div class="well">
		<p>This page is a magic page.</p>
		<ul>
			<li>It magically changes links into WP links in the OJS pages it retrieves.</li>
			<li>If it's not given an article number after it in the URL it will serve up the current issue.</li>
			<li>If it is given an article number (e.g. "journal/1"), it will serve up that article abstract.</li>
			<li>If it's given an article number and a galley id in a query string (e.g. "journal/1/html") it will serve the galley.</li>
	</div>
	<?php
	$article_id = $remoraOJS->get_requested_article_id();
	$galley = $remoraOJS->get_requested_galley_type();

	// Fetch the galley dom if a galley is requested	
	if($article_id && $galley) $journal_page = $remoraOJS->fetch_galley_by_article_id($article_id, $galley);
	// Fetch the article DOM if there is just an article id
	elseif($article_id) $journal_page = $remoraOJS->fetch_article_by_id($article_id);
	// If nothing else, fetch the current issue TOC
	else $journal_page = $remoraOJS->fetch_issue_by_id('current');

	echo $journal_page->url;
	echo $remoraOJS->show_page($journal_page);

	?>
</div><!-- #primary -->

<?php 
get_sidebar();
get_footer();
?>