<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
// import Joomla table library
jimport('joomla.database.table');
 /**
 * gain_concours Table class
 */
class concoursTablegain_concours extends JTable{
        /**
         * Constructor
         *
         * @param object Database connector object
         */
        function __construct(&$db) 
        {
                parent::__construct('#__gain_concours', 'id', $db);
        }}