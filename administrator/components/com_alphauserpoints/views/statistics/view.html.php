<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2012 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view');
jimport( 'joomla.html.pagination' );

class alphauserpointsViewstatistics extends JView {

	function _displaylist($tpl = null) {	
		
		$document	=  JFactory::getDocument();
		
		$document->addStyleDeclaration( ".icon-32-user-reset {background-image: url(components/com_alphauserpoints/assets/images/icon-32-user-reset.png);}", "text/css" );
	
		JToolBarHelper::title(   JText::_('AUP_USERS'), 'user' );
		getCpanelToolbar();
		JToolBarHelper::editList( 'edituser' );
		JToolBarHelper::custom( 'applybonus', 'new.png', 'new.png', JText::_('AUP_BONUS'), true );
		JToolBarHelper::custom( 'applycustomrule', 'apply.png', 'new.png', JText::_('AUP_CUSTOM_POINTS'), true );
		JToolBarHelper::divider();		
		JToolBarHelper::custom( 'exportallactivitiesallusers', 'export.png', 'export.png', JText::_('AUP_EXPORT_ACTIVITIES'), false );
		JToolBarHelper::custom( 'resetuser', 'user-reset.png', 'user-reset.png', JText::_('AUP_RESET_USER'), true );
		getPrefHelpToolbar();
		
		$this->assignRef( 'usersStats', $this->usersStats );
	
		$pagination = new JPagination( $this->total, $this->limitstart, $this->limit );		
		$this->assignRef('pagination', $pagination );
		$this->assignRef('lists', $this->lists);
		$this->assignRef('ranksexist', $this->ranksexist);
		$this->assignRef('medalsexist', $this->medalsexist);
		$this->assignRef('medalslistuser', $this->medalslistuser);
		$this->assignRef('listmedals', $this->listmedals);
		
		parent::display( $tpl) ;	
		
	}
	
	function _edit_user($tpl = null) {
		
		$document	=  JFactory::getDocument();
		
		JRequest::setVar( 'hidemainmenu', 1 );

		JToolBarHelper::title(   JText::_('AUP_USERS_POINTS') . ': ' . $this->row->name, 'user' );
		getCpanelToolbar();
		JToolBarHelper::save( 'saveuser' );
		JToolBarHelper::cancel( 'canceluser' );
		getPrefHelpToolbar();
			
  		JHTML::_('behavior.mootools');
		JHTML::_('behavior.calendar');
		$document->addScriptDeclaration("window.addEvent('domready', function(){ var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); });");

		$this->assignRef( 'row', $this->row );		
		$this->assignRef( 'listrank', $this->listrank );
		$this->assignRef( 'medalsexist', $this->medalsexist );
	
		parent::display( "form" ) ;
	}
	
}
?>
