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

/**
 * Convert non-breaking space to a forced break
 *
 * @str - String to convert
 *
 * Returns string with non-breaking space converted to newlines
 */
function nbsp_to_break($str) {

	$converted = preg_replace('/\xC2\xA0/', "\n", $str);

	return $converted;
}

/**
 * Convert break to html break
 *
 * @str - String to convert
 * @break_type - Optional break type, default: br
 *
 * Returns string with newlines converted to breaks
 */
function break_to_html($str, $break_type = 'br'){

	if ($break_type != "br"){
		$before = "<{$break_type}>";
		$after = "</{$break_type}"; 
	}
	else {
		$before = null;
		$after = "<{$break_type}/>";
	}

	// TODO: Refine replace to allow placing elements before and after
	$converted = preg_replace('/[\n|\r]/', "{$after}", $str);

	return $converted;
}

/**
 * Converts text QA to HTML QA
 *
 * @str - String containing QA
 * @match_filter - Function name to use to filter matches
 * 
 * Returns html-formatted QA
 */
function qa_to_html($str, $match_filter = null) {

	$lines = explode("\n", $str);
	$q_rx = "/^[\t ]*Q\.\s/i";
	$a_rx = "/^[\t ]*A\.\s/i";
	$open_qa_rx = "/start qa/i";
	$close_qa_rx = "/end qa/i";

	$qa_container = 'dl';
	$q_tag = 'dt';
	$a_tag = 'dd';
	$html;
	

	foreach($lines as $line) {

		static $container_open = false;

		// Open or close the qa container as requested
		if (preg_match($open_qa_rx, $line) ) {

			$container_open = true;
			$line = null;
			$html .= "\n<{$qa_container}>";
		}

		elseif ($container_open && preg_match($close_qa_rx, $line) ) {

			$container_open = false;
			$line = null;
			$html .= "\n</{$qa_container}>\n";
		}

		// Properly tag Q and A lines appropriately
		if($line && $container_open){

			$processed_line = (function_exists($match_filter) ) ?  $match_filter($line) : $line;
			
			if(preg_match($q_rx, $line) ){

				$match = true;
				$html .= "\n<{$q_tag}>".preg_replace($q_rx, "", $processed_line)."</{$q_tag}>";
			}

			elseif(preg_match($a_rx, $line) ){

				$match = true;
				$html .= "\n<{$a_tag}>".preg_replace($a_rx, "", $processed_line)."</{$a_tag}>";
			}

			else {
				$match = false;
			}
		}

		// Let other lines through normally
		if(!$match && $line) 
			$html .= "\n<p>{$line}</p>";
	}

	if ($container_open) { 

		$container_open = false;
		$html .= "\n</{$qa_container}>\n";
	}
	echo "<!--\n".var_export($lines, 1)."\n-->";

	return $html;
}

/**
 * Converts html breaks to markdown breaks
 *
 * @str Html string
 * 
 * Returns String with markdown-style breaks
 */
function convert_html_breaks($str){

	// Convert break elements to newline elements (\n)
	$converted = preg_replace("/<br[\/\s]*>/i", "\n", $str);

	// Convert paragraph elements to markdown paragraph elements (\n\n)
	if( preg_replace("/<p[^>]*>/i", "\n\n", $converted) ) {
		$converted = preg_replace("/<\/p>/i", "\n", $converted);
	}
	return $converted;
}








