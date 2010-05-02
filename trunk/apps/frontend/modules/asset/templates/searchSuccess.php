<?php if(sizeof($Assets)>0): ?>
<h2>Search results</h2>
<div id="assets">
  <?php include_partial('asset/list', array('Assets' => $Assets)) ?>
</div>
<?php endif ?>
