<?php
/**
 * Custom Directory Listing
 * 
 * PHP version 7.2
 * 
 * @category  Something
 * @package   Something
 * @author    kittenAngie <angiejschmitt@gmail.com>
 * @copyright 2020 kittenAngie
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://pear.php.net/package/PackageName
 */

$full = $_SERVER['DOCUMENT_ROOT'];
$local = $_SERVER['REQUEST_URI'];

$dir = $_SERVER['SCRIPT_URL'];

$files = scandir($full.$dir);
$ignore_files = array('.','..','index.php','error_log','.well-known','cgi-bin');
$ignore_ext = array('rar');

foreach ($files as $file) {
    $ext = pathinfo($dir."/".$file, PATHINFO_EXTENSION);
    if (!in_array($ext, $ignore_ext)) {
        if (!in_array($file, $ignore_files)) {
            if (is_dir($full.$local.$file)) {
                $dirList[$file] = $local.$file;
            } else {
                $fileList[$file] = str_replace('%20', ' ', $local.$file);
            }
        }
    }
}

/**
 * Convert from bytes to other things
 * 
 * @param array $bytes - size in bytes
 * 
 * @return string - size in other sizes
 */
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
?>
<html>
    <head>
        <style type="text/css">
            h2{ 
                margin: 0 0 0 20px; 
            }
            ul{ 
                margin: 10px 0 20px 30px;
                list-style: none;
                padding-left: 0; 
            }
            ul li{
                margin-bottom: 8px;
                font-family: 'Open Sans', 'sans-serif';
                font-size: 14px; 
            }
            ul li a{ 
                color: black;
                border-bottom: 1px dashed #000;
                text-decoration: none;
            }
            ul li a:hover{ 
                color: green !important;
                border-color: green !important; 
            }
            ul li a:visited{
                color: darkred;
                border-color: darkred; 
            }
        </style>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" 
            rel="stylesheet">
    </head>
    <body>
        <h1>Directory Listing for: <?php echo urldecode($local); ?></h1>
        <?php if (!empty($dirList)) :?>
        <h2>Folders</h2>
        <ul>
            <?php foreach ($dirList as $name => $path) : ?>
            <li>
                <a target="_blank" href="<?php echo $path; ?>">
                    <?php echo $name; ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <?php if (!empty($fileList)) :?>
        <h2>Files</h2>
        <ul>
            <?php foreach ($fileList as $name => $path) : ?>
                <?php $size = fileSizeConvert(filesize($full.$path)); ?>
            <li>
                <a target="_blank" href="<?php echo $path; ?>">
                    <?php echo $name; ?>
                </a> - <?php echo $size; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </body>
</html>
