<?php

    use NN\Session;
    use NN\files;
    use NN\Uuid;
    use NN\Module\DB;
    use NN\Text;

    $login = Session::get('loginsiswa');
    $datauser = DB::dbquery("SELECT * FROM  username WHERE idsiswa = '$login->id'")[0];
    $datalogin = base64_encode(json_encode($datauser));
    $filejsModule = new Text(files::read('module/js/file.js.ttm'));
    $filejsModule = $filejsModule->replace('{api}', PATH.'/api/')->get();

?>
<?php $this->layout('temp/layout', ['title' => 'Data Kehadiran '.$login->nama.' || Dashboard Siswa']) ?>
<?php $this->insert('landing/navbar/siswa') ?>
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
                   <form id="setting-password">
                       <h1>Setting</h1>
                       <div class="form-group">
                           <label>Username</label>
                           <input type="hidden" ff name="idsiswa" id="idsiswa" value="<?= $data->idsiswa ?>" />
                           <input type="username" name="username"  id="username" class="form-control" autocomplete="off" value="<?= $data->username ?>" />
                       </div>
                       <div class="form-group">
                           <label>Password</label>
                           <input type="password" ff name="password" id="password" class="form-control" autocomplete="off" value="<?= $data->passview ?>" />
                       </div>
                       <div class="form-group">
                        <button class="btn btn-primary" type="submit"> <i class="fa fa-save"></i> Simpan</button>
                       </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>
<noscript id="datalogin"><?= $datalogin ?></noscript>
<?php $this->push('scripts') ?>
<script>
    const datalogin = document.getElementById('datalogin').innerText;
    <?= $filejsModule ?>
</script>
<script>
const getFormData = function(id, func){
  document.getElementById(id).addEventListener('submit', function(event){
    event.preventDefault();
    var data = Object.fromEntries(new FormData(event.target).entries());
    func(data)
  }, false)
}

getFormData('setting-password', function(data){
  AuditDevQuery(datalogin,`
      UPDATE username SET username = '${data.username}'
      , password = md5('${data.password}')
      , passview = '${data.password}'
       WHERE idsiswa = '${data.idsiswa}'
    `, function(){
      alert('data diupdate')
    })
  // AuditDevQuery(datalogin, `
  //     UPDATE username SET username = '${data.username}', password = md5('${data.password}') WHERE idsiswa
  //   `,function(){
  //
  //   })
  console.log(data)
})
</script>
<?php $this->end() ?>
