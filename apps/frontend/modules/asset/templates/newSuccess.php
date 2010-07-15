<h1><?php echo __('Archive asset «%filename%»', array('%filename%'=>$sourcefile->getBaseName())) ?></h1>

<h2><?php echo __('Basic information') ?></h2>

<ul>
<li><?php echo __('Size') ?>: <?php echo Generic::getHumanReadableSize($sourcefile->getStat('size'))?></li>
<li><?php echo __('Date') ?>: <?php echo format_datetime($sourcefile->getStat('mtime')) ?></li>
</ul>

<?php include_partial('form', array('form' => $form, 'sourcefile'=>$sourcefile, 'binderform'=>$binderform)) ?>

