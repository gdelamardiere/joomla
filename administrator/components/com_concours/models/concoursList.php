<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

 // import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * HelloWorldList Model
 */
class concoursModelconcoursList extends JModelList{
        /**
         * Method to build an SQL query to load the list data.
         *
         * @return      string  An SQL query
         */
        protected function getListQuery()
        {
                // Create a new query object.           
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                // Select some fields
                $query->select('c.id,c.libelle,c.nb_gagnant,c.tirage,(select count(*) from #__participant p where p.id_concours=c.id) as nb_participant');
                // From the hello table
                $query->from('#__concours c');
                return $query;
        }
}
