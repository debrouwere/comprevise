<?php

/* import requirements */

require('./routing.php');
require('./settings.php');
require('./data.php');
require('./vendors/Smarty/libs/Smarty.class.php');

/* initialization */

$smarty = new Smarty;
$license = new License(CR_CODE, CR_EMAIL);

/* set debug mode */

if (CR_DEBUG) {
    $smarty->debugging = true;
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

/* views */

function concept($tpl) {

}

function category($tpl) {

}

function client($tpl) {
    $clients = Client::search("../clients");
    $client = $clients[0];

    $tpl->assign("BASE_URL", CR_BASE_URL);
    $tpl->assign("page_title", "Concepts for " . $client->name);
    $tpl->assign("folders", $client->categories);
    $tpl->display('./templates/index.tpl');
}

if ($license->is_verified()) {
    $tpl->display('./templates/license.tpl');
} else {
    // minimalistic view routing
    call_user_func($requested_view, $smarty);
}