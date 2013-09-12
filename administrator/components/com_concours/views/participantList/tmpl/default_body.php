<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');?>
<?php 
foreach($this->items as $i => $item): ?>
        <tr class="row<?php echo $i % 2; ?>">
                <td>
                        <?php echo $item->id_concours; ?>
                </td>
                <td>
                        <a href="<?php echo JRoute::_('index.php?option=com_concours&task=concours.edit&id=' . $item->id); ?>">
                                <?php echo $item->libelle_concours; ?>
                        </a>
                </td>
                <td>
                        <a href="<?php echo JRoute::_('index.php?option=com_users&view=user&layout=edit&id=' . $item->id_user); ?>">
                                <?php echo $item->id_user; ?>
                        </a>
                </td>
                <td>
                        <a href="<?php echo JRoute::_('index.php?option=com_users&view=user&layout=edit&id=' . $item->id_user); ?>">
                                <?php echo $item->username; ?>
                        </a>
                </td>
                <td>
                        <?php echo $item->nb_ligne; ?>
                </td>
        </tr>
<?php endforeach; ?>