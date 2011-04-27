<!DOCTYPE html>
<html>
<head>
<title>{$page_title}</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="_resources/style.css">
</head>
<body>
<div id="wrapper">
    <h1>{$page_title}</h1>
    <p class="description">This dashboard will automatically update as new concepts and revisions are uploaded.</p>
    
    <ul>
    {foreach $folders as $folder}
        <li>{$folder->name}</li>
        {*
        <h3 {if folder.is_first()}class="first"{/if}>
            <a href="{$folder->latest_concept->url}">{$folder->latest_concept->name}</a>
            {$folder->latest_concept->upload_time}
        </h3>
        *}
        <ul>
            {foreach $folder->concepts as $concept}
                <li class="{$concept->cls}"><a href="{$concept->url}">{$concept->name}</a></li>
            {/foreach}
        </ul>
    {/foreach}
    </ul>
    
    {*
    {foreach $category_folders as $category}
        <h2>{$category->name}</h2>
        
        <h3><a href="{$category->latest_concept->url}">{$category->latest_concept->name}{$category->latest_concept->upload_time}</a></h3>    
            <ul>
                {section name=concept loop=$category->concepts}
                    <li class="{$concept->revision_url}"><a href="{$concept->revision_url}">{$concept->revision_name}</a></li>
                {/section}
            </ul>
    {/section}
    *}
    
    <div id="footer">
        Powered by <a href="http://www.conceptrevisions.com">Concept Revisions</a>
    </div>
</div>
</body>
</html>