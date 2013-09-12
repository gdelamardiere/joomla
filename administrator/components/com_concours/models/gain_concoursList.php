<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

 // import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * HelloWorldList Model
 */
class concoursModelgain_concoursList extends JModelList{
        /**
         * Method to build an SQL query to load the list data.
         *
         * @return      string  An SQL query
         */
        protected function getListQuery()
        {
                $id_concours=intval(JRequest::getCmd('id_concours', '1'));              
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                $query->select('g.id,g.place,g.lot,c.libelle as libelle_concours,c.id as id_concours');
                $query->where('id_concours='.$id_concours);
                $query->from('#__gain_concours g, #__concours c');
                $query->where('g.id_concours=c.id');
                return $query;
        }
}