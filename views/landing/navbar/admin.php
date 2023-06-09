<?php
    use NN\Session;
    $login = Session::get('loginadmin');
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?= PATH ?>/dashboard/admin"><?= $login->nama ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="<?= PATH ?>/dashboard/admin"><i class="fa fa-home"></i> Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= PATH ?>/dashboard/admin/datasiswa"><i class="fa fa-users"></i> Data Siswa</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= PATH ?>/dashboard/admin/jadwal"><i class="fa fa-calendar"></i> Jadwal Acara</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="<?= PATH ?>/logout/admin"> <i class="fa fa-sign-out"></i> Log Out</a>
        </li>
    </ul>
  </div>
</nav>
