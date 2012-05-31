<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="<?php echo sfConfig::get('sf_default_culture')?>">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <title>WVIOLA
    <?php if (has_slot('subtitle')): ?>
       - <?php include_slot('subtitle') ?>
    <?php endif ?>
    </title>
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
    <?php if ($sf_user->hasFlash('notice')): ?>
      <div class="notice"><?php echo $sf_user->getFlash('notice')?></div>
    <?php endif; ?>
    <?php if ($sf_user->hasFlash('error')): ?>
      <div class="error"><?php echo $sf_user->getFlash('error')?></div>
    <?php endif; ?>
    <?php echo $sf_content ?>
	  <?php include_component('welcome', 'info') ?>
	</div>
	<div class="tagline">
	<p>
  <a href="http://code.google.com/p/wviola"><?php echo image_tag('wviola', array('alt'=>'WVIOLA logo', 'size'=>'16x16')) ?>&nbsp;WVIOLA (Web-based Videos and Images On Line Archiver)</a><br />
  Copyright &copy 2009-2012 Loris Tissino<br />
  <?php echo __('Free software released under the %license%', array(
      '%license%'=>link_to(
        __('GNU General Public License v3'),
        'http://www.gnu.org/licenses/gpl.html'
        )
      )
      ) ?>
  </p>
	</div>
  </body>  
</html>
