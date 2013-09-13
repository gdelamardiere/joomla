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

	public function tirage($key = null, $urlVar = null){
		$app = JFactory::getApplication();
		$model = $this->getModel();
		$table = $model->getTable();
		$id_concours = JRequest::getint('id');
		$exist=$table->load($id_concours);
		
		//si le concours n'existe pas
		if(!$exist){
				$this->setError(JText::_('JLIB_APPLICATION_ERROR_NON_EXIST_ID'));
				$this->setMessage($this->getError(), 'error');
				$this->setRedirect(
					JRoute::_(
						'index.php?option=' . $this->option . '&view=' . $this->view_list
						. $this->getRedirectToListAppend(), false
					)
				);
			return false;
		}
		//si le concours existe mais le tirage est deja effectué
		elseif($exist && $table->tirage==1){
				$this->setError(JText::_('JLIB_APPLICATION_ERROR_ALREADY_EFFECTUED'));
				$this->setMessage($this->getError(), 'error');
				$this->setRedirect(
					JRoute::_(
						'index.php?option=' . $this->option . '&view=' . $this->view_list
						. $this->getRedirectToListAppend(), false
					)
				);
			return false;
		}
		else{
			//determine les participants
			$db = JFactory::getDBO();
	        $query = $db->getQuery(true);
	        $query->select('p.id_user,p.nb_ligne');
	        $query->where('p.id_concours='.$id_concours);
	        $query->from('#__participant p');
	        $db->setQuery((string)$query);
			$listParticipant = $db->loadObjectList();
			$nb_participant=count($listParticipant);
			//si le concours existe mais plus de gagnant que de participant
			if($table->nb_gagnant>$nb_participant)
			{
				$this->setError(JText::_('JLIB_APPLICATION_ERROR_NB_PARTICIPANT'));
				$this->setMessage($this->getError(), 'error');
				$this->setRedirect(
					JRoute::_(
						'index.php?option=' . $this->option . '&view=' . $this->view_list
						. $this->getRedirectToListAppend(), false
					)
				);
			return false;
			}
			//sinon on effectue le tirage au sort
			else
			{
				$db = JFactory::getDBO();
	            $query = $db->getQuery(true);
	            $query->select('p.id_user,p.nb_ligne');
	            $query->where('p.id_concours='.$id_concours);
	            $query->from('#__participant p');
	            $db->setQuery((string)$query);
				$listParticipant = $db->loadObjectList();
				$listGagnant=$this->SelectAllGagnant($listParticipant,$table->nb_gagnant);
				for($i=0;$i<count($listGagnant);$i++){
					$this->insertGagnant($id_concours,$listGagnant[$i],$i+1);
				}
				$this->updateConcoursTire($id_concours);
				$this->setMessage(JText::_('JLIB_APPLICATION_SUCCES_TIRAGE'), 'success');

				$this->setRedirect(
					JRoute::_(
							'index.php?option=' . $this->option . '&view=' . $this->view_list
							. $this->getRedirectToListAppend(), false
						)
				);

				return true;
			}

		}		
	}


	protected function updateConcoursTire($id_concours){
		$db = JFactory::getDBO();
		$query = "UPDATE #__concours SET tirage=1 WHERE id=".$id_concours ;
						
		$db->setQuery($query);
        $db->query();
	}

	protected function insertGagnant($id_concours,$id_user,$place){
		$db = JFactory::getDBO();
		$query = "INSERT INTO #__gagnant"
						. "\n (`id` ,`id_concours` ,`id_user` ,`classement`) VALUES (NULL , '".$id_concours."', '".$id_user."', '".$place."')";
						echo $query;
		$db->setQuery($query);
        $db->query();
	}

	protected function SelectRandomGagnant($listParticipant){
		return $listParticipant[mt_rand(0, (count($listParticipant)-1))];
	}

	protected function SelectAllGagnant($listParticipant,$nb_gagnant){
		$list_gagnant=array();
		for($i=0;$i<$nb_gagnant;$i++){
			$aParticipant=array();
			for($j=0;$j<count($listParticipant);$j++){
				if(!in_array($j,$list_gagnant)){
					for($k=0;$k<$listParticipant[$j]->nb_ligne;$k++){
						$aParticipant[]=$j;
					}
				}
			}
			$list_gagnant[]=$listParticipant[$this->SelectRandomGagnant($aParticipant)]->id_user;
		}
		return $list_gagnant;
	}
}
