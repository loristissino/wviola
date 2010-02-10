<div class="info">
   <p>
<?php if ($sf_context->getActionName()!='signin'): ?>
  <?php if(!$sf_user->isAuthenticated()): ?>
        <?php echo link_to(__('Login'), '@sf_guard_signin') ?>
  <?php else: ?>
        <?php echo link_to(__('Logout'), '@sf_guard_signout') ?> - 
		<?php echo link_to(__('Profile'), '@profile') ?>
  <?php endif ?>
 <?php else: ?>
	<?php echo __('Login required') ?>
 <?php endif ?>
	</p>
</div>
