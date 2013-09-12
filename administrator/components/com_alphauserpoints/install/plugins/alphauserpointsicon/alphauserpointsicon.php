<?php defined('_JEXEC') or die('Restricted Access');

/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2012 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

class plgQuickiconalphauserpointsicon extends JPlugin
{
	public function onGetIcons($context)
	{
		if (
			$context == $this->params->get('context', 'mod_quickicon')
			&& JFactory::getUser()->authorise('core.manage', 'com_alphauserpoints')
		)
		{
			$db = JFactory::getDBO();
			
			$lang = JFactory::getLanguage();
			
			JPlugin::loadLanguage( 'com_alphauserpoints' );
			$label = JText::_('AUP_USERS_POINTS');
			$label2 = "";
		
			// check if unapproved item
			$query = "SELECT COUNT(*) FROM #__alpha_userpoints_details"
				   . " WHERE approved='0' AND status='0'"
				   ;
			$db->setQuery( $query );
			$result = $db->loadResult();
			
			if ( $result ) $label2 = '<div><span class="small">' . JText::_('AUP_PENDING_APPROVAL') . ' <font color="red">('.$result.')</font></span></div>';
			$image = ($result)? "icon-48-alphauserpoints-warning.png" : "icon-48-alphauserpoints.png";
		
			return array(array(
				'link' => 'index.php?option=com_alphauserpoints',
				'image' => JURI::base().'components/com_alphauserpoints/assets/images/'.$image,
				'text' => $label.$label2,
				'id' => 'plg_quickicon_alphauserpointsicon'
			));
		} else return;
	}
}
