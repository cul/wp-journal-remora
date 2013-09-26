<?php
/**
 * This class contains functions for retrieving data from a remora-ready OJS install
 */
class Remora_OJS {

	public $journal_url = "http://localhost/huahua-ojs/index.php/tremor"; // TODO: Change this to a setting
	public $local_url = "http://localhost/huahua/ojs";

	/**
	 * Retrives an article from a remora-ready OJS install
	 *
	 * Parameters:
	 * @ojs_article_id - Required. Int. A valid OJS article ID. Default: none.
	 * @asAjax - Bool. Should the article be retrieved as a DOM segment. Default: true.
	 * @journal_url - String. URL of the OJS install. Default: null.
	 *
	 * Returns:
	 * DomDocument or null
	 */
	function fetch_ojs_article_by_id($ojs_article_id, $asAjax = true){
		$article_id = (int) $ojs_article_id;
		$article_url = $this->journal_url."/article/view/".$article_id."?ajax=".(bool) $asAjax;
		$doc = new DOMDocument();
		$doc->loadHTMLFile($article_url);

		return $doc;
		//return $doc->saveHTML();
	}

	/**
	 * Retrives issue table of contents (TOC) from a remora-ready OJS install
	 *
	 * Parameters:
	 * @ojs_issue_id - Required. Int. A valid OJS article ID. Default: none.
	 * @asAjax - Bool. Should the article be retrieved as a DOM segment. Default: false.
	 *
	 * Returns:
	 * DomDocument or null
	 */
	function fetch_ojs_issue_by_id($ojs_issue_id = 'current', $asAjax = true){
		// Allow the issue id to be either "current" or an int
		if($ojs_issue_id != 'current'){
			if(is_int($ojs_issue_id)) $issue_id = (int) $ojs_issue_id;
		}
		else $issue_id = 'current';

		$issue_url = $this->journal_url.'/issue/'.$issue_id."?ajax=".(bool) $asAjax;
		$doc = new DOMDocument();
		$doc->loadHTMLFile($issue_url);

		return $doc;
		//return $doc->saveHTML();
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

	/**
	 * Replaces link domains with the WordPress Remora path
	 *
	 * Parameters:
	 * @dom - DOM object
	 *
	 * Returns:
	 * DOM object with links changed to local
	 */
	function make_links_local($dom){
		foreach ($dom->getElementsByTagName('a') as $link) {
			$subject = $link->getAttribute('href');
			$link->setAttribute('href', str_replace($this->journal_url.'/article/view/', $this->local_url.'/', $subject));
			$dom->saveHTML();
		}

		return $dom;
	}

}