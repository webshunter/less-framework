<?php
    use NN\Session;
    use NN\files;
    use NN\Text;
    $login = Session::get('loginadmin');
    $filejsModule = new Text(files::read('module/js/file.js.ttm'));
    $filejsModule = $filejsModule->replace('{api}', PATH.'/api/')->get();
?>
<?php $this->layout('temp/layout', ['title' => 'Data Siswa || Dashboard Admin']) ?>
<?php $this->insert('landing/navbar/admin') ?>
<?php $this->push('js') ?>
  <script>
    <?= $filejsModule ?>
  </script>
<?php $this->end() ?>
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
    <div style="display: grid; grid-template-columns: 40px auto 40px;margin-bottom: 10px; grid-gap: 10px;">
      <button id="siswabaru" class="btn btn-primary" style="border-radius: 50%;"><i class="fa fa-plus"></i></button>
      <input style="border-radius: 12px;" id="pencarian" type="search" placeholder="cari siswa" class="form-control" value="<?= $cari ?>" />
      <button id="btn-pencarian" class="btn btn-primary" style="border-radius: 50%;"><i class="fa fa-search"></i></button>
    </div>
    <script>
      $('#siswabaru').on('click',function(e){
          e.preventDefault();
          Swal.fire({
              title: 'tambah data!',
              text: "Tambah siswa bari!",
              type: 'success',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'buat baru'
          })
          .then((result) => {
              if (result.value) {
                  location.href = '<?= PATH ?>/dashboard/admin/datasiswa/baru'
              }
          });
      });
      document.getElementById("btn-pencarian").addEventListener('click', function(){
        var caridata = document.getElementById("pencarian").value;
        location.href = '<?= PATH ?>/dashboard/admin/datasiswa/0/'+caridata;
      }, false)
      document.getElementById("pencarian")
        .addEventListener("keyup", function(event) {
        event.preventDefault();
        if (event.keyCode === 13) {
            document.getElementById("btn-pencarian").click();
        }
      });
      const getFormData = function(id, func){
        document.getElementById(id).addEventListener('submit', function(event){
          event.preventDefault();
          var data = Object.fromEntries(new FormData(event.target).entries());
          func(data)
        }, false)
      }
    </script>
    <div class="row">
        <?php foreach ($siswa as $data) : ?>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-3">
                <?php $this->insert('temp/card',['data' => $data]) ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="row">
      <div class="col-12">
        <?php $this->insert('landing/pagination/datasiswa', [
            "total" => $total,
            "page" => ceil($total / 20),
            "active" => $page,
            "nextlink" => "/".$cari,
            "datahalaman" => 20,
          ]) ?>
      </div>
    </div>
</div>
