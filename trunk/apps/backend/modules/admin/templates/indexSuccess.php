<h1><?php echo __('Backend administration') ?></h1>

<h2><?php echo __('Archives') ?></h2>
<ul>
<li><?php echo link_to(
	__('Archives'),
	url_for('@archive')
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
	url_for('@access_log')
	)
	?></li>
<li><?php echo link_to(
	__('Task log'),
	url_for('@task_log')
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
<li><?php echo link_to(
	__('Asset types'),
	url_for('@asset_type')
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
