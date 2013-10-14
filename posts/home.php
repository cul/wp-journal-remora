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

	<div id="featured row clearfix">
		<?php
		$remoraOJS = (class_exists(Remora_OJS_Core)) ? new Remora_OJS_Core() : null;
		$articles = array(9, 3, 5, 8);
		$sectionImage = 'http://www.consiliencejournal.org/blog/wp-content/uploads/2012/06/MjPFeP1339472471.jpg';
		foreach($articles as $article){
			$abstract = $remoraOJS->get_abstract_by_id($article, array('excerpt_length'=> 60));

			if (!$abstract) continue;

			echo '<div class="excerpt pull-left span2">
			<header>
			<img src="'.$sectionImage.'" style="height: 120px !important;" />
			<h4 class="excerpt-title">
			<a href="'.$abstract->link.'">'.$abstract->title.'</a>
			</h4>
			<div class="excerpt-authors byline">
			'.$abstract->authors.'
			</div>
			</header>
			<div class="excerpt-text">
			'.$abstract->excerpt.'
			</div>
			<ul class="excerpt-galleys">';
			
			foreach($abstract->galleys as $galley) {
				echo "<li>$galley</li>";
			}
			echo'
			</ul>
			</div>';

			switch($sectionImage){
				case 'http://www.consiliencejournal.org/blog/wp-content/uploads/2012/06/MjPFeP1339472471.jpg':
				$sectionImage = 'http://www.consiliencejournal.org/blog/wp-content/uploads/2012/06/zNEAWS1339472372.jpg';
				break;

				case 'http://www.consiliencejournal.org/blog/wp-content/uploads/2012/06/zNEAWS1339472372.jpg';
				$sectionImage = 'http://www.consiliencejournal.org/blog/wp-content/uploads/2012/06/kHIN2Y1339472935.jpg';
				break;

				case 'http://www.consiliencejournal.org/blog/wp-content/uploads/2012/06/kHIN2Y1339472935.jpg':
				$sectionImage = 'http://www.consiliencejournal.org/blog/wp-content/uploads/2012/06/8EGGbd1339472243.jpg';
				break;
			}
		}
		?>
	</div>
	<div class="clearfix">
		<?php
		cfct_loop();
		cfct_misc('nav-posts');
		?>

	</div>

</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
?>