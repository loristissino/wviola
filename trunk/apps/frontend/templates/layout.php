<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="<?php echo sfConfig::get('sf_default_culture')?>">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="<?php echo sfConfig::get('app_config_website')?>/images/favicon.ico" />
    <?php use_javascript('search.js') ?>
    <?php use_helper('jQuery') ?>
    <?php include_javascripts() 
    /* the book says it could be at the end of the page for performance reasons 
    but that way it doesn't work with FlowPlayer (which is not unobtrusive) */?>
  </head>
  <body>
    <div id="header"><?php echo sfConfig::get('app_config_organization') ?></div>
	<div id="sf_admin_container">
  <?php include_partial('welcome/searchbox') ?>
    <?php if ($sf_user->hasFlash('notice')): ?>
      <div class="notice"><?php echo $sf_user->getFlash('notice')?></div>
    <?php endif; ?>
    <?php if ($sf_user->hasFlash('error')): ?>
      <div class="error"><?php echo $sf_user->getFlash('error')?></div>
    <?php endif; ?>
    <?php echo $sf_content ?>
	</div>
	<hr />
	<?php include_component('welcome', 'info') ?>
	<div class="tagline">
	<p><a href="http://code.google.com/p/wviola">WVIOLA</a></p>
	</div>
  </body>  
</html>
