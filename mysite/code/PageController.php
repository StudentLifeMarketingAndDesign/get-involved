<?php
use SilverStripe\Core\Config\Config;
use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\View\Requirements;

class PageController extends ContentController {

	/**
	 * An array of actions that can be accessed via a request. Each array element should be an action name, and the
	 * permissions or conditions required to allow the user to access it.
	 *
	 * <code>
	 * array (
	 *     'action', // anyone can access this action
	 *     'action' => true, // same as above
	 *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
	 *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
	 * );
	 * </code>
	 *
	 * @var array
	 */

	private static $allowed_actions = array(
		'navHeader'
	);

	private static $url_handlers = array(
		'navHeader' => 'navHeader'
	);

	public function navHeader(){


		$header = $this->renderWith('Navigation');
		$url = "https://csil.uiowa.edu";
		$headerReplace = preg_replace('/((?:href|src) *= *[\'"](?!(http|ftp)))/i', "$1$url", $header);
		return $headerReplace;

	}
	protected function init() {
		parent::init();

		// Note: you should use SS template require tags inside your templates
		// instead of putting Requirements calls here.  However these are
		// included so that our older themes still work
		// Requirements::themedCSS('reset');
		// Requirements::themedCSS('layout');
		// Requirements::themedCSS('typography');
		// Requirements::themedCSS('form');

	 //    Requirements::block('division-bar/css/_division-bar.css');
	 //    Requirements::block('division-project/js/main.js');
    
	}
	
  public function Events(){
    $events = $this->RSSDisplay(3, 'http://afterclass.uiowa.edu/events/categories/Center%20for%20Student%20Involvement%20and%20Leadership/feed/rss');
    return $events;

  }	
  
	/* Clear Out Empty Lines from SS Template Indents */
	/*public function handleRequest(SS_HTTPRequest $request, DataModel $model) {
		$ret = parent::handleRequest($request, $model);
		$temp=$ret->getBody();
		$temp = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $temp);
		$ret->setBody($temp);
		return $ret;
	} */


}
