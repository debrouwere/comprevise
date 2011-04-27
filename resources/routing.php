<?php

$path = $_GET['q'];

if (strpos($_SERVER['REQUEST_URI'], 'index.php')) {
    $clean_urls = false;
} else {
    $clean_urls = true;
}