<?php
/* <Template> */

require_once(dirname(__FILE__).'/../conf/b2evo_config.php');
$title = _('Custom skin template editing');

/*
 * add_magic_quotes(-)
 */
function add_magic_quotes($array) 
{
	foreach ($array as $k => $v) {
		if (is_array($v)) {
			$array[$k] = add_magic_quotes($v);
		} else {
			$array[$k] = addslashes($v);
		}
	}
	return $array;
} 

if (!get_magic_quotes_gpc()) 
{
	$HTTP_GET_VARS    = add_magic_quotes($HTTP_GET_VARS);
	$HTTP_POST_VARS   = add_magic_quotes($HTTP_POST_VARS);
	$HTTP_COOKIE_VARS = add_magic_quotes($HTTP_COOKIE_VARS);
}

$b2varstoreset = array('action','standalone','redirect','profile','error','warning','a','file');
for ($i=0; $i<count($b2varstoreset); $i += 1) 
{
	$b2var = $b2varstoreset[$i];
	if (!isset($$b2var)) {
		if (empty($HTTP_POST_VARS["$b2var"])) {
			if (empty($HTTP_GET_VARS["$b2var"])) {
				$$b2var = '';
			} else {
				$$b2var = $HTTP_GET_VARS["$b2var"];
			}
		} else {
			$$b2var = $HTTP_POST_VARS["$b2var"];
		}
	}
}

switch($action) 
{

case "update":

	$standalone=1;
	require_once(dirname(__FILE__)."/b2header.php");

	if ($user_level < 3) 
	{
		die( _('You have no right to edit the templates.') );
	}

	// Determine the edit folder:
	$edit_folder = get_path().'/skins/custom';

	$newcontent = stripslashes($_POST["newcontent"]);
	$f = fopen( $edit_folder.'/'.$file , "w+" );
	fwrite($f,$newcontent);
	fclose($f);

	header("Location: b2template.php?file=$file&a=te");
	exit();

	break;

default:

	require( dirname(__FILE__).'/b2header.php' );

	if ($user_level <= 3) 
	{
		die( _('You have no right to edit the templates.') );
	}

	// Determine the edit folder:
	$edit_folder = get_path().'/skins/custom';

	$file = trim($file);
	if( !empty($file)) 
	{
		echo '<div class="panelblock">';

		echo _('Listing:'), '<strong>', $edit_folder, '/', $file, '</strong>';

		if( ereg( '([^-A-Za-z0-9._]|\.\.)', $file ) )
		{
			echo '<p>', _('Invalid filename!'), '</p>';
		}
		elseif( !is_file($edit_folder.'/'.$file) )
		{
				echo '<p>', _('Oops, no such file !'), '</p>';
		}
		else
		{	
		
			$f = fopen( $edit_folder.'/'.$file, 'r');
			$content = fread($f,filesize($edit_folder.'/'.$file));
			//	$content = template_simplify($content);
			$content = htmlspecialchars($content);
			//	$content = str_replace("</textarea","&lt;/textarea",$content);

			if ($a == 'te')	echo '<em> [ ', _('File edited!'), ' ]</em>';
			
			if (!$error) {
			?>
			<p><?php echo _('Be careful what you do, editing this file could break your template! Do not edit what\'s between <code>&lt;?php</code> and <code>?&gt;</code> if you don\'t know what you\'re doing!') ?></p>
			<form name="template" action="b2template.php" method="post">
				<textarea cols="80" rows="20" style="width:100%" name="newcontent" tabindex="1"><?php echo $content ?></textarea>
				<input type="hidden" name="action" value="update" />
				<input type="hidden" name="file" value="<?php echo $file ?>" />
				<br />
				<?php
				if( is_writable($edit_folder.'/'.$file) ) 
				{
					echo '<input type="submit" name="submit" class="search" value="', _('update template !'), '" tabindex="2" />';
				}
				else
				{
					echo '<input type="button" name="oops" class="search" value="', _('(you cannot update that file/template: must make it writable, e.g. CHMOD 766)'), '" tabindex="2" />';
				}
				?>
			</form>
			<?php
			} 
		}
		echo "</div>\n";
	}
?>

	<div class="panelblock">
	<p><?php echo _('This screen allows you to edit the <strong>custom skin</strong> (located under /skins/custom).') ?></p>
	<p><?php echo _('You can edit any of the following files (provided it\'s writable by the server, e.g. CHMOD 766)') ?>:</p>
	<ul>
<?php
	// Determine the edit folder:
	if( empty($edit_folder) ) $edit_folder = get_path().'/skins/custom';
	//lists all files in edit directory
	$this_dir = dir( $edit_folder );
	while ($this_file = $this_dir->read()) 
	{
		if( is_file($edit_folder.'/'.$this_file) )
		{
			?>
			<li><a href="b2template.php?file=<?php echo $this_file; ?>"><?php echo $this_file; ?></a>
			<?php 
			switch( $this_file )
			{
				case '_archives.php':
					echo '- ', _('This is the template that displays the links to the archives for a blog');
					break;
				case '_categories.php':
					echo '- ', _('This is the template that displays the (recursive) list of (sub)categories');
					break;
				case '_feedback.php':
					echo '- ', _('This is the template that displays the feedback for a post');
					break;
				case '_lastcomments.php':
					echo '- ', _('This is the template that displays the last comments for a blog');
					break;
				case '_main.php':
					echo '- ', _('This is the main template. It displays the blog.');
					break;
				case '_stats.php':
					echo '- ', _('This is the template that displays stats for a blog');
					break;
				case 'comment_popup.php':
					echo '- ', _('This is the page displayed in the comment popup');
					break;
				case 'pingback_popup.php':
					echo '- ', _('This is the page displayed in the pingback popup');
					break;
				case 'trackback_popup.php':
					echo '- ', _('This is the page displayed in the trackback popup');
					break;
			}
		?>	
			</li>
		<?php }
	}
?>
</ul>

<p>	<?php echo _('Note: of course, you can also edit the files/templates in your text editor and upload them. This online editor is only meant to be used when you don\'t have access to a text editor...') ?>
</p>	
	
	</div>

	<?php

break;
}

/* </Template> */
require( dirname(__FILE__).'/_footer.php' ); 
 ?>