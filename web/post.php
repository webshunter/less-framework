<?php 

use NN\module\View;

class Post{
    
    public static function cek(){
        if(count($_POST) == 0){
            $view = new View('views');
            echo $view->render('landing/post', ['name' => 'Jonathan']);
            die();
        }
    }

    public static function err(){
        if(count($_POST) == 0){
            View::render('landing/err', ['name' => 'Jonathan']);
            die();
        }
    }
    
}
