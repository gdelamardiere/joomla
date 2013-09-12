<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2012 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

//Ordering allowed ?
$ordering = ($this->lists['order_rank'] == 'ordering');
JHTML::_('behavior.tooltip');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		//if (task == 'cpanel' || document.formvalidator.isValid(document.id('levelranks-form'))) {
			Joomla.submitform(task, document.getElementById('adminForm'));
		//}
		//else {
			//alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		//}
	}
</script>
<!-- <div class="clr"></div>-->
<!-- Listing ranks/medals Form -->
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
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->levelrank); ?>);" />
				</th>
				<th width="5%" class="title" >
					<?php echo JText::_('AUP_ICON'); ?>
				</th>
				<th width="10%" class="title">
					<?php echo JText::_('AUP_NAME'); ?>
				</th>
				<th class="title">
					<?php echo JText::_( 'AUP_DESCRIPTION' ); ?>
				</th>
				<th width="10%" class="title" nowrap="nowrap">
					<?php echo JText::_( 'JCATEGORY' ); ?>
				</th>
				<th width="10%" class="title" nowrap="nowrap">
					<?php echo JText::_('AUP_TYPE'); ?>
				</th>
				<th width="10%" class="title" nowrap="nowrap">
					<?php echo JText::_( 'AUP_LEVEL_POINTS' ); ?>
				</th>
				<th width="12%" class="title" nowrap="nowrap">
					<?php echo JText::_( 'AUP_IMAGE' ); ?>
				</th>
				<th width="3%" class="title" nowrap="nowrap">
					<?php echo JText::_( 'AUP_AWARDED' ); ?>
				</th>
				<th width="15%" class="title" nowrap="nowrap">
					<?php echo JText::_( 'AUP_ATTACH_TO_A_RULE' ); ?>
				</th>
				<th width="10%" class="title" nowrap="nowrap">&nbsp;
					<?php 
					// echo JHTML::_('grid.sort',   JTEXT::_('AUP_REORDER'), 'ordering', @$this->lists['order_Dir_rank'], @$this->lists['order_rank'] ); 
						echo JTEXT::_('AUP_REORDER');
					?>
					<?php echo JHTML::_('grid.order',  $this->levelrank ); ?>
				</th>		
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="16">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
			$k = 0;
			$last = count( $this->levelrank )-1;
			
			for ($i=0, $n=count( $this->levelrank ); $i < $n; $i++)			
			{
				$row 	=& $this->levelrank[$i];
				
				if ($row->icon ) {
					$pathicon = JURI::root() . 'components/com_alphauserpoints/assets/images/awards/icons/';
					$icone = '<img src="'.$pathicon . $row->icon.'" width="16" height="16" border="0" alt="" />';
				} else $icone ='';
				if ($row->image ) {
					$pathimage = JURI::root() . 'components/com_alphauserpoints/assets/images/awards/large/';
					$image = '<img src="'.$pathimage . $row->image.'" height="32" border="0" alt="" />';
				} else $image ='';				
				
				$typerank = ( $row->typerank ) ? JText::_( 'AUP_MEDAL' ) : JText::_( 'AUP_RANK' );
				
				$link 	= 'index.php?option=com_alphauserpoints&amp;task=editlevelrank&amp;cid[]='. $row->id. '';
				
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td align="center">
					<?php echo JHTML::_('grid.id', $i, $row->id ); ?>
				</td>
				<td>
					<div align="center">
					<?php echo $icone; ?>
					</div>
				</td>
				<td>
					<a href="<?php echo $link; ?>">
						<?php echo JText::_( $row->rank ); ?>
					</a>
				</td>
				<td>
					<div align="center">
					<?php echo JText::_( $row->description ); ?>
					</div>
				</td>
				<td>
					<div align="center">
					<?php echo JText::_( $row->category_title ); ?>
					</div>
				</td>
				<td>
					<div align="center">
					<?php echo $typerank; ?>
					</div>
				</td>
				<td>		
					<div align="center">
					<?php echo getFormattedPoints( $row->levelpoints ); ?>
					</div>
				</td>
				<td>
					<div align="center">
					<?php echo $image; ?>
					</div>
				</td>
				<td>
					<div align="center">
					<?php					
					$num = ( $row->typerank ) ? $row->nummedals : $row->numrank; 
					if ( $num ) {
						echo '<b><a href="index.php?option=com_alphauserpoints&amp;task=detailrank&amp;cid='.$row->id.'&amp;typerank='.$row->typerank.'">'.$num.'</a></b>';
					} else 	echo '-';
					?>
					</div>
				</td>
				<td>
					<div align="center">
					<?php echo $row->rulename; ?>
					</div>
				</td>
				<td class="order">
					<span><?php echo $this->pagination->orderUpIcon( $i, $row->typerank == @$this->levelrank[$i-1]->typerank, 'orderup', JText::_( 'AUP_MOVE_UP' ), $ordering ); ?></span>
					<span><?php echo $this->pagination->orderDownIcon( $i, $n,  $row->typerank == @$this->levelrank[$i+1]->typerank, 'orderdown', JText::_( 'AUP_MOVE_DOWN' ), $ordering ); ?></span>
					<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
					<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
				</td>
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>

	<input type="hidden" name="option" value="com_alphauserpoints" />
	<input type="hidden" name="task" value="levelrank" />
	<input type="hidden" name="table" value="alpha_userpoints_levelrank" />
	<input type="hidden" name="redirect" value="levelrank" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order_rank" value="<?php echo @$this->lists['order_rank']; ?>" />
	<input type="hidden" name="filter_order_Dir_rank" value="<?php echo @$this->lists['order_Dir_rank']; ?>" />
</form>
<div class="clr"></div>
<!-- File Upload Form -->
<form action="<?php echo JURI::base(); ?>index.php?option=com_alphauserpoints&amp;task=upload&amp;tmpl=component&amp;<?php echo JUtility::getToken();?>=1" id="uploadForm" method="post" enctype="multipart/form-data">
<div class="width-100 fltrt">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Upload File' ); ?> [ <?php echo JText::_( 'Max' ); ?>&nbsp;<?php echo (10000000 / 1000000); ?>M ]</legend>
		<fieldset class="actions">
			<input type="file" id="file-upload" name="Filedata" />
			<fieldset id="jform_folder" class="radio"><?php echo $this->lists['folder'] . "&nbsp;" ; ?></fieldset>
			<input type="submit" id="file-upload-submit" value="<?php echo JText::_('Start Upload'); ?>"/>
			<span id="upload-clear"></span>
		</fieldset>
		<ul class="upload-queue" id="upload-queue">
			<li style="display: none" />
		</ul>
	</fieldset>
</div>
	<input type="hidden" name="return-url" value="<?php echo base64_encode('index.php?option=com_alphauserpoints&task=levelrank'); ?>" />
</form>