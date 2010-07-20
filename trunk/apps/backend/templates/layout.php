<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php use_helper('Wviola') ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="<?php echo sfConfig::get('sf_default_culture')?>">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="<?php echo sfConfig::get('app_config_website')?>/images/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <?php echo $sf_content ?>
	<hr />
	<?php echo link_to(__('Back end home'), '@homepage') ?>
  &nbsp;-&nbsp;
  <?php echo link_to(
    __('Front end'),
    url_for_frontend('homepage', array())
    )?>
  </body>
</html>
