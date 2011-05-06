<?php

function get_concept_path($concept) {
    return $concept->path;
}

function concept($request, $tpl) {
    $current = Concept::reverse($request);
    
    if (get_class($current->category) == "Category") {
        $concepts = new Paginator($current->category->concepts);
    } else {
        $concepts = new Paginator(array($current));
    }

    // initialize paginator, setting the paginator to the
    // current object using its path as a guide
    $concepts->current($current, "get_concept_path");

    $tpl->assign("concepts", $concepts);
    return $tpl->fetch('./templates/concept.tpl');
}

function category($request, $tpl) {
    $category = Category::reverse($request);
    
    // if this category doesn't exist, we might be
    // searching for an uncategorized concept instead
    if (!$category->exists) {
        $params = array(
            "client" => $request["client"], 
            "category" => "uncategorized",
            "concept" => $request["category"]
            );
        return concept($params, $tpl);
    }
    
    $tpl->assign("category", $category);    
    $tpl->assign("client", $category->client);
    $tpl->assign("concepts", $category->concepts);
    return $tpl->fetch('./templates/category.tpl');
}

function client($request, $tpl) {
    $client = Client::reverse($request);    
    $tpl->assign("client", $client);
    $tpl->assign("folders", $client->categories);
    $tpl->assign("concepts", $client->concepts);
    return $tpl->fetch('./templates/client.tpl');
}

function license($request, $tpl) {
    return $tpl->fetch('./templates/license.tpl');
}