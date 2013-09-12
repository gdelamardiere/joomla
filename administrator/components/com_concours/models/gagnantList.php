<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

 // import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * HelloWorldList Model
 */
class concoursModelgagnantList extends JModelList{
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
                $query->select('g.id,g.id_concours,g.id_user,g.classement,c.libelle as libelle_concours,u.username');
                $query->where('g.id_concours='.$id_concours);
                $query->where('g.id_user=u.id');
                $query->where('g.id_concours=c.id');
                $query->from('#__gagnant g, #__concours c,#__users u');
                return $query;
        }
}

                