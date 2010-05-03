<?php if($sf_user->isAuthenticated()): ?>
  <hr />
  <ul class="sf_admin_td_actions">
    <li class="sf_admin_action_search"><?php echo link_to(__('Search'), '@asset_search') ?></li>
    <li class="sf_admin_action_sources"><?php echo link_to(__('My sources'), 'source/index') ?></li>
    <li class="sf_admin_action_binders"><?php echo link_to(__('My binders'), 'binder/index') ?></li>
    <li class="sf_admin_action_assets"><?php echo link_to(__('My assets'), 'asset/index') ?></li>
  </ul>
<?php endif ?>
  <hr />
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
&nbsp;-&nbsp;
<?php echo link_to(__('Home'), '@homepage') ?>
	</p>
</div>
