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

class alphauserpointsViewUser extends JView {

	function _displaylist($tpl = null) {
		
		$document	=  JFactory::getDocument();
		
		JToolBarHelper::title(   JText::_( 'AUP_ACTIVITY' ) . ': ' . $this->name , 'searchtext' );
		getCpanelToolbar();
		JToolBarHelper::back( 'Back' );
		JToolBarHelper::divider();
		JToolBarHelper::editList( 'edituserdetails' );
		JToolBarHelper::custom( 'deleteuserdetails', 'trash.png', 'delete.png', JText::_('AUP_DELETE') );
		JToolBarHelper::custom( 'deleteuserallactivities', 'delete.png', 'delete.png', JText::_('AUP_DELETE_ALL'), false );
		JToolBarHelper::divider();
		JToolBarHelper::custom( 'exportallactivitiesuser', 'export.png', 'export.png', JText::_('AUP_EXPORT_ACTIVITIES'), false );
		JToolBarHelper::divider();
		$bar =  JToolBar::getInstance('toolbar');
		$bar->appendButton( 'Popup', 'apply', JText::_('AUP_CUSTOM_POINTS'), 'index.php?option=com_alphauserpoints&task=applycustom&layout=modal&tmpl=component&cid='.$this->cid.'&name='.$this->name, 800, 560, 0, 0, 'window.top.location.reload(true);document.location.reload(true);' );
		getPrefHelpToolbar();	
		
		$this->assignRef( 'userDetails', $this->userDetails );
	
		$pagination = new JPagination( $this->total, $this->limitstart, $this->limit );		
		$this->assignRef('pagination', $pagination );
		
		$this->assignRef('name', $this->name );
		
		parent::display( $tpl) ;
	}
	
	function _edit_pointsDetails () {
		
		$document	=  JFactory::getDocument();
		
		JRequest::setVar( 'hidemainmenu', 1 );
		
		JToolBarHelper::title(   JText::_( 'AUP_ACTIVITY' ) . ': ' . $this->name, 'addedit' );
		getCpanelToolbar();
		JToolBarHelper::save( 'saveuserdetails' );
		JToolBarHelper::cancel( 'canceluserdetails' );
		getPrefHelpToolbar();
		
  		JHTML::_('behavior.mootools');
		JHTML::_('behavior.calendar');
		$document->addScriptDeclaration("window.addEvent('domready', function(){ var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); });");

		$this->assignRef( 'row', $this->row );
		$this->assignRef('name', $this->name );
		$this->assignRef('rulename', $this->rulename );
		$this->assignRef('cid', $this->cid );
		
		parent::display( "form" ) ;
	
	}
}
?>