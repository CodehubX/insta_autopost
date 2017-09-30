<?php 
namespace Plugins\SampleModule;

// Disable direct access
if (!defined('APP_VERSION')) 
    die("Yo, what's up?");

/**
 * SampleList model
 */
class SampleListModel extends \DataList
{	
	/**
	 * Initialize
	 */
	public function __construct()
	{
		$this->setQuery(\DB::table(TABLE_PREFIX."sample_table"));
	}
}
