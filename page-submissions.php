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
			<li>It pulls up an OJS page in an iframe which displays all the content but doesn't scroll.</li>
			<li>It allows authors to access the OJS author page without being on OJS.</li>
			<li>If you're not logged in it provides the OJS login/register process which will also show up here.</li>
		</ul>
	</div>
	<iframe src="<?php echo $remoraOJS->journal_url; ?>/author" id="remora" style="width:100%; border: none;"></iframe>
</div><!-- #primary -->

<?php 
get_sidebar();
get_footer();
?>