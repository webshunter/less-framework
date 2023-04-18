<?php 
use thiagoalessio\TesseractOCR\TesseractOCR;
class Teseract{
    public static function test(){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        echo (new TesseractOCR('imagetext/kop.jpg'))
        ->lang('id')
        ->run();
    }
}