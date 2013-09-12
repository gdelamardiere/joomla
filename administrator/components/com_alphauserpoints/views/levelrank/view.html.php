<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2012 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */


// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );
jimport( 'joomla.html.pagination' );

class alphauserpointsViewLevelrank extends JView {

	function _displaylist($tpl = null) {
		
		$document	=  JFactory::getDocument();		
		
		JToolBarHelper::title(   JText::_( 'AUP_LEVEL_RANK_MEDALS' ), 'levels' );
		getCpanelToolbar();
		JToolBarHelper::editList( 'editlevelrank' );
		JToolBarHelper::addNew( 'editlevelrank' );
		JToolBarHelper::custom( 'deletelevelrank', 'delete.png', 'delete.png', JText::_('AUP_DELETE') );		
		getPrefHelpToolbar();
		$pagination = new JPagination( $this->total, $this->limitstart, $this->limit );		
		
		$this->assignRef( 'pagination', $pagination );
		$this->assignRef( 'levelrank', $this->levelrank );
		$this->assignRef( 'lists',  $this->lists );
		
		parent::display( $tpl) ;
	}
	
	function _edit_levelrank($tpl = null) {
		
		$document	=  JFactory::getDocument();		

		JRequest::setVar( 'hidemainmenu', 1 );
		
		JToolBarHelper::title(   JText::_( 'AUP_LEVEL_RANK_MEDALS' ), 'levels-add' );
		
		getCpanelToolbar();
		JToolBarHelper::save( 'savelevelrank' );
		JToolBarHelper::cancel( 'cancellevelrank' );
		getPrefHelpToolbar();
		
  		JHTML::_('behavior.mootools');
		$document->addScriptDeclaration("window.addEvent('domready', function(){ var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); });");

		$this->assignRef( 'row', $this->row );
		$this->assignRef( 'lists', $this->lists );
		
		parent::display( "form" ) ;
	}
	
	
	function  _displaydetailrank($tpl = null) {

		$document	=  JFactory::getDocument();

		JToolBarHelper::title(   JText::_( 'AUP_AWARDED' ), 'addedit' );
		getCpanelToolbar();
		JToolBarHelper::back();
		getPrefHelpToolbar();
		
		$this->assignRef( 'detailrank', $this->detailrank );
	
		$pagination = new JPagination( $this->total, $this->limitstart, $this->limit );		
		$this->assignRef( 'pagination', $pagination );
		
		parent::display( "listing" );
	}
}
?>
