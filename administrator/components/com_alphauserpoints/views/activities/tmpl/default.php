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
		//if (task == 'cpanel' || document.formvalidator.isValid(document.id('activities-form'))) {
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
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo @$this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<td nowrap="nowrap" align="right">
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
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->activities); ?>);" />
				</th>
				<th class="title" width="18%">
					<?php echo JHTML::_('grid.sort', 'AUP_DATE', 'a.insert_date', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th class="title" width="14%">
					<?php echo JHTML::_('grid.sort', 'AUP_RULENAME', 'r.rule_name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th class="title">
					<?php echo JHTML::_('grid.sort', 'AUP_NAME', 'u.name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th class="title">
					<?php echo JHTML::_('grid.sort', 'AUP_USERNAME', 'u.username', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th class="title" width="8%">
					<?php echo JHTML::_('grid.sort', 'AUP_POINTS', 'a.points', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th class="title" width="12%">
					<?php echo JHTML::_('grid.sort', 'AUP_APPROVED', 'a.approved', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="8">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
			$k = 0;
			for ($i=0, $n=count( $this->activities ); $i < $n; $i++)
			{
				$row 	=& $this->activities[$i];
				$link 	= 'index.php?option=com_alphauserpoints&amp;task=showdetails&amp;cid='. $row->referreid. '&amp;name='.$row->uname;
				$style  = ( $row->last_points < 0 ) ? 'style="color:red;"' : '' ;
			?>
			<tr class="<?php echo "row$k"; ?>" <?php echo "$style"; ?>>
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<?php echo JHTML::_('grid.id', $i, $row->id ); ?>
				</td>
				<td align="center">
					<?php echo JHTML::_('date',  $row->insert_date,  JText::_('DATE_FORMAT_LC2') ); ?>				
				</td>
				<td>
					<?php echo JText::_($row->rule_name); ?>
				</td>
				<td>
					<a href="<?php echo $link; ?>">
						<?php echo htmlspecialchars(JText::_( $row->uname ), ENT_QUOTES, 'UTF-8'); ?>
					</a>
				</td>
				<td>
					<a href="<?php echo $link; ?>">
						<?php echo htmlspecialchars(JText::_( $row->usrname ), ENT_QUOTES, 'UTF-8'); ?>
					</a>
				</td>
				<td align="right">
				<?php echo getFormattedPoints($row->last_points); ?>									
				</td>
				<td align="center">
				<?php 
				if ( $row->approved=='1' ) {
					echo JText::_( 'AUP_APPROVED' );
				} elseif ( $row->approved=='0' ) {
					echo JText::_( 'AUP_UNAPPROVED' );
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
	<input type="hidden" name="task" value="activities" />
	<input type="hidden" name="table" value="__alpha_userpoints_details" />
	<input type="hidden" name="redirect" value="activities" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo @$this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo @$this->lists['order_Dir']; ?>" />	
</form>