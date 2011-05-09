<?php

$path = $_SERVER['PATH_INFO'];

function redirect($url) {
    header('Status: 303');
    header('Location: ' . $url);
}

// add trailing slash to url if necessary
if ($path[strlen($path)-1] != '/') {
    redirect($_SERVER['REQUEST_URI'] . '/');
}

if (strpos($_SERVER['REQUEST_URI'], 'index.php') || strpos($_SERVER['REQUEST_URI'], '?q=')) {
    $clean_urls = false;
} else {
    $clean_urls = true;
}

// try to autodetect the base url
if (!defined('CR_BASE_URL_OVERRIDE') || CR_BASE_URL_OVERRIDE === NULL) {
    $base = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['PHP_SELF'], '/_resources/'));
    define('CR_BASE_URL', $base);
} else {
    define('CR_BASE_URL', '');
}

$request = array();
$pieces = array("client", "category", "concept", "revision");
foreach (explode("/", $path) as $value) {
    if (empty($value)) continue;
    // trim serves as a basic security measure to avoid
    // people requesting things like ../../.htaccess
    $request[array_shift($pieces)] = trim($value, "./");
}
$requested_view = array_pop(array_keys($request));