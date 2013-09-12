<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2012 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */
 
define( '_JEXEC', 1 );

/*
define( 'JPATH_BASE', realpath(dirname(__FILE__).'/../../../../..' ));
//define( 'JPATH_BASE', realpath(dirname(__FILE__).'\..\..\..\..\..' ));
define( 'DS', DIRECTORY_SEPARATOR );

require_once ( JPATH_BASE.DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE.DS.'includes'.DS.'framework.php' );
$app = JFactory::getApplication('administrator');
$app ->initialise();
*/

if(!defined('DS')) {
   define('DS', DIRECTORY_SEPARATOR);
}

if (file_exists( dirname( dirname( dirname( dirname(__FILE__)))) .DS. 'defines.php')) {
	include_once dirname( dirname( dirname( dirname(__FILE__)))) .DS. 'defines.php';
}

if (!defined('_JDEFINES')) {
	define('JPATH_BASE', dirname( dirname( dirname( dirname(__FILE__)))));
	require_once JPATH_BASE.'/includes/defines.php';
}

require_once ( JPATH_BASE.DS.'includes'.DS.'framework.php' );
$app = JFactory::getApplication('administrator');
$app->initialise();
$app = JFactory::getApplication();

jimport( 'joomla.plugin.plugin' );
JPlugin::loadLanguage( 'com_alphauserpoints', JPATH_ADMINISTRATOR );

$old_db_prefix = 'jos_';

$install = '<p><b>Result migration process:</b></p><p><code>';

$db = JFactory::getDBO();

if ( !_checkMigration15x() )
{
	$count = '0';
	
	$jnow			= JFactory::getDate();
	$dateCombine	= $jnow->toMySQL();
	
	$testPublished = "SELECT published FROM ".$old_db_prefix."alpha_userpoints";
	$db->setQuery( $testPublished );
	if ( !$db->query() ) {
		$query = "ALTER TABLE ".$old_db_prefix."alpha_userpoints"
				 . " ADD `published` TINYINT(1) NOT NULL DEFAULT '1', "
				 . " ADD `shareinfos` TINYINT(1) NOT NULL DEFAULT '1'"
				 ;
		$db->setQuery( $query );
		$db->query();
	}
	
	// copy old users profile in J16
	$query = "INSERT INTO j16_alpha_userpoints (SELECT ".$old_db_prefix."alpha_userpoints.* FROM ".$old_db_prefix."alpha_userpoints WHERE ".$old_db_prefix."alpha_userpoints.referreid!='GUEST')";
	$db->setQuery( $query );
	if ( $db->query() )
	{			
		/*
		$query = "UPDATE `j16_alpha_userpoints` SET published='1', shareinfos='1'";
		$db->setQuery( $query );
		$db->query();
		*/
		$install .= '<img src="components/com_alphauserpoints/assets/images/icon-16-allow.png" alt="" align="absmiddle" />  All users and profiles are imported.<br/>';
	} else $install .= '<img src="components/com_alphauserpoints/assets/images/warning.png" alt="" align="absmiddle" /><font color="red"> All users and profiles are NOT imported.</font><br/>'; 
	
	// purge expired activities
	$query = "DELETE FROM ".$old_db_prefix."alpha_userpoints_details WHERE `expire_date`!='0000-00-00 00:00:00' AND `expire_date`<='".$dateCombine."'";
	$db->setQuery( $query );		
	if ( $db->query() )
	{			
		$install .= '<img src="components/com_alphauserpoints/assets/images/icon-16-allow.png" alt="" align="absmiddle" />  All expired activities has been removed.<br/>';
	} else $install .= '<img src="components/com_alphauserpoints/assets/images/warning.png" alt="" align="absmiddle" /><font color="red"> All expired activities has NOT been removed.</font><br/>'; 
	
	// create a new combined activity
	$query ="SELECT SUM(points) AS sumAllPoints, referreid FROM ".$old_db_prefix."alpha_userpoints_details WHERE insert_date < '".$dateCombine."' GROUP BY referreid";
	$db->setQuery($query );
	$resultCombined = $db->loadObjectList();
	
	JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphauserpoints'.DS.'tables');
	
	// retreive ID for rule Archive
	$id_archive_rule = _getIdPluginFunction( 'sysplgaup_archive' );
	
	foreach ( $resultCombined as $combined ) 
	{
		if ( $combined->referreid!='' ) 
		{
			$query = "INSERT INTO j16_alpha_userpoints_details (id, referreid, points, insert_date, expire_date,rule,approved,status, keyreference,datareference) VALUES ('', '".$combined->referreid."', '".$combined->sumAllPoints."','".$dateCombine."','','".$id_archive_rule."','1','1','','".sprintf ( JText::_('AUP_COMBINED_ACTIVITIES_BEFORE_DATE'), JHTML::_('date', $dateCombine, JText::_('DATE_FORMAT_LC2')) )."')";
			$db->setQuery( $query );
			$db->query();	
			
			$query = "UPDATE j16_alpha_userpoints SET `points`='" . $combined->sumAllPoints . "', `last_update`='".$dateCombine."' WHERE `referreid`='" . $combined->referreid . "'";
			$db->setQuery( $query );
			$db->query();			
		}
		
	} // end for each
	$install .= '<img src="components/com_alphauserpoints/assets/images/icon-16-allow.png" alt="" align="absmiddle" /> All old activities has been combined from now for all users.<br/>';

} else $install = '<img src="components/com_alphauserpoints/assets/images/warning.png" alt="" align="absmiddle" /><font color="red"> Error on checking migration.</font><br/>';

// fresh install + migration -> update table version
$query = "UPDATE j16_alpha_userpoints_version SET `version`='1.6.0' WHERE 1";
$db->setQuery( $query );
$db->query();

echo $install."</p></code>";


function _checkMigration15x()
{
	$db = JFactory::getDBO();
	
	$query = "SELECT version FROM j16_alpha_userpoints_version WHERE 1";
	$db->setQuery( $query );
	$result = $db->loadResult();
	
	if ( version_compare($result, '1.6.0', '>=') ) 
	{
		return true;
	} else return false;

}

function _getIdPluginFunction( $plugin_function )
{
	$db	   = JFactory::getDBO();
	$query = "SELECT `id` FROM j16_alpha_userpoints_rules WHERE `plugin_function`='$plugin_function'";
	$db->setQuery( $query );
	$plugin_id = $db->loadResult();
	return	$plugin_id;	
}

?>