<?php include_partial('welcome/results', array('pager'=>$pager, 'action'=>$action, 'item_name'=>'asset')) ?>
<?php include_partial('welcome/pager', array('pager'=>$pager, 'action'=>$action, 'params'=>$params)) ?>

<?php if ($pager->getNbResults()>0): ?>
<?php include_partial('asset/list', array('Assets'=>$pager->getResults())) ?>
<?php endif ?>


  
