<td>
  <ul class="sf_admin_td_actions">
    <?php echo $helper->linkToEdit($Asset, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
    <?php echo $helper->linkToDelete($Asset, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
    <?php echo $helper->linkToChangeThumbnail($Asset, array(  'params' =>   array(  ),  'class_suffix' => 'thumbnail',  'label' => __('Change thumbnail'),)) ?>
  </ul>
</td>

