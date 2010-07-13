<?php if($sf_user->isAuthenticated()): ?>
  <hr />
  <ul class="sf_admin_actions">
    <li class="sf_admin_action_search"><?php echo link_to(__('Search'), '@asset_search') ?></li>
    <?php if($sf_user->hasCredential('asset_encode')): ?>
      <li class="sf_admin_action_sources"><?php echo link_to(__('Sources to archive'), 'filebrowser/index') ?></li>
      <li class="sf_admin_action_binders"><?php echo link_to(__('Binders I manage'), 'binder/index') ?></li>
      <li class="sf_admin_action_assets"><?php echo link_to(__('Assets I archived'), 'asset/index') ?></li>
    <?php endif ?>
  </ul>
<?php endif ?>
  <hr />
<div class="info">
   <p>
<?php if ($sf_context->getActionName()!='signin'): ?>
  <?php if(!$sf_user->isAuthenticated()): ?>
        <?php echo link_to(__('Login'), '@sf_guard_signin') ?>
  <?php else: ?>
        <?php echo link_to(__('Logout'), '@sf_guard_signout') ?>
        &nbsp;-&nbsp;
		<?php echo link_to(__('Profile'), '@profile') ?>
  <?php endif ?>
 <?php else: ?>
	<?php echo __('Login required') ?>
 <?php endif ?>
&nbsp;-&nbsp;
<?php echo link_to(__('Home'), '@homepage') ?>
	</p>
</div>
