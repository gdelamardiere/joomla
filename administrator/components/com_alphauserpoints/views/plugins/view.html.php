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

class alphauserpointsViewPlugins extends JView {

	function show($tpl = null) {
	
		JToolBarHelper::title( JText::_( 'AUP_PLUGINS' ), 'plugin' );

		JToolBarHelper::back();
		
		getPrefHelpToolbar();		
		
		parent::display( $tpl) ;		
	}
}
?>
