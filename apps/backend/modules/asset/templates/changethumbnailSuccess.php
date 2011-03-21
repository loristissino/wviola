<h1><?php echo __('Thumbnail for asset %asset_id%', array('%asset_id%' =>$Asset->getId())) ?></h1>

<form action="<?php echo url_for('@changethumbnail?id=' . $Asset->getId()) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php //echo $form->renderHiddenFields(false) ?>
          <input type="submit" value="<?php echo __('Upload') ?>" />
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <?php //echo $form->renderHiddenFields(false) ?>
          <?php echo link_to(
            __('Back to list'),
            url_for('asset')
            )
          ?>
        </td>
      </tr>
    </tfoot>
    <tbody>
      <tr>
        <th><label for="asset_current_thumbnail"><?php echo __('Current thumbnail') ?></label>
        </th>
        <td><?php include_partial('thumbnail', array('Asset'=>$Asset, 'link'=>false)) ?>
        </td>
      </tr>
      <tr>
        <th><label for="asset_current_thumbnail_width_and_height"><?php echo __('Width and height') ?></label>
        </th>
        <td><?php echo $Asset->getThumbnailWidth() ?>x<?php echo $Asset->getThumbnailHeight() ?>
        </td>
      </tr>
      <tr>
        <th><label for="asset_current_thumbnail_size"><?php echo __('Size') ?></label>
        </th>
        <td><?php echo $Asset->getThumbnailSize() ?>
        </td>
      </tr>
      <?php echo $form ?>
    </tbody>
  </table>
</form>
