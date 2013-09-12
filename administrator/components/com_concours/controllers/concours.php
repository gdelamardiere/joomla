<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 // import Joomla controllerform library
jimport('joomla.application.component.controllerform');

 /**
 * concours Controller
 */
class concoursControllerconcours extends JControllerForm{
	/**
	 * Method to edit an existing record.
	 *
	 * @param   string  $key     The name of the primary key of the URL variable.
	 * @param   string  $urlVar  The name of the URL variable if different from the primary key
	 * (sometimes required to avoid router collisions).
	 *
	 * @return  boolean  True if access level check and checkout passes, false otherwise.
	 *
	 * @since   11.1
	 */
	protected $view_item = 'concours';
	protected $view_list = 'concoursList';

	public function save($key = null, $urlVar = null)
	{
		$return = parent::save();
		$db = JFactory::getDBO();
		$id_concours=$db->insertid();
		if ($return == true) {
			$data = JRequest::getVar('jform', array(), 'post', 'array');
			if (isset($data['nb_gagnant'])) {
				$nb_gagnant=intval($data['nb_gagnant']);
				$nb_gagnant_old=0;
				if(isset($data['id']) && $data['id']!=''){
					$id_concours=$data['id'];
					$query = $db->getQuery(true);
	                $query->select('count(*) as nb');
	                $query->from('#__gain_concours');
					$query->where('id_concours='.$id_concours);
	                $db->setQuery($query);
					$reponse = $db->loadObjectList();
					$nb_gagnant_old=$reponse[0]->nb;
				} 		
			}		
			if($nb_gagnant_old>$nb_gagnant) {
				$query = "DELETE FROM #__gain_concours"
						. "\n WHERE `id_concours` = '" . $id_concours. "'"
						. "\n AND `place` > '" . $nb_gagnant. "'";
				$db->setQuery($query);
	            $db->query();
			}  
			elseif($nb_gagnant_old<$nb_gagnant)  {
				for($i=$nb_gagnant_old;$i<$nb_gagnant;$i++){
					$place=$i+1;
					$query = "INSERT INTO #__gain_concours"
						. "\n (`id` ,`id_concours` ,`place` ,`lot`) VALUES (NULL , '".$id_concours."', '".$place."', '')";
					$db->setQuery($query);
	                $db->query();
				}
			}        
		}
		return $return;
	}
}