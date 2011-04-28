<?php

$path = $_GET['q'];

if (strpos($_SERVER['REQUEST_URI'], 'index.php')) {
    $clean_urls = false;
} else {
    $clean_urls = true;
}

$request = array();
$pieces = array("client", "category", "concept");
foreach (explode("/", $path) as $value) {
    if (empty($value)) continue;
    $request[array_shift($pieces)] = $value;
}
$requested_view = array_pop(array_keys($request));