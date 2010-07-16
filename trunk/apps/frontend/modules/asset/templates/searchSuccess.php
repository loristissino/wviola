<?php include_partial('welcome/searchbox', array('query'=>$query)) ?>
<?php if($pager->getNbResults()>0): ?>
<h2><?php echo __('Search results') ?></h2>
<?php endif ?>
<div id="assets">
  <?php if($pager->getNbResults()>0): ?>
    <?php include_partial('asset/assetpager', array('pager'=>$pager, 'action'=>'asset/search', 'item_name'=>'result', 'params'=>'query=' . $query)) ?>
  <?php else: ?>
    <?php if(""!=$query): ?>
      <?php include_partial('asset/noresults') ?>
    <?php endif ?>
  <?php endif ?>
</div>
<?php use_javascript('searchfocus.js') ?>
