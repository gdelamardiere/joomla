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
		//if (task == 'cpanel' || document.formvalidator.isValid(document.id('couponcodes-form'))) {
			Joomla.submitform(task, document.getElementById('adminForm'));
		//}
		//else {
			//alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		//}
	}
</script>
<form action="index.php?option=com_alphauserpoints" method="post" name="adminForm" id="adminForm" class="form-validate">
	<table>
		<tr>
			<td align="left" width="100%">&nbsp;
				<?php //echo JText::_( 'Filter' ); ?>
				<!--<input type="text" name="search" id="search" value="<?php echo @$this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>-->
			</td>
			<td nowrap="nowrap" align="right">
				<select name="filter_category_id" class="inputbox" onchange="this.form.submit()">
					<option value=""><?php echo JText::_('JOPTION_SELECT_CATEGORY');?></option>
					<?php echo JHtml::_('select.options', JHtml::_('category.options', 'com_alphauserpoints'), 'value', 'text', $this->lists['filter_category_id']);?>
				</select>
				<?php
				echo $this->lists['filter_state'];
				?>
			</td>
		</tr>
	</table>
	<table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th width="3%" class="title">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->couponcodes); ?>);" />
				</th>
				<th width="20%" class="title">
					<?php echo JText::_('AUP_CODE'); ?>
				</th>
				<th width="10%" class="title" nowrap="nowrap">
					<?php echo JText::_( 'AUP_POINTS' ); ?>
				</th>
				<th width="10%" class="title" nowrap="nowrap">
					<?php echo JText::_( 'JCATEGORY' ); ?>
				</th>				
				<th width="15%" class="title" nowrap="nowrap">
					<?php echo JText::_( 'AUP_EXPIRE' ); ?>
				</th>
				<th class="title" >
					<?php echo JText::_('AUP_DESCRIPTION'); ?>
				</th>
				<th width="5%" class="title" >
					<?php echo JText::_('AUP_PUBLIC'); ?>
				</th>
				<th width="60" class="title" >
					<?php echo JText::_('AUP_PRINTABLE'); ?>
				</th>
				<th width="50" class="title" >
					<?php echo JText::_('AUP_SCANNED'); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="15">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php		
			$db = JFactory::getDBO();
				
			$k = 0;
			
			$img = '<img src="images/tick.png" border="0" alt="'. JText::_('AUP_PUBLIC') .'" /></a>';
			
			$img = '<img src="components/com_alphauserpoints/assets/images/tick.png" border="0" alt="'. JText::_('AUP_PUBLIC') .'" /></a>';
			
			for ($i=0, $n=count( $this->couponcodes ); $i < $n; $i++)
			{
				$row 	=& $this->couponcodes[$i];
				
				$link 	= 'index.php?option=com_alphauserpoints&amp;task=editcoupon&amp;cid[]='. $row->id. '';
				
				//$db = JFactory::getDBO();		

				$nullDate 		= $db->getNullDate();				
				
				// check if the coupon is already awarded		
				if ( $row->public ) {
					$where =  "d.keyreference LIKE '".strtoupper($row->couponcode)."##%'";
				} else $where = "d.keyreference='".strtoupper($row->couponcode)."'";
				
				$query = "SELECT d.* FROM #__alpha_userpoints_details AS d, #__alpha_userpoints_rules AS r WHERE $where AND r.id=d.rule AND r.plugin_function='sysplgaup_couponpointscodes'";
				$db->setQuery( $query );
				$resultCoupons = $db->loadObjectList();
				
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td align="center">
					<?php 
						echo JHTML::_('grid.id', $i, $row->id );	
					?>
				</td>
				<td>					
						<?php
						if ( $resultCoupons ) {
							if ( !$row->public ) {
						 		echo "<b><s>" . JText::_( strtoupper($row->couponcode)) . "</s></b><br />";
							} else {
								echo '<b><a href="'.$link.'">';
								echo JText::_( strtoupper($row->couponcode) );
								echo '</a></b>';
							}
							// show list user(s)
							echo '<span class="small">' . JText::_( 'AUP_AWARDED' ) . ': ';
							foreach ( $resultCoupons as $awardedcoupon ) {
								echo '<br />&nbsp;&nbsp;-&nbsp;' . $awardedcoupon->referreid . '&nbsp;('.JHTML::_('date',  $awardedcoupon->insert_date,  JText::_('DATE_FORMAT_LC2') ).')';										
							}
							echo '</span>';
						} else {
							echo '<a href="'.$link.'">';
							echo JText::_( strtoupper($row->couponcode) );
							echo '</a>';
						}
						?>					
				</td>
				<td>
					<div align="right">
					<?php echo getFormattedPoints( $row->points ); ?>
					</div>
				</td>
				<td>
					<div align="center">
					<?php echo JText::_( $row->category_title ); ?>
					</div>
				</td>				
				<td>
					<div align="center">
					<?php 
					if ( $row->expires == $nullDate ) {
						echo '-';
					} else {
						echo JHTML::_('date',  $row->expires,  JText::_('DATE_FORMAT_LC') );
					}
					?>
					</div>
				</td>
				<td>		
					<?php echo JText::_( $row->description ); ?>							
				</td>
				<td>
					<div align="center">
					<?php					
					$public = ( $row->public ) ? $img : '';
					echo $public; 					
					?>
					</div>						
				</td>
				<td>
					<?php 
					if ( $row->printable )
					{
						$QRcode50 = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_alphauserpoints'.DS.'assets'.DS.'coupons'.DS.'QRcode'.DS.'50'.DS. strtoupper($row->couponcode) .'.png';
						if ( file_exists($QRcode50)) {
						?>
						<a href="<?php echo JURI::base()."components/com_alphauserpoints/assets/coupons/QRcode/250/".strtoupper($row->couponcode).".png" ; ?>"><img src="<?php echo JURI::base(); ?>components/com_alphauserpoints/assets/coupons/QRcode/50/<?php echo strtoupper($row->couponcode); ?>.png" alt="" align="absmiddle" /></a>
					<?php 
						}
					} 
					?>
				</td>
				<td>
					<?php 
					if ( $row->printable )
					{
						$db = JFactory::getDBO();
						$query = "SELECT COUNT(*) FROM #__alpha_userpoints_qrcodetrack WHERE couponid='".$row->id."'";
						$db->setQuery( $query );
						$resultQRstats = $db->loadResult();
						if ($resultQRstats) {
							$linkQRcodestats = 'index.php?option=com_alphauserpoints&amp;task=qrcodestats&amp;id='. $row->id. '';
							echo '<a href="'.$linkQRcodestats.'" title="'.JText::_('AUP_TRACK').'">';
							echo $resultQRstats;
							echo '</a>';						
						} else echo '0';
					}
					?>
				</td>				
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>
	<input type="hidden" name="option" value="com_alphauserpoints" />
	<input type="hidden" name="task" value="couponcodes" />
	<input type="hidden" name="table" value="alpha_userpoints_coupons" />
	<input type="hidden" name="redirect" value="couponcodes" />
	<input type="hidden" name="boxchecked" value="0" />
</form>