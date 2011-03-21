<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php use_helper('Wviola') ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="<?php echo sfConfig::get('sf_default_culture')?>">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <title>WVIOLA <?php echo __('back end') ?>
    <?php if (has_slot('subtitle')): ?>
       - <?php include_slot('subtitle') ?>
    <?php endif ?>
    </title>
    <link rel="shortcut icon" href="<?php echo sfConfig::get('app_config_website')?>/images/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php use_helper('jQuery') ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <div id="header"><?php echo sfConfig::get('app_config_organization') ?></div>
    <div id="sf_admin_container">
    <?php if ($sf_user->hasFlash('notice')): ?>
      <div class="notice"><?php echo $sf_user->getFlash('notice')?></div>
    <?php endif; ?>
    <?php if ($sf_user->hasFlash('error')): ?>
      <div class="error"><?php echo $sf_user->getFlash('error')?></div>
    <?php endif; ?>

    <?php echo $sf_content ?>
    </div>
	<hr />
	<?php echo link_to(__('Back end home'), '@homepage') ?>
  &nbsp;-&nbsp;
  <?php echo link_to(
    __('Front end'),
    url_for_frontend('homepage', array())
    )?>
  <?php if($sf_user->isAuthenticated()): ?>
    &nbsp;-&nbsp;
    <?php echo link_to(__('Backend Logout'), '@sf_guard_signout') ?>
  <?php endif ?>
  
  </body>
</html>
