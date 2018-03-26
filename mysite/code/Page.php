<?php
class Page extends SiteTree {

	private static $db = array(

	);

	private static $has_one = array(
      "PreviewImage" => "Image"
	);



public function getCMSFields(){
		$f = parent::getCMSFields();
		$parent = $this->getParent();

		if((isset($parent)) && ($parent->ClassName == "FeaturePage")){
			$f->removeByName("Content");
			$f->addFieldToTab("Root.Main", new UploadField("PreviewImage", "Preview Image (361 x 215 pixels) (if under a Feature Page)"));
			$f->addFieldToTab("Root.Main", new HTMLEditorField("Content"));
		}

		return $f;
	}
	
}
class Page_Controller extends ContentController {

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

	public function init() {
		parent::init();

		// Note: you should use SS template require tags inside your templates
		// instead of putting Requirements calls here.  However these are
		// included so that our older themes still work
		Requirements::themedCSS('reset');
		Requirements::themedCSS('layout');
		Requirements::themedCSS('typography');
		Requirements::themedCSS('form');

    Requirements::block('division-bar/css/_division-bar.css');
    Requirements::block('division-project/js/main.js');
    
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