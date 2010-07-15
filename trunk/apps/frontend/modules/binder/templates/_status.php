<?php if ($Binder->getIsOpen()): ?>
  <?php echo image_tag('openbinder', array('alt'=>__('Open binder'), 'title'=>__('Open binder'))) ?>
<?php else: ?>
  <?php echo image_tag('closedbinder', array('alt'=>__('Closed binder'), 'title'=>__('Closed binder'))) ?>
<?php endif ?>
