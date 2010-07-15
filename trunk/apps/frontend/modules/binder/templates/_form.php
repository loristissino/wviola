<?php use_stylesheets_for_form($form) ?>
<?php use_stylesheet('ui-lightness/jquery-ui-1.8.custom.css') ?>
<?php use_javascripts_for_form($form) ?>
<?php use_javascript('jquery-ui-1.8.custom.min.js') ?>
<?php use_javascript('datepicker') ?>
<?php use_javascript('jquery.ui.datepicker-' . sfConfig::get('sf_default_culture') . '.js') ?>
<?php use_helper('jQuery') ?>

<?php if ($form['embedded']->getValue()): ?>
  <?php echo jq_form_remote_tag(array(
      'update'   => 'binderchoice',
      'url'      => 'binder/create',
      'complete' => "$('#newbinderform').hide();",
  )) ?>
<?php else: ?>
  <form action="<?php echo url_for('binder/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php endif ?>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;
          <?php if(!$form['embedded']->getValue()): ?>
          <?php echo link_to(
            __('Back to list'),
            url_for('binder/index'))
          ?>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to(__('Delete'), 'binder/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => __('Are you sure?'))) ?>
          <?php endif; ?>
          <?php endif ?>
          <input type="submit" value="<?php echo __('Save') ?>" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['category_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['category_id']->renderError() ?>
          <?php echo $form['category_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['title']->renderLabel() ?></th>
        <td>
          <?php echo $form['title']->renderError() ?>
          <?php echo $form['title'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['code']->renderLabel() ?></th>
        <td>
          <?php echo $form['code']->renderError() ?>
          <?php echo $form['code'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['event_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['event_date']->renderError() ?>
          <?php echo $form['event_date'] ?>
        </td>
      </tr>

    </tbody>
  </table>
</form>
<?php if($form['embedded']->getValue()): ?>
  <?php echo jq_link_to_function(__('Close this window'),
    jq_visual_effect('fadeOut', '#newbinderform')
    ) ?>
<?php endif ?>
