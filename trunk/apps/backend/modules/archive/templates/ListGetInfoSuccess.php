<?php use_helper('Wviola') ?>
<h1><?php echo __('Archive %id% (%slug%)', array('%id%'=>$Archive->getId(), '%slug%'=>$Archive->getSlug())) ?></h1>
<p><?php echo __('Index') ?></p>
<ul>
<?php foreach($Archive->getBinders() as $Binder): ?>
  <li>
    <a href="#binder_<?php echo $Binder->getId() ?>">
    <?php echo sprintf('Raccoglitore %d «%s»', $Binder->getId(), $Binder->getTitle()) ?>
    </a>
  </li>
<?php endforeach ?>
</ul>
<?php foreach($Archive->getBinders() as $Binder): ?>
  <h2>
  <a name="binder_<?php echo $Binder->getId() ?>"></a>
  <?php echo __('Binder %id% «%title%»', array('%id%'=>$Binder->getId(), '%title%'=>$Binder->getTitle())) ?>
  </h2>
  <p>
  <?php echo __('User: %username%', array('%username%'=>$Binder->getSfGuardUserProfile()->getUsername())) ?><br />
  <?php echo __('Event date: %date%', array('%date%'=>$Binder->getEventDate())) ?><br />
  <?php echo link_to(
    __('Show binder'),
    url_for_frontend('binder_show', array('id'=>$Binder->getId()))
    ) ?>
  </p>
  <h3><?php echo __('Assets') ?></h3>
  <ul>
  <?php foreach($Binder->getAssets() as $Asset): ?>
    <li>
      <?php echo sprintf('%s (id %d)', $Asset->getAssetTypeCode(), $Asset->getId()) ?>

      <ul>
        <li><?php echo sprintf('Note: «%s»', $Asset->getNotes()) ?></li>
        <li><?php echo sprintf('Dimensione: %s', Generic::getHumanReadableSize($Asset->getHighQualitySize())) ?></li>
        <li><?php echo sprintf('MD5: %s', $Asset->getHighQualityMD5Sum()) ?></li>
      </ul>
    </li>
  <?php endforeach ?>
  </ul>
<?php endforeach ?>
