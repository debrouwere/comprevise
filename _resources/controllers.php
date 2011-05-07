<?php

function get_concept_path($concept) {
    return $concept->path;
}

function revision($request, $tpl) {
    $current = Revision::reverse($request);
    
    if (get_class($current->concept->category) == "Category") {
        // this won't work
        $revisions = new Paginator($current->concept->category->concepts);
    } else {
        $revisions = new Paginator(array($current));
    }

    // initialize paginator, setting the paginator to the
    // current object using its path as a guide
    $revisions->current($current, "get_concept_path");

    $tpl->assign("revisions", $revisions);
    return $tpl->fetch('./templates/revision.tpl');
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
    
    print_r($client);
    
    return $tpl->fetch('./templates/client.tpl');
}

function license($request, $tpl) {
    return $tpl->fetch('./templates/license.tpl');
}