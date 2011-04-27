<?php

/* import requirements */

require('./routing.php');
require('./settings.php');
require('./data.php');
require('./vendors/Smarty/libs/Smarty.class.php');

/* process folder structure */

$clients = Client::search("../clients");

var_dump($clients);

/* initialize template engine */

$tpl = new Smarty;

/* set debug mode */

if (CR_DEBUG) {
    $tpl->debugging = true;
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

/* render template */

$tpl->assign("page_title", "bleh");
$tpl->assign("folders", $clients[0]->categories);
$tpl->display('./templates/index.tpl');