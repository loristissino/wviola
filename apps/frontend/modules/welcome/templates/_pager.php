<?php if ($pager->haveToPaginate()): ?>
  <div class="pagination">
    <?php echo link_to(
      image_tag('sfPropelPlugin/first'),
      url_for($action . '?page=1') . ($params!=''? '&' .$params:''),
      array(
        'title'=>__('First page'),
        )
      )
    ?>
    <?php echo link_to(
      image_tag('sfPropelPlugin/previous'),
      url_for($action . '?page=' . $pager->getPreviousPage()) . ($params!=''?'&' .$params:''),
      array(
        'title'=>__('Previous page'),
        )
      )
    ?>
    <?php foreach ($pager->getLinks() as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
         <strong><?php echo $page ?></strong>
      <?php else: ?>
         <?php echo link_to(
          $page,
          url_for($action . '?page=' . $page) . ($params!=''?'&' .$params:''),
          array(
            'title'=>__('Go to page %page%', array('%page%'=>$page)),
            )
          )
        ?>
      <?php endif; ?>
    <?php endforeach; ?>
    <?php echo link_to(
      image_tag('sfPropelPlugin/last'),
      url_for($action . '?page=' . $pager->getNextPage()) . ($params!=''?'&' .$params:''),
      array(
        'title'=>__('Next page'),
        )
      )
    ?>
    <?php echo link_to(
      image_tag('sfPropelPlugin/last'),
      url_for($action . '?page=' . $pager->getLastPage()) . ($params!=''?'&' .$params:''),
      array(
        'title'=>__('Last page'),
        )
      )
    ?>
</div>
<?php endif; ?>