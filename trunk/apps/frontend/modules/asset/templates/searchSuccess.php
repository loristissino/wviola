<?php include_partial('welcome/searchbox') ?>
<?php if(sizeof($Assets)>0): ?>
<h2>Search results</h2>
<?php endif ?>
<div id="assets">
  <?php if(sizeof($Assets)>0): ?>
    <?php include_partial('asset/list', array('Assets' => $Assets)) ?>
  <?php else: ?>
    <?php if(""!=$query): ?>
      <?php include_partial('asset/noresults') ?>
    <?php endif ?>
  <?php endif ?>
</div>
