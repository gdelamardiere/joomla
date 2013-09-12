<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

 // import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * HelloWorldList Model
 */
class concoursModelparticipantList extends JModelList{
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
                $query->select('p.id,p.id_concours,p.id_user,p.nb_ligne,c.libelle as libelle_concours,u.username');
                $query->where('p.id_concours='.$id_concours);
                $query->where('p.id_user=u.id');
                $query->where('p.id_concours=c.id');
                $query->from('#__participant p, #__concours c,#__users u');
                return $query;
        }
}