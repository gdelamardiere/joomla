<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2012 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

$row = $this->row;
$listrank = $this->listrank;
$medalsexist = $this->medalsexist;

JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		//if (task == 'cpanel' || task == 'cancelrule' || document.formvalidator.isValid(document.id('statistic-form'))) {
			Joomla.submitform(task, document.getElementById('statistic-form'));
		//}
		//else {
			//alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		//}
	}
</script>
<form action="index.php?option=com_alphauserpoints" method="post" name="adminForm" id="statistic-form" class="form-validate">
<div class="width-50 fltlft">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'AUP_DETAILS' ); ?></legend>
		<div>
		<?php
		$com_params     = JComponentHelper::getParams( 'com_alphauserpoints' );
		$useAvatarFrom  = $com_params->get('useAvatarFrom');		
		if ( $com_params->get('useAvatarFrom')=='alphauserpoints' ) 
		{
			$api_AUP = JPATH_SITE.DS.'components'.DS.'com_alphauserpoints'.DS.'helper.php';	
			require_once ($api_AUP);
			$avatar 		= AlphaUserPointsHelper::getAupAvatar( $row->userid, 0, '', 100 );
			echo '<div style="float:right;padding: 0 10px 0 10px;">';
			echo $avatar;
			echo '</div>';
		} 
		?>		
		<table class="admintable">
		<tbody>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_NAME'); ?>">
					<?php echo JText::_( 'AUP_NAME' ); ?>:
				</span>
			</td>
			<td>
				<?php 
					echo "<font color='green'>" . JText::_($row->name) . "</font>";
				?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_USERNAME'); ?>">
					<?php echo JText::_( 'AUP_USERNAME' ); ?>:
				</span>
			</td>
			<td>
				<?php 
					echo "<font color='green'>" . JText::_($row->username) . "</font>"; 
				?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_REFERREID'); ?>">
					<?php echo JText::_( 'AUP_REFERREID' ); ?>:
				</span>
			</td>
			<td>
				<?php 
					echo "<font color='green'>" . JText::_($row->referreid) . "</font>"; 
				?>				
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_POINTS'); ?>">
					<?php echo JText::_( 'AUP_POINTS' ); ?>:
				</span>
			</td>
			<td>
				<input class="inputbox" type="text" name="points" id="points" size="20" maxlength="255" value="<?php echo $row->points; ?>"  readonly="readonly"/><br /><br />
				<a href="index.php?option=com_alphauserpoints&task=showdetails&cid=<?php echo $row->referreid; ?>&name=<?php echo $row->name; ?>"><?php echo JText::_('AUP_SHOW_DETAIL_ACTIVITIES'); ?></a>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_MAXPOINTS'); ?>">
					<?php echo JText::_( 'AUP_MAXPOINTS' ); ?>:
				</span>
			</td>
			<td>
				<input class="inputbox" type="text" name="max_points" id="max_points" size="20" maxlength="255" value="<?php echo $row->max_points; ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_EXCLUDESPECIFICUSERSDESCRIPTION'); ?>">
					<?php echo JText::_( 'AUP_ENABLED' ); ?>:
				</span>
			</td>
			<td><fieldset id="jform_percentage" class="radio">	
				<?php echo JHTML::_('select.booleanlist', 'published', '', $row->published); ?></fieldset>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_RANK'); ?>">
					<?php echo JText::_( 'AUP_RANK' ); ?>:
				</span>
			</td>
			<td>
				<?php echo $listrank; ?>
			</td>
		</tr>
		<?php 
			if ( $row->leveldate != '0000-00-00' ) {
		?>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_DATE'); ?>">
					<?php echo JText::_( 'AUP_DATE' ); ?>:
				</span>
			</td>
			<td>
			<?php
				echo JHTML::_('date',  $row->leveldate,  JText::_('DATE_FORMAT_LC') );
			?>
			</td>
		<?php } ?>
		</tr>
		</tbody>
		</table>		
	  </div>
	</fieldset>
</div>
<div class="width-50 fltrt">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'AUP_PROFILE' ); ?></legend>
		<table class="admintable">
		<tbody>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_PROFILE_VIEWS'); ?>">
					<?php echo JText::_( 'AUP_PROFILE_VIEWS' ); ?>:
				</span>
			</td>
			<td>
				<?php 
					echo "<font color='green'>" . $row->profileviews . "</font>"; 
					if ( $row->profileviews )
					{
					?>
					--- [<a href="index.php?option=com_alphauserpoints&task=resetprofilviews&id=<?php echo $row->id; ?>"><?php echo JText::_( 'AUP_RESET' ); ?></a>]							
					<?php
					}
				?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_REFERRALUSER'); ?>">
					<?php echo JText::_( 'AUP_REFERRALUSER' ); ?>:
				</span>
			</td>
			<td>
				<?php 
					echo "<font color='green'>" . $row->referraluser . "</font> ";
					if ( $row->referralusername ) 
					{
						echo "(" . $row->referralusername . ")"; 
					}
					if ( $row->referraluser )
					{
					?>
					--- [<a href="index.php?option=com_alphauserpoints&task=resetreferraluser&id=<?php echo $row->id; ?>"><?php echo JText::_( 'AUP_RESET' ); ?></a>]							
					<?php
					}					
				?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_REFERREES'); ?>">
					<?php echo JText::_( 'AUP_REFERREES' ); ?>:
				</span>
			</td>
			<td>
				<?php 
					echo "<font color='green'>" . $row->referrees . "</font>"; 
					if ( $row->referrees )
					{
					?>
					--- [<a href="index.php?option=com_alphauserpoints&task=resetreferrees&id=<?php echo $row->id; ?>"><?php echo JText::_( 'AUP_RESET' ); ?></a>]							
					<?php
					}
				?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_BIRTHDATE'); ?>">
					<?php echo JText::_( 'AUP_BIRTHDATE' ); ?>:
				</span>
			</td>
			<td>
				<input class="inputbox" type="text" name="birthdate" id="birthdate" size="20" maxlength="255" value="<?php echo $row->birthdate; ?>"/>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_GENDER'); ?>">
					<?php echo JText::_( 'AUP_GENDER' ); ?>:
				</span>
			</td>
			<td>
				<fieldset id="jform_gender" class="radio">	
					<?php echo getListGender( $row->gender ); ?>
				</fieldset>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_ABOUT_ME'); ?>">
					<?php echo JText::_( 'AUP_ABOUT_ME' ); ?>:
				</span>
			</td>
			<td>
				<input class="inputbox" type="text" name="aboutme" id="aboutme" size="60" maxlength="255" value="<?php echo $row->aboutme; ?>"/>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_WEBSITE'); ?>">
					<?php echo JText::_( 'AUP_WEBSITE' ); ?>:
				</span>
			</td>
			<td>
				<input class="inputbox" type="text" name="website" id="website" size="60" maxlength="255" value="<?php echo $row->website; ?>"/>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_HOME_PHONE'); ?>">
					<?php echo JText::_( 'AUP_HOME_PHONE' ); ?>:
				</span>
			</td>
			<td>
				<input class="inputbox" type="text" name="phonehome" id="phonehome" size="20" maxlength="255" value="<?php echo $row->phonehome; ?>"/>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_MOBILE_PHONE'); ?>">
					<?php echo JText::_( 'AUP_MOBILE_PHONE' ); ?>:
				</span>
			</td>
			<td>
				<input class="inputbox" type="text" name="phonemobile" id="phonemobile" size="20" maxlength="255" value="<?php echo $row->phonemobile; ?>"/>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_ADDRESS'); ?>">
					<?php echo JText::_( 'AUP_ADDRESS' ); ?>:
				</span>
			</td>
			<td>
				<input class="inputbox" type="text" name="address" id="address" size="60" maxlength="255" value="<?php echo $row->address; ?>"/>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_ZIPCODE'); ?>">
					<?php echo JText::_( 'AUP_ZIPCODE' ); ?>:
				</span>
			</td>
			<td>
				<input class="inputbox" type="text" name="zipcode" id="zipcode" size="20" maxlength="255" value="<?php echo $row->zipcode; ?>"/>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_CITY'); ?>">
					<?php echo JText::_( 'AUP_CITY' ); ?>:
				</span>
			</td>
			<td>
				<input class="inputbox" type="text" name="city" id="city" size="20" maxlength="255" value="<?php echo $row->city; ?>"/>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_COUNTRY'); ?>">
					<?php echo JText::_( 'AUP_COUNTRY' ); ?>:
				</span>
			</td>
			<td>
				<!--<input class="inputbox" type="text" name="country" id="country" size="20" maxlength="255" value="<?php echo $row->country; ?>"/>-->
				<?php echo getCountryList($row->country); ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_COLLEGE_UNIVERSITY'); ?>">
					<?php echo JText::_( 'AUP_COLLEGE_UNIVERSITY' ); ?>:
				</span>
			</td>
			<td>
				<input class="inputbox" type="text" name="education" id="education" size="60" maxlength="255" value="<?php echo $row->education; ?>"/>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_CLASS_YEAR'); ?>">
					<?php echo JText::_( 'AUP_CLASS_YEAR' ); ?>:
				</span>
			</td>
			<td>
				<input class="inputbox" type="text" name="graduationyear" id="graduationyear" size="10" maxlength="255" value="<?php echo $row->graduationyear; ?>"/>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_JOB_TITLE'); ?>">
					<?php echo JText::_( 'AUP_JOB_TITLE' ); ?>:
				</span>
			</td>
			<td>
				<input class="inputbox" type="text" name="job" id="job" size="60" maxlength="255" value="<?php echo $row->job; ?>"/>
			</td>
		</tr>
		</tbody>
		</table>
	</fieldset>
</div>
<input type="hidden" name="option" value="com_alphauserpoints" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
	<input type="hidden" name="userid" value="<?php echo $row->userid; ?>" />
	<input type="hidden" name="referreid" value="<?php echo $row->referreid; ?>" />
	<!--<input type="hidden" name="referraluser" value="<?php echo $row->referraluser; ?>" />-->	
	<input type="hidden" name="oldrank" value="<?php echo $row->levelrank; ?>" />	
	<input type="hidden" name="upnid" value="<?php echo $row->upnid; ?>" />
	<!--<input type="hidden" name="referrees" value="<?php echo $row->referrees; ?>" />-->
	<input type="hidden" name="blocked" value="<?php echo $row->blocked; ?>" />	
	<!--<input type="hidden" name="birthdate" value="<?php echo $row->birthdate; ?>" />-->
	<input type="hidden" name="avatar" value="<?php echo $row->avatar; ?>" />
	<!--<input type="hidden" name="gender" value="<?php echo $row->gender; ?>" />
	<input type="hidden" name="aboutme" value="<?php echo $row->aboutme; ?>" />
	<input type="hidden" name="website" value="<?php echo $row->website; ?>" />
	<input type="hidden" name="phonehome" value="<?php echo $row->phonehome; ?>" />
	<input type="hidden" name="phonemobile" value="<?php echo $row->phonemobile; ?>" />
	<input type="hidden" name="address" value="<?php echo $row->address; ?>" />
	<input type="hidden" name="zipcode" value="<?php echo $row->zipcode; ?>" />
	<input type="hidden" name="city" value="<?php echo $row->city; ?>" />
	<input type="hidden" name="country" value="<?php echo $row->country; ?>" />
	<input type="hidden" name="education" value="<?php echo $row->education; ?>" />
	<input type="hidden" name="graduationyear" value="<?php echo $row->graduationyear; ?>" />
	<input type="hidden" name="job" value="<?php echo $row->job; ?>" />-->
	<input type="hidden" name="facebook" value="<?php echo $row->facebook; ?>" />
	<input type="hidden" name="twitter" value="<?php echo $row->twitter; ?>" />
	<input type="hidden" name="icq" value="<?php echo $row->icq; ?>" />
	<input type="hidden" name="aim" value="<?php echo $row->aim; ?>" />
	<input type="hidden" name="yim" value="<?php echo $row->yim; ?>" />
	<input type="hidden" name="msn" value="<?php echo $row->msn; ?>" />
	<input type="hidden" name="skype" value="<?php echo $row->skype; ?>" />
	<input type="hidden" name="gtalk" value="<?php echo $row->gtalk; ?>" />
	<input type="hidden" name="xfire" value="<?php echo $row->xfire; ?>" />		
	<!--<input type="hidden" name="profileviews" value="<?php echo $row->profileviews; ?>" />-->
	<input type="hidden" name="shareinfos" value="<?php echo $row->shareinfos; ?>" />	
	<input type="hidden" name="redirect" value="statistics" />
	<input type="hidden" name="boxchecked" value="0" />
</form>
<!--<div class="clr"></div>-->
<?php
if ( $medalsexist ) {
?>
	<?php
	if ( $this->medalslistuser ) {
	?>
<div class="width-50 fltlft">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'AUP_MEDALS' ); ?></legend>
		<table class="admintable" width="100%">
		<tbody>
		<?php foreach ( $this->medalslistuser as $medaluser ) { ?>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_NAME'); ?>">
					<?php echo $medaluser->medaldate; ?>
				</span>
			</td>
			<td>
				<?php 
					$linkdelete = '&nbsp;&nbsp;(<a href="index.php?option=com_alphauserpoints&amp;task=removemedaluser&amp;cid='.$medaluser->id.'&amp;rid='.$row->id.'">'.JText::_( 'AUP_DELETE' ).'</a>)';
					echo $medaluser->rank . " - " . $medaluser->reason . $linkdelete ;
				?>
			</td>
		</tr>
		<?php } ?>
		</tbody>
		</table>
	</fieldset>
</div>
	<?php } ?>
		<form action="index.php?option=com_alphauserpoints" method="post" name="adminForm2">
	<div class="width-50 fltlft">
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'AUP_AWARDED_NEW_MEDAL' ); ?></legend>
				<table class="admintable" width="100%">
				<tbody>
				<tr>
					<td class="key">
						<span class="editlinktip hasTip" title="<?php echo JText::_('AUP_MEDAL'); ?>">
							<?php echo JText::_( 'AUP_MEDAL' ); ?>
						</span>				
					</td>
					<td>
					  <?php echo $this->listmedals; ?>
				  </td>
				</tr>
				<tr>
					<td class="key">
						<span class="editlinktip hasTip" title="<?php echo JText::_( 'AUP_OPTIONAL' ). ' - ' . JText::_( 'AUP_DESCRIPTION_MEDAL_BY_DEFAULT' ) ; ?>">
							<?php echo JText::_( 'AUP_DESCRIPTION' ) .  ' <i>(' . JText::_( 'AUP_OPTIONAL' ) . ')</i>'; ?>
						</span>				
					</td>
					<td>
					  <input type="text" id="reason" name="reason" class="inputbox" value="" size="60" />
				  </td>
				</tr>		
				<tr>
					<td class="key">&nbsp;
					</td>
					<td>
					  <input type="submit" name="Submit" class="button" value="<?php echo  JText::_('AUP_AWARDED_NEW_MEDAL'); ?>" />
				  </td>
				</tr>		
				</tbody>
				</table>
			</fieldset>
		</div>
			<input type="hidden" name="option" value="com_alphauserpoints" />
			<input type="hidden" name="task" value="awardedmedal" />
			<input type="hidden" name="rid" value="<?php echo $row->id; ?>" />
			<input type="hidden" name="userid" value="<?php echo $row->userid; ?>" />
			<input type="hidden" name="referreid" value="<?php echo $row->referreid; ?>" />
			<input type="hidden" name="referraluser" value="<?php echo $row->referraluser; ?>" />	
			<input type="hidden" name="redirect" value="edituser" />
			<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
			<input type="hidden" name="boxchecked" value="0" />
		</form>
<?php } ?>
<div class="clr"></div>