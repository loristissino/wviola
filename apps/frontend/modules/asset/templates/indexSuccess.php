<?php include_partial('welcome/title', array('title'=>__('Assets List'))) ?>
<?php include_partial('asset/assetpager', array('pager'=>$pager, 'action'=>'asset/index', 'item_name'=>'asset', 'params'=>'')) ?>
