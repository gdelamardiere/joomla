<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2012 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		//if (task == 'cpanel' || document.formvalidator.isValid(document.id('archive-form'))) {
			Joomla.submitform(task, document.getElementById('archive-form'));
		//}
		//else {
			//alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		//}
	}
</script>
<form action="index.php?option=com_alphauserpoints" method="post" name="adminForm" id="archive-form" class="form-validate">
<div class="width-100 fltlft">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'AUP_COMBINE_ACTIVITIES_DESCRIPTION' ); ?></legend>
		<table class="admintable">
		<tbody>		
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'AUP_COMBINE_ACTIVITIES' ); ?>::<?php echo JText::_('AUP_COMBINE_ACTIVITIES_DESCRIPTION'); ?>">
					<?php echo JText::_( 'AUP_COMBINE_ACTIVITIES' ); ?>:
				</span>
			</td>
		  <td>
			<?php echo JHTML::_('calendar', '', 'datestart', 'datestart', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19')); ?>
			</td>
		</tr>
		<tr>
			<td class="key">&nbsp;
			</td>
		  <td>
			<input type="submit" name="Submit" value="<?php echo JText::_( 'AUP_COMBINE_ACTIVITIES' ); ?>">
			</td>
		</tr>		
		</tbody>
		</table>
	</fieldset>
</div>
	<input type="hidden" name="option" value="com_alphauserpoints" />
	<input type="hidden" name="task" value="processarchive" />
	<input type="hidden" name="boxchecked" value="0" />
</form>
<div class="clr"></div>