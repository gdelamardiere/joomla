<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_concours
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<?php 
if($this->getExistConcours){
	$user = &JFactory::getUser() ;
	if ( $user->id ) {?>
		     <a href="<?php echo JRoute::_('index.php?option=com_concours&task=participation_concours.edit&id=' . JRequest::getint('id')); ?>">Participer</a>
	<?php } else {
		  echo "non connecte";
		} 
    	
}
else{
	echo "ce concours n'existe pas!!";
} ?>