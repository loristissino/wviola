<?php include_partial('welcome/title', array('title'=>__('Archive asset «%filename%»', array('%filename%'=>Generic::standardizePath($sourcefile->getBaseName()))))) ?>

<h2><?php echo __('Basic information') ?></h2>

<ul>
<li><?php echo __('Size') ?>: <?php echo Generic::getHumanReadableSize($sourcefile->getStat('size'))?></li>
<li><?php echo __('Date') ?>: <?php echo format_datetime($sourcefile->getStat('mtime')) ?></li>
<li><?php echo __('Full path') ?>: <?php echo $sourcefile->getAdaptedFullPath(wvConfig::get('filebrowser_path_replacements')) ?></li>
</ul>

<?php include_partial('form', array('form' => $form, 'sourcefile'=>$sourcefile, 'binderform'=>$binderform)) ?>

