<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo link_to($TaskLogEvent->getId(), 'task_log_event_edit', $TaskLogEvent) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_task_name">
  <?php echo $TaskLogEvent->getTaskName() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_options">
<?php //FIXME This doesn't work: include_component('admin', 'keyvalues', array('serializedvalues'=>$TaskLogEvent->getOptions())) ?>
<?php $values=unserialize(html_entity_decode($TaskLogEvent->getOptions())) ?>
<?php if (is_array($values)): ?>
  <?php foreach($values as $key=>$value): ?>
  <?php if ($value): ?>
    <?php include_partial('admin/keyvalue', array('key'=>$key, 'value'=>$value)) ?>
  <?php endif ?>
  <?php endforeach ?>
<?php endif ?>
</td>
<td class="sf_admin_text sf_admin_list_td_arguments">
<?php $values=unserialize(html_entity_decode($TaskLogEvent->getArguments())) ?>
<?php if (is_array($values)): ?>
  <?php foreach($values as $key=>$value): ?>
  <?php if ($value): ?>
    <?php include_partial('admin/keyvalue', array('key'=>$key, 'value'=>$value)) ?>
  <?php endif ?>
  <?php endforeach ?>
<?php endif ?>
</td>
<td class="sf_admin_date sf_admin_list_td_started_at">
  <?php echo false !== strtotime($TaskLogEvent->getStartedAt()) ? format_date($TaskLogEvent->getStartedAt(), sfConfig::get('app_admin_date_format')) : '&nbsp;' ?>
</td>
<td class="sf_admin_date sf_admin_list_td_finished_at">
  <?php echo false !== strtotime($TaskLogEvent->getFinishedAt()) ? format_date($TaskLogEvent->getFinishedAt(), sfConfig::get('app_admin_date_format')) : '&nbsp;' ?>
</td>
<td class="sf_admin_text sf_admin_list_td_task_exception">
  <?php echo $TaskLogEvent->getTaskException() ?>
</td>
