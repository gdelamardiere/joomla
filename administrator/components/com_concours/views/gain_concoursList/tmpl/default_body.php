<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');?>
<?php 
foreach($this->items as $i => $item): ?>
        <tr class="row<?php echo $i % 2; ?>">
                <td>
                        <a href="<?php echo JRoute::_('index.php?option=com_concours&task=concours.edit&id=' . $item->id_concours); ?>"><?php echo $item->libelle_concours; ?></a>
                </td>
                <td>
                        <a href="<?php echo JRoute::_('index.php?option=com_concours&task=gain_concours.edit&id=' . $item->id); ?>">
                                <?php echo $item->place; ?>
                        </a>
                </td>
                <td>
                        <a href="<?php echo JRoute::_('index.php?option=com_concours&task=gain_concours.edit&id=' . $item->id); ?>">
                                <?php echo $item->lot; ?>
                        </a>
                </td>
        </tr>
<?php endforeach; ?>