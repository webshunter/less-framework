<?php
// ------------- BRAND {NATURAL} / NN
// ------------- ROUTING CLASS
// ------------- simple natural router conf
// define NN brand class
namespace NN;

// setup path
define('SETUP_PATH', '../');

// NN defined encription key
define('ENCRIPT_KEY', 'FFde#33');
// define url get
if(isset($_SERVER["REQUEST_URI"]))
{
  define('URL', urldecode($_SERVER["REQUEST_URI"]));
}

define('ROOT', dirname($_SERVER['DOCUMENT_ROOT']));

define('APP', $_SERVER['DOCUMENT_ROOT']);

define('WEB', APP.'/web');

// view module
require_once SETUP_PATH.'module/view.php';

// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

define('IP', get_client_ip());

// set time jakarta

date_default_timezone_set("Asia/Jakarta");
class Uuid{
    public static function gen(){
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,
            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
}

class Enc {

    public static function encrypt($string = ''){
        $x = chunk_split(bin2hex($string),2,'-');
        $len = strlen($x);
        return substr($x,0, ($len-1));

    }

    public static function decrypt($hex = ''){
        return hex2bin(str_replace('-','',$hex));
    }
}


class Post{
    private static $post = [];
    private static $active = NULL;
    function __construct(){
        self::$post = $_POST;
    }
    public function md5(){
        self::$active = md5(self::$active);
        return $this;
    }
    public function get(){
        return self::$active;
    }
    public static function name(...$arg){
        if(isset($arg[0])){
            if(isset(self::$post[$arg[0]])){
                self::$active = self::$post[$arg[0]];
                return (new self);
            };
        }
    }
}

class Debug {

	/**
     * A collapse icon, using in the dump_var function to allow collapsing
     * an array or object
     *
     * @var string
     */
    public static $icon_collapse = 'iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAMAAADXT/YiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2RpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo3MjlFRjQ2NkM5QzJFMTExOTA0MzkwRkI0M0ZCODY4RCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpFNzFDNDQyNEMyQzkxMUUxOTU4MEM4M0UxRDA0MUVGNSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpFNzFDNDQyM0MyQzkxMUUxOTU4MEM4M0UxRDA0MUVGNSIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M1IFdpbmRvd3MiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo3NDlFRjQ2NkM5QzJFMTExOTA0MzkwRkI0M0ZCODY4RCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo3MjlFRjQ2NkM5QzJFMTExOTA0MzkwRkI0M0ZCODY4RCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PuF4AWkAAAA2UExURU9t2DBStczM/1h16DNmzHiW7iNFrypMvrnD52yJ4ezs7Onp6ejo6P///+Tk5GSG7D9h5SRGq0Q2K74AAAA/SURBVHjaLMhZDsAgDANRY3ZISnP/y1ZWeV+jAeuRSky6cKL4ryDdSggP8UC7r6GvR1YHxjazPQDmVzI/AQYAnFQDdVSJ80EAAAAASUVORK5CYII=';
    /**
     * A collapse icon, using in the dump_var function to allow collapsing
     * an array or object
     *
     * @var string
     */
    public static $icon_expand = 'iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAMAAADXT/YiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2RpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo3MTlFRjQ2NkM5QzJFMTExOTA0MzkwRkI0M0ZCODY4RCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpFQzZERTJDNEMyQzkxMUUxODRCQzgyRUNDMzZEQkZFQiIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpFQzZERTJDM0MyQzkxMUUxODRCQzgyRUNDMzZEQkZFQiIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M1IFdpbmRvd3MiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo3MzlFRjQ2NkM5QzJFMTExOTA0MzkwRkI0M0ZCODY4RCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo3MTlFRjQ2NkM5QzJFMTExOTA0MzkwRkI0M0ZCODY4RCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PkmDvWIAAABIUExURU9t2MzM/3iW7ubm59/f5urq85mZzOvr6////9ra38zMzObm5rfB8FZz5myJ4SNFrypMvjBStTNmzOvr+mSG7OXl8T9h5SRGq/OfqCEAAABKSURBVHjaFMlbEoAwCEPRULXF2jdW9r9T4czcyUdA4XWB0IgdNSybxU9amMzHzDlPKKu7Fd1e6+wY195jW0ARYZECxPq5Gn8BBgCr0gQmxpjKAwAAAABJRU5ErkJggg==';
    private static $hasArray = false;

	public static function var_dump($var, $return = false, $expandLevel = 1)
    {
        self::$hasArray = false;
        $toggScript = 'var colToggle = function(toggID) {var img = document.getElementById(toggID);if (document.getElementById(toggID + "-collapsable").style.display == "none") {document.getElementById(toggID + "-collapsable").style.display = "inline";setImg(toggID, 0);var previousSibling = document.getElementById(toggID + "-collapsable").previousSibling;while (previousSibling != null && (previousSibling.nodeType != 1 || previousSibling.tagName.toLowerCase() != "br")) {previousSibling = previousSibling.previousSibling;}} else {document.getElementById(toggID + "-collapsable").style.display = "none";setImg(toggID, 1);var previousSibling = document.getElementById(toggID + "-collapsable").previousSibling; while (previousSibling != null && (previousSibling.nodeType != 1 || previousSibling.tagName.toLowerCase() != "br")) {previousSibling = previousSibling.previousSibling;}}};';
        $imgScript = 'var setImg = function(objID,imgID,addStyle) {var imgStore = ["data:image/png;base64,' . self::$icon_collapse . '", "data:image/png;base64,' . self::$icon_expand . '"];if (objID) {document.getElementById(objID).setAttribute("src", imgStore[imgID]);if (addStyle){document.getElementById(objID).setAttribute("style", "position:relative;left:-5px;top:-1px;cursor:pointer;");}}};';
        $jsCode = preg_replace('/ +/', ' ', '<script>' . $toggScript . $imgScript . '</script>');
        $html = '<pre style="margin-bottom: 18px;' .
            'background: #f7f7f9;' .
            'border: 1px solid #e1e1e8;' .
            'padding: 8px;' .
            'border-radius: 4px;' .
            '-moz-border-radius: 4px;' .
            '-webkit-border radius: 4px;' .
            'display: block;' .
            'font-size: 12.05px;' .
            'white-space: pre-wrap;' .
            'word-wrap: break-word;' .
            'color: #333;' .
            'font-family: Menlo,Monaco,Consolas,\'Courier New\',monospace;">';
        $done  = array();
        $html .= self::var_dump_plain($var, intval($expandLevel), 0, $done);
        $html .= '</pre>';
        if (self::$hasArray) {
            $html = $jsCode . $html;
        }
        if (! $return) {
            echo $html;
        }
        return $html;
    }
    /**
     * Display a variable's contents using nice HTML formatting (Without
     * the <pre> tag) and will properly display the values of variables
     * like booleans and resources. Supports collapsable arrays and objects
     * as well.
     *
     * @param  mixed $var The variable to dump
     * @return string
     */
    public static function var_dump_plain($var, $expLevel, $depth = 0, $done = array())
    {
        $html = '';
        if ($expLevel > 0) {
            $expLevel--;
            $setImg = 0;
            $setStyle = 'display:inline;';
        } elseif ($expLevel == 0) {
            $setImg = 1;
            $setStyle='display:none;';
        } elseif ($expLevel < 0) {
            $setImg = 0;
            $setStyle = 'display:inline;';
        }
        if (is_bool($var)) {
            $html .= '<span style="color:#588bff;">bool</span><span style="color:#999;">(</span><strong>' . (($var) ? 'true' : 'false') . '</strong><span style="color:#999;">)</span>';
        } elseif (is_int($var)) {
            $html .= '<span style="color:#588bff;">int</span><span style="color:#999;">(</span><strong>' . $var . '</strong><span style="color:#999;">)</span>';
        } elseif (is_float($var)) {
            $html .= '<span style="color:#588bff;">float</span><span style="color:#999;">(</span><strong>' . $var . '</strong><span style="color:#999;">)</span>';
        } elseif (is_string($var)) {
            $html .= '<span style="color:#588bff;">string</span><span style="color:#999;">(</span>' . strlen($var) . '<span style="color:#999;">)</span> <strong>"' . self::htmlentities($var) . '"</strong>';
        } elseif (is_null($var)) {
            $html .= '<strong>NULL</strong>';
        } elseif (is_resource($var)) {
            $html .= '<span style="color:#588bff;">resource</span>("' . get_resource_type($var) . '") <strong>"' . $var . '"</strong>';
        } elseif (is_array($var)) {
            // Check for recursion
            if ($depth > 0) {
                foreach ($done as $prev) {
                    if ($prev === $var) {
                        $html .= '<span style="color:#588bff;">array</span>(' . count($var) . ') *RECURSION DETECTED*';
                        return $html;
                    }
                }
                // Keep track of variables we have already processed to detect recursion
                $done[] = &$var;
            }
            self::$hasArray = true;
            $uuid = 'include-php-' . uniqid() . mt_rand(1, 1000000);
            $html .= (!empty($var) ? ' <img style="margin-bottom: -4px;" width="14px" id="' . $uuid . '" src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" onclick="javascript:colToggle(this.id);" /><script>setImg("' . $uuid . '",'.$setImg.',1);</script>' : '') . '<span style="color:#588bff;font-size: 14px;">array</span>(' . count($var) . ')';
            if (! empty($var)) {
                $html .= ' <span id="' . $uuid . '-collapsable" style="'.$setStyle.'"><br />[<br />';
                $indent = 4;
                $longest_key = 0;
                foreach ($var as $key => $value) {
                    if (is_string($key)) {
                        $longest_key = max($longest_key, strlen($key) + 2);
                    } else {
                        $longest_key = max($longest_key, strlen($key));
                    }
                }
                foreach ($var as $key => $value) {
                    if (is_numeric($key)) {
                        $html .= str_repeat(' ', $indent) . str_pad($key, $longest_key, ' ');
                    } else {
                        $html .= str_repeat(' ', $indent) . str_pad('"' . self::htmlentities($key) . '"', $longest_key, ' ');
                    }
                    $html .= ' => ';
                    $value = explode('<br />', self::var_dump_plain($value, $expLevel, $depth + 1, $done));
                    foreach ($value as $line => $val) {
                        if ($line != 0) {
                            $value[$line] = str_repeat(' ', $indent * 2) . $val;
                        }
                    }
                    $html .= implode('<br />', $value) . '<br />';
                }
                $html .= ']</span>';
            }
        } elseif (is_object($var)) {
            // Check for recursion
            foreach ($done as $prev) {
                if ($prev === $var) {
                    $html .= '<span style="color:#588bff;">object</span>(' . get_class($var) . ') *RECURSION DETECTED*';
                    return $html;
                }
            }
            // Keep track of variables we have already processed to detect recursion
            $done[] = &$var;
            self::$hasArray=true;
            $uuid = 'include-php-' . uniqid() . mt_rand(1, 1000000);
            $html .= ' <img style="margin-bottom: -4px;" width="14px" id="' . $uuid . '" src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" onclick="javascript:colToggle(this.id);" /><script>setImg("' . $uuid . '",'.$setImg.',1);</script><span style="font-size: 14px; color:#588bff;">object</span>(' . get_class($var) . ') <span id="' . $uuid . '-collapsable" style="'.$setStyle.'"><br />[<br />';
            $varArray = (array) $var;
            $indent = 4;
            $longest_key = 0;
            foreach ($varArray as $key => $value) {
                if (substr($key, 0, 2) == "\0*") {
                    unset($varArray[$key]);
                    $key = 'protected:' . substr($key, 2);
                    $varArray[$key] = $value;
                } elseif (substr($key, 0, 1) == "\0") {
                    unset($varArray[$key]);
                    $key = 'private:' . substr($key, 1, strpos(substr($key, 1), "\0")) . ':' . substr($key, strpos(substr($key, 1), "\0") + 1);
                    $varArray[$key] = $value;
                }
                if (is_string($key)) {
                    $longest_key = max($longest_key, strlen($key) + 2);
                } else {
                    $longest_key = max($longest_key, strlen($key));
                }
            }
            foreach ($varArray as $key => $value) {
                if (is_numeric($key)) {
                    $html .= str_repeat(' ', $indent) . str_pad($key, $longest_key, ' ');
                } else {
                    $html .= str_repeat(' ', $indent) . str_pad('"' . self::htmlentities($key) . '"', $longest_key, ' ');
                }
                $html .= ' => ';
                $value = explode('<br />', self::var_dump_plain($value, $expLevel, $depth + 1, $done));
                foreach ($value as $line => $val) {
                    if ($line != 0) {
                        $value[$line] = str_repeat(' ', $indent * 2) . $val;
                    }
                }
                $html .= implode('<br />', $value) . '<br />';
            }
            $html .= ']</span>';
        }
        return $html;
    }

 	/**
     * Convert entities, while preserving already-encoded entities.
     *
     * @param  string $string The text to be converted
     * @return string
     */
    public static function htmlentities($string, $preserve_encoded_entities = false)
    {
        if ($preserve_encoded_entities) {
            // @codeCoverageIgnoreStart
            if (defined('HHVM_VERSION')) {
                $translation_table = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
            } else {
                $translation_table = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES, self::mbInternalEncoding());
            }
            // @codeCoverageIgnoreEnd
            $translation_table[chr(38)] = '&';
            return preg_replace('/&(?![A-Za-z]{0,4}\w{2,3};|#[0-9]{2,3};)/', '&amp;', strtr($string, $translation_table));
        }
        return htmlentities($string, ENT_QUOTES, self::mbInternalEncoding());
    }

	/**
     * Wrapper to prevent errors if the user doesn't have the mbstring
     * extension installed.
     *
     * @param  string $encoding
     * @return string
     */
    protected static function mbInternalEncoding($encoding = null)
    {
        if (function_exists('mb_internal_encoding')) {
            return $encoding ? mb_internal_encoding($encoding) : mb_internal_encoding();
        }
        // @codeCoverageIgnoreStart
        return 'UTF-8';
        // @codeCoverageIgnoreEnd
    }
}

class dd
{
    public static function run(...$arg){
        array_map(function($x) { Debug::var_dump($x); }, $arg); die;
    }

    public static function table()
    {
      $args = func_get_args();
      $value = $args[0];
      if($args[0] === true){
        $value = $args[1];
      }
      if(is_array($value)){
          echo "<table style='background: black; color: white; border: 1px solid white;'>";
        if(isset($value[0])){
          if(count($value) > 0){
            $obj = array_keys((array) $value[0]);
            $colp = [];
            echo "<tr>";
            foreach($obj as $key => $tr){
              echo "<td style='border-collapse:collapse;border: 1px solid white;padding: 3px 8px;'>";
              echo $tr;
              echo "</td>";
              $colp[] = $tr;
            }
            echo "</tr>";

            foreach($value as $val){
              $val = (array) $val;
              echo "<tr>";
              foreach($colp as $q){
                echo "<td style='border-collapse:collapse;border: 1px solid white;padding: 3px 8px;'>";
                if(is_array($val[$q])){
                  $y[] = true;
                  $y[] = $val[$q];
                  call_user_func_array('dd', $y);
                }else{
                  echo $val[$q];
                }
                echo "</td>";
              }
              echo "</tr>";
            }

          }
        }else{
            foreach($value as $key => $v){
                echo "<tr>";
                    echo "<td style='border-collapse:collapse;border: 1px solid white;padding: 3px 8px;'>";
                    echo $key;
                    echo "</td>";
                    echo "<td style='border-collapse:collapse;border: 1px solid white;padding: 3px 8px;'>";
                    echo $v;
                    echo "</td>";
                echo "</tr>";
            }
        }
          //
          echo "</table>";
          if ($args[0] !== true) {
            die();
          }
      }else{
          echo "<pre>";
          var_dump($value);
          echo "</pre>";
      }
    }


}

class files
{
    public static function exist(...$arg)
    {
        if(isset($arg[0]))
        {
            if(file_exists($arg[0]))
            {
                return true;
            }else{
                return false;
            }
        }
    }

    public static function slug(...$arg){
        if(isset($arg[0])){
            $name = $arg[0];
            $name = str_replace('"','',$name);
            $name = str_replace("'",'',$name);
            $name = str_replace(" ",'-',$name);
            $name = str_replace("@",'',$name);
            $name = str_replace(",",'',$name);
            $name = str_replace(".",'',$name);
            $name = str_replace("/",'',$name);
            $name = str_replace("|",'',$name);
            $name = str_replace("\\",'',$name);
            $name = str_replace("=",'',$name);
            $name = str_replace("+",'',$name);
            $name = str_replace("(",'',$name);
            $name = str_replace(")",'',$name);
            $name = str_replace("[",'',$name);
            $name = str_replace("]",'',$name);
            $name = str_replace(";",'',$name);
            $name = str_replace(":",'',$name);
            $name = str_replace("`",'',$name);
            $name = str_replace("#",'',$name);
            $name = str_replace("\$",'',$name);
            $name = str_replace("%",'',$name);
            $name = str_replace("^",'',$name);
            $name = str_replace("&",'',$name);
            $name = str_replace("?",'',$name);
            $name = str_replace("~",'',$name);
            return strtolower($name);
        }
    }

    public static function remove(...$arg){
        if(isset($arg[0])){
            if(file_exists($arg[0])
                && $arg[0] != ''
                && $arg != '/'
                && $arg != 'web'
                && $arg != 'views'
                && $arg != 'vendor'
                && $arg != 'module'
            ){
                unlink($arg[0]);
            }
        }
    }

    public static function write(...$arg)
    {
        if(isset($arg[0]) && isset($arg[1]))
        {
            $myfile = fopen($arg[0], "w") or die("Unable to open file!");
            $txt = $arg[1];
            fwrite($myfile, $txt);
            fclose($myfile);
        }
    }

    public static function read(...$arg)
    {
        $path = $arg[0];
        if(!file_exists($path)){
            return null;
        }
        $myfile = fopen($path, "r") or die("Unable to open file!");
        $er = fread($myfile,filesize($path));
        fclose($myfile);
        return $er;
    }

}

$env = explode("\n", files::read(SETUP_PATH.'.env'));


class Tanggal{

    private $dates = NULL;
    private $jarak = NULL;

    public function __construct(...$arg){
        if(isset($arg[0])){
            $textdate = new Text($arg[0]);
            $textdate = $textdate->replace('/','-')->get();
            $this->dates = strtotime($textdate);
        }else{
            $this->dates = strtotime(date('Y-m-d H-i-d'));
        }
    }

    public function format(...$arg){
        if(isset($arg[0])){
            return date($arg[0], $this->dates);
        }
    }

    public function id(){
        return date('d-m-Y', $this->dates);
    }

    public function selisih(...$arg){
        if(isset($arg[0])){
            $pembanding = strtotime($arg[0]);
            $jarak = $pembanding - $this->dates;
            $jarak = $jarak / 60/ 60 / 24; // hari
            $this->jarak = $jarak;
        }else{
            $pembanding = strtotime(date('Y-m-d h:i:s'));
            $jarak = $pembanding - $this->dates;
            $jarak = $jarak / 60/ 60 / 24; // hari
            $this->jarak = $jarak;
        }
        return $this;
    }

    public function banyakHari(){
        if($this->jarak != NULL){
            return $this->jarak;
        }else{
            return 0;
        }
    }

    public function banyakBulan(){
        if($this->jarak != NULL){
            return round($this->jarak / 30);
        }else{
            return 0;
        }
    }

    public function banyakTahun(){
        if($this->jarak != NULL){
            return round($this->jarak / 30 / 12);
        }else{
            return 0;
        }
    }

}

class Text{
    private $string;
    public function __construct(...$arg){
        if(isset($arg[0])){
            $this->string = $arg[0];
        }
        return $this;
    }

    public function replace(...$arg){
        if(isset($arg[0]) && isset($arg[1])){
            $arg[] = $this->string;
            $this->string = str_replace(...$arg);
        }
        return $this;
    }

    public function slug(){
          $name = $this->string;
          $name = str_replace('"','',$name);
          $name = str_replace("'",'',$name);
          $name = str_replace(" ",'-',$name);
          $name = str_replace("@",'',$name);
          $name = str_replace(",",'',$name);
          $name = str_replace(".",'',$name);
          $name = str_replace("/",'',$name);
          $name = str_replace("|",'',$name);
          $name = str_replace("\\",'',$name);
          $name = str_replace("=",'',$name);
          $name = str_replace("+",'',$name);
          $name = str_replace("(",'',$name);
          $name = str_replace(")",'',$name);
          $name = str_replace("[",'',$name);
          $name = str_replace("]",'',$name);
          $name = str_replace(";",'',$name);
          $name = str_replace(":",'',$name);
          $name = str_replace("`",'',$name);
          $name = str_replace("#",'',$name);
          $name = str_replace("\$",'',$name);
          $name = str_replace("%",'',$name);
          $name = str_replace("^",'',$name);
          $name = str_replace("&",'',$name);
          $name = str_replace("?",'',$name);
          $name = str_replace("~",'',$name);
          $this->string = $name;
    }

    public function get(){
        return $this->string;
    }
}

foreach($env as $name => $val ){
    if(strpos($val, "=") !== false){
        $v = explode("=",$val);
        $val = new Text($v[1]);
        $val = $val
        ->replace("\n","")
        ->replace("{APP}",APP)
        ->replace("{ROOT}",ROOT)
        ->get();
        define(str_replace("\n","",$v[0]), $val);
    }
};

class Link{
    public static function redirect(...$arg){
        if(isset($arg[0])){
            $url = PATH.$arg[0];
            echo "<script>";
            echo "location.href = '$url'";
            echo "</script>";
            die();
        }
    }
}


class Session{

    public static function put($name = "", $data_arr = [])
    {
        $_SESSION[$name.'simanisanggrek'] = $data_arr;
    }

    public static function delete($name = '')
    {
        unset($_SESSION[$name.'simanisanggrek']);
    }

    public static function get($name = "", $defaultnull = "")
    {
        if(isset($_SESSION[$name.'simanisanggrek'])){
            if ($_SESSION[$name.'simanisanggrek'] != "") {
                return $_SESSION[$name.'simanisanggrek'];
            }else{
                return $defaultnull;
            }
        }else{
            if ($defaultnull != "") {
                return $defaultnull;
            }else{
                return "";
            }
        }
    }
}

// cek htaccess
if(files::exist('.htaccess') === false)
{
  files::write();
}

class load{
    public function __construct(...$arg){
        foreach ($arg as $argument){
            include_once SETUP_PATH.$argument.'.php';
        }
    }
}

class Route {
    private static $route = [];
    private static $middleware = [];
    private static $use = [];
    private static $activeadd = NULL;
    private static $datamidleware = [];

    // midleware setup
    public function middleware(...$arg){
        if(isset($arg[0])){
            if(is_callable($arg[0])){
                if(!isset(self::$middleware[self::$activeadd])){
                    self::$middleware[self::$activeadd] = [];
                }
                self::$middleware[self::$activeadd][] = $arg[0];
            }else{
                if(!isset(self::$middleware[self::$activeadd])){
                    self::$middleware[self::$activeadd] = [];
                }
                self::$middleware[self::$activeadd][] = $arg[0];
            }
        }
        return $this;
    }

    public function addMidleware(...$arg){
        if(isset($arg[0]) && isset($arg[1])){
            self::$datamidleware[$arg[0]] = $arg[1];
        }
    }

    public function use(...$arg){
        if(isset($arg[0])){
            if(is_string($arg[0])){
                if(!isset(self::$use[self::$activeadd])){
                    self::$use[self::$activeadd] = [];
                }
                self::$use[self::$activeadd][] = $arg[0];
            }
        }
        return $this;
    }

    public static function session(...$arg){
        if(isset($arg[0]) && $arg[0] == true){
            defined('SESSION') or die();
            if(files::exist(SETUP_PATH.'session53539'.SESSION) === false){
                mkdir(SETUP_PATH.'session53539'.SESSION);
            }
            $filesession = SETUP_PATH.'session53539'.SESSION;
            if(session_status() === ''){
                ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/'.$filesession));
                ini_set('session.gc_probability', 1);
            }
            session_start();
        }
    }

    // add new route
    public static function add(...$argv){
        $newRoute = [];
        if(isset($argv[0])){
            if(substr( $argv[0], 0,1) != '/'){
                $newRoute["url"] = PATH."/".$argv[0];
            }else{
                $newRoute["url"] = PATH.$argv[0];
            }
            self::$activeadd = $newRoute['url'];
            $pathofroute = [];
            $pathofparams = [];
            $newRoute['totpath'] = 0;
            $newRoute['action-type'] = NULL;
            $newRoute['action'] = NULL;
            foreach(explode("/",$newRoute['url']) as $key => $pathRoute){
                if(strpos($pathRoute, "{") !== false && strpos($pathRoute, "}") !== false){
                    $pathofparamsnew = [];
                    $pathofparamsnew['position'] = $key;
                    $pathofparamsnew['nameparams'] = $pathRoute;
                    $pathofparams[] = $pathofparamsnew;
                    $pathofroute[] = $pathRoute;
                    $newRoute['totpath'] +=1;
                }else{
                    $newRoute['totpath'] +=1;
                    $pathofroute[] = $pathRoute;
                }
            }
            $newRoute['routepath'] = $pathofroute;
            $newRoute['params'] = $pathofparams;

            // cek seccond parameters
            if(isset($argv[1])){
                $action = $argv[1];
                if( is_callable($action) ){
                    $newRoute['action-type'] = 'function';
                    $newRoute['action'] = $argv[1];
                }else{
                    if(strpos($argv[1],'@') !== false){
                        $newRoute['action-type'] = 'controller';
                        $newRoute['action'] = $argv[1];
                    }
                }
            }
        }
        self::$route[] = $newRoute;
        return (new self);
    }

    // validation route after call
    private static function validating(...$argv){
        if(isset($argv[0])){
            $parameterone = $argv[0];
            $routeactive = self::$route[$parameterone];
            if($routeactive['action-type'] != NULL){
                if($routeactive['action-type'] == 'function'){
                    $pathurl = explode('/',URL);
                    $params = [];
                    foreach($routeactive['params'] as $getpar){
                        $params[] = $pathurl[$getpar['position']];
                    }
                    $params = (array) $params;
                    error_reporting(0);

                    if(isset(self::$use[$routeactive['url']])){
                        foreach(self::$use[$routeactive['url']] as $usecall){
                            require_once SETUP_PATH.$usecall;
                        }
                    }

                    error_reporting(-1);

                    if(isset(self::$middleware[$routeactive['url']])){
                        foreach(self::$middleware[$routeactive['url']] as $midlecall){
                            if(is_callable($midlecall)){
                                $midlecall();
                            }else{
                                self::$datamidleware[$midlecall]();
                            }
                        }
                    }

                    $routeactive['action'](...$params);
                    die();
                }else{
                    $pathurl = explode('/',URL);
                    $params = [];
                    foreach($routeactive['params'] as $getpar){
                        $params[] = $pathurl[$getpar['position']];
                    }
                    $params = (array) $params;
                    error_reporting(1);
                    if(isset(self::$use[$routeactive['url']])){
                        foreach(self::$use[$routeactive['url']] as $usecall){
                            require_once SETUP_PATH.$usecall;
                        }
                    }

                    $path = explode("@",$routeactive['action']);

                    $pathDir = SETUP_PATH.$path[0];
                    

                    if(file_exists($pathDir.'.php')){

                        error_reporting(-1);

                        require_once $pathDir.'.php';
                        if(isset(self::$middleware[$routeactive['url']])){
                            foreach(self::$middleware[$routeactive['url']] as $midlecall){
                                if(is_callable($midlecall)){
                                    $midlecall();
                                }else{
                                    self::$datamidleware[$midlecall]();
                                }
                            }
                        }
                        $pat = explode('/',$path[0]);
                        $pcount = count($pat) - 1;
                        $nameclass = ucfirst($pat[$pcount]);
                        $namefunc = $path[1];
                        $ripText = " ".$nameclass."::".$namefunc."(...\$params); ";
                        eval($ripText);
                    }else{
                        $route = self::$route;
                        foreach($route as $y => $founderror){
                            if($founderror['url'] == '/404'){
                                (new self)->validating($y);
                                die();
                            }
                        }
                        echo "/404 <br>page not found";
                    }

                }
            }
        }
    }

    // starting route
    public static function call(){
        $route = self::$route;
        // cari data yang sesuai dengan URL
        // cek url;
        foreach($route as $key => $routedata){
            if($routedata['url'] == URL){
                (new self)->validating($key);
                die();
            }
        }

        $pathurl = explode('/',URL);

        $countpathurl = count($pathurl);
        
        // cek url base on count path of url and filter it
        $pathofroot = array_filter($route, function(...$arg) use ($countpathurl, $pathurl) {
            if($arg[0]['totpath'] == $countpathurl){
                return $arg;
            }
        }, ARRAY_FILTER_USE_BOTH  );
        
        
        $capable = array_map(function(...$arg) use($pathurl){
            $data = $arg[0];
            $data['compability'] = 0;
            foreach($data['routepath'] as $kk => $root){
                if($pathurl[$kk] == $root){
                    $data['compability'] += 1;
                }
            }
            return $data['compability'];
        }, $pathofroot);
        
        
        $rr = [-1,-2];

        foreach($capable as $n){
            $rr[] = $n;
        }

        $capable = max(...$rr);

        
        $get = array_map(function(...$arg) use($pathurl){
            $data = $arg[0];
            $data['compability'] = 0;
            foreach($data['routepath'] as $kk => $root){
                if($pathurl[$kk] == $root){
                    $data['compability'] += 1;
                }
            }
            return $data;
        }, $pathofroot);
        

        $getdata = array_map(function(...$arg){
            return $arg[0];
        },array_filter($get, function(...$arg) use ($capable) {
            if($arg[0]['compability'] == $capable && $capable > 1){
                return $arg[0];
            }
        }));

        function serachParamTrueOrFalse(...$arg){
            function isparams(...$ssa){
                $res = false;
                foreach($ssa[1] as $s){
                    if($s['position'] == $ssa[0]){
                        $res = true;
                    }
                }
                return $res;
            }
            $result = true;
            foreach($arg[2] as $key => $prm){
                if(isparams($key, $arg[1]) != true){
                    if($arg[0][$key] != $prm){
                        $result = false;
                    };
                }
            }
            return $result;
        }

        if(count($getdata) > 0){
            foreach($getdata as $key => $calldata){
                $url = $calldata['url'];
                if(serachParamTrueOrFalse($calldata['routepath'], $calldata["params"], $pathurl) == true){
                    foreach($route as $numroute => $routes){
                        if($routes['url'] == $url){
                            (new self)->validating($numroute);
                            die();
                        }
                    }
                }else{
                    foreach($route as $y => $founderror){
                        if($founderror['url'] == '/404'){
                            (new self)->validating($y);
                            die();
                        }
                    }
                    echo "/404 <br>page not found";
                };
                die();
            };
        }else{
            foreach($route as $y => $founderror){
                if($founderror['url'] == '/404'){
                    (new self)->validating($y);
                    die();
                }
            }
            echo "/404 <br>page not found";
        }

    }
}

// cek web folder

if(files::exist(SETUP_PATH.'web') === false){
    mkdir(SETUP_PATH.'web');
    if(files::exist(SETUP_PATH.'web/route.php') === false){
        files::write(SETUP_PATH.'web/route.php', "<?php use NN\Route;\n \n\$route = new Route();\n\n\n\$route->call();");
        require_once SETUP_PATH.'web/route.php';
    }
}else{
    require_once SETUP_PATH.'web/route.php';
}
