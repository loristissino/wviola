<td>
  <ul class="sf_admin_td_actions">
    <?php echo $helper->linkToEdit($Archive, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
    <li class="sf_admin_action_get_info">
      <?php echo link_to(__('Get info', array(), 'messages'), 'archive/ListGetInfo?id='.$Archive->getId(), array()) ?>
    </li>
    <?php if (!$Archive->getBurnedAt()): ?>
    <br />
    <li class="sf_admin_action_mark_as_burned">
      <?php echo link_to(__('Mark as burned', array(), 'messages'), 'archive/ListMarkAsBurned?id='.$Archive->getId(), array('confirm' => 
        __('You are marking the archive «%name%» as burned.', array('%name%'=>$Archive->getSlug()))
        . ' '
        . __('This operation will set all its contents as not available anymore online in high quality.')
        . ' '
        . __('Do you want to proceed?')
)) ?>
    </li>
    <?php endif ?>
  </ul>
</td>
