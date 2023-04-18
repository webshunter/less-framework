<?php
    use NN\Session;
    use NN\files;
    $login = Session::get('loginadmin');
?>
<?php $this->layout('temp/layout', ['title' => 'Data Kehadiran '.$login->nama.' || Dashboard Admin']) ?>
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
                   <h1>Welcome, <?= $login->nama ?>!</h1>
                </div>
            </div>
        </div>
    </div>
</div>
