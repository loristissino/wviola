<?php if($sf_user->isAuthenticated()): ?>
<div class="searchbox">
<h1><?php echo __('Search') ?></h1>
<form action="<?php echo url_for('asset_search') ?>" method="get">
  <input type="text" name="query" size="60" value="<?php echo $sf_request->getParameter('query') ?>" id="search_keywords" />
  <input type="submit" value="<?php echo __('Search') ?>" />
  <?php echo image_tag('loader.gif', array('id'=>'loader', 'style'=>'vertical-align: middle; display: none')) ?>
  <?php echo link_to(
    __('Advanced Search'),
    url_for($query ? '@asset_filled_advancedsearch?query=' . $query : '@asset_empty_advancedsearch')
  )?>
  <div class="searchhelp">
<?php echo __('Enter some keywords (+, -, title:…, notes:…)') ?>
  </div>
</form>
</div>
<?php endif ?>