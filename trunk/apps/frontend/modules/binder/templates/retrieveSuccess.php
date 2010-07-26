<th><label for="binder_title"><?php echo __('Title') ?></label></th>
  <td>
    <?php if(!$value): ?>
    <ul class="error_list">
    <li><?php echo __('No hints available.') ?></li>
    </ul>
    <?php endif ?>

    <input size="70" type="text" name="binder[title]" id="binder_title" value="<?php echo $value ?>" />
  </td>
