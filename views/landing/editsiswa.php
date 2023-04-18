<?php

    use NN\Session;
    use NN\files;
    use NN\Module\DB;
    use NN\Text;

    $login = DB::dbquery("SELECT * FROM siswa WHERE id = '$id' ")[0];
    $datalogin = $login;
    $data = $login;

    $filejsModule = new Text(files::read('module/js/file.js.ttm'));
    $filejsModule = $filejsModule->replace('{api}', PATH.'/api/')->get();

    $barcode = json_encode([
        "id" => $login->id,
        "nama" => $login->nama
    ]);

    $profile = 'fotoprofilesiswa/'.files::slug($login->nama).'.jpg';

    // cek if foto profile exits

    if(files::exist($profile) === false){
        $profile = files::read('fotoprofilesiswa/profile.file');
    }else{
      $profile = PATH.'/'.$profile.'?v='.date('ymdhis');
    }

    // generate new qrcode
    
    $namefile = 'userqr/'.$login->id.'.png';
    QRcode::png($barcode, $namefile, 'L', 8, 2);

    function cekKey(...$arg){
        $aliase = [
            "id" => "id siswaa",
            "tanggallahir" => "tanggal lahir",
            "jk" => "jenis kelamin",
            "hp" => "handphone",
            "growcomunity" => "grow comunity"
        ];

        $response = null;
        if(isset($arg[0])){
            $key = $arg[0];
            if(isset($aliase[$key])){
                $response = ucwords($aliase[$key]);
            }else{
                $response = ucwords($key);
            }
        }
        return $response;
    }

?>
<?php $this->layout('temp/layout', ['title' => $login->nama.' || Dashboard Siswa']) ?>
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
        <div class="col-12 col-sm-4 mb-3">
            <div class="card">
                <div class="card-body">
                    
                    <?php $this->insert('widget/uploadFoto', [
                      'profile' => $profile 
                      ,'data' => $datalogin 
                      ]) ?>
                    
                    <?php $this->push('scripts') ?>

                      <script type="text/javascript">
                      <?= $filejsModule ?>

                      window.addEventListener('DOMContentLoaded', function () {
                        var avatar = document.getElementById('profile-img-<?= $data->id ?>');
                        var image = document.getElementById('uploadedAvatar-<?= $data->id ?>');
                        var input = document.getElementById('file-input-<?= $data->id ?>');
                        var cropBtn = document.getElementById('crop-<?= $data->id ?>');
                    
                        var $modal = $('#cropAvatarmodal<?= $data->id ?>');
                        var cropper;

                        $('[data-toggle="tooltip"]').tooltip();

                        input.addEventListener('change', function (e) {
                          var files = e.target.files;
                          var done = function (url) {
                            // input.value = '';
                            console.log(input.value)
                            image.src = url;
                            $modal.modal('show');
                          };
                          // var reader;
                          // var file;
                          // var url;
                          if (files && files.length > 0) {
                            let file = files[0];
                              // done(URL.createObjectURL(file));
                            // if (URL) {
                            // } 
                            // else if (FileReader) {
                              reader = new FileReader();
                              reader.onload = function (e) {
                                done(reader.result);
                              };
                              reader.readAsDataURL(file);
                            // }
                          }
                        });
                        $modal.on('shown.bs.modal', function () {
                          cropper = new Cropper(image, {
                            aspectRatio: 1,
                            viewMode: 2,
                          });
                        }).on('hidden.bs.modal', function () {
                          cropper.destroy();
                          cropper = null;
                        });
                        cropBtn.addEventListener('click', function () {
                          // var initialAvatarURL;
                          var canvas;
                          $modal.modal('hide');
                          if (cropper) {
                              canvas = cropper.getCroppedCanvas({
                                  width: 160,
                                  height: 160,
                              });
                              // initialAvatarURL = avatar.src;
                              avatar.src = canvas.toDataURL();
                              upload('<?= PATH ?>/upload', 'fotoprofilesiswa/', '<?= files::slug($login->nama) ?>.jpg', avatar.src, function(){},function(){
                                var data = Array.from(document.querySelectorAll('[w-input ]')).map(function(a){
                                  var obj = {}
                                  obj['name'] = a.getAttribute('w-input');
                                  obj['value'] = a.value;
                                  return ` ${obj.name} = '${obj.value.replace(/\'/g,'\\\'')}' `;
                                }).join(',')+` , \`update\` = '${Date.now()}'`
                                console.log(`UPDATE siswa SET ${data} WHERE id='<?= $datalogin->id ?>'`)
                                AuditDevQuery('sasa',`UPDATE siswa SET ${data} WHERE id='<?= $datalogin->id ?>'`,function(a){
                                  alert('update')
                                })
                              })
                          }
                        });
                      });

                      $("#simpan").click(function(){
                        var data = Array.from(document.querySelectorAll('[w-input ]')).map(function(a){
                          var obj = {}
                          obj['name'] = a.getAttribute('w-input');
                          obj['value'] = a.value;
                          return ` ${obj.name} = '${obj.value.replace(/\'/g,'\\\'')}' `;
                        }).join(',')+` , \`update\` = '${Date.now()}'`
                        AuditDevQuery('sasa',`UPDATE siswa SET ${data} WHERE id='<?= $datalogin->id ?>'`,function(a){
                          alert('update')
                        })
                      })

                      </script>
                    <?php $this->end(); ?>
                </div>
            </div>
        </div>
        <?php

       

        $username = DB::dbquery("SELECT * FROM username WHERE idsiswa = '$data->id' ");

        $datas = [
          "idsiswa" => $data->id,
          "username" => "",
          "password" => ""
        ];

        if(count($username) > 0){
          $datas['username'] = $username[0]->username;
          $datas['password'] = $username[0]->passview;
        }

        $datas = (object) $datas;

        $up = DB::query("INSERT INTO username (idsiswa)
          SELECT a.idsiswa FROM (
            SELECT $data->id idsiswa
          ) a LEFT JOIN username b ON a.idsiswa = b.idsiswa
          WHERE b.idsiswa IS NULL
        ");
        
        ?>
        <div class="col-12 col-sm-8 mb-3">
            <div class="card">
                <div class="card-body">
                    <table  class="w-100">
                        <?php foreach((array) $login as $key => $val) : ?>
                          <?php if ($key == 'id'): ?>
                              <tr>
                                <td><?= cekKey($key) ?></td><td style="padding: 0 10px;">:</td><td><?= $val ?></td>
                              </tr>
                            <?php elseif($key != 'update'): ?>
                              <tr>
                                <td width="120px"><?= cekKey($key) ?></td><td style="padding: 0 10px;">:</td><td><input class="form-control" w-input="<?= $key ?>" class="w-100" type="text" autocomplete="off" name="<?= $key ?>" value="<?= $val ?>"/></td>
                              </tr>
                          <?php endif; ?>
                        <?php endforeach; ?>
                    </table>
                    <button id="simpan" class="btn btn-primary">simpan</button>
                    <button onclick="window.history.back()" class="btn btn-light">kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>
