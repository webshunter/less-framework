<nav aria-label="Page navigation example">
  <ul class="pagination">
    <?php for($x=0;$x<$page;$x++) : ?>
      <?php if(($datahalaman * $x) == $active) : ?>
        <li class="page-item active"><a class="page-link" href="<?= PATH.'/dashboard/admin/datasiswa/'.($x * $datahalaman).$nextlink ?>"><?= $x+1; ?></a></li>
      <?php else: ?>
        <li class="page-item"><a class="page-link" href="<?= PATH.'/dashboard/admin/datasiswa/'.($x * $datahalaman).$nextlink ?>"><?= $x+1; ?></a></li>
      <?php endif?>
    <?php endfor; ?>
  </ul>
</nav>
