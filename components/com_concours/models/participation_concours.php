<?php

/**
 * @version		$Id: hello.php 15 2009-11-02 18:37:15Z chdemko $
 * @package		Joomla16.Tutorials
 * @subpackage	Components
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @author		Christophe Demko
 * @link		http://joomlacode.org/gf/project/helloworld_1_6/
 * @license		License GNU General Public License version 2 or later
 */




//table comprofiler






// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modelform');

/**
 * HelloWorld Model
 */
class concoursModelparticipation_concours extends JModelForm
{
	 /**
         * Returns a reference to the a Table object, always creating it.
         *
         * @param       type    The table type to instantiate
         * @param       string  A prefix for the table class name. Optional.
         * @param       array   Configuration array for model. Optional.
         * @return      JTable  A database object
         * @since       2.5
         */
        public function getTable($type = 'concours', $prefix = 'concoursTable', $config = array()) 
        {
                return JTable::getInstance($type, $prefix, $config);
        }
        /**
         * Method to get the record form.
         *
         * @param       array   $data           Data for the form.
         * @param       boolean $loadData       True if the form is to load its own data (default case), false if not.
         * @return      mixed   A JForm object on success, false on failure
         * @since       2.5
         */
        public function getForm($data = array(), $loadData = true) 
        {
                // Get the form.
                $form = $this->loadForm('com_concours.participation_concours', 'participation_concours',
                                        array('control' => 'jform', 'load_data' => $loadData));
                if (empty($form)) 
                {
                        return false;
                }
                return $form;
        }

        /**
         * Method to get the data that should be injected in the form.
         *
         * @return      mixed   The data for the form.
         * @since       2.5
         */
        protected function loadFormData() 
        {
                // Check the session for previously entered form data.
                $data = JFactory::getApplication()->getUserState('com_concours.edit.participation_concours.data', array());
                if (empty($data)) 
                {
                        $data = $this->getItem();
                }
                return $data;
        }

         /**
         * Get the message
         * @return object The message to be displayed to the user
         */
        function &getItem()
        {
 
                if (!isset($this->_item))
                {
                       // $cache = JFactory::getCache('com_concours', '');
                        $user = &JFactory::getUser() ;
						if ( $user->id ){
							$this->_item =$user;
						}
						else{
							die("rer");
						}
                        $id = JRequest::getInt('id');
                       /* $this->_item =  $cache->get($id);
                        if ($this->_item === false) {
 							$db		= $this->getDbo();
							$query	= $db->getQuery(true);
							$query->select(
								'a.clickurl as libelle,'.
								'a.cid as cid,'.
								'a.track_clicks as track_clicks'
								);
							$query->from('#__banners as a');
							$query->where('a.id = ' . (int) $id);

							$query->join('LEFT', '#__banner_clients AS cl ON cl.id = a.cid');
							$query->select('cl.track_clicks as client_track_clicks');

							$db->setQuery((string) $query);

							if (!$db->query()) {
								JError::raiseError(500, $db->getErrorMsg());
							}

							$this->_item = $db->loadObject();
							$cache->store($this->_item, $id);
                        }*/
                }
                return $this->_item;
 
        }
 
}
