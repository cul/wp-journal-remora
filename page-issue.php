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
	// Get the requested issue
	$issue_id = $remoraOJS->get_requested_issue_id();
	$journal_page = $remoraOJS->get_issue_by_id($issue_id);

	// If the requested issue doesn't exist
	if(!$journal_page)
		$journal_page = $remoraOJS->get_issue_by_id('current');

	echo $remoraOJS->show_page($journal_page);
	?>
</div><!-- #primary -->

<?php 
get_sidebar();
get_footer();
?>