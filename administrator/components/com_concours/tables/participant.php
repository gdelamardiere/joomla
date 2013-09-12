<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
// import Joomla table library
jimport('joomla.database.table');
 /**
 * participant Table class
 */
class concoursTableparticipant extends JTable{
        /**
         * Constructor
         *
         * @param object Database connector object
         */
        function __construct(&$db) 
        {
                parent::__construct('#__participant', 'id', $db);
        }
    }