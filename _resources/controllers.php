<?php

/* UTILS */

function get_revision_path($revision) {
    return $revision->path;
}

/* BASIC CONTROLLERS */

function not_found($request, $tpl) {
    header("HTTP/1.0 404 Not Found");
    return $tpl->fetch('templates/404.tpl');
}

function forbidden($request, $tpl) {
    header("HTTP/1.0 403 Forbidden");
    return $tpl->fetch('templates/403.tpl');
}

function authenticate($request, $tpl) {
    header('WWW-Authenticate: Basic realm="Comprevise"');
    header('HTTP/1.0 401 Unauthorized');
    print $tpl->fetch('templates/403.tpl');
    exit;
}

function is_authenticated($request, $tpl) {
    if (!isset($_SERVER['PHP_AUTH_PW'])) {
        authenticate($request, $tpl);
        return false;
    } else {
        if ($_SERVER['PHP_AUTH_PW'] == setting('PASSWORD')) {
            return true;
        } else {
            unset($_SERVER['PHP_AUTH_PW']);
            return false;
        }
    }
}

/* APP-SPECIFIC CONTROLLERS */

function revision($request, $tpl) {
    $current = Revision::reverse($request);
    if (!$current->exists) return not_found($request, $tpl);
    
    $revisions = new Paginator($current->concept->revisions);

    // initialize paginator, setting the paginator to the
    // current object using its path as a guide
    $revisions->current($current, "get_revision_path");

    $tpl->assign("revisions", $revisions);
    return $tpl->fetch('templates/revision.tpl');
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
    if (!$category->exists) return not_found($request, $tpl);

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
        return $tpl->fetch('templates/category.tpl');    
    }
}

function client($request, $tpl) {
    $client = Client::reverse($request);   
    if (!$client->exists) return not_found($request, $tpl);
     
    $tpl->assign("client", $client);
    $tpl->assign("categories", $client->categories);
    $tpl->assign("concepts", $client->concepts);
    
    return $tpl->fetch('templates/client.tpl');
}

function license($request, $tpl) {
    return $tpl->fetch('templates/license.tpl');
}