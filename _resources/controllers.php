<?php

function get_revision_path($revision) {
    return $revision->path;
}

function revision($request, $tpl) {
    $current = Revision::reverse($request);
    $revisions = new Paginator($current->concept->revisions);

    // initialize paginator, setting the paginator to the
    // current object using its path as a guide
    $revisions->current($current, "get_revision_path");

    $tpl->assign("revisions", $revisions);
    return $tpl->fetch('./templates/revision.tpl');
}

function concept($request, $tpl) {
    $concept = Concept::reverse($request);
    if ($concept->exists) {
        redirect($concept->get_latest_revision()->get_absolute_url());
        return '';
    } else {
        $params = array(
            "client" => $request["client"], 
            "category" => "uncategorized",
            "concept" => $request["category"],
            "revision" => $request["concept"]
            );
        return revision($params, $tpl);    
    }
}

function category($request, $tpl) {
    $category = Category::reverse($request);
    if ($category->machine_name == "uncategorized") {
        $params = array(
            "client" => $request["client"], 
            "category" => "uncategorized",
            "concept" => $request["category"],
            );
        return concept($params, $tpl);      
    } else {
        $tpl->assign("category", $category);    
        $tpl->assign("client", $category->client);
        $tpl->assign("concepts", $category->concepts);
        return $tpl->fetch('./templates/category.tpl');    
    }
}

function client($request, $tpl) {
    $client = Client::reverse($request);    
    $tpl->assign("client", $client);
    $tpl->assign("categories", $client->categories);
    $tpl->assign("concepts", $client->concepts);
    
    return $tpl->fetch('./templates/client.tpl');
}

function license($request, $tpl) {
    return $tpl->fetch('./templates/license.tpl');
}

function not_found($request, $tpl) {
    return "Not Found";
}