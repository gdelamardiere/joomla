<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2012 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

class alphauserpointsModelExports extends Jmodel {
	
	function __construct(){
		parent::__construct();
	}
	

	function _export_most_active_users() 
	{
		
		$db = JFactory::getDBO();	
		$query = "SELECT a.*, u.id AS iduser, u.name, u.username FROM #__alpha_userpoints AS a, #__users AS u WHERE u.id = a.userid ORDER BY a.points DESC, u.name ASC";
		$result = $this->_getList($query, 0, 50);
		
		return $result;
		
	}	
	
	function _export_emails() 
	{
	
		$db = JFactory::getDBO();	
		$query = "SELECT datareference FROM #__alpha_userpoints_details WHERE datareference!=''";
		$db->setQuery( $query );
		$result = $db->loadObjectList();
		
		return $result;
	}	
	
	function _exportallactivitiesuser() 
	{
	
		$db = JFactory::getDBO();	
		$referrerid = JRequest::getVar( 'c2id', '', 'post', 'string' );		
		$query = "SELECT a.*, r.rule_name, r.plugin_function, u.username, g.userid FROM #__alpha_userpoints_details AS a, #__alpha_userpoints_rules as r, #__users AS u, #__alpha_userpoints AS g "
				."\nWHERE a.referreid='$referrerid' AND a.rule=r.id AND a.referreid=g.referreid AND g.userid=u.id "
				."\nORDER BY a.insert_date DESC";
		$db->setQuery( $query );
		$result = $db->loadObjectList();
		
		return $result;
	}
	
	function _exportallactivitiesallusers() 
	{
		
		$db = JFactory::getDBO();	
		$referrerid = JRequest::getVar( 'c2id', '', 'post', 'string' );		
		$query = "SELECT a.*, r.rule_name, r.plugin_function, u.username, g.userid FROM #__alpha_userpoints_details AS a, #__alpha_userpoints_rules as r, #__users AS u, #__alpha_userpoints AS g "
				."\nWHERE a.rule=r.id AND a.referreid=g.referreid AND g.userid=u.id"
				."\nORDER BY a.insert_date DESC";
		$db->setQuery( $query );
		$result = $db->loadObjectList();
		
		return $result;
	}	
	
	function _export_coupons ()
	{	
		$db = JFactory::getDBO();	
		$query = "SELECT * FROM #__alpha_userpoints_coupons";
		$db->setQuery( $query );
		$result = $db->loadObjectList();
				
		return $result;	
	}
	
}
?>