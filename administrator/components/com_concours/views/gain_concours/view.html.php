<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

 // import Joomla view library
jimport('joomla.application.component.view');

 /**
 * concours View
 */
 class concoursViewgain_concours extends JView{
        /**
         * concours view display method
         * @return void
         */
        public function display($tpl = null) 
        {

                // get the Data
                $form = $this->get('Form');
                $item = $this->get('Item');
                $script = $this->get('Script');
 
                // Check for errors.
                if (count($errors = $this->get('Errors'))) 
                {
                        JError::raiseError(500, implode('<br />', $errors));
                        return false;
                }
                // Assign the Data
                $this->form = $form;
                $this->item = $item;                
                $this->script = $script;
 
                // Set the toolbar
                $this->addToolBar();
 
                // Display the template
                parent::display($tpl);

                // Set the document
                $this->setDocument();
        }
 
        /**
         * Setting the toolbar
         */
        protected function addToolBar() 
        {
                $input = JFactory::getApplication()->input;
                $input->set('hidemainmenu', true);
                $isNew = ($this->item->id == 0);
                JToolBarHelper::title($isNew ? JText::_('COM_CONCOURS_MANAGER_CONCOURS_NEW')
                                             : JText::_('COM_CONCOURS_MANAGER_CONCOURS_EDIT'), 'gain_concours');
                JToolBarHelper::save('gain_concours.save');
                JToolBarHelper::cancel('gain_concours.cancel', $isNew ? 'JTOOLBAR_CANCEL'
                                                                   : 'JTOOLBAR_CLOSE');
        }
         /**
         * Method to set up the document properties
         *
         * @return void
         */
        protected function setDocument() 
        {
                $isNew = ($this->item->id < 1);
                $document = JFactory::getDocument();
                $document->setTitle($isNew ? JText::_('COM_CONCOURS_CONCOURS_CREATING')
                                           : JText::_('COM_CONCOURS_CONCOURS_EDITING'));
                $document->addScript(JURI::root() . $this->script);
                $document->addScript(JURI::root() . "/administrator/components/com_concours". "/views/gain_concours/submitbutton.js");
                JText::script('COM_CONCOURS_CONCOURS_ERROR_UNACCEPTABLE');
        }
    }