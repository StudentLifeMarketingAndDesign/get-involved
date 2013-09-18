<?php
class Page extends SiteTree {

	private static $db = array(
		"HideDefaultPageTitle" => "Boolean"
	);

	private static $has_one = array(
      "PreviewImage" => "Image"
	);


	private static $many_many = array (
		"SidebarItems" => "SidebarItem"
	);

    private static $many_many_extraFields=array(
        'SidebarItems'=>array(
            'SortOrder'=>'Int'
        )
    );

    private static $plural_name = "Pages";

	private static $defaults = array (


		"Content" =>
			"
<p>The first paragraph directly after an H1 is the lede paragraph and is styled with a larger font size than other paragraphs.</p>
<h2>H2. This is a large header.</h2>
<p>Nullam id dolor id nibh ultricies vehicula ut id elit. Cum sociis natoque penatibus et magnis dis parturient.</p>
<h3>H3. This is a medium header.</h3>
<p>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh ut fermentum massa justo.</p>
<h4>H4. This is a moderate header.</h4>
<p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl.</p>
<h5>H5. This is small header.</h5>
<p>Cum sociis natoque penatibus magnis parturient montes, nascetur ridiculus mus. Sed consectetur est.</p>
<h6>H6. This is very small header.</h6>
<p>Donec id elit non mi porta gravida at eget metus. Curabitur blandit tempus porttitor.</p>"

	);


	public function getCMSFields(){
		$f = parent::getCMSFields();
		$parent = $this->getParent();
		$f->addFieldToTab("Root.Main", new CheckboxField("HideDefaultPageTitle", "Hide default (cursive) page header", "Content"));

		if((isset($parent)) && ($parent->ClassName == "FeaturePage")){
			$f->removeByName("Content");
			$f->addFieldToTab("Root.Main", new UploadField("PreviewImage", "Preview Image (361 x 215 pixels) (if under a Feature Page)"));
			$f->addFieldToTab("Root.Main", new HTMLEditorField("Content"));
		}

		$gridFieldConfig = GridFieldConfig_RelationEditor::create();
		$gridFieldConfig->addComponent(new GridFieldManyRelationHandler(), 'GridFieldPaginator');
		$row = "SortOrder";
		$gridFieldConfig->addComponent($sort = new GridFieldSortableRows(stripslashes($row))); 
		
		$sort->table = 'Page_SidebarItems'; 
		$sort->parentField = 'PageID'; 
		$sort->componentField = 'SidebarItemID'; 

		$gridField = new GridField("SidebarItems", "Sidebar Items", $this->SidebarItems(), $gridFieldConfig);
		$f->addFieldToTab("Root.Sidebar", new LabelField("SidebarLabel", "<h2>Add sidebar items below</h2>"));
		$f->addFieldToTab("Root.Sidebar", $gridField); // add the grid field to a tab in the CMS

		return $f;
	}


    public function SidebarItems() {
        return $this->getManyManyComponents('SidebarItems')/*
### @@@@ UPGRADE REQUIRED @@@@ ###
FIND: ->sort(
NOTE: ArrayList and DataList sort method no longer modifies current list; only returns a new version. 
### @@@@ ########### @@@@ ###
*/->sort('SortOrder');
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
	private static $allowed_actions = array (
	);

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
	}
	
  public function Events(){
    $events = $this->RSSDisplay(3, 'http://afterclass.uiowa.edu/events/categoriesrss/Center%20for%20Student%20Involvement%20and%20Leadership');
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