<?php use_helper('Wviola') ?>
<h1 id="maintitle"><?php echo __('%firstname%\'s profile', array('%firstname%'=>$sf_user->getProfile()->getFirstName())) ?></h1>

<p>
<?php echo __('Username') ?>:
  <strong><?php echo $sf_user->getUsername()?></strong><br />
<?php echo __('First name') ?>:
  <strong><?php echo $sf_user->getProfile()->getFirstName()?></strong><br />
<?php echo __('Last name') ?>:
  <strong><?php echo $sf_user->getProfile()->getLastName()?></strong><br />
<?php /*<?php echo __('UserId') ?>:
  <strong><?php echo $sf_user->getProfile()->getUserId()?></strong><br /> */ ?>
</p>

<h2><?php echo __('Permissions') ?></h2>
<?php if(sizeof($sf_user->getAllPermissionNames())>0): ?>
<ul>
<?php foreach($sf_user->getAllPermissionNames() as $permission): ?>
  <li><?php echo $permission ?></li>
<?php endforeach ?>
</ul>
<?php else: ?>
  <?php echo __('No permission') ?>
<?php endif ?>

<?php if ($sf_user->hasCredential('admin')): ?>
<h2><?php echo __('Backend') ?></h2>
<ul class="sf_admin_actions">
<li class="sf_admin_action_backend"><?php echo link_to(
  __('Backend administration'),
  url_for_backend('homepage', array())
  )?>
</li>
</ul>
<?php endif ?>