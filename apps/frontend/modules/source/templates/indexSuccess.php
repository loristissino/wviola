<h1><?php echo __('Scanned Sources List') ?></h1>
<?php include_partial('welcome/results', array('pager'=>$pager, 'action'=>'source/index', 'item_name'=>'source')) ?>
<?php include_partial('welcome/pager', array('pager'=>$pager, 'action'=>'source/index', 'params'=>'')) ?>

<?php if ($pager->getNbResults()>0): ?>
<table>
  <thead>
    <tr>
      <th><?php echo __('Relative path') ?></th>
      <th><?php echo __('Filename') ?></th>
      <th><?php echo __('Status') ?></th>
      <th><?php echo __('Scanned at') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php $oldpath='' ?>
    <?php foreach ($pager->getResults() as $Source): ?>
    <tr>
      <td>
        <?php if ($Source->getRelativePath()!=$oldpath): ?>
          <?php echo link_to(
          $Source->getRelativePath(),
          url_for('filebrowser/opendir?code=' . Generic::b64_serialize($Source->getRelativePath()))
          )
          ?>
          <?php $oldpath=$Source->getRelativePath() ?>
        <?php endif ?>
        </td>
      <td><?php echo link_to(
        $Source->getBasename(),
        url_for('filebrowser/opendir?code=' . Generic::b64_serialize($Source->getRelativePath())) . '#' . $Source->getInode()
        )
        ?></td>
      <td><?php include_partial('sourcestatus', array('status'=>$Source->getStatus())) ?></td>
      <td><?php echo $Source->getCreatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif ?>
