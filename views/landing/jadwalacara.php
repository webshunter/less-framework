<?php
    use NN\Session;
    use NN\files;
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
                   <div id="table-x">
                       
                   </div>
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
<?php $this->insert('widget/tableWidget') ?>
<script>
    var datalogin = document.getElementById('datalogin').innerText;
</script>
<?php $this->insert('landing/tableview/jadwal'); ?>
<?php $this->end() ?>


