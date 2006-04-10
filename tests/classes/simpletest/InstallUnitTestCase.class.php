<?php
/**
 * The unit testcase class for install tests.
 */

/**
 * The DB class for the internal DB object.
 */
require_once( dirname(__FILE__).'/DbUnitTestCase.class.php' );


global $install_subdir, $basepath;

require_once $basepath.$install_subdir.'_functions_install.php';
require_once $basepath.$install_subdir.'_functions_evoupgrade.php';
require_once $inc_path.'_misc/_upgrade.funcs.php';


/**
 * The base class for all /install tests.
 */
class InstallUnitTestCase extends DbUnitTestCase
{
	/**
	 * Number of basic plugins to test for being installed.
	 */
	var $nr_of_basic_plugins = 7;


	/**
	 * General after-install checks.
	 */
	function tearDown()
	{
		// Test if item types (which get installed for Phoenix-Alpha) are present:
		$this->assertEqual(
			$this->test_DB->get_col( 'SELECT ptyp_name FROM T_itemtypes' ), array('Post', 'Link') );

		parent::tearDown();
	}
}

?>
