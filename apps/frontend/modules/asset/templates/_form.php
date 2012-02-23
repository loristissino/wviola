<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php use_helper('jQuery') ?>

<div id="newbinderform" style="display:none; z-index=1; position:fixed; background-color:#E0E0E0;padding:5px;height:300px; left:200px; top: 100px">
<?php include_partial('binder/form', array('form'=>$binderform)) ?>
</div>

<hr />

<form action="<?php echo url_for('asset/'.(!$form['id']->getValue() ? 'create' : 'update').($form['id']->getValue() ? '?id='.$form['id']->getValue() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'asset/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="<?php echo $form['id']->getValue()? __('Save'): __('Archive') ?>" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['binder_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['binder_id']->renderError() ?>
          <span id="binderchoice"><?php echo $form['binder_id'] ?></span>
          <ul class="sf_admin_actions">
          <li class="sf_admin_action_new"><?php echo jq_link_to_function(__('New binder'),
            jq_visual_effect('fadeIn', '#newbinderform')
            ) ?>
          </li>
          </ul>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['notes']->renderLabel() ?></th>
        <td>
          <?php echo $form['notes']->renderError() ?>
          <?php echo $form['notes'] ?>
        </td>
      </tr>
      <?php if($form->getOption('thumbnail')): ?>
        <tr>
          <th><?php echo $form['thumbnail']->renderLabel() ?></th>
          <td>
            <?php echo $form['thumbnail']->renderError() ?>
            <?php echo htmlspecialchars_decode($form['thumbnail']->render()) ?>
          </td>
        </tr>
      <?php endif ?>

    </tbody>
  </table>
</form>
