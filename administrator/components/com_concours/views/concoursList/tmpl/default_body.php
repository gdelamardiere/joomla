<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');?>
<?php 
foreach($this->items as $i => $item): ?>
        <tr class="row<?php echo $i % 2; ?>">
                <td>
                        <?php echo $item->id; ?>
                </td>
                <td>
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                </td>
                <td>
                        <a href="<?php echo JRoute::_('index.php?option=com_concours&task=concours.edit&id=' . $item->id); ?>">
                                <?php echo $item->libelle; ?>
                        </a>
                </td>
                <td>
                        <a href="<?php echo JRoute::_('index.php?option=com_concours&task=concours.edit&id=' . $item->id); ?>">
                                <?php echo $item->nb_gagnant; ?>
                        </a>
                </td>
                <td>
                        <a href="<?php echo JRoute::_('index.php?option=com_concours&task=concours.edit&id=' . $item->id); ?>">
                                <?php echo $item->tirage; ?>
                        </a>
                </td>
                <td>
                        <a href="<?php echo JRoute::_('index.php?option=com_concours&view=gain_concoursList&id_concours=' . $item->id); ?>">
                                Voir les lots
                        </a>
                </td>
                <td>
                        <a href="<?php echo JRoute::_('index.php?option=com_concours&view=participantList&id_concours=' . $item->id); ?>">
                                Voir les Participants(<?php echo $item->nb_participant;?>)
                        </a>
                </td>
                <td>
                        <?php if( $item->tirage==1){?>
                        <a href="<?php echo JRoute::_('index.php?option=com_concours&view=gagnantList&id_concours=' . $item->id); ?>">
                                Voir les Gagnants
                        </a>

                        <?php }?>
                </td>
        </tr>
<?php endforeach; ?>