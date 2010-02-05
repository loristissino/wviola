<h1><?php echo __('Backend administration') ?></h1>

<h2><?php echo __('Archives') ?></h2>
<ul>
<li><?php echo link_to(
	__('Archives'),
	url_for('@archive')
	)
	?>
</ul>

<h2><?php echo __('Logs') ?></h2>
<ul>
<li><?php echo link_to(
	__('Access log'),
	url_for('@access_log')
	)
	?>
</ul>

<h2><?php echo __('General configuration') ?></h2>
<ul>
<li><?php echo link_to(
	__('Categories'),
	url_for('@category')
	)
	?>
</ul>
