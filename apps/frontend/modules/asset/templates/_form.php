<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php // use_helper('jQuery') ?>

<?php /* test only
<hr />
<div id="item_list"></div>
<?php echo jq_form_remote_tag(array(
    'update'   => 'item_list',
    'url'      => 'asset/testadd',
)) ?>
  <label for="item">Item:</label>
  <input type="text" name="item" />
  <input type="submit" name="Add" value="Add" />
</form>
<hr />

<div id="ajaxtest">some text</div>

<?php echo jq_link_to_remote(
  __('Change text'),
				array(
					'update'=>'ajaxtest',
					'url'=>'asset/ajaxtest')
) ?>

<hr />

*/ ?>

<form action="<?php echo url_for('asset/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('filebrowser/index') ?>">Back to files</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'asset/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Archive" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['binder_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['binder_id']->renderError() ?>
          <?php echo $form['binder_id'] ?>
          &nbsp;&nbsp;
          <?php echo link_to(
            __('New binder'),
            url_for('binder/new'),
            array('popup'=>array('popupWindow', 'width=600,height=300,left=250,top=0,scrollbars=yes'))
            )
          ?>
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
        <th><?php echo $form['notes']->renderLabel() ?></th>
        <td>
          <?php echo $form['notes']->renderError() ?>
          <?php echo $form['notes'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['thumbnail']->renderLabel() ?></th>
        <td>
          <?php echo $form['thumbnail']->renderError() ?>
          <?php echo $form['thumbnail'] ?>
        </td>
      </tr>

    </tbody>
  </table>
</form>
