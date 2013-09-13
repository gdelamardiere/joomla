<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 // import Joomla controllerform library
jimport('joomla.application.component.controllerform');

 /**
 * concours Controller
 */

class concoursControllerparticipation_concours extends JControllerForm{
	/**
	 * Method to edit an existing record.
	 *
	 * @param   string  $key     The name of the primary key of the URL variable.
	 * @param   string  $urlVar  The name of the URL variable if different from the primary key
	 * (sometimes required to avoid router collisions).
	 *
	 * @return  boolean  True if access level check and checkout passes, false otherwise.
	 *
	 * @since   11.1
	 */
	protected $view_item = 'participation_concours';
	protected $view_list = 'concours';

	
	
}
