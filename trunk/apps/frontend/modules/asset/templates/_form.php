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
        <th><?php echo $form['uniqid']->renderLabel() ?></th>
        <td>
          <?php echo $form['uniqid']->renderError() ?>
          <?php echo $form['uniqid'] ?>
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
        <th><?php echo $form['user_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['user_id']->renderError() ?>
          <?php echo $form['user_id'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
