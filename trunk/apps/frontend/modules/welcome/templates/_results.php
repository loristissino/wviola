<div class="pagination_desc">
  <strong>
  <?php echo format_number_choice(
    '[0]No asset found|[1]One asset found|(1,+Inf]%number% assets found',
    array('%number%'=>$pager->getNbResults()),
    $pager->getNbResults()
    )
  ?>
  </strong>
  <?php if ($pager->haveToPaginate()): ?>
    - 
    <?php echo __(
      'Page <strong>%page%</strong>/%pages%',
      array(
        '%page%'=>$pager->getPage(),
        '%pages%'=>$pager->getLastPage(),
        )
      )
    ?>
  <?php endif; ?>
</div>

