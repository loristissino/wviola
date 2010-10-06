<?php use_helper('Wviola') ?>
<h1><?php echo __('Archive %id% (%slug%)', array('%id%'=>$Archive->getId(), '%slug%'=>$Archive->getSlug())) ?></h1>
<p><?php echo __('Index') ?></p>
<ul>
<?php foreach($Archive->getBinders() as $Binder): ?>
  <li>
    <a href="#binder_<?php echo $Binder->getId() ?>">
    <?php echo __('Binder %id% «%title%»', array('%id%'=>$Binder->getId(), '%title%'=>$Binder->getTitle())) ?>
    </a>
  </li>
<?php endforeach ?>
</ul>
<?php foreach($Archive->getBinders() as $Binder): ?>
  <h2>
  <a name="binder_<?php echo $Binder->getId() ?>"></a>
  <?php echo __('Binder «%title%»', array('%title%'=>$Binder->getTitle())) ?>
  </h2>
  <p>
  <?php echo __('Binder id: %id%', array('%id%'=>$Binder->getId())) ?><br />
  <?php echo __('User: %username%', array('%username%'=>$Binder->getSfGuardUserProfile()->getUsername())) ?><br />
  <?php echo __('Event date: %date%', array('%date%'=>$Binder->getEventDate())) ?><br />
  <?php echo __('Code: %code%', array('%code%'=>$Binder->getCode())) ?><br />
  <?php echo __('Category: %category_shortcut% (%category_name%)', array('%category_shortcut%'=>$Binder->getCategory()->getShortcut(), '%category_name%'=>$Binder->getCategory()->getName())) ?><br />
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
        <li><?php echo __('Notes: %notes%', array('%notes%'=>$Asset->getNotes())) ?></li>
        <li><?php echo __('Uniqid: %uniqid%', array('%uniqid%'=>$Asset->getUniqid())) ?></li>
        <li><?php echo __('Size: %size%', array('%size%'=>Generic::getHumanReadableSize($Asset->getHighQualitySize()))) ?></li>
        <li><?php echo __('MD5: %md5%', array('%md5%'=>$Asset->getHighQualityMD5Sum())) ?></li>
      </ul>
    </li>
  <?php endforeach ?>
  </ul>
<?php endforeach ?>
