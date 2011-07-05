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
$smarty->assign("BASE_URL", setting('BASE_URL'));
$smarty->assign("THEME", setting('THEME'));
$smarty->assign("ANIMATE", setting('ANIMATE'));
$smarty->assign("NAV_POSITION", setting('NAV_POSITION'));
$smarty->assign("ALIGNMENT", setting('ALIGNMENT'));

/* set debug mode */

if (CR_DEBUG) {
    $smarty->debugging = true;
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

/* routing */

// minimalistic routing to functions 
// in controllers.php
if (function_exists($requested_view)) {
    if ((setting('PASSWORD') == false) or is_authenticated($request, $smarty)) {
        $output = call_user_func($requested_view, $request, $smarty);
    } else {
        authenticate($request, $smarty);
    }
} else {
    if (empty($request)) {
        // directory listings are forbidden
        $output = forbidden($request, $smarty);
    } else {
        $output = not_found($request, $smarty);
    }
}

print $output;