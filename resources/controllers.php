<?php

function concept($tpl) {
    $tpl->display('./templates/concept.tpl');
}

function category($tpl) {
    global $request;

    $category = Category::reverse($request);
    
    $tpl->assign("category", $category);    
    $tpl->assign("client", $category->client);
    $tpl->assign("concepts", $category->concepts);
    $tpl->display('./templates/category.tpl');
}

function client($tpl) {
    $clients = Client::search("../clients");
    $client = $clients[0];

    $tpl->assign("client", $client);
    $tpl->assign("folders", $client->categories);
    $tpl->assign("concepts", $client->concepts);
    $tpl->display('./templates/client.tpl');
}

function license($tpl) {
    $tpl->display('./templates/license.tpl');
}