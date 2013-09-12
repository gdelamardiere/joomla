<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
// import Joomla table library
jimport('joomla.database.table');
 /**
 * concours Table class
 */
class concoursTableconcours extends JTable{
        /**
         * Constructor
         *
         * @param object Database connector object
         */
        function __construct(&$db) 
        {
                parent::__construct('#__concours', 'id', $db);
        }}