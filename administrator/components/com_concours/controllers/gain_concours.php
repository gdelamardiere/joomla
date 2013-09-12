<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 // import Joomla controllerform library
jimport('joomla.application.component.controllerform');

 /**
 * concours Controller
 */
class concoursControllergain_concours extends JControllerForm{
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
	
	protected $view_item = 'gain_concours';
	protected $view_list = 'gain_concoursList';

	public function edit($key = null, $urlVar = null)
	{

		// Initialise variables.
		$app = JFactory::getApplication();
		$model = $this->getModel();
		$table = $model->getTable();
		$id_concours=JRequest::getCmd('id_concours', '0');
		$cid = JRequest::getVar('cid', array(), 'post', 'array');
		$context = "$this->option.edit.$this->context";
		// Determine the name of the primary key for the data.
		if (empty($key))
		{
			$key = $table->getKeyName();
		}

		// To avoid data collisions the urlVar may be different from the primary key.
		if (empty($urlVar))
		{
			$urlVar = $key;
		}

		// Get the previous record id (if any) and the current record id.
		$recordId = (int) (count($cid) ? $cid[0] : JRequest::getInt($urlVar));
		$checkin = property_exists($table, 'checked_out');

		// Access check.
		if (!$this->allowEdit(array($key => $recordId), $key))
		{
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_EDIT_NOT_PERMITTED'));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_list
					. $this->getRedirectToListAppend(), false
				)
			);

			return false;
		}

		// Attempt to check-out the new record for editing and redirect.
		if ($checkin && !$model->checkout($recordId))
		{
			// Check-out failed, display a notice but allow the user to see the record.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_CHECKOUT_FAILED', $model->getError()));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_item
					. $this->getRedirectToItemAppend($recordId, $urlVar), false
				)
			);

			return false;
		}
		else
		{
			// Check-out succeeded, push the new record id into the session.
			$this->holdEditId($context, $recordId);
			$app->setUserState($context . '.data', null);
			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_item.'&id_concours='.$id_concours
					. $this->getRedirectToItemAppend($recordId, $urlVar), false
				)
			);

			return true;
		}
	}

	public function save($key = null, $urlVar = null)
	{
		$return = parent::save();
		if($return){
			$this->addIdToPath();
		}
		return $return;
	}

	public function cancel($key = null){
		$return = parent::cancel();
		if($return){
			$this->addIdToPath();
		}
		return $return;
	}

	private function addIdToPath(){
		$data = JRequest::getVar('jform', array(), 'post', 'array');
		if (isset($data['id_concours'])) {
			$id_concours=intval($data['id_concours']);
			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_list. '&id_concours='.$id_concours 
					. $this->getRedirectToListAppend(), false
				)
			);
		}
	}
}