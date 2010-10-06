<h1><?php echo __('Back end administration') ?></h1>

<h2><?php echo __('Media') ?></h2>
<ul>
<li><?php echo link_to(
	__('ISO images and DVD-ROM archives'),
	url_for('@archive')
	)
	?></li>
<li><?php echo link_to(
	__('Binders'),
	url_for('@binder')
	)
	?></li>
<li><?php echo link_to(
	__('Assets'),
	url_for('@asset')
	)
	?></li>
</ul>

<h2><?php echo __('Logs') ?></h2>
<ul>
<li><?php echo link_to(
	__('Access log'),
	url_for('@access_log_event') 
	) 
	?></li>
<li><?php echo link_to(
	__('Task log'),
	url_for('@task_log_event')
	)
	?>
</ul>

<h2><?php echo __('General configuration') ?></h2>
<ul>
<li><?php echo link_to(
	__('Categories'),
	url_for('@category')
	)
	?></li>
</ul>

<h2><?php echo __('Users') ?></h2>
<ul>
<li><?php echo link_to(
	__('Users'),
	url_for('@sf_guard_user_profile')
	)
	?></li>
</ul>
