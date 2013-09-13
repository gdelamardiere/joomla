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
	var_dump($this->getGagnantConcours);
}
else{
	echo "ce concours n'existe pas!!";
} ?>