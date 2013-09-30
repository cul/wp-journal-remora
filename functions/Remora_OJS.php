<?php
/**
 * This class contains functions for retrieving data from a remora-ready journal install
 */
class Remora_OJS {

	public $journal_url;
	public $local_url;

	function __construct(){
		$this->journal_url = cfct_get_option('cfct_ojs_url');
		$this->local_url = get_bloginfo('url').'/'.cfct_get_option('cfct_wp_journal_slug');
	}

	/**
	 * Fetches the output of a path from the journal specified in settings
	 *
	 * @path (string) Path in the journal to retrieve
	 * @asAjax (bool) Whether to retreive the file as AJAX
	 */
	function fetch_journal_html($journal_page, $asAjax = true){
		$page_url = ($asAjax) ? $this->journal_url.$journal_page."?ajax=".(bool) $asAjax : $this->journal_url.$journal_page;
		$page_output = stream_get_contents(( fopen($page_url, 'r')) );

		return $page_output;
	}

	function strip_headers(&$dom){
		// remove <!DOCTYPE 
		$doc->removeChild($doc->firstChild);            

		// remove <html><body></body></html> 
		$doc->replaceChild($doc->firstChild->firstChild->firstChild, $doc->firstChild);
	}

	/**
	 * Retrives an article from a remora-ready journal install
	 *
	 * Parameters:
	 * @journal_article_id - Required. Int. A valid journal article ID. Default: none.
	 * @asAjax - Bool. Should the article be retrieved as a DOM segment. Default: true.
	 * @journal_url - String. URL of the journal install. Default: null.
	 *
	 * Returns:
	 * DomDocument or null
	 */
	function fetch_journal_article_by_id($journal_article_id, $asAjax = true){
		$article_id = (int) $journal_article_id;
		$article_page = "/article/view/".$article_id;
		$article = $this->fetch_journal_html($article_page, $asAjax);

		$doc = new DOMDocument();
		$doc->loadHTML('<?xml encoding="UTF-8">' . $article);

		return $doc;
	}

	/**
	 * Retrives an html galley from a remora-ready journal install
	 *
	 * Parameters:
	 * @journal_article_id - Required. Int. A valid journal article ID. Default: none.
	 * @requested_galley - Required. String. A valid journal article ID. Default: none.
	 * @asAjax - Bool. Should the article be retrieved as a DOM segment. Default: true.
	 *
	 * Returns:
	 * DomDocument, Redirect, or null
	 */
	function fetch_journal_galley_by_article_id($journal_article_id, $requested_galley, $asAjax = true){
		$article_id = (int) $journal_article_id;
		$galley = preg_replace("/[^A-Za-z0-9_]/", "", (string) $requested_galley);

		// If the requested galley is HTML grab the DOM
		if(strpos($galley, 'htm') == 0 ){
			$galley_page = "/article/view/".$article_id."/".$galley;
			$article = $this->fetch_journal_html($galley_page, $asAjax);

			$doc = new DOMDocument();
			$doc->loadHTML('<?xml encoding="UTF-8">' . $article);

			return $doc;
		}

		// Download other galleys

	}

	/**
	 * Retrives issue table of contents (TOC) from a remora-ready journal install
	 *
	 * Parameters:
	 * @journal_issue_id - Required. Int. A valid journal article ID. Default: none.
	 * @asAjax - Bool. Should the article be retrieved as a DOM segment. Default: false.
	 *
	 * Returns:
	 * DomDocument or null
	 */
	function fetch_journal_issue_by_id($journal_issue_id = 'current', $asAjax = true){
		// Allow the issue id to be either "current" or an int
		if($journal_issue_id != 'current'){
			if(is_int($journal_issue_id)) $issue_id = (int) $journal_issue_id;
		}
		else $issue_id = 'current';

		$issue_page = "/issue/".$issue_id;
		$issue = $this->fetch_journal_html($issue_page, $asAjax);

		$doc = new DOMDocument();
		$doc->loadHTML('<?xml encoding="UTF-8">' . $issue);

		return $doc;
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
	 * @translations - array of paths to convert, values local to the wp journal page
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