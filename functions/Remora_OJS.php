<?php
/**
 * This class contains functions for retrieving data from a remora-ready OJS install
 */
class Remora_OJS {

	/**
	 * Retrives an article from a remora-ready OJS install
	 *
	 * Parameters:
	 * @ojs_article_id - Required. Int. A valid OJS article ID. Default: none.
	 * @journal_url - String. URL of the OJS install. Default: null.
	 * @asAjax - Bool. Should the article be retrieved as a DOM segment. Default: false.
	 *
	 * Returns:
	 * DomDocument or null
	 */
	function fetch_ojs_article_by_id($ojs_article_id, $journal_url = null, $asAjax = false){
		$asAjax = 'chicken';
		$article_id = (int) $ojs_article_id;
		$journal_url = "http://localhost/huahua-ojs/index.php/tremor";
		$article_url = $journal_url."/article/view/".$article_id."?ajax=".(bool) $asAjax;
		$doc = new DOMDocument();
		$doc->loadHTMLFile($article_url);
		return $doc->saveHTML();
	}

	/**
	 * Gets the article id from the get data
	 *
	 * Returns: Int or null.
	 */
	function get_requested_article() {
		$article_id = (int) $_GET['article_id'];
		return ($article_id) ? $article_id : null ;
	}

}