<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2012 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

$row = $this->row;
$pos = strpos( $row->plugin_function, 'sysplgaup_' );
$disabled = ( $pos === false ) ? 0 : 1;
$duplicate = $row->duplicate;
$system = $row->system;

JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		//if (task == 'cpanel' || task == 'cancelrule' || document.formvalidator.isValid(document.id('rule-form'))) {
			Joomla.submitform(task, document.getElementById('rule-form'));
		//}
		//else {
			//alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		//}
	}
</script>
<form action="index.php?option=com_alphauserpoints" method="post" name="adminForm" id="rule-form" class="form-validate">
<div class="width-60 fltlft">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'AUP_DETAILS' ); ?></legend>
		<table class="admintable">
		<tbody>
		<tr>
			<td class="key"  width="150">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_ID'); ?>">
					<?php echo JText::_( 'AUP_ID' ); ?>:
				</span>
			</td>
			<td>
			<?php echo "<font color='green'>" . $row->id . "</font>"; ?>
			</td>
		</tr>
		<tr>
			<td class="key"  width="150">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_CATEGORY'); ?>">
					<?php echo JText::_( 'AUP_CATEGORY' ); ?>:
				</span>
			</td>
			<td>
			<?php echo $this->lists['category']; ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php if ( $disabled ) : echo JText::_('AUP_THISFIELDCANBEMODIFIEDINLANGUAGEFILE'); else : echo JText::_('AUP_RULENAME'); endif; ?>">
					<?php echo JText::_( 'AUP_RULENAME' ); ?>:
				</span>
			</td>
			<td>
				<?php 
				if ( !$disabled || $duplicate )  { ?>
				<input class="inputbox" type="text" name="rule_name" id="rule_name" size="80" maxlength="255" value="<?php echo JText::_($row->rule_name); ?>" />
				<?php
				} else {
					echo "<font color='green'>" . JText::_($row->rule_name) . "</font>"; 
					?>
					<input type="hidden" name="rule_name" value="<?php echo $row->rule_name; ?>" />
					<?php
				}
				?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php if ( $disabled ) : echo JText::_('AUP_THISFIELDCANBEMODIFIEDINLANGUAGEFILE'); else : echo JText::_('AUP_DESCRIPTION'); endif; ?>">
					<?php echo JText::_( 'AUP_DESCRIPTION' ); ?>:
				</span>
			</td>
			<td>
				<?php 
				if ( !$disabled || $duplicate )  { ?>
				<input class="inputbox" type="text" name="rule_description" id="rule_description" size="80" maxlength="255" value="<?php echo JText::_($row->rule_description); ?>" />
				<?php
				} else {
					echo "<font color='green'>" . JText::_($row->rule_description) . "</font>"; 
					?>
					<input type="hidden" name="rule_description" value="<?php echo $row->rule_description; ?>" />
					<?php
				}
				?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php if ( $disabled ) : echo JText::_('AUP_THISFIELDCANBEMODIFIEDINLANGUAGEFILE'); else : echo JText::_('AUP_PLUGIN_TYPE_DESCRIPTION'); endif; ?>">
					<?php echo JText::_( 'AUP_PLUGIN_TYPE' ); ?>:
				</span>
			</td>
			<td>
				<?php 
				if ( !$disabled )  { ?>
				<input class="inputbox" type="text" name="rule_plugin" id="rule_plugin" size="20" maxlength="50" value="<?php echo JText::_($row->rule_plugin); ?>" />
				<?php
				} else {
					echo "<font color='green'>" . JText::_($row->rule_plugin) . "</font>"; 
					?>
					<input type="hidden" name="rule_plugin" value="<?php echo $row->rule_plugin; ?>" />
					<?php
				}
				?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php if ( $disabled ) : echo JText::_('AUP_UNIQUE_NAME_FUNCTION_RULE_DESCRIPTION'); else : echo JText::_('AUP_UNIQUE_NAME_FUNCTION_RULE_DESCRIPTION'); endif; ?>">
					<?php echo JText::_( 'AUP_UNIQUE_NAME_FUNCTION_RULE' ); ?>:
				</span>
			</td>
			<td>
				<?php 
				if ( !$disabled )  { ?>
				<input class="inputbox" type="text" name="plugin_function" id="plugin_function" size="20" maxlength="50" value="<?php echo $row->plugin_function; ?>" />
				<?php
				} else {
					echo "<font color='green'>" . $row->plugin_function . "</font>"; 
					?>
					<input type="hidden" name="plugin_function" value="<?php echo $row->plugin_function; ?>" />
					<?php
				}
				?>
			</td>
		</tr>
		<?php		
		 if (   $row->plugin_function=='sysplgaup_changelevel1' 
				   || $row->plugin_function=='sysplgaup_changelevel2' 
				    || $row->plugin_function=='sysplgaup_changelevel3' 				 
				    ) {
		 
		 ?>		
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_CHANGELEVELTO'); ?>">
					<?php echo JText::_( 'AUP_CHANGELEVELTO' ); ?>:
				</span>
			</td>
			<td>	
				<?php echo $this->lists['groups']; ?>
				
			</td>
		</tr>
		<?php } ?>

		<?php		
		 if ( $row->plugin_function!='sysplgaup_newregistered'
		  	&& $row->plugin_function!='sysplgaup_referralpoints' 
		     && $row->plugin_function!='sysplgaup_excludeusers' 
		      && $row->plugin_function!='sysplgaup_emailnotification' 
		       && $row->plugin_function!='sysplgaup_winnernotification' 
				 && $row->plugin_function!='sysplgaup_changelevel1' 
				  && $row->plugin_function!='sysplgaup_changelevel2' 
				   && $row->plugin_function!='sysplgaup_changelevel3' ) {	 
		 ?>		
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_USERLEVEL'); ?>">
					<?php echo JText::_( 'AUP_USERLEVEL' ); ?>:
				</span>
			</td>
			<td>
				<?php echo JHTML::_('list.accesslevel',  $row); ?>
			</td>
		</tr>
		<?php 		
		} else { 		
		?>
		<input type="hidden" name="access" value="2" />		
		<?php				
		}		
		
		// show categories field for rule plgaup_readarticle_by_cat (added in 1.8.1)
		if ( substr($row->plugin_function, 0, 25) == 'plgaup_readarticle_by_cat' ) {
		$categories = array();
		$categories = explode(',',$row->categories);
		?>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'JCATEGORIES' ); ?>::<?php echo JText::_('JCATEGORIES'); ?>">
					<?php echo JText::_( 'JCATEGORIES' ); ?>:
				</span>
			</td>
			<td>		
				<select name="categories[]" class="inputbox" multiple="multiple">
					<option value=""><?php echo JText::_('JOPTION_SELECT_CATEGORY');?></option>
					<?php echo JHtml::_('select.options', JHtml::_('category.categories', 'com_content'), 'value', 'text', $categories);?>
				</select>
			</td>
		</tr>
		<?php
		} 
		?>		
		<?php		
		 if ( $row->plugin_function=='sysplgaup_changelevel1' 
				|| $row->plugin_function=='sysplgaup_changelevel2' 
				  || $row->plugin_function=='sysplgaup_changelevel3' 		
				  	|| $row->plugin_function=='sysplgaup_unlockmenus'
					  || substr($row->plugin_function, 0, 22) == 'sysplgaup_unlockmenus_'	 
				    ) {
		  
		 ?>		
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_NUMBEROFPOINTSNECESSARY'); ?>">
					<?php echo JText::_( 'AUP_POINTSREACHED' ); ?>
				</span>
			</td>
			<td>			
				<input class="inputbox" type="text" name="points2" id="points2" size="10" maxlength="30" value="<?php echo $row->points2; ?>" /> <?php echo  JText::_( 'AUP_NUMBEROFPOINTSNECESSARY' ); ?>	
			</td>
		</tr>
		<?php
		} elseif ( $row->plugin_function=='plgaup_kunena_message_thankyou' )  {
		?>		
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'AUP_KU_POINT_USER_TARGET' ); ?>::<?php echo JText::_('AUP_KU_POINT_USER_TARGET_DESCRIPTION'); ?>">
					<?php echo JText::_( 'AUP_KU_POINT_USER_TARGET' ); ?>:
				</span>
			</td>
			<td>
			<input class="inputbox" type="text" name="points2" id="points2" size="10" maxlength="30"   value="<?php echo $row->points2; ?>" /> <?php echo JText::_('AUP_KU_POINT_USER_TARGET_DESCRIPTION'); ?>
			</td>
		</tr>
		<?php
		} else {
		?>		
		<input type="hidden" name="points2" value="<?php echo $row->points2; ?>" />
		<?php
		} 
		?>		
		<?php
		if ( $row->fixedpoints || $row->plugin_function=='' ) {    // $row->plugin_function = '' if new rule
		?>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_ATTRIB_X_POINTS_TO_THIS_RULE'); ?>">
					<?php echo JText::_( 'AUP_POINTS' ); if ($row->percentage) echo " (" . JText::_( 'AUP_PERCENTAGE' ) . ")"; ?> :
				</span>
			</td>
			<td>			
				<input class="inputbox" type="text" name="points" id="points" size="10" maxlength="30" value="<?php echo $row->points; ?>" />
				<?php if ($row->percentage) echo " <b> %</b>" ; ?>
			</td>
		</tr>
		<?php
		} else {
		?>		
		<input type="hidden" name="points" value="<?php echo $row->points; ?>" />
		<?php
		} 
		?>
		
		<?php if ( !$disabled )  { ?>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_FIXED_POINTS_DESCRIPTION'); ?>">
					<?php echo JText::_( 'AUP_FIXED_POINTS' ); ?>:
				</span>
			</td>
			<td><fieldset id="jform_fixedpoints" class="radio">		
				<?php 
					echo $this->lists['fixedpoints'];
				?></fieldset>
			</td>
		</tr>
		<?php } else { ?>
			<input type="hidden" name="fixedpoints" value="<?php echo $row->fixedpoints; ?>" />
		<?php } ?>
		
		<?php if ( !$disabled )  { ?>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_PERCENTAGE'); ?>">
					<?php echo JText::_( 'AUP_PERCENTAGE' ); ?>:
				</span>
			</td>
			<td><fieldset id="jform_percentage" class="radio">	
				<?php 
					echo $this->lists['percentage'];
				?></fieldset>
			</td>
		</tr>
		<?php } else { ?>
			<input type="hidden" name="percentage" value="<?php echo $row->percentage; ?>" />
		<?php } ?>
		
		<?php
		if ( $row->plugin_function!='sysplgaup_newregistered'
			 && $row->plugin_function!='sysplgaup_excludeusers'
			  && $row->plugin_function!='sysplgaup_emailnotification'
			   && $row->plugin_function!='sysplgaup_winnernotification'
				  && $row->plugin_function!='sysplgaup_changelevel1' 
				   && $row->plugin_function!='sysplgaup_changelevel2' 
					&& $row->plugin_function!='sysplgaup_changelevel3' 
					 && $row->plugin_function!='sysplgaup_archive') {
		?>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_EXPIRE_DESC'); ?>">
					<?php echo JText::_( 'AUP_EXPIRE' ); ?>:
				</span>
			</td>
			<td>
				    <?php echo JHTML::_('calendar', $row->rule_expire, 'rule_expire', 'rule_expire', '%Y-%m-%d %H:%M:%S', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19')); ?>
					<?php echo "<BR /><BR />" . $this->lists['type_expire_date'] ; ?>
			</td>
		</tr>
		<?php 
		} else { 
		?>
		<input type="hidden" name="rule_expire" value="0000-00-00 00:00:00" />		
		<?php 
		}
		?>
		<?php if ( $row->plugin_function=='sysplgaup_excludeusers' ) { ?>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_EXCLUDEUSERIDDESCRIPTION'); ?>">
					<?php echo JText::_( 'AUP_EXCLUDEUSERID' ); ?>:
				</span>
			</td>
			<td>
			<input class="inputbox" type="text" name="exclude_items" id="exclude_items" size="100" value="<?php echo $row->exclude_items; ?>" />
			</td>
		</tr>
		<?php }?>		
		<?php if ( $row->plugin_function=='sysplgaup_winnernotification' ) { ?>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_EMAILDAMINSNOTIFICATION'); ?>">
					<?php echo JText::_( 'AUP_EMAILDAMINS' ); ?>:
				</span>
			</td>
			<td>
			<input class="inputbox" type="text" name="content_items" id="content_items" size="100" value="<?php echo $row->content_items; ?>" />
			</td>
		</tr>
		<?php }?>		
		<?php if ( $row->plugin_function=='sysplgaup_inactiveuser' ) { ?>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_INACTIVE_PERIOD'); ?>">
					<?php echo JText::_( 'AUP_INACTIVE_PERIOD' ); ?>:
				</span>
			</td>
			<td>			
			<?php echo $this->lists['inactive_preset_period'] ; ?>
			</td>
		</tr>
		<?php }?>		
		<?php if ( $row->plugin_function!='sysplgaup_newregistered' ) { ?>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_PUBLISHED'); ?>">
					<?php echo JText::_( 'AUP_PUBLISHED' ); ?>:
				</span>
			</td>
			<td><fieldset id="jform_published" class="radio">	
				<?php echo $this->lists['published']; ?>
				</fieldset>
			</td>
		</tr>
		<?php } else { ?>
		<input type="hidden" name="published" value="1" />		
		<?php }?>
		<?php
		switch ( $row->plugin_function ) {
			case 'sysplgaup_newregistered':
			case 'sysplgaup_excludeusers':
			case 'sysplgaup_emailnotification':
			case 'sysplgaup_winnernotification':
			case 'sysplgaup_archive':
			case 'sysplgaup_unlockmenus':
			case (substr($row->plugin_function, 0, 22) == 'sysplgaup_unlockmenus_'):	
				echo "<input type=\"hidden\" name=\"autoapproved\" value=\"1\" />";
				break;										
			default:
				?>
			<tr>
				<td class="key">
					<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_AUTOAPPROVED'); ?>">
						<?php echo JText::_( 'AUP_AUTOAPPROVED' ); ?>:
					</span>
				</td>
				<td><fieldset id="jform_autoapproved" class="radio">		
					<?php echo $this->lists['autoapproved']; ?>
					</fieldset>
				</td>
			</tr>
		<?php
		}					 

		switch ( $row->plugin_function ) {
			case 'sysplgaup_newregistered':
			case 'sysplgaup_excludeusers':
			case 'sysplgaup_archive':
			case 'sysplgaup_couponpointscodes':
			case 'sysplgaup_changelevel1' :
		    case 'sysplgaup_changelevel2' :
		    case 'sysplgaup_changelevel3' :
			case 'sysplgaup_winnernotification' :
			case 'sysplgaup_happybirthday':
			case 'sysplgaup_unlockmenus':
			case (substr($row->plugin_function, 0, 22) == 'sysplgaup_unlockmenus_'):	
				echo '<input type="hidden" name="method" value="4" />';
				break;
			default:
		?>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_METHOD_DESCRIPTION'); ?>">
					<?php echo JText::_( 'AUP_METHOD' ); ?>:
				</span>
			</td>
			<td>
			<fieldset id="jform_methods" class="radio">
			  <?php echo $this->lists['methods']; ?> 
			 </fieldset>
			</td>
		</tr>
		<?php  } ?>		
		</tbody>
		</table>
	</fieldset>
</div>
<div class="width-40 fltrt">
<?php 
if (  $row->plugin_function != 'sysplgaup_referralpoints'  ) 
{
?>
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'AUP_MESSAGE' ); ?></legend>
		<table class="admintable">
		<tbody>
		<tr>
			<td class="key" width="150">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_DISPLAY_MSG'); ?>">
					<?php echo JText::_( 'AUP_DISPLAY_MSG' ); ?>:
				</span>
			</td>
			<td><fieldset id="jform_displaymsg" class="radio">		
			<?php echo $this->lists['displaymsg']; ?></fieldset>
			</td>
		</tr>		
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_MESSAGE_DESCRIPTION'); ?>">
					<?php echo JText::_( 'AUP_MESSAGE' ); ?>:
				</span>
			</td>
			<td>
			<input class="inputbox" type="text" name="msg" id="msg" size="68" maxlength="255" value="<?php echo $row->msg; ?>" />
			</td>
		</tr>		
		</tbody>
		</table>	
	</fieldset>
<?php 
}
?>
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'AUP_EMAILNOTIFICATION' ); ?></legend>
		<table class="admintable">
		<tbody>
		<tr>
			<td class="key" width="150">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_EMAILNOTIFICATIONDESCRIPTION'); ?>">
					<?php echo JText::_( 'AUP_EMAILNOTIFICATION' ); ?>:
				</span>
			</td>
			<td><fieldset id="jform_notification" class="radio">		
			<?php echo $this->lists['notification']; ?></fieldset>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_SUBJECT_DESCRIPTION'); ?>">
					<?php echo JText::_( 'AUP_SUBJECT' ); ?>:
				</span>
			</td>
			<td>
			  <input name="emailsubject" type="text" class="inputbox" id="emailsubject" value="<?php echo JText::_($row->emailsubject); ?>" size="68" maxlength="255">
</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_MESSAGE_BODY_DESCRIPTION'); ?>">
					<?php echo JText::_( 'AUP_MESSAGE_BODY' ); ?>:
				</span>
			</td>
			<td>	
			  <!--<textarea name="emailbody" cols="100" rows="5" class="inputbox" id="emailbody"><?php echo JText::_($row->emailbody); ?></textarea>-->
			  <?php            			
			    $editor		=  JFactory::getEditor();
				echo $editor->display( 'emailbody',  $row->emailbody , '100%', '200', '75', '20', false );
				?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_FORMAT_DESCRIPTION'); ?>">
					<?php echo JText::_( 'AUP_FORMAT' ); ?>:
				</span>
			</td>
			<td><fieldset id="jform_emailformat" class="radio">		
			<?php echo $this->lists['emailformat']; ?></fieldset>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_SEND_COPY_ADMIN_DESCRIPTION'); ?>">
					<?php echo JText::_( 'AUP_SEND_COPY_ADMIN' ); ?>:
				</span>
			</td>
			<td><fieldset id="jform_bcc2admin" class="radio">		
			<?php echo $this->lists['bcc2admin']; ?></fieldset>
			</td>
		</tr>	
		</tbody>
		</table>	
	</fieldset>
</div>
<?php 
//if ($row->plugin_function=='sysplgaup_unlockmenus') :
if ( substr($row->plugin_function, 0, 21) == 'sysplgaup_unlockmenus' ) :
	JPlugin::loadLanguage( 'com_modules', JPATH_ADMINISTRATOR );
?>
<div class="width-60 fltlft">
	<?php echo $this->loadTemplate('assignment'); ?>
</div>
<?php endif; ?>
	<input type="hidden" name="option" value="com_alphauserpoints" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
	<input type="hidden" name="system" value="<?php echo $row->system; ?>" />
	<input type="hidden" name="duplicate" value="<?php echo $row->duplicate; ?>" />
	<input type="hidden" name="blockcopy" value="<?php echo $row->blockcopy; ?>" />
	<input type="hidden" name="redirect" value="rules" />
	<input type="hidden" name="boxchecked" value="0" />
</form>
<div class="clr"></div>