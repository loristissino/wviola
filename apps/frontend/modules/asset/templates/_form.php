<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('asset/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('asset/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'asset/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['slug']->renderLabel() ?></th>
        <td>
          <?php echo $form['slug']->renderError() ?>
          <?php echo $form['slug'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['asset_type_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['asset_type_id']->renderError() ?>
          <?php echo $form['asset_type_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['assigned_title']->renderLabel() ?></th>
        <td>
          <?php echo $form['assigned_title']->renderError() ?>
          <?php echo $form['assigned_title'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['category_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['category_id']->renderError() ?>
          <?php echo $form['category_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['notes']->renderLabel() ?></th>
        <td>
          <?php echo $form['notes']->renderError() ?>
          <?php echo $form['notes'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['duration']->renderLabel() ?></th>
        <td>
          <?php echo $form['duration']->renderError() ?>
          <?php echo $form['duration'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['source_filename']->renderLabel() ?></th>
        <td>
          <?php echo $form['source_filename']->renderError() ?>
          <?php echo $form['source_filename'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['source_file_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['source_file_date']->renderError() ?>
          <?php echo $form['source_file_date'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['highquality_width']->renderLabel() ?></th>
        <td>
          <?php echo $form['highquality_width']->renderError() ?>
          <?php echo $form['highquality_width'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['highquality_height']->renderLabel() ?></th>
        <td>
          <?php echo $form['highquality_height']->renderError() ?>
          <?php echo $form['highquality_height'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['highquality_video_codec']->renderLabel() ?></th>
        <td>
          <?php echo $form['highquality_video_codec']->renderError() ?>
          <?php echo $form['highquality_video_codec'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['highquality_audio_codec']->renderLabel() ?></th>
        <td>
          <?php echo $form['highquality_audio_codec']->renderError() ?>
          <?php echo $form['highquality_audio_codec'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['highquality_frame_rate']->renderLabel() ?></th>
        <td>
          <?php echo $form['highquality_frame_rate']->renderError() ?>
          <?php echo $form['highquality_frame_rate'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['highquality_md5sum']->renderLabel() ?></th>
        <td>
          <?php echo $form['highquality_md5sum']->renderError() ?>
          <?php echo $form['highquality_md5sum'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['lowquality_width']->renderLabel() ?></th>
        <td>
          <?php echo $form['lowquality_width']->renderError() ?>
          <?php echo $form['lowquality_width'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['lowquality_height']->renderLabel() ?></th>
        <td>
          <?php echo $form['lowquality_height']->renderError() ?>
          <?php echo $form['lowquality_height'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['lowquality_video_codec']->renderLabel() ?></th>
        <td>
          <?php echo $form['lowquality_video_codec']->renderError() ?>
          <?php echo $form['lowquality_video_codec'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['lowquality_audio_codec']->renderLabel() ?></th>
        <td>
          <?php echo $form['lowquality_audio_codec']->renderError() ?>
          <?php echo $form['lowquality_audio_codec'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['lowquality_frame_rate']->renderLabel() ?></th>
        <td>
          <?php echo $form['lowquality_frame_rate']->renderError() ?>
          <?php echo $form['lowquality_frame_rate'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['lowquality_md5sum']->renderLabel() ?></th>
        <td>
          <?php echo $form['lowquality_md5sum']->renderError() ?>
          <?php echo $form['lowquality_md5sum'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['user_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['user_id']->renderError() ?>
          <?php echo $form['user_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['created_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['created_at']->renderError() ?>
          <?php echo $form['created_at'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['updated_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['updated_at']->renderError() ?>
          <?php echo $form['updated_at'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
