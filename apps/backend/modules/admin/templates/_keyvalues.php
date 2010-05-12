<pre>
<?php print_r($values) ?>
</pre>
<?php if (is_array($values)): ?>
  <?php foreach($values as $key=>$value): ?>
  <?php if ($value): ?>
    <?php include_partial('admin/keyvalue', array('key'=>$key, 'value'=>$value)) ?>
  <?php endif ?>
  <?php endforeach ?>
<?php endif ?>
