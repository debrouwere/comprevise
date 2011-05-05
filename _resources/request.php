<?php

$path = $_GET['q'];

if (strpos($_SERVER['REQUEST_URI'], 'index.php') || strpos($_SERVER['REQUEST_URI'], '?q=')) {
    $clean_urls = false;
} else {
    $clean_urls = true;
}

$request = array();
$pieces = array("client", "category", "concept");
foreach (explode("/", $path) as $value) {
    if (empty($value)) continue;
    // trim serves as a basic security measure to avoid
    // people requesting things like ../../.htaccess
    $request[array_shift($pieces)] = trim($value, "./");
}
$requested_view = array_pop(array_keys($request));