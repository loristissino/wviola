<?php use_helper('Wviola') ?>
<td>
  <ul class="sf_admin_td_actions">
    <?php echo $helper->linkToEdit($AccessLogEvent, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
    <?php echo $helper->linkToDelete($AccessLogEvent, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
    <li class='sf_admin_action_show'>
      <?php echo link_to(
        __('Show Asset'),
        url_for_frontend('asset_show', array('id'=>$AccessLogEvent->getAsset()->getId()))
        ) ?>
    </li>
  </ul>
</td>
