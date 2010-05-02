<?php
/**
 * Function for handling Classes in PHP 5.
 *
 * In PHP4, _class4.funcs.php should be used instead.
 *
 * This file is part of the evoCore framework - {@link http://evocore.net/}
 * See also {@link http://sourceforge.net/projects/evocms/}.
 *
 * @copyright (c)2010 by Francois PLANQUE - {@link http://fplanque.net/}
 * Parts of this file are copyright (c)2009 by Daniel HAHLER - {@link http://daniel.hahler.de/}.
 *
 * {@internal License choice
 * - If you have received this file as part of a package, please find the license.txt file in
 *   the same folder or the closest folder above for complete license terms.
 * - If you have received this file individually (e-g: from http://evocms.cvs.sourceforge.net/)
 *   then you must choose one of the following licenses before using the file:
 *   - GNU General Public License 2 (GPL) - http://www.opensource.org/licenses/gpl-license.php
 *   - Mozilla Public License 1.1 (MPL) - http://www.opensource.org/licenses/mozilla1.1.php
 * }}
 *
 * {@internal Open Source relicensing agreement:
 * Daniel HAHLER grants Francois PLANQUE the right to license
 * Daniel HAHLER's contributions to this file and the b2evolution project
 * under any OSI approved OSS license (http://www.opensource.org/licenses/).
 * }}
 *
 * @package evocore
 *
 * @author blueyed: Daniel HAHLER.
 *
 * @version $Id$
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

/**
 * Dynamic list of class mapping.
 *
 * Controllers should call load_class() to register classes they may need to have autoloaded when they use them.
 *
 * @var marray
 */
$map_class_path = array();

/**
 * Autoload the required .class.php file when a class is accessed but not defined yet.
 * This gets hooked into spl_autoload_register (preferred) or called through __autoload.
 * Requires PHP5.
 */
function evocms_autoload_class( $classname )
{
	global $map_class_path;

	$classname = strtolower($classname);
	if( isset($map_class_path[$classname]) )
	{
		require_once $map_class_path[$classname];
	}
}


/*
 * Use spl_autoload_register mechanism, if available (PHP>=5.1.2).
 * This way a stacked set of autoload functions can be used.
 */
if( function_exists('spl_autoload_register') )
{
	// spl_autoload_register( 'var_dump' );
	spl_autoload_register( 'evocms_autoload_class' );
}
else
{
	// PHP<5.1.2: Use the fallback method.
	function __autoload( $classname )
	{
		return evocms_autoload_class($classname);
	}
}


/**
 * In PHP4, this really loads the class. In PHP5, it's smarter than that:
 * It only registers the class & file name so that __autoload() can later
 * load the class IF and ONLY IF the class is actually needed during execution.
 */
function load_class( $class_path, $classname )
{
	global $map_class_path, $inc_path;
	if( !is_null($classname) )
	{
		$map_class_path[strtolower($classname)] = $inc_path.$class_path;
	}
	return true;
}


/**
 * Create a copy of an object (abstraction from PHP4 vs PHP5)
 */
function duplicate( $Obj )
{
	$Copy = clone $Obj;
	return $Copy;
}


/*
 * $Log$
 * Revision 1.31  2010/05/02 19:27:24  fplanque
 * rollback. Not worth the 10 million additional fstats.
 *
 * Revision 1.30  2010/04/28 21:27:21  blueyed
 * doc
 *
 * Revision 1.29  2010/04/28 21:26:15  blueyed
 * Autoloading in PHP5: if source file is not readable, wait for 250-750ms and fire off require_once afterwards.
 *
 * Revision 1.28  2010/02/08 17:51:28  efy-yury
 * copyright 2009 -> 2010
 *
 * Revision 1.27  2009/10/02 13:39:46  tblue246
 * Fixed wrong load_class() calls
 *
 * Revision 1.25  2009/09/18 15:47:11  fplanque
 * doc/cleanup
 *
 * Revision 1.24  2009/09/15 19:31:55  fplanque
 * Attempt to load classes & functions as late as possible, only when needed. Also not loading module specific stuff if a module is disabled (module granularity still needs to be improved)
 * PHP 4 compatible. Even better on PHP 5.
 * I may have broken a few things. Sorry. This is pretty hard to do in one swoop without any glitch.
 * Thanks for fixing or reporting if you spot issues.
 *
 * Revision 1.23  2009/09/14 18:46:41  blueyed
 * fix typo
 *
 * Revision 1.22  2009/09/14 18:37:07  fplanque
 * doc/cleanup/minor
 *
 * Revision 1.21  2009/09/13 22:26:54  blueyed
 * todo/question
 *
 * Revision 1.20  2009/09/03 14:08:04  fplanque
 * automated load_class()
 *
 * Revision 1.19  2009/09/03 10:43:37  efy-maxim
 * Countries tab in Global Settings section
 *
 * Revision 1.18  2009/09/02 06:23:59  efy-maxim
 * Currencies Tab in Global Settings
 *
 * Revision 1.17  2009/08/31 20:35:31  fplanque
 * cleanup
 *
 * Revision 1.16  2009/08/30 00:30:52  fplanque
 * increased modularity
 *
 * Revision 1.15  2009/04/09 22:16:28  tblue246
 * Fixing staticfiles.php and updating static files POT file
 *
 * Revision 1.14  2009/04/08 11:33:55  tblue246
 * Renaming file _zip_archives.class.php back to _zip_archives.php to prevent inclusion into the autogenerated __autoload() list (when it gets regenerated).
 *
 * Revision 1.13  2009/04/07 19:23:43  tblue246
 * Fixing sam2kb's fix. See http://forums.b2evolution.net/viewtopic.php?t=18455
 *
 * Revision 1.12  2009/04/06 20:36:21  sam2kb
 * class zip_archives renamed, see http://forums.b2evolution.net/viewtopic.php?t=18455
 *
 * Revision 1.11  2009/03/31 22:17:55  blueyed
 * evocms_autoload_class: move global assignments to the block where they get used.
 *
 * Revision 1.10  2009/03/23 13:33:21  tblue246
 * Fix fatal errors (PHP5 autoloading). Sigh.
 *
 * Revision 1.9  2009/03/23 09:48:32  yabs
 * minor fix
 *
 * Revision 1.8  2009/03/23 04:09:43  fplanque
 * Best. Evobar. Menu. Ever.
 * menu is now extensible by plugins
 *
 * Revision 1.7  2009/03/17 20:17:54  blueyed
 * Use spl_autoload_register instead of __autoload, if available.
 *
 * Revision 1.6  2009/03/15 21:15:52  tblue246
 * Fix fatal error
 *
 * Revision 1.5  2009/03/08 22:37:29  fplanque
 * doc
 *
 * Revision 1.4  2009/03/06 00:31:04  blueyed
 * Remove require=false use case from class5.funcs, too.
 *
 * Revision 1.3  2009/03/06 00:11:27  blueyed
 * Abstract POFile handling to POFile class completely.
 *  - move gettext/pofile.class.php to blogs/inc/locales
 *  - use it in locales.ctrl
 * _global.php generation:
 *  - use double quotes only when necessary (msgid/msgstr containing e.g. \n),
 *    this speeds up reading the file a lot
 *  - add __meta__ key to trans array, used for versioning, so old files still
 *    get handled (and converted when being read)
 * Not tested for long in CVS HEAD, but works well in whissip for some time
 * already.
 *
 * Revision 1.2  2009/03/05 23:42:43  blueyed
 * Remove todo
 *
 * Revision 1.1  2009/03/05 23:38:53  blueyed
 * Merge autoload branch (lp:~blueyed/b2evolution/autoload) into CVS HEAD.
 *
 */
?>
