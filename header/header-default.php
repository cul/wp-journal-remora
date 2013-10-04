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

$blog_desc = get_bloginfo('description');
$title_description = (is_home() && !empty($blog_desc) ? ' - '.$blog_desc : '');

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7 oldie" <?php language_attributes() ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8 oldie" <?php language_attributes() ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9 oldie" <?php language_attributes() ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes() ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo('charset') ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php wp_title( '-', true, 'right' ); echo esc_html( get_bloginfo('name'), 1 ).$title_description; ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>

</head>
<body <?php body_class('wp'); ?>>
	<div id="masthead-wallpaper"></div>
	<div class="container grid">
		<header id="masthead" class="row site-header clearfix">
			<?php
			// Display the logo with the site name as alt text, otherwise put the logo as the heading
			$siteLogo = (cfct_get_option('cfct_logo')) ? '<img src="'.cfct_get_option('cfct_logo').'" alt="'.get_bloginfo('name').'" />' : get_bloginfo('name');
			?>
			
			<h1 id="site-name"><a href="<?php echo home_url('/'); ?>" title="<?php _e('Home', 'carrington-blueprint'); ?>"><?php echo $siteLogo; ?></a></h1>
		</header><!-- #masthead -->
		<div id="main" class="row clearfix">
			<nav id="nav-main" class="navbar navbar-default nav-stacked" role="navigation">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="nav-collapse collapse">

					<?php 
					wp_nav_menu( array(
						'menu'       => 'main',
						'theme_location' => 'main',
						'depth'      => 2,
						'container'  => false,
						'menu_class' => 'nav navbar-nav',
						'fallback_cb' => 'wp_page_menu',
						'walker' => new wp_bootstrap_navwalker())
					);
					?>
				</div>
			</nav>
			<div id="breadcrumbs-main">
				<?php if (function_exists('dimox_breadcrumbs')) echo dimox_breadcrumbs(); ?>
				<span class="fade-overflow"></span>
			</div>

