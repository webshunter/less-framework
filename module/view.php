<?php 

namespace NN\Module;
require_once SETUP_PATH.'vendor/autoload.php';
use Jenssegers\Blade\Blade;

class View {

    public static function render($name = '', $arg = []){
        $blade = new Blade(SETUP_PATH.'views', 'cache');
        echo $blade->make($name, $arg)->render();
    }
}
