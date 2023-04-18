<?php

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


function cekValue(...$arg){
    if(isset($arg[0]) && isset($arg[1])){
        $key = $arg[0];
        $val = $arg[1];

        if($key == 'tanggallahir'){
            $tgl = new \NN\Tanggal($val);
            $val = $tgl->id();
        }

        return $val;
    }
}


$dataLoad = (array) $data;

unset($dataLoad['id']);
unset($dataLoad['update']);
unset($dataLoad['nama']);
unset($dataLoad['panggilan']);
unset($dataLoad['alamat']);

?>

<table class="w-100">
    <?php foreach($dataLoad as $key => $val) : ?>
        <tr style="border-bottom: 1px solid #ddd;">
            <td width="120px;"><?= cekKey($key) ?></td>
            <td width="30px;" style="padding: 0 10px;">:</td>
            <td><?= cekValue($key, $val) ?></td>
        </tr>
    <?php endforeach; ?>
</table>