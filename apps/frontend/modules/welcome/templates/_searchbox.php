<?php if($sf_user->isAuthenticated()): ?>
<div class="searchbox">
<h1>Search</h1>
<form action="<?php echo url_for('asset_search') ?>" method="get">
  <input type="text" name="query" size="60" value="<?php echo $sf_request->getParameter('query') ?>" id="search_keywords" />
  <input type="submit" value="search" />
  <?php echo image_tag('loader.gif', array('id'=>'loader', 'style'=>'vertical-align: middle; display: none')) ?>
  <div class="searchhelp">
Enter some keywords (+, -, title:..., notes:...)
  </div>
</form>
</div>
<?php endif ?>