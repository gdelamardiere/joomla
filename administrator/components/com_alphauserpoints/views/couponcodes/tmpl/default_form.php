<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2012 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );


$row = $this->row;
$lists = $this->lists;

JHtml::_('behavior.formvalidation');
?>

<script type="text/javascript">
function generatecode() {
   
    var length=8;
    var sCode = "";
   
    for (i=0; i < length; i++) {    
        numI = getRandomNum();
        while (checkPunc(numI))	{ numI = getRandomNum(); }        
        sCode = sCode + String.fromCharCode(numI);
    }
    
    document.adminForm.couponcode.value = sCode.toUpperCase();;    
    return true;
}

function getRandomNum() {        
    // between 0 - 1
    var rndNum = Math.random()
    // rndNum from 0 - 1000    
    rndNum = parseInt(rndNum * 1000);
    // rndNum from 33 - 127        
    rndNum = (rndNum % 94) + 33;            
    return rndNum;
}

function checkPunc(num) {
    
    if ((num >=33) && (num <=47)) { return true; }
    if ((num >=58) && (num <=64)) { return true; }    
    if ((num >=91) && (num <=96)) { return true; }
    if ((num >=123) && (num <=126)) { return true; }
    
    return false;
}

Joomla.submitbutton = function(task)
{
	//if (task == 'cpanel' || document.formvalidator.isValid(document.id('couponcodes-form'))) {
		Joomla.submitform(task, document.getElementById('couponcode-form'));
	//}
	//else {
		//alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
	//}
}

</Script>
<form action="index.php?option=com_alphauserpoints" method="post" name="adminForm" id="couponcode-form" class="form-validate">
<div class="width-100 fltlft">
	<fieldset class="adminform">
	  <legend><?php echo JText::_( 'AUP_DETAILS' ); ?></legend>
		<table class="admintable">
		<tbody>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'AUP_CODE' ); ?>::<?php echo JText::_('AUP_CODE'); ?>">
					<?php echo JText::_( 'AUP_CODE' ); ?>:
				</span>
			</td>
		  <td>
			<input class="inputbox" type="text" name="couponcode" id="couponcode" size="20" maxlength="20" value="<?php echo $row->couponcode; ?>" />
			<input name="autogenerate" type="button" id="autogenerate" value="..." onclick="javascript:generatecode()">
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'AUP_DESCRIPTION' ); ?>::<?php echo JText::_('AUP_DESCRIPTION'); ?>">
					<?php echo JText::_( 'AUP_DESCRIPTION' ); ?>:
				</span>
			</td>
			<td>
			<input class="inputbox" type="text" name="description" id="description" size="100" maxlength="255" value="<?php echo $row->description; ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'JCATEGORIES' ); ?>::<?php echo JText::_('JCATEGORIES'); ?>">
					<?php echo JText::_( 'JCATEGORIES' ); ?>:
				</span>
			</td>
			<td>		
				<select name="category" class="inputbox">
					<option value=""><?php echo JText::_('JOPTION_SELECT_CATEGORY');?></option>
					<?php echo JHtml::_('select.options', JHtml::_('category.categories', 'com_alphauserpoints'), 'value', 'text', $row->category);?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'AUP_POINTS' ); ?>::<?php echo JText::_('AUP_POINTS'); ?>">
					<?php echo JText::_( 'AUP_POINTS' ); ?>:
				</span>
			</td>
			<td>
				<input class="inputbox" type="text" name="points" id="points" size="20" value="<?php echo $row->points; ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'AUP_EXPIRE' ); ?>::<?php echo JText::_('AUP_EXPIRE'); ?>">
					<?php echo JText::_( 'AUP_EXPIRE' ); ?>:
				</span>
			</td>
			<td>
			<?php echo JHTML::_('calendar', $row->expires, 'expires', 'expires', '%Y-%m-%d %H:%M:%S', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19')); ?>
			</td>
		</tr>
		<tr>
		  <td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'AUP_PUBLIC' ); ?>::<?php echo JText::_('AUP_PUBLIC'); ?>">
					<?php echo JText::_( 'AUP_PUBLIC' ); ?>:
				</span>
		  </td>
		  <td><fieldset id="jform_public" class="radio"><?php echo $lists['public']; ?></fieldset></td>
		  </tr>
		<tr>
		  <td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'AUP_PRINTABLE' ); ?>::<?php echo JText::_('AUP_PRINTABLE'); ?>">
					<?php echo JText::_( 'AUP_PRINTABLE' ); ?>:
				</span>
		  </td>
		  <td><fieldset id="jform_public" class="radio"><?php echo $lists['printable']; ?></fieldset></td>
		  </tr>
         <?php if ( $row->couponcode && $row->printable ) { ?>
		<tr>
		  <td colspan="2" align="left">
					<?php 
					$QRcode250 = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphauserpoints'.DS.'assets'.DS.'coupons'.DS.'QRcode'.DS.'250'.DS. strtoupper($row->couponcode) .'.png';
					if ( file_exists($QRcode250)) {
					?>
					<img src="<?php echo JURI::base(); ?>components/com_alphauserpoints/assets/coupons/QRcode/250/<?php echo strtoupper($row->couponcode); ?>.png" alt="" align="absmiddle" />
					</td>
                    </tr>
                    <tr>
                    <td colspan="2" align="left">
                    <a href="<?php echo JURI::base()."components/com_alphauserpoints/assets/coupons/QRcode/250/".strtoupper($row->couponcode).".png";?>"><?php echo JURI::base(); ?>components/com_alphauserpoints/assets/coupons/QRcode/250/<?php echo strtoupper($row->couponcode); ?>.png</a>
					<?php } ?>		
		  </td>
		 </tr>
         <?php } ?>
		</tbody>
		</table>
	</fieldset>
</div>
	<input type="hidden" name="option" value="com_alphauserpoints" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
	<input type="hidden" name="redirect" value="couponcodes" />
	<input type="hidden" name="boxchecked" value="0" />
</form>
<div class="clr"></div>