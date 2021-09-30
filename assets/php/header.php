<?php
$params = params();
if ( $params['folder'] ) {
    $pageTitle  = "Storage - ".$params['folder'];
} else {
    $pageTitle  = "Storage";
}

$nav    = getNavigation(new DirectoryIterator($_SERVER['DOCUMENT_ROOT'].$params['base']));
$nav    = alphaSort($nav);
$files  = getFileListing();
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?=( $pageTitle ? $pageTitle : 'Storage' )?></title>
        <link rel="stylesheet" href="/storage/assets/css/styles.css">
        <script type="text/javascript" src="/storage/assets/js/scripts.js"></script>
    </head>
    <body>
        <header>
            <?=$pageTitle?>
        </header>