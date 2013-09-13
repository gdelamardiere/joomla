<?php

/**
 * @version		$Id: hello.php 15 2009-11-02 18:37:15Z chdemko $
 * @package		Joomla16.Tutorials
 * @subpackage	Components
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @author		Christophe Demko
 * @link		http://joomlacode.org/gf/project/helloworld_1_6/
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modelitem');

/**
 * HelloWorld Model
 */
class concoursModelconcours extends JModelItem
{
	/**
	 * @var string msg
	 */
	protected $msg;
	protected $idConcours;
	protected $stateConcours;
	protected $infosConcours;
	protected $listeGagnant;
	protected $existConcours=false;
	const EN_COURS=-1;
	const FINI=0;
	const TIRAGE=1;
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'concours', $prefix = 'concoursTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	/**
	 * Get the message
	 * @return string The message to be displayed to the user
	 */
	
	public function __construct(){
		$this->idConcours = JRequest::getInt('id');
		parent::__construct();
		$table = $this->getTable();
		if($table->load($this->idConcours)){
			$this->existConcours=true;
		}
		$this->infosConcours=$table;
	}
	public function getMsg() 
	{
		if (!isset($this->msg)) 
		{
			
		$this->msg="coucou";
			
		}
		return $this->msg;
	}

	public function getInfosConcours(){
		return $this->infosConcours;
	}

	public function getExistConcours(){
		return $this->existConcours;
	}

	public function getStateConcours(){
		if(!isset($this->stateConcours)){
			$table = $this->getInfosConcours();
			$now = date('Y-m-d H:i:s');
			$expire =$table->date_fin;
			$now = new DateTime( $now );
			$now = $now->format('YmdHis');
			$expire = new DateTime( $expire );
			$expire = $expire->format('YmdHis');
			if($now < $expire){
				$this->stateConcours = $this::EN_COURS;
			}
			else{
				if($table->tirage==1){
					$this->stateConcours = $this::TIRAGE;
				}
				else{
					$this->stateConcours = $this::FINI;
				}
			}
		}
		
		return $this->stateConcours;
	}

	public function getGagnantConcours(){
		if(!isset($this->listeGagnant)){
			$this->listeGagnant=array();
			if($this->getExistConcours() && $this->getStateConcours()==$this::TIRAGE){
				$db = JFactory::getDBO();
                $query = $db->getQuery(true);
                $query->select('g.id_user,g.classement,u.username,l.lot');
                $query->where('g.id_concours='.$this->idConcours);
                $query->where('g.id_user=u.id');
                $query->where('g.id_concours=l.id_concours');
                $query->where('g.classement=l.place');
                $query->from('#__gagnant g, #__gain_concours l,#__users u');
                $db->setQuery((string)$query);
				$this->listeGagnant = $db->loadObjectList();
				//$this->listeGagnant=$query->loadRowList();
			}
		}
		return $this->listeGagnant;
	}
}
