<?php

// Gets the attachment ID from image source
function get_attachment_id_from_src($image_src) {

	global $wpdb;
	$query = "SELECT ID FROM ".$wpdb->posts." WHERE guid LIKE '%".$image_src."%'";
	$id = $wpdb->get_var($query);

	return $id;

}

/**
 * Gets a term's parent by the term ID. Returns the parent term id or false if there's no parent
 */
function get_term_parent($id, $taxonomy){
	$term = get_term_by( 'id', $id, $taxonomy );

	return ($term->parent) ? get_term($term->parent, $taxonomy ) : false;
}

/**
 * Gets the featured discussion
 */
function featured_discussion($issueSlug){
	$featuredDiscussionParams = array(
		'post_type' => 'discussion',
		);
	query_posts($featuredDiscussionParams);


	if (have_posts()) {
		while (have_posts()) {
			the_post();

				// if the discussion isn't featured, skip it. Otherwise, display that and stop looking.
			if(!get_post_custom_values('featured_discussion', get_the_ID())) continue;
			cfct_template_file('excerpt', 'excerpt-featured-discussion');
			
			break;
		}
	}
}




/** 
 * Gets the highlight image
 * The highlight image is determined in the following order:
 * 1. Featured image
 * 2. Author image
 * 3. false
 */
function get_highlight_image($size = null){
	if(has_post_thumbnail()) 
		the_post_thumbnail($size);
	else author_image($size);

	return $image;
}

function highlight_image($size = null) {
	 echo get_highlight_image($size);
}

/**
 * Gets the featured articles
 */
function featured_articles($issueSlug){
	$featuredArticleParams = array(
		'post_type' => 'article',
		'issues' => $issueSlug
		);
	query_posts($featuredArticleParams);

	if (have_posts()) {
		while (have_posts()) {
			the_post();

			// if the article isn't featured, skip it. Otherwise, display that.
			if(!get_post_custom_values('featured_article', get_the_ID())) continue;
			cfct_template_file('excerpt', 'excerpt-featured-article');
		}
	}
}

/**
 * Returns the custom authors
 */
function get_the_authors(){
	$authorsVal = get_post_custom_values('authors', get_the_ID());
	$authors = preg_split("/\\r\\n|\\r|\\n/", $authorsVal[0]);
	while(key($authors) !== null) {
		$articleAuthors .= current($authors);
		if(next($authors) !== false) $articleAuthors .=', ';
	}

	return ($articleAuthors) ? $articleAuthors : get_the_author();
}

/**
 * Outputs the custom authors
 */
function the_authors() {
	echo get_the_authors($id);
}

/**
 * Get the author image
 */
function get_post_author_image($size = array(45,45)){
	$image = get_post_custom_values('author_image', get_the_ID());
	return wp_get_attachment_image( $image[0], $size );
}

function author_image($size){
	echo get_post_author_image($size);
}




