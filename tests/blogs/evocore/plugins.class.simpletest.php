<?php
/**
 * Tests for the {@link Plugins} class
 */

/**
 * SimpleTest config
 */
require_once( dirname(__FILE__).'/../../config.simpletest.php' );


/**
 * @package tests
 */
class PluginsTestCase extends DbUnitTestCase
{
	function PluginsTestCase()
	{
		$this->DbUnitTestCase( 'Plugins class test' );
	}


	function setUp()
	{
		parent::setUp();

		ob_start();
		$this->create_current_tables( true ); // we need current tables for Plugins to work
		ob_end_clean();

		$this->Plugins = new Plugins();
	}


	function tearDown()
	{
		parent::tearDown();
	}


	function testUninstall()
	{
		$this->assertTrue( $this->Plugins->uninstall( 1 ) );

		$this->assertFalse( $this->Plugins->get_by_ID( 1 ) );
	}


	/**
	 * Test dependencies.
	 */
	function test_dependencies()
	{
		// Should return string, because simpletest_b_plugin is not installed
		$a_Plugin = & $this->Plugins->install( 'simpletests_a_plugin', 'enabled', __FILE__ );
		$this->assertIsA( $a_Plugin, 'string' );

		$b_Plugin = & $this->Plugins->install( 'simpletests_b_plugin', 'enabled', __FILE__ );
		$this->assertIsA( $b_Plugin, 'Plugin' );

		$a_Plugin = & $this->Plugins->install( 'simpletests_a_plugin', 'enabled', __FILE__ );
		$this->assertIsA( $a_Plugin, 'Plugin' );

		// The B plugin should now NOT be able to get disabled
		$dep_msgs = $this->Plugins->validate_dependencies( $b_Plugin, 'disable' );
		$this->assertEqual( array_keys($dep_msgs), array('error') );
		$this->assertEqual( count($dep_msgs['error']), 1 );

		$this->assertTrue( $this->Plugins->uninstall( $a_Plugin->ID ) );

		// The B plugin should now be able to get disabled
		$dep_msgs = $this->Plugins->validate_dependencies( $b_Plugin, 'disable' );
		$this->assertEqual( $dep_msgs, array() );
	}


	/**
	 * Test dependencies.
	 */
	function test_dependencies_api()
	{
		Mock::generatePartial( 'Plugin', 'MockPlugin', array('GetDependencies') );

		// Only major version given (not fulfilled)
		$mock_Plugin = new MockPlugin();
		$mock_Plugin->setReturnValue( 'GetDependencies', array( 'requires' => array( 'api_min' => $this->Plugins->api_version[0]+1 ) ) );
		$dep_msgs = $this->Plugins->validate_dependencies( $mock_Plugin, 'enable' );
		$this->assertEqual( array_keys($dep_msgs), array('error') );
		$this->assertEqual( count($dep_msgs['error']), 1 );


		// Only major version given (fulfilled)
		$mock_Plugin = new MockPlugin();
		$mock_Plugin->setReturnValue( 'GetDependencies', array( 'requires' => array( 'api_min' => $this->Plugins->api_version[0] ) ) );
		$dep_msgs = $this->Plugins->validate_dependencies( $mock_Plugin, 'enable' );
		$this->assertEqual( array_keys($dep_msgs), array() );

	}

}


// TEST plugin classes

/**
 * This is a test plugin, used in the tests.
 *
 * It depends on {@link simpletests_b_plugin}.
 */
class simpletests_a_plugin extends Plugin
{
	function GetDependencies()
	{
		return array(
				'requires' => array(
					'plugins' => array('simpletests_b_plugin')
				)
			);

	}
}


/**
 * This is a test plugin, used in the tests
 */
class simpletests_b_plugin extends Plugin
{
	function GetDependencies()
	{
		return array();
	}
}


if( !isset( $this ) )
{ // Called directly, run the TestCase alone
	$test = new PluginsTestCase();
	$test->run( new HtmlReporter() );
	unset( $test );
}

?>
