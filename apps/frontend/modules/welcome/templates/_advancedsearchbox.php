<?php if($sf_user->isAuthenticated()): ?>
<?php use_stylesheets_for_form($form) ?>
<div class="searchbox">
<h1>Advanced Search</h1>
<form action="<?php echo url_for('@asset_empty_advancedsearch') ?>" method="get" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php echo $form['actionrequested'] ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          <input type="submit" value="<?php echo __('Search') ?>" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['title']->renderLabel() ?></th>
        <td>
          <?php echo $form['title']->renderError() ?>
          <?php echo $form['title'] ?>
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
        <th><?php echo $form['binder']->renderLabel() ?></th>
        <td>
          <?php echo $form['binder']->renderError() ?>
          <?php echo $form['binder'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['date']->renderLabel() ?></th>
        <td>
          <?php echo $form['date']->renderError() ?>
          <?php echo $form['date'] ?>
        </td>
      </tr>

    </tbody>
  </table>
</form>

</div>
<?php endif ?>