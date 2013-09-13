<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

 // import Joomla view library
jimport('joomla.application.component.view');

 /**
 * concours View
 */
 class concoursViewconcoursList extends JView{
        /**
         * concours view display method
         * @return void
         */
        function display($tpl = null) 
        {
            // Get data from the model
        	$items = $this->get('Items');
        	$pagination = $this->get('Pagination');

                // Check for errors.
        	if (count($errors = $this->get('Errors'))) 
        	{
        		JError::raiseError(500, implode('<br />', $errors));
        		return false;
        	}
                // Assign data to the view
        	$this->items = $items;
        	$this->pagination = $pagination;

            // Set the toolbar
                $this->addToolBar();

                // Display the template
        	parent::display($tpl);
        }

        /**
         * Setting the toolbar
         */
        protected function addToolBar() 
        {
                JToolBarHelper::title(JText::_('COM_CONCOURS_MANAGER_CONCOURS'));
                JToolBarHelper::deleteList('', 'concoursList.delete');
                JToolBarHelper::editList('concours.edit');
                JToolBarHelper::addNew('concours.add');
        }

        protected function isOverConcours($date_fin){
            $now = date('Y-m-d H:i:s');
            $now = new DateTime( $now );
            $now = $now->format('YmdHis');
            $date_fin = new DateTime( $date_fin );
            $date_fin = $date_fin->format('YmdHis');
            return $now >= $date_fin;
        }
    }