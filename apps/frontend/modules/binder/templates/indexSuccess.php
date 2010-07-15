<h1><?php echo __('Binders List') ?></h1>
<?php include_partial('welcome/results', array('pager'=>$pager, 'action'=>'binder/index', 'item_name'=>'binder')) ?>
<?php include_partial('welcome/pager', array('pager'=>$pager, 'action'=>'binder/index')) ?>

<?php if ($pager->getNbResults()>0): ?>
<table>
  <thead>
    <tr>
      <th><?php echo __('Id') ?></th>
      <th><?php echo __('Category') ?></th>
      <th><?php echo __('Title') ?></th>
      <th><?php echo __('Code') ?></th>
      <th><?php echo __('Event date') ?></th>
      <th><?php echo __('Assets count') ?></th>
      <th><?php echo __('Status') ?></th>
      <th><?php echo __('Actions') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($pager->getResults() as $Binder): ?>
    <tr>
      <td><a href="<?php echo url_for('binder/show?id='.$Binder->getId()) ?>"><?php echo $Binder->getId() ?></a></td>
      <td><?php echo $Binder->getCategory() ?></td>
      <td><?php echo $Binder->getTitle() ?></td>
      <td><?php echo $Binder->getCode() ?></td>
      <td><?php echo $Binder->getEventDate() ?></td>
      <td><?php echo $Binder->countAssets() ?></td>
      <td><?php include_partial('binder/status', array('Binder'=>$Binder)) ?></td> 
      <td>
        <ul class="sf_admin_td_actions">
          <li class="sf_admin_action_opendir"><?php echo link_to(
            __('Show'),
            'binder/show?id='.$Binder->getId()
            )
          ?></li>
        </ul>  
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif ?>
<ul class="sf_admin_actions">
  <li class="sf_admin_action_new"><?php echo link_to(
    __('New binder'),
    url_for('binder/new')
    )
  ?></li>
</ul>  
