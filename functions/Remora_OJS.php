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
		$article_text = stream_get_contents(( fopen($article_url, 'r')) );
		$doc = new DOMDocument();
		$doc->loadHTML('<?xml encoding="UTF-8">' . $article_text);

		return $doc;
	}

	/**
	 * Retrives an html galley from a remora-ready OJS install
	 *
	 * Parameters:
	 * @ojs_article_id - Required. Int. A valid OJS article ID. Default: none.
	 * @requested_galley - Required. String. A valid OJS article ID. Default: none.
	 * @asAjax - Bool. Should the article be retrieved as a DOM segment. Default: true.
	 *
	 * Returns:
	 * DomDocument, Redirect, or null
	 */
	function fetch_ojs_galley_by_article_id($ojs_article_id, $requested_galley, $asAjax = true){
		$article_id = (int) $ojs_article_id;
		$galley = preg_replace("/[^A-Za-z0-9_]/", "", (string) $requested_galley);

		// If the requested galley is HTML grab the DOM
		if(strpos($galley, 'htm') == 0 ){
			$article_url = $this->journal_url."/article/view/".$article_id."/".$galley."?ajax=".(bool) $asAjax;
			$article_text = stream_get_contents(( fopen($article_url, 'r')) );
			$doc = new DOMDocument();
			$doc->loadHTML('<?xml encoding="UTF-8">' . $article_text);

			return $doc;
		}

		// Download other galleys

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
		$issue_text = stream_get_contents(( fopen($issue_url, 'r')) );
		$doc = new DOMDocument();
		$doc->loadHTML('<?xml encoding="UTF-8">' . $issue_text);

		return $doc;
		//return $doc->saveHTML();
	}

	/**
	 * Gets the article id from the get data
	 *
	 * Returns: Int or null.
	 */
	function get_requested_article_id() {
		$article_id = (int) $_GET['article_id'];
		return ($article_id) ? $article_id : null ;
	}

	/**
	 * Gets the article id from the get data
	 *
	 * Returns: Int or null.
	 */
	function get_requested_galley_type() {
		$galley_type = preg_replace("/[^A-Za-z0-9_]/", "", (string) $_GET['galley']);
		return ($galley_type) ? $galley_type : null ;
	}

	/**
	 * Replaces link domains with the WordPress Remora path
	 *
	 * Parameters:
	 * @dom - DOM object
	 * @translations - array of paths to convert, values local to the wp ojs page
	 *
	 * Returns:
	 * DOM object with links changed to local
	 */
	function make_links_local($dom, $translations = null){
		$translations = array(
			'\/article\/view\/(\d*)\/?$' => '/\1',
			'\/article\/view\/(\d*)\/(.*)' => '/\1/?galley=\2'
			);

		foreach ($dom->getElementsByTagName('a') as $dom_link) {
			$link = $dom_link->getAttribute('href');
			foreach($translations as $old => $new) {
				$old_url = $this->journal_url.$old;
				$new_url = $this->local_url.$new;
				$link = preg_replace('#'.$old_url.'#', $new_url, $link);
				$dom_link->setAttribute('href', $link);
			}
			$dom->saveHTML();
		}

		return $dom;
	}

	/**
	 * Cleans up DOM for document ingest
	 * NOTE: INCOMPLETE
	 *
	 * Parameters:
	 * @dom - DOM object
	 *
	 * Returns:
	 * DOM object with certain tags removed
	 */
	function strip_dom_elements($dom){
		$marked_nodes = array(
			'html',
			'body',
			'title',
			'head',
			);

		$marked_node->parentNode->removeChild($marked_node);

		foreach ($dom->getElementsByTagName('a') as $link) {
			$subject = $link->getAttribute('href');
			$link->setAttribute('href', str_replace($this->journal_url.'/article/view/', $this->local_url.'/', $subject));
			$dom->saveHTML();
		}

		return $dom;
	}

}