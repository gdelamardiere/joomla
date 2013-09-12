<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

 // import Joomla modelform library
jimport('joomla.application.component.modeladmin');

 /**
 * concours Model
 */
class concoursModelgain_concours extends JModelAdmin{
        /**
         * Returns a reference to the a Table object, always creating it.
         *
         * @param       type    The table type to instantiate
         * @param       string  A prefix for the table class name. Optional.
         * @param       array   Configuration array for model. Optional.
         * @return      JTable  A database object
         * @since       2.5
         */
        public function getTable($type = 'gain_concours', $prefix = 'concoursTable', $config = array()) 
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
                $id_concours=JRequest::getCmd('id_concours', '0');
                // Get the form.
                $form = $this->loadForm('com_concours.gain_concours', 'gain_concours',
                                        array('control' => 'jform', 'load_data' => $loadData));
                if (empty($form)) 
                {
                        return false;
                }
                return $form;
        }
        /**
         * Method to get the script that have to be included on the form
         *
         * @return string       Script files
         */
        public function getScript() 
        {
                return 'administrator/components/com_concours/models/forms/gain_concours.js';
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
                $data = JFactory::getApplication()->getUserState('com_concours.edit.gain_concours.data', array());
                if (empty($data)) 
                {
                        $data = $this->getItem();
                }
                return $data;
        }
}