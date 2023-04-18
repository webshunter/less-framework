<?php
    use NN\Session;
    use NN\files;
    use NN\Uuid;
    $login = Session::get('loginadmin');
    $datalogin = base64_encode(json_encode($login));
    $filejsModule = files::read('module/js/file.js.ttm');
    $filejsModule = str_replace("{api}", PATH.'/api/', $filejsModule);
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
                   <h1>Absensi Siswa
                    <?php if($status == 1) : ?>
                        ( Ditutup )
                    <?php endif; ?>
                   </h1
                   <p>Data absensi akan di load secara realtime, setelah code qr di scan di perangkat android, jika aplikasi belum diinstall silahkan download dengan klik link berikut <a href="<?= PATH ?>/android/absensi.apk">download scanner</a>, klik button check di kanan bawah jika sudah selesai</p>
                   <table class="table">
                       <thead>
                           <tr>
                               <th>No</th>
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

<style>
    .i-check{
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        font-size: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
<?php if($status == 0) : ?>
    <button id="finish" class="btn btn-primary i-check"><i class="fa fa-check"></i></button>
<?php endif; ?>
<noscript id="datalogin"><?= $datalogin ?></noscript>
<?php $this->push('scripts'); ?>
<script>
    <?= $filejsModule ?>
</script>
<script>
    const datalogin = document.getElementById('datalogin').innerText;
    const bodytable = document.getElementById('loadsiswa');
    (function realTime(){

        AuditDevQuery(datalogin,`SELECT nama,tanggal,jam, ifnull(nullif(lokasi,''),'-') lokasi FROM absen WHERE idjadwal = '<?= $idjadwal ?>'`, function(a){
            if(a.length > 0){
                bodytable.innerHTML = `
                    ${a.map(function(j,i){
                        return `
                            <tr>
                                <td>${i+1}</td>
                                <td>${j.nama}</td>
                                <td>${j.tanggal}</td>
                                <td>${j.jam}</td>
                                <td>${j.lokasi}</td>
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

    document.getElementById('finish').addEventListener('click', ()=>{
        AuditDevQuery(datalogin, `UPDATE jadwal SET status = 1 WHERE id = '<?= $idjadwal ?>' `, function(res){
            location.href = '<?= PATH ?>/dashboard/admin/jadwal'
        })
    },false)

</script>
<?php $this->end() ?>
