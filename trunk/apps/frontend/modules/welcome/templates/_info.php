<div class="info">
   <p>
  <?php if(!$sf_user->isAuthenticated()): ?>
        <?php echo link_to(__('Login'), '@sf_guard_signin') ?>
  <?php else: ?>
        <?php echo link_to(__('Logout'), '@sf_guard_signout') ?> - 
		<?php echo link_to(__('Profile'), '@profile') ?>
  <?php endif ?>
</div>