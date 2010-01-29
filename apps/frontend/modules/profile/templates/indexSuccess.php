<h1><?php echo __('Profile') ?></h1>

<pre>
Name: <?php echo $sf_user->getProfile()->getFirstName() . "\n" ?>
Surname: <?php echo $sf_user->getProfile()->getLastName() . "\n"?>

Permissions:
<?php foreach($sf_user->getAllPermissionNames() as $permission): ?>
* <?php echo $permission . "\n" ?>
<?php endforeach ?>

</pre>