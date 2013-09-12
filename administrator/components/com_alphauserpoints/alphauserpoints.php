<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2013 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

if(!defined('DS')) {
   define('DS', DIRECTORY_SEPARATOR);
}

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_alphauserpoints')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// include version
require_once (JPATH_COMPONENT.DS.'assets'.DS.'includes'.DS.'version.php');
require_once (JPATH_COMPONENT.DS.'assets'.DS.'includes'.DS.'functions.php');

// Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');

// Create the controller
$controller = new alphauserpointsController();

// Perform the Request task
$controller->execute( JRequest::getVar( 'task', 'cpanel', 'default', 'string' ) );
$controller->redirect();

aup_CopySite();

?>