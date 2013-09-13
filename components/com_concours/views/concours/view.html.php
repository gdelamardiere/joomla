<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_concours
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');
/**
 * @package		Joomla.Site
 * @subpackage	com_concours
 */
class concoursViewconcours extends JView
{
	const EN_COURS=-1;
	const FINI=0;
	const TIRAGE=1;


	public function getFormulaireConcours(){
		$user = &JFactory::getUser() ;
		if ( $user->id ) {
		    echo "afficher le forlmulaire connecte";
		} else {
		  echo "afficher le forlmulaire non connecte";
		} 
	}
	public function display($tpl = null)
	{
		$this->getExistConcours=$this->get('ExistConcours');
		if($this->getExistConcours){

			switch($this->get('StateConcours')){
		    	case $this::EN_COURS:
		    		$this->setLayout('form_participation');
		    		break;
		    	case $this::FINI:
		    		$this->setLayout('cloture');
		    		break;
		    	case $this::TIRAGE:
		    		$this->getGagnantConcours=$this->get('GagnantConcours');
		    		$this->setLayout('liste_gagnant');
		    		break;
		    };
		}
               
                // Check for errors.
                if (count($errors = $this->get('Errors'))) 
                {
 
                        JError::raiseError(500, implode('<br />', $errors));
                        return false;
                }
                // Display the view
                parent::display($tpl);
	}
}
