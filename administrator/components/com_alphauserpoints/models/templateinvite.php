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

class alphauserpointsModelTemplateinvite extends Jmodel {

	function __construct(){
		parent::__construct();
	}
	
	function _load_templateinvite() {
	
		$app = JFactory::getApplication();
		
		$db			    = JFactory::getDBO();
		
		$total 			= 0;
		
		// Get the pagination request variables
		$limit = $app->getUserStateFromRequest('com_alphauserpoints.limit', 'limit', $app->getCfg('list_limit'), 'int');
		$limitstart = JRequest::getVar('limitstart', 0, '', 'int');
		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ( $limit != 0 ? (floor( $limitstart / $limit ) * $limit) : 0);
	
		
		$query = "SELECT * FROM #__alpha_userpoints_template_invite";
		$total = @$this->_getListCount($query);
		$result = $this->_getList($query, $limitstart, $limit);
		
		return array($result, $total, $limit, $limitstart);
	
	}	
	
	function _edit_templateinvite() {
	
		$db     = JFactory::getDBO();

		$cid 	= JRequest::getVar('cid', array(0));
		$option = JRequest::getVar('option');
		
		if (!is_array( $cid )) {
			$cid = array(0);
		}

		$lists = array();

		$row = JTable::getInstance('template_invite');
		$row->load( $cid[0] );
		
		
		
		return $row;
	
	}	
	
	function _delete_templateinvite() {
	
		$app = JFactory::getApplication();

		// initialize variables
		$db			= JFactory::getDBO();
		$cid		= JRequest::getVar('cid', array(), 'post', 'array');
		$msgType	= '';
		
		JArrayHelper::toInteger($cid);
		
		if (count($cid)) {		
			
			// are there one or more rows to delete?
			/*
			if (count($cid) == 1) {
				$row = JTable::getInstance('template_invite');
				$row->load($cid[0]);
			} else {
				$msg = JText::sprintf('AUP_MSGSUCCESSFULLYDELETED', JText::_('AUP_RULES'), '');
			}
			*/
		
			$query = "DELETE FROM #__alpha_userpoints_template_invite"
					. "\n WHERE (`id` = " . implode(' OR `id` = ', $cid) . ")"
					;
			$db->setQuery($query);
			
			if (!$db->query()) {
				$msg = $db->getErrorMsg();
				$msgType = 'error';
			}

		}

		$app->redirect('index.php?option=com_alphauserpoints&task=templateinvite', $msg, $msgType);
		
	}
	
	function _save_templateinvite() {
		$app = JFactory::getApplication();

		// initialize variables
		$db = JFactory::getDBO();
		$post	= JRequest::get( 'post' );
		$post['emailbody'] = JRequest::getVar( 'emailbody', '', 'post', 'string', JREQUEST_ALLOWHTML );
		$row = JTable::getInstance('template_invite');
		
		if (!$row->bind( $post )) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		
		if (!$row->store()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}

		$msg = JText::_( 'AUP_TEMPLATESAVED' );
		$app->redirect( 'index.php?option=com_alphauserpoints&task=templateinvite', $msg );
	}
	

}
?>