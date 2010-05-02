<?php if($sf_user->isAuthenticated()): ?>
<div class="searchbox">
<h2>Search</h2>
<form action="<?php echo url_for('asset_search') ?>" method="get">
  <input type="text" name="query" value="<?php echo $sf_request->getParameter('query') ?>" id="search_keywords" />
  <input type="submit" value="search" />
  <?php echo image_tag('loader.gif', array('id'=>'loader', 'style'=>'vertical-align: middle; display: none')) ?>
  <div class="help">
Enter some keywords (+, -, title:..., notes:...)
  </div>
</form>
</div>
<?php endif ?>