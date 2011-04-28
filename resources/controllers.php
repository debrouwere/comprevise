<?php

function concept($tpl) {
    global $request;

    $current = Concept::reverse($request);
    $concepts = new Paginator($current->category->concepts);

    // initialize paginator
    $location = array_search($current, $concepts->list);
    $concepts->current($location);

    $tpl->assign("concepts", $concepts);
    return $tpl->fetch('./templates/concept.tpl');
}

function category($tpl) {
    global $request;

    $category = Category::reverse($request);
    
    $tpl->assign("category", $category);    
    $tpl->assign("client", $category->client);
    $tpl->assign("concepts", $category->concepts);
    return $tpl->fetch('./templates/category.tpl');
}

function client($tpl) {
    $clients = Client::search("../clients");
    $client = $clients[0];

    $tpl->assign("client", $client);
    $tpl->assign("folders", $client->categories);
    $tpl->assign("concepts", $client->concepts);
    return $tpl->fetch('./templates/client.tpl');
}

function license($tpl) {
    return $tpl->fetch('./templates/license.tpl');
}