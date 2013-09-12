<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2012 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

Jimport( 'joomla.application.component.view');

class alphauserpointsViewArchive extends JView {

	function show($tpl = null) {
		
		$document	=  JFactory::getDocument();
		
		JRequest::setVar( 'hidemainmenu', 1 );
		
		JToolBarHelper::title(  JText::_('AUP_COMBINE_ACTIVITIES'), 'install' );
		
		getCpanelToolbar();

		JToolBarHelper::back();
		
		getPrefHelpToolbar();
		
  		JHTML::_('behavior.mootools');		
		$document->addScriptDeclaration("window.addEvent('domready', function(){ var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); });");
		
		parent::display( $tpl);
		
	}
}
?>
