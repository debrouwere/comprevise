<?php

/* import requirements */

require('./settings.php');
require('./request.php');
require('./utils.php');
require('./models.php');
require('./controllers.php');
require('./vendors/Smarty/libs/Smarty.class.php');

/* initialization */

$smarty = new Smarty;
$smarty->assign("BASE_URL", CR_BASE_URL);
$smarty->assign("THEME", CR_THEME);
$smarty->assign("ANIMATE", CR_ANIMATE);
$smarty->assign("NAV_POSITION", CR_NAV_POSITION);
$license = new License(CR_CODE, CR_EMAIL);

/* set debug mode */

if (CR_DEBUG) {
    $smarty->debugging = true;
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

/* routing */

// if (!$license->is_verified()) { // reverse verification for testing
if ($license->is_verified()) {
    $output = license($smarty);
} else {
    // minimalistic routing to functions 
    // in controllers.php
    if (function_exists($requested_view)) {
        $output = call_user_func($requested_view, $request, $smarty);
    } else {
        header("HTTP/1.0 404 Not Found");
        $output = not_found($request, $smarty);
    }
}

print $output;