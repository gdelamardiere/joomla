<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2013 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

defined('_JEXEC') or die('Restricted access');
defined('JPATH_BASE') or die();

if(!defined('DS')) {
   define('DS', DIRECTORY_SEPARATOR);
}

// includes
require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphauserpoints'.DS.'assets'.DS.'includes'.DS.'version.php');
require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphauserpoints'.DS.'assets'.DS.'includes'.DS.'functions.php');

?>
<h1>AlphaUserPoints Installation <?php echo _ALPHAUSERPOINTS_NUM_VERSION ; ?></h1>
<table width="100%" border="0">
<!--<tr>
  <td><img src="components/com_alphauserpoints/assets/images/aup_logo.png" alt=""/></td>
</tr>-->
<?php

$app = JFactory::getApplication();

$error = 0;

$cache =  JFactory::getCache();
$cache->clean( null, 'com_alphauserpoints' );

$db	= JFactory::getDBO();
$uninstall_status = array();
class Status {
	var $STATUS_FAIL = 'Failed';
	var $STATUS_SUCCESS = 'Success';
	var $infomsg = array();
	var $errmsg = array();
	var $status;
}

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');


/************************************************************************
 *
 *                              START INSTALL
 *
 *************************************************************************/
$install = "";

// copy example of Joomla plugin for AlphaUserPoints
$pathPluginsAUP = JPATH_SITE.DS.'plugins'.DS.'alphauserpoints';
if (!JFolder::exists($pathPluginsAUP)) JFolder::create($pathPluginsAUP);
$src = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphauserpoints'.DS.'install'.DS.'plugins'.DS.'example';
$dest = $pathPluginsAUP . DS . 'example';
JFolder::copy($src, $dest, '', true);

// Disabled old module mod_aupadmin
$query = "SELECT id FROM #__modules WHERE module='mod_aupadmin' AND published='1'";
$db->setQuery( $query );
$idmodule = $db->LoadResult();
if ($idmodule)
{	
	$query = "UPDATE #__modules SET published='0' WHERE `module`='mod_aupadmin'";
	$db->setQuery( $query );
	$db->query();	
}

// Install plugins
$plugin_installer = new JInstaller;
$file_origin = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphauserpoints'.DS.'install'.DS.'plugins'.DS.'alphauserpointsicon';
if( $plugin_installer->install($file_origin) ) {
	// publish plugin
	$query = "UPDATE #__extensions SET enabled='1' WHERE `element`='alphauserpointsicon' AND `type`='plugin'";
	$db->setQuery( $query );
	$db->query();
	$install .= '<img src="components/com_alphauserpoints/assets/images/icon-16-allow.png" alt="" align="absmiddle" /> Installing AlphaUserPoints Quick Icon <b>Button</b><br/>';
}  else $error++;

$plugin_installer = new JInstaller;
$file_origin = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphauserpoints'.DS.'install'.DS.'plugins'.DS.'alphauserpoints';
if( $plugin_installer->install($file_origin) ) {
	// publish plugin
	$query = "UPDATE #__extensions SET enabled='1' WHERE `element`='alphauserpoints' AND `type`='plugin' AND folder='system'";
	$db->setQuery( $query );
	$db->query();
	$install .= '<img src="components/com_alphauserpoints/assets/images/icon-16-allow.png" alt="" align="absmiddle" /> Installing AlphaUserPoints <b>System</b> Plugin <br/>';
}  else $error++;


$plugin_installer = new JInstaller;
$file_origin = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphauserpoints'.DS.'install'.DS.'plugins'.DS.'sysplgaup_newregistered';
if($plugin_installer->install($file_origin)) {
	// publish plugin
	$query = "UPDATE #__extensions SET enabled='1', ordering='999' WHERE element='sysplgaup_newregistered' AND `type`='plugin' AND folder='user'";
	$db->setQuery( $query );
	$db->query();
	$install .= '<img src="components/com_alphauserpoints/assets/images/icon-16-allow.png" alt="" align="absmiddle" /> Installing AlphaUserPoints Registering <b>User</b> Plugin <br/>';
} else $error++;

$plugin_installer = new JInstaller;
$file_origin = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphauserpoints'.DS.'install'.DS.'plugins'.DS.'sysplgaup_raffle';
if($plugin_installer->install($file_origin)) {
	// publish plugin
	$query = "UPDATE #__extensions SET enabled='1' WHERE element='sysplgaup_raffle' AND `type`='plugin' AND folder='content'";
	$db->setQuery( $query );
	$db->query();
	$install .= '<img src="components/com_alphauserpoints/assets/images/icon-16-allow.png" alt="" align="absmiddle" /> Installing AlphaUserPoints Raffle <b>Content</b> Plugin <br/>';
} else $error++;

$plugin_installer = new JInstaller;
$file_origin = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphauserpoints'.DS.'install'.DS.'plugins'.DS.'sysplgaup_reader2author';
if($plugin_installer->install($file_origin)) {
	// publish plugin
	$query = "UPDATE #__extensions SET enabled='1' WHERE element='sysplgaup_reader2author' AND `type`='plugin' AND folder='content'";
	$db->setQuery( $query );
	$db->query();
	$install .= '<img src="components/com_alphauserpoints/assets/images/icon-16-allow.png" alt=""  align="absmiddle" /> Installing AlphaUserPoints Reader to Author <b>Content</b> Plugin <br/>';
} else $error++;


$plugin_installer = new JInstaller;
$file_origin = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphauserpoints'.DS.'install'.DS.'plugins'.DS.'sysplgaup_content';
if($plugin_installer->install($file_origin)) {
	// publish plugin
	$query = "UPDATE #__extensions SET enabled='1' WHERE element='sysplgaup_content' AND `type`='plugin' AND folder='content'";
	$db->setQuery( $query );
	$db->query();
	$install .= '<img src="components/com_alphauserpoints/assets/images/icon-16-allow.png" alt="" align="absmiddle" /> Installing AlphaUserPoints system <b>Content</b> Plugin <br/>';
} else $error++;


$plugin_installer = new JInstaller;
$file_origin = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphauserpoints'.DS.'install'.DS.'plugins'.DS.'plg_editors-xtd_raffle';
if($plugin_installer->install($file_origin)) {
	// publish plugin
	$query = "UPDATE #__extensions SET enabled='1' WHERE element='raffle' AND `type`='plugin' AND folder='editors-xtd'";
	$db->setQuery( $query );
	$db->query();
	$install .= '<img src="components/com_alphauserpoints/assets/images/icon-16-allow.png" alt="" align="absmiddle"/> Installing AlphaUserPoints Raffle Editor Button <b>Editor</b> Plugin <br/>';
} else $error++;

if ( $error ) {
	$app->redirect( 'index.php?option=com_alphauserpoints','NOTICE: AlphaUserPoints plugins are not successfully installed. Make sure that the plugins directory is writeable' );
} else {

	// Insert rules and Guest user on fresh install
	$query = "SELECT id FROM #__alpha_userpoints WHERE `userid`='0' AND `referreid`='GUEST'";
	$db->setQuery( $query );
	$result = $db->loadResult();
	if ( !$result ) {
		// This GUEST user is used by AUP system, don't remove!
		$query = "INSERT INTO #__alpha_userpoints (`id`, `userid`, `referreid`, `points`, `max_points`, `last_update`, `referraluser`, `referrees`, `blocked`, `levelrank`) VALUES ('', '0', 'GUEST', '0', '0', '0000-00-00 00:00:00', '', '0', '0', '0');";
		$db->setQuery( $query );
		$db->query();
	}
	
	$query = "SELECT count(*) FROM #__alpha_userpoints_rules";
	$db->setQuery( $query );
	$result = $db->loadResult();
	if ( !$result ) {		
		// Insert default rules on fresh install
		$query = "INSERT INTO #__alpha_userpoints_rules (`id`, `rule_name`, `rule_description`, `rule_plugin`, `plugin_function`, `access`, `component`, `calltask`, `taskid`, `points`, `points2`, `percentage`, `rule_expire`, `sections`, `categories`, `content_items`, `exclude_items`, `published`, `system`, `duplicate`, `blockcopy`, `autoapproved`, `fixedpoints`, `category`, `displaymsg`, `msg`, `method`, `notification`, `emailsubject`, `emailbody`, `emailformat`, `bcc2admin`, `type_expire_date`) VALUES
			('', 'AUP_NEWUSER', 'AUP_NEWUSERDESCRIPTION', 'AUP_SYSTEM', 'sysplgaup_newregistered', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 1, 1, 0, 1, 1, 1, 'us', '0', '', '1', '0', '', '', '0', '0', '0'),
			('', 'AUP_INVITE', 'AUP_INVITE_A_USER', 'AUP_SYSTEM', 'sysplgaup_invite', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 1, 0, 1, 1, 1, 're', '1', '', '4', '0', '', '', '0', '0', '0'),
			('', 'AUP_INVITESUCCES', 'AUP_INVITE_A_USERSUCCESS', 'AUP_SYSTEM', 'sysplgaup_invitewithsuccess', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 1, 0, 1, 1, 1, 're', '0', '', '4', '0', '', '', '0', '0', '0'),
			('', 'AUP_READTOAUTHOR', 'AUP_READTOAUTHORDESCRIPTION', 'AUP_SYSTEM', 'sysplgaup_reader2author', '0', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 1, 0, 1, 1, 1, 'ar', '1', '', '4', '0', '', '', '0', '0', '0'),
			('', 'AUP_REFERRALPOINTS', 'AUP_REFERRALPOINTSDESCRIPTION', 'AUP_SYSTEM', 'sysplgaup_referralpoints', '1', '', '', '', 0, 0, 1, '0000-00-00 00:00:00', '', '', '', '', 0, 1, 0, 1, 1, 1, 'co', '0', '', '4', '0', '', '', '0', '0', '0'),
			('', 'AUP_BONUSPOINTS', 'AUP_BONUSPOINTSDESCRIPTION', 'AUP_SYSTEM', 'sysplgaup_bonuspoints', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 1, 0, 1, 1, 1, 'ot', '0', '', '4', '0', '', '', '0', '0', '0'),
			('', 'AUP_WINNERNOTIFICATION', 'AUP_WINNERNOTIFICATIONDESCRIPTION', 'AUP_SYSTEM', 'sysplgaup_winnernotification', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 1, 0, 1, 1, 0, 'sy', '0', '', '4', '0', '', '', '0', '0', '0'),
			('', 'AUP_COUPON_POINTS_CODES', 'AUP_COUPON_POINTS_CODES_DESCRIPTION', 'AUP_SYSTEM', 'sysplgaup_couponpointscodes', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 1, 0, 1, 1, 0, 'cd', '1', '', '4', '0', '', '', '0', '0', '0'),			
			('', 'AUP_RAFFLE', 'AUP_RAFFLE_DESCRIPTION', 'AUP_SYSTEM', 'sysplgaup_raffle', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 1, 0, 1, 1, 0, 'ot', '1', '', '4', '0', '', '', '0', '0', '0'),
			('', 'AUP_CUSTOM', 'AUP_CUSTOM_DESCRIPTION', 'AUP_SYSTEM', 'sysplgaup_custom', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 1, 0, 0, 1, 0, 'ot', '1', '', '4', '0', '', '', '0', '0', '0'),
			('', 'AUP_UPLOADAVATAR', 'AUP_UPLOADAVATAR_DESCRIPTION', 'AUP_SYSTEM', 'sysplgaup_uploadavatar', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 1, 0, 1, 1, 1, 'us', '1', '', '1', '0', '', '', '0', '0', '0'),
			('', 'AUP_PROFILECOMPLETE', 'AUP_PROFILECOMPLETE_DESCRIPTION', 'AUP_SYSTEM', 'sysplgaup_profilecomplete', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 1, 0, 1, 1, 1, 'us', '1', '', '1', '0', '', '', '0', '0', '0'),
			('', 'AUP_PROFILE_VIEW', 'AUP_PROFILE_VIEW_DESCRIPTION', 'AUP_SYSTEM', 'sysplgaup_profile_view', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 1, 0, 1, 1, 1, 'co', '1', '', '1', '0', '', '', '0', '0', '0'),
			('', 'AUP_CHANGE_LEVEL_1', 'AUP_CHANGE_LEVEL_DESCRIPTION', 'AUP_SYSTEM', 'sysplgaup_changelevel1', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 1, 0, 1, 1, 1, 'us', '0', '', '4', '0', '', '', '0', '0', '0'),
			('', 'AUP_CHANGE_LEVEL_2', 'AUP_CHANGE_LEVEL_DESCRIPTION', 'AUP_SYSTEM', 'sysplgaup_changelevel2', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 1, 0, 1, 1, 1, 'us', '0', '', '4', '0', '', '', '0', '0', '0'),
			('', 'AUP_CHANGE_LEVEL_3', 'AUP_CHANGE_LEVEL_DESCRIPTION', 'AUP_SYSTEM', 'sysplgaup_changelevel3', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 1, 0, 1, 1, 1, 'us', '0', '', '4', '0', '', '', '0', '0', '0'),			
			('', 'AUP_COMBINED_ACTIVITIES', 'AUP_COMBINE_ACTIVITIES_DESCRIPTION', 'AUP_SYSTEM', 'sysplgaup_archive', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 1, 1, 0, 1, 1, 0, 'sy', '0', '', '4', '0', '', '', '0', '0', '0'),
			('', 'AUP_KU_NEW_TOPIC', 'AUP_KU_NEW_TOPIC_DESCRIPTION', 'AUP_KUNENA_FORUM', 'plgaup_kunena_topic_create', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 1, 'fo', '1', '', '4', '0', '', '', '0', '0', '0'),
			('', 'AUP_KU_REPLY_TOPIC', 'AUP_KU_REPLY_DESCRIPTION', 'AUP_KUNENA_FORUM', 'plgaup_kunena_topic_reply', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 1, 'fo', '1', '', '4', '0', '', '', '0', '0', '0'),
			('', 'AUP_KU_THANKYOU', 'AUP_KU_THANKYOU_DESCRIPTION', 'AUP_KUNENA_FORUM', 'plgaup_kunena_message_thankyou', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 1, 'fo', '1', '', '4', '0', '', '', '0', '0', '0'),
			('', 'AUP_KU_DELETE_POST', 'AUP_KU_DELETE_POST_DESCRIPTION', 'AUP_KUNENA_FORUM', 'plgaup_kunena_message_delete', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 1, 'fo', '1', '', '4', '0', '', '', '0', '0', '0');";

		$db->setQuery( $query );
		if ( $db->query() ) {
			// default
			$install .=  '<img src="components/com_alphauserpoints/assets/images/icon-16-allow.png" alt="" align="absmiddle" /> 17 default rules installed<br/>';
			// Kunena
			$install .=  '<img src="components/com_alphauserpoints/assets/images/icon-16-allow.png" alt="" align="absmiddle" /> 4 default rules for Kunena installed<br/>';
		}
		
		// fresh install 1.6 -> then...
		// update table version
		$query = "INSERT INTO #__alpha_userpoints_version (`version`) VALUES ('AUP160')";
		$db->setQuery( $query );
		$db->query();

	}	
		
	$query = "SELECT COUNT(*) FROM #__alpha_userpoints_levelrank";
	$db->setQuery( $query );
	$nblevelrank = $db->loadResult();
	
	if ( !$nblevelrank ) {
	
		// insert sample ranks and medals on fresh install
		$query = "INSERT INTO `#__alpha_userpoints_levelrank` (`id`, `rank`, `description`, `levelpoints`, `typerank`, `icon`, `image`, `gid`, `category`) VALUES
				('', 'Gold member', 'Gold member', 10000, 0, 'icon_gold.gif', 'gold.gif', 0, 0),
				('', 'Silver member', 'Silver member', 6000, 0, 'icon_silver.gif', 'silver.gif', 0, 0),
				('', 'Bronze member', 'Bronze member', 3000, 0, 'icon_bronze.gif', 'bronze.gif', 0, 0),			
				('', 'Honor Medal 2010', 'Honor Medal 2010 for best activities on this site', 1000, 1, 'award_star_gold.gif', 'award_big_gold.png', 0, 0);";
		$db->setQuery( $query );
		$db->query();
		
		$install .=  '<img src="components/com_alphauserpoints/assets/images/icon-16-allow.png" alt="" align="absmiddle" /> Sample ranks/medals installed<br/>';
		
	}
	
	
	// Upgrade version 1.7.4 -> version 1.8.0
	// -------------------------------------------
	// add new field category for coupon code
	$testcat = "SELECT `category` FROM #__alpha_userpoints_coupons";
	$db->setQuery( $testcat );
	if ( !$db->query() ) {		
		$query = "ALTER TABLE #__alpha_userpoints_coupons ADD `category` INT( 11 ) NOT NULL DEFAULT '1'";
		$db->setQuery( $query );
		$db->query();
		
		// add printable field
		$query = "ALTER TABLE #__alpha_userpoints_coupons ADD `printable` TINYINT( 1 ) NOT NULL DEFAULT '0'";
		$db->setQuery( $query );
		$db->query();
		
		// modify lenght field
		$query =  "ALTER TABLE #__alpha_userpoints_coupons CHANGE `couponcode` `couponcode` VARCHAR( 255 )";
		$db->setQuery( $query );
		$db->query();
		
		$query = "CREATE TABLE IF NOT EXISTS `#__alpha_userpoints_qrcodetrack` (
		  `id` int(11) NOT NULL auto_increment,
		  `couponid` int(11) NOT NULL default '0',
		  `trackid` varchar(30) NOT NULL default '',
		  `trackdate` datetime NOT NULL default '0000-00-00 00:00:00',
		  `country` varchar(50) NOT NULL default '',
		  `city` varchar(50) NOT NULL default '',
		  `device` varchar(30) NOT NULL default '',
		  `ip` varchar(40) NOT NULL default '',
		  `confirmed` tinyint(1) NOT NULL default '0',
		  PRIMARY KEY  (`id`)
		) DEFAULT CHARSET=utf8;";
		$db->setQuery( $query );
		$db->query();
		
		$query = "SELECT extension_id FROM #__extensions WHERE `name`='alphauserpoints' AND `type`='component' AND `element`='com_alphauserpoints' AND `enabled`='1'";
		$db->setQuery( $query );
		$extensionID = $db->loadResult();
		
		$query = "INSERT INTO #__schemas (`extension_id`, `version_id`)"
				. "VALUES ( '".$extensionID."', '1.8.0');";
		$db->setQuery( $query );
		$db->query();
		
		// add new field category for level rank medal
		$query = "ALTER TABLE #__alpha_userpoints_levelrank ADD `category` INT( 11 ) NOT NULL DEFAULT '1'";
		$db->setQuery( $query );
		$db->query();
		
		// add new field category for raffle
		$query = "ALTER TABLE #__alpha_userpoints_raffle ADD `category` INT( 11 ) NOT NULL DEFAULT '1'";
		$db->setQuery( $query );
		$db->query();
		
		$install .= '<img src="components/com_alphauserpoints/assets/images/icon-16-allow.png" alt="" align="absmiddle" /> Migration 1.8.0 successfully<br/>';
	
	}
?>
<tr>
	<td>
	<code>
	<?php echo $install; ?>
	</code><br />		
	</td>
</tr>
<?php
	

	
	/************************************************************************
	 *
	 *                START MIGRATION 1.5.x TO > 1.8.x IF NEEDED
	 *
	 *************************************************************************/
	 // test if JUpgrade used for migration
	$J16 = false;
	$testJ16 = "SELECT id FROM j16_users";	
	@$db->setQuery( $testJ16 );
	if ( @$db->query() ) {
		$J16 =  true;
	}
	
	// directly from J2.5
	$J25 = false;
	$testJ25 = "SELECT id FROM j25_users";	
	@$db->setQuery( $testJ25 );
	if ( @$db->query() ) {
		$J25 =  true;
	}	
	
	$J16details = false;
	$testJ16_details = "SELECT COUNT(*) FROM j16_alpha_userpoints_details";	
	@$db->setQuery( $testJ16_details );
	$result = @$db->loadResult();
	if ( $result ) $J16details = true; // already migrate
	
	$J25details = false;
	$testJ25_details = "SELECT COUNT(*) FROM j25_alpha_userpoints_details";	
	@$db->setQuery( $testJ25_details );
	$result = @$db->loadResult();
	if ( $result ) $J25details = true; // already migrate	

	// check table added in 1.5.12
	$query = "SELECT version FROM jos_alpha_userpoints_version WHERE 1";
	@$db->setQuery( $query );
	$result = @$db->loadResult();
	if ( !$result ) 
	{
		$install = '<img src="components/com_alphauserpoints/assets/images/warning.png" alt="" align="absmiddle" /> INSTALLATION ERROR: You must install first AlphaUserPoints 1.5.13 before install AlphaUserPoints 1.8.x <b>OR</b> uninstall previous AlphaUserPoints 1.6.0 beta version (remove manually all related tables in database)';
	} 
	elseif ( (version_compare($result, '1.5.13', '==') && $J16 && !$J16details) || (version_compare($result, '1.5.13', '==') && $J25 && !$J25details) )
	{

		JHTML::_('behavior.mootools');
						
		$scriptMigration = "<script type=\"text/javascript\">
						window.addEvent('domready', function(){
						$('idrpcmigrate').addEvent('click', function(e){	
							// stop the default link event
							// new Event(e).stop();	
							var waiting	 = '<img src=\"".JURI::base(true)."/components/com_alphauserpoints/assets/images/working.gif\" alt=\"\" align=\"absmiddle\" />&nbsp;&nbsp;&nbsp;Migration process in progress, do not interrupt...';	
							$('migration').set('html', waiting);		
							var url = '".JURI::base(true)."/components/com_alphauserpoints/install/migration_1.5.x.php';
							var myAjax = new Request({
									url:url,
									method: 'get',						
									onComplete: function(responseText) {
										$('migration').set('html', responseText);
									}
								});
						myAjax.send();
						});
						});
						</script>";

						
		echo $scriptMigration;
		
		$link = 'javascript:;';
		echo '<tr><td bgcolor="#EFEFEF"><code><div id="cpanel"><div id="migration" align="left">';
		echo '<p><b>Old version 1.5.13 detected after migration with JUpgrade.<br/>You can import all profiles members with activities and preserve all points for each member. Raffles, medals and ranks are\'nt saved</b></p>';
		aup_createIconPanel($link, 'icon-48-migration.png', JText::_('Import now!'), '', 'id="idrpcmigrate" class="rpcmigrate"');
		echo '</div></div></code></td></tr>';

	}  
	elseif ($result == 'AUP160' || $result >= '1.6.0' )
	{
		// fresh install or update -> update table version
		aup_update_db_version ();		
	}	
	
?>
<tr>
	<td>
<?php aup_CopySite ('left'); ?><br />
	</td>
</tr>
</table>
<?php } ?>