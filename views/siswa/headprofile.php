<?php
    use \NN\Text;
    use \NN\Tanggal;
    $birthday = new Tanggal($data->tanggallahir);
    $birthday = $birthday->selisih()->banyakTahun();
?>

<div class="foto text-center">
    <div class="foto-area">
        <img src="<?= $profile ?>" width="150px">
        <i class="fa fa-camera"></i>
    </div>
    <h1><?= $data->nama ?></h1>
    <div class="info-header">
        <p><?= $data->alamat ?></p>
    </div>
    <a href="<?= PATH ?>/dashboard/siswa/datakehadiran" class="btn btn-light"><i class="fa fa-birthday-cake"></i> <br> <?= $birthday ?> TH</a>
    <a href="<?= PATH ?>/dashboard/siswa/edit/<?= $data->id ?>" class="btn btn-light"><i class="fa fa-edit"></i> <br> Edit</a>
</div>