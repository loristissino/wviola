<select name="asset[binder_id]" id="asset_binder_id">
<option value=""></option>
<?php foreach($Binders as $Binder): ?>
<option value="<?php echo $Binder->getId() ?>"
  <?php if($Binder->getId()==$selected): ?>
    <?php echo ' selected="selected"' ?>
  <?php endif ?>
>
<?php echo $Binder ?></option>
<?php endforeach ?>
</select>

<?php if (!$selected): ?>
<br />
<?php echo __('Binder information was not correctly filled and could not be saved.') ?>&nbsp;

<?php echo form_tag(
  'binder/create'
  )
?>

<?php /*

<?php foreach($sf_data->getRaw('BinderValues') as $key=>$value): ?>
  <input type="hidden" name="binder[<?php echo $key ?>]" id="binder_<?php echo $key ?>" value="<?php echo $value ?>" />
<?php endforeach ?>
  <input type="submit" value="See why" />
</form>

*/ ?>
<?php endif ?>

