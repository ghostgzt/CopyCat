<?php
	error_reporting(0);
    // Include the DirectoryLister class
    require_once('resources/DirectoryLister.php');

    // Initialize the DirectoryLister object
    $lister = new DirectoryLister();
	function encode_iconv($sencoding, $tencoding, $str) {
    if (function_exists("mb_convert_encoding")) {
        $str = mb_convert_encoding($str, $tencoding, $sencoding);
    } else {
        $str = iconv($sencoding, $tencoding . "//TRANSLIT//IGNORE", $str);
    }
    return $str;
	}
    // Return file hash
    if (isset($_GET['hash'])) {

        // Get file hash array and JSON encode it
        $hashes = $lister->getFileHash($_GET['hash']);
        $data   = json_encode($hashes);

        // Return the data
        die($data);

    }

    // Initialize the directory array
    if (isset($_GET['dir'])) {
        $dirArray = $lister->listDirectory($_GET['dir']);
    } else {
        $dirArray = $lister->listDirectory('.');
    }

    // Define theme path
    if (!defined('THEMEPATH')) {
        define('THEMEPATH', $lister->getThemePath());
    }

    // Set path to theme index
    $themeIndex = $lister->getThemePath(true) . '/index.php';

    // Initialize the theme
    if (file_exists($themeIndex)) {
        include($themeIndex);
    } else {
        die('ERROR: Failed to initialize theme');
    }
