<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
// import Joomla table library
jimport('joomla.database.table');
 /**
 * gagnant Table class
 */
class concoursTablegagnant extends JTable{
        /**
         * Constructor
         *
         * @param object Database connector object
         */
        function __construct(&$db) 
        {
                parent::__construct('#__gagnant', 'id', $db);
        }}