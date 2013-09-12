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
		//if (task == 'cpanel' || document.formvalidator.isValid(document.id('reportsystem-form'))) {
			Joomla.submitform(task, document.getElementById('reportsystem-form'));
		//}
		//else {
			//alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		//}
	}
</script>
<script type="text/javascript">
	window.addEvent('domready', function(){
		$('link_sel_all').addEvent('click', function(e){
			$('reportsystem').select();
		});
	});
</script>
<form action="index.php?option=com_alphauserpoints" method="post" name="adminForm" id="reportsystem-form" class="form-validate">
<div class="width-100 fltlft">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'AUP_REPORT_SYSTEM' ); ?></legend>
		<table class="admintable">
		<tbody>	
		<tr>
			<td class="key"><br />
			<?php echo JText::_('AUP_REPORT_SYSTEM_DESCRIPTION'); ?>
			</td>
		</tr>
		<tr>
		  <td>
		  <div><br /><a href="#" id="link_sel_all" ><?php echo JText::_('AUP_REPORT_SELECT_ALL'); ?></a></div>
			<textarea id="reportsystem" name="reportsystem" rows="15" style="width:65%;"><?php echo $this->reportsystem; ?></textarea>
			</td>
		</tr>
		</tbody>
		</table>
	</fieldset>
</div>
	<input type="hidden" name="option" value="com_alphauserpoints" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
</form>
<div class="clr"></div>