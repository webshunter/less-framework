<?php
    use NN\Session;
    use NN\files;
    use NN\Uuid;
    use NN\Text;
    $login = Session::get('loginadmin');
    $datalogin = base64_encode(json_encode($login));
    $filejsModule = new Text(files::read('module/js/file.js.ttm'));
    $filejsModule = $filejsModule->replace('{api}', PATH.'/api/')->get();
?>
<?php $this->layout('temp/layout', ['title' => 'Data Jadwal Acara || Dashboard Admin']) ?>
<?php $this->insert('landing/navbar/admin') ?>
<style>
    .foto{
        width: 150px;
        height: 150px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .foto img{
        width: 100%;
    }
</style>
<div class="container mt-3">
    <div class="row">
        <div class="col-12 col-sm-12 mb-3">
            <div class="card">
                <div class="card-body">
                   <form action="<?= PATH ?>/dashboard/admin/jadwal/simpan" method="post">
                       <h3>Tambah Acara</h3>
                       <div class="form-group">
                           <label>Id (uniq)</label>
                           <input type="text" name="id" class="form-control" readonly="true" value="<?= Uuid::gen(); ?>"  />
                       </div>
                       <div class="form-group">
                           <label>Tanggal</label>
                           <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d')?>" />
                       </div>
                       <div class="form-group">
                           <label>Acara</label>
                           <input type="text" name="acara" class="form-control" placeholder="inputkan deskripsi acara" />
                       </div>
                       <div class="form-group">
                        <button class="btn btn-primary"> <i class="fa fa-save"></i> Simpan & Buat Absensi</button>
                        <button class="btn btn-light" href="<?= PATH ?>/dashboard/admin/jadwal"> Kembali </button>
                       </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>
