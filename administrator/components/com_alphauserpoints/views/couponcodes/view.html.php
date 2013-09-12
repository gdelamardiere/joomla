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

class alphauserpointsViewCouponcodes extends JView {

	function _displaylist($tpl = null) {

		$document	=  JFactory::getDocument();
		//$document->addStyleDeclaration( ".icon-32-qrcode-stats {background-image: url(components/com_alphauserpoints/assets/images/icon-32-qrcode-stats.png);}", "text/css" );	
		
		JToolBarHelper::title(   JText::_( 'AUP_COUPON_CODES' ), 'thememanager' );
		
		getCpanelToolbar();
		
		JToolBarHelper::editList( 'editcoupon' );
		JToolBarHelper::addNew( 'editcoupon' );
		JToolBarHelper::custom( 'deletecoupon', 'delete.png', 'delete.png', JText::_('AUP_DELETE') );
		JToolBarHelper::divider();
		//JToolBarHelper::custom( 'qrcodestats', 'qrcode-stats.png', 'qrcode-stats.png', JText::_('AUP_QRCODE'), false );
		$bar =  JToolBar::getInstance('toolbar');
		$bar->appendButton( 'Popup', 'upload', JText::_('AUP_GENERATOR'), 'index.php?option=com_alphauserpoints&task=coupongenerator&layout=modal&tmpl=component', 800, 560, 0, 0, 'window.top.location.reload(true);document.location.reload(true);' );
		JToolBarHelper::custom( 'exportcoupons', 'export.png', 'export.png', JText::_('AUP_EXPORT'), false );		
		
		getPrefHelpToolbar();
		
		isIE();
		
		$this->assignRef( 'couponcodes', $this->couponcodes );
		$this->assignRef( 'lists', $this->lists );
	
		$pagination = new JPagination( $this->total, $this->limitstart, $this->limit );		
		$this->assignRef( 'pagination', $pagination );
		
		parent::display( $tpl) ;
	}
	
	function _edit_coupon($tpl = null) {
		
		$document	= & JFactory::getDocument();
		
		JRequest::setVar( 'hidemainmenu', 1 );
		
		JToolBarHelper::title(   JText::_( 'AUP_COUPON_CODES' ), 'thememanager' );
		getCpanelToolbar();
		
		if ( $this->row->printable ) {
			$bar =  JToolBar::getInstance('toolbar');
			$bar->appendButton( 'Popup', 'print', JText::_('AUP_PRINT'), 'index.php?option=com_alphauserpoints&task=printcoupon&id='.$this->row->id.'&layout=modal&tmpl=component', 740, 480, 0, 0 );
			JToolBarHelper::divider();
		}
			
		JToolBarHelper::save( 'savecoupon' );
		JToolBarHelper::cancel( 'cancelcoupon' );
		getPrefHelpToolbar();				
  		JHTML::_('behavior.mootools');
		JHTML::_('behavior.calendar');
		$document->addScriptDeclaration("window.addEvent('domready', function(){ var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); });");
		
		$this->assignRef( 'row', $this->row );
		$this->assignRef( 'lists', $this->lists );
		
		parent::display( "form" ) ;
	}
	
	function _displayQRcodestats ($tpl = null) {
	
		$document	=  JFactory::getDocument();
		
		JToolBarHelper::title(   JText::_( 'AUP_QRCODE' ), 'thememanager' );
		
		getCpanelToolbar();
		JToolBarHelper::back();
		getPrefHelpToolbar();
		
		$this->assignRef( 'qrcodestats', $this->qrcodestats );
		$this->assignRef( 'id', $this->id );
	
		$pagination = new JPagination( $this->total, $this->limitstart, $this->limit );
		$this->assignRef( 'pagination', $pagination );
		
		parent::display( 'qrstats') ;
	}
	
	function _generate_coupon($tpl = null) {
		
		$document	= & JFactory::getDocument();
  		JHTML::_('behavior.mootools');
		JHTML::_('behavior.calendar');
		
		$this->assignRef( 'lists', $this->lists );
		
		parent::display( "generator" ) ;
	}
	
	
	function _print_coupon($tpl = null) {
		
		$document	= & JFactory::getDocument();
		$document->addStyleSheet(JURI::base().'components/com_alphauserpoints/assets/css/print_coupon.css');
		
  		JHTML::_('behavior.mootools');
		
		$this->assignRef( 'couponcode', $this->couponcode );
		$this->assignRef( 'points', $this->points );
		$this->assignRef( 'sitename', $this->sitename );
		
		parent::display( "print" );
	}
	
	
}
?>
