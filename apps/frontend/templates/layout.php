<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="<?php echo sfConfig::get('sf_default_culture')?>">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="<?php echo sfConfig::get('app_config_website')?>/images/favicon.ico" />
  </head>
  <body>
    <div id="header"><?php echo sfConfig::get('app_config_organization') ?></div>
	<div id="sf_admin_container">
    <?php echo $sf_content ?>
	</div>
	<hr />
	<?php include_component('welcome', 'info') ?>
	<div class="tagline">
	<p><a href="http://code.google.com/p/wviola">WVIOLA</a></p>
	</div>
  </body>  
</html>
