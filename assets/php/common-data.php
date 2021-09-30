<?php

function params()
{
    $params = array();
    $params['docRoot'] = $_SERVER['DOCUMENT_ROOT'];
    $params['root'] = '/storage';
    $params['base'] = $params['root'].'/files';

    if ( empty($_GET) ) {
        $params['folder'] = '';
    } else {
        $parts = explode('/', $_GET['params']);
        $params['parent'] = '/'.$parts[0];
        $params['folder'] = '/'.$_GET['params'];
    }

    return $params;
}

function getNavigation(DirectoryIterator $dir)
{
    $data = array();
    foreach ($dir as $node) {
        if ( $node->isDir() && !$node->isDot() ) {
            $data[$node->getFilename()] = getNavigation(new DirectoryIterator($node->getPathname()));
        }
    }
    return $data;
}

function getFileListing()
{

    $params     = params();
    $baseURI    = $_SERVER['DOCUMENT_ROOT'];
    $local      = $baseURI.$params['base'].$params['folder'];
    $files      = scandir($local);

    // echo '<pre>'; print_r($params); echo '</pre>';
    // echo '<pre>'; print_r($baseURI); echo '</pre>';
    // echo '<pre>'; print_r($local); echo '</pre>';
    // echo '<pre>'; print_r($files); echo '</pre>';

    $ignore_files = array('.','..','index.php','error_log','.well-known','cgi-bin');
    $ignore_ext = array('rar');

    foreach ($files as $file) {
        $ext = pathinfo($params['root']."/".$file, PATHINFO_EXTENSION);
        if (!in_array($ext, $ignore_ext)) {
            if (!in_array($file, $ignore_files)) {
                if ( !is_dir($local.'/'.$file) ) {
                    $fileList[$file] = $params['docRoot'].$params['base'].$params['folder'].'/'.$file;
                }
            }
        }
    }

    return $fileList;
}

function fileSizeConvert($bytes)
{
    $bytes = floatval($bytes);
    $arBytes = array(
        0 => array(
            "UNIT" => "tb",
            "VALUE" => pow(1024, 4)
        ),
        1 => array(
            "UNIT" => "gb",
            "VALUE" => pow(1024, 3)
        ),
        2 => array(
            "UNIT" => "mb",
            "VALUE" => pow(1024, 2)
        ),
        3 => array(
            "UNIT" => "kb",
            "VALUE" => 1024
        ),
        4 => array(
            "UNIT" => "b",
            "VALUE" => 1
        ),
    );

    foreach ($arBytes as $arItem) {
        if ($bytes >= $arItem["VALUE"]) {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(
                ".",
                ".",
                strval(round($result, 0))
            ).$arItem["UNIT"];
            break;
        }
    }
    return $result;
}

function alphaSort($array)
{
    ksort($array);
    foreach ($array as &$layer) {
        ksort($layer);
        foreach ($layer as &$layer2) {
            ksort($layer2);
            foreach ($layer2 as &$layer3) {
                ksort($layer3);
            }
        }
    }
    return $array;
}

function menuCheck($url)
{
    $params = params();

    if ( $params['folder'] == '' ) {
        return '';
    }
    $check1 = $params['root'].$params['folder'];
    if ( $check1 == $url ) {
        return 'open';
    }
    $check2 = $params['root'].$params['parent'];
    if ( strpos($url, $check2) !== false ) {
        return 'open';
    }
    return false;

}

function formatURL($url)
{
    // $url = str_replace(' ', '_', $url);

    return $url;
}