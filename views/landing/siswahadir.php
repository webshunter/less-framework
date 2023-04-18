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
                   <h1>Data Kehadiran</h1>
                   <p>Rekap data kehadiran <?= $login->nama ?> </p>
                   <table class="table">
                       <thead>
                           <tr>
                               <th>No</th>
                               <th>Acara</th>
                               <th>Siswa</th>
                               <th>Tanggal Datang</th>
                               <th>Waktu Datang</th>
                               <th>Lokasi</th>
                           </tr>
                       </thead>
                       <tbody id="loadsiswa">
                           
                       </tbody>
                   </table>
                </div>
            </div>
        </div>
    </div>
</div>

<noscript id="datalogin"><?= $datalogin ?></noscript>
<?php $this->push('scripts'); ?>
<script>
    <?= $filejsModule ?>
</script>
<script>
    const datalogin = document.getElementById('datalogin').innerText;
    const bodytable = document.getElementById('loadsiswa');
    (function realTime(){
        AuditDevQuery(datalogin,`SELECT a.*, b.acara FROM absen a 
        LEFT JOIN jadwal b ON b.id = a.idjadwal
        WHERE a.idsiswa = '<?= $login->id ?>'`, function(a){
            if(a.length > 0){
                bodytable.innerHTML = `
                    ${a.map(function(j,i){
                        return `
                            <tr>
                                <td>${i+1}</td>
                                <td>${j.acara}</td>
                                <td>${j.nama}</td>
                                <td>${j.tanggal}</td>
                                <td>${j.jam}</td>
                                <td>-</td>
                            </tr>
                        `;
                    }).join('')}
                `   
            }else{
                bodytable.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center">Belum Ada Siswa Absen</td>
                    </tr>
                `;
            };
            setTimeout(function() {
                realTime();
            }, 1000);
        })
        
        
    })()
    
</script>
<?php $this->end() ?>

