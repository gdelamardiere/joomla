<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
//var_dump(get_included_files());
 // load tooltip behavior
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');?>
<form action="<?php echo JRoute::_('index.php?option=com_concours&layout=edit&id='.(int) $this->item->id.'&id_concours='.(int) $this->item->id); ?>" method="post" name="adminForm" id="concours-form" class="form-validate">
        <fieldset class="adminform">
                <legend><?php echo JText::_( 'COM_CONCOURS_CONCOURS_DETAILS' ); ?></legend>
                <ul class="adminformlist"><?php foreach($this->form->getFieldset() as $field): ?>
                        <li><?php echo $field->label;echo $field->input;?></li><?php endforeach; ?>
                </ul>
        </fieldset>
        <div>
                <input type="hidden" name="task" value="gain_concours.edit" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>