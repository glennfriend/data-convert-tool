<?php

use Symfony\Component\VarDumper\Cloner\VarCloner;   // dd()
use Symfony\Component\VarDumper\Dumper\CliDumper;   // dd()

//setlocale(LC_ALL, "en_US.UTF-8");
$timezone = 'Asia/Taipei';

date_default_timezone_set($timezone);
ini_set('date.timezone',  $timezone);

/**
 *
 */
function init()
{

}

/**
 *
 */
function getRootPath()
{
    return realpath(__DIR__ . '/..');
}

function getParam($key, $defaultValue=null)
{
    if (isset($_POST[$key])) {
        return $_POST[$key];
    }
    elseif (isset($_GET[$key])) {
        return $_GET[$key];
    }
    return $defaultValue;
}

/**
 * 儲存 暫存檔
 *
 * @param string $saveName
 * @param array $data
 */
function saveVar($saveName, Array $data)
{
    // validate $saveName
    if (!preg_match('/^[a-zA-Z0-9_\-\.\/]+$/', $saveName)) {
        return false;
    }
    if (false !== strpos($saveName, '..')) {
        return false;
    }

    //
    $file = getRootPath().'/var/' . $saveName . '.json';
    $text = json_encode($data, JSON_PRETTY_PRINT);
    return (bool) file_put_contents($file, $text);
}

/**
 * 讀取 暫存檔
 *
 * @param string $loadName file name
 * @return array
 */
function loadVar($loadName)
{
    // validate $saveName
    if (!preg_match('/^[a-zA-Z0-9_\-\.\/]+$/', $loadName)) {
        return false;
    }
    if (false !== strpos($loadName, '..')) {
        return false;
    }

    //
    $file = getRootPath().'/var/' . $loadName . '.json';
    if (!file_exists($file)) {
        return [];
    }
    $json = file_get_contents($file);
    return json_decode($json, true);
}

/**
 *
 */
function redirect($url='')
{
    header('Location: ' . $url);
    exit;
}

/**
 * symfony var dump
 *
 * @param $type
 *          null        => 顯示, 會自動判斷是不是 ILC
 *          'pre'       => 當作是 html 環境, 顯示 <pre></pre>
 *          'text'      => 當作是 text 環境, 顯示原始內容
 *          'return'    => 不顯示, 回傳內容
 */
function dd($data, $type=null)
{
    $h = fopen('php://memory', 'r+b');
    $cloner = new VarCloner();
    $cloner->setMaxItems(-1);
    $dumper = new CliDumper($h, null);
    $dumper->setColors(false);

    $data = $cloner->cloneVar($data)->withRefHandles(false);
    $dumper->dump($data);
    $data = stream_get_contents($h, -1, 0);
    fclose($h);

    //
    // return or output
    //
    $type = trim(strtolower($type));

    if ('return' === $type) {
        return rtrim($data);
    }

    if ('pre' === $type) {
        echo '<pre>';
        print_r(rtrim($data));
        echo '</pre>';
        return;
    }

    if ('text' === $type) {
        print_r(rtrim($data));
        return;
    }

    if (php_sapi_name() == "cli") {
        print_r($data);
    }
    else {
        echo '<pre>';
        print_r(rtrim($data));
        echo '</pre>';
    }

}


/**
 *  escape output
 *
 *  @link http://www.smarty.net/manual/en/language.modifier.escape.php
 *        escape (Smarty online manual)
 *        by 2012-01-04
 *  @param string
 *  @param html|htmlall|url|quotes|hex|hexentity|javascript
 *  @return string
 *
 */
function escape($string, $esc_type = "html", $char_set = 'UTF-8')
{
    switch ($esc_type) {
        case 'html':
            return htmlspecialchars($string, ENT_QUOTES, $char_set);

        case 'htmlall':
            return htmlentities($string, ENT_QUOTES, $char_set);

        case 'url':
            return rawurlencode($string);

        case 'urlpathinfo':
            return str_replace('%2F','/',rawurlencode($string));

        case 'quotes':
            // escape unescaped single quotes
            return preg_replace("%(?<!\\\\)'%", "\\'", $string);

        case 'hex':
            // escape every character into hex
            $return = '';
            for ($x=0; $x < strlen($string); $x++) {
                $return .= '%' . bin2hex($string[$x]);
            }
            return $return;

        case 'hexentity':
            $return = '';
            for ($x=0; $x < strlen($string); $x++) {
                $return .= '&#x' . bin2hex($string[$x]) . ';';
            }
            return $return;

        case 'decentity':
            $return = '';
            for ($x=0; $x < strlen($string); $x++) {
                $return .= '&#' . ord($string[$x]) . ';';
            }
            return $return;

        case 'javascript':
            // escape quotes and backslashes, newlines, etc.
            return strtr($string, array('\\'=>'\\\\',"'"=>"\\'",'"'=>'\\"',"\r"=>'\\r',"\n"=>'\\n','</'=>'<\/'));

        case 'mail':
            // safe way to display e-mail address on a web page
            return str_replace(array('@', '.'),array(' [AT] ', ' [DOT] '), $string);

        case 'nonstd':
           // escape non-standard chars, such as ms document quotes
           $_res = '';
           for($_i = 0, $_len = strlen($string); $_i < $_len; $_i++) {
               $_ord = ord(substr($string, $_i, 1));
               // non-standard char, escape it
               if($_ord >= 126){
                   $_res .= '&#' . $_ord . ';';
               }
               else {
                   $_res .= substr($string, $_i, 1);
               }
           }
           return $_res;

        default:
            return $string;
    }
}

