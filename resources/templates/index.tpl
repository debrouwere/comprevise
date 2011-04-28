<!DOCTYPE html>
<html>
    <head>
        <title>{$page_title}</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">    
        <link rel="stylesheet" type="text/css" href="{$BASE_URL}/resources/css/style.css">
    </head>
    <body>
        <div id="wrapper">
            <h1>{$page_title}</h1>
            <p class="description">This dashboard will automatically update as new concepts and revisions are uploaded.</p>
            
            <ul>
            {foreach $folders as $folder}
                <li>{$folder->name}</li>
        
                <h3 {if $folder@first}class="first"{/if}>
                    <a href="{$folder->concepts[0]->get_absolute_url()}">{$folder->concepts[0]->name}</a>
                    <time>{$folder->last_changed_iso}</time>
                </h3>
                <ul>
                    {foreach $folder->concepts as $concept}
                        <li><a href="{$concept->get_absolute_url()}">{$concept->name}</a></li>
                    {/foreach}
                </ul>
            {/foreach}
            </ul>
            
            <div id="footer">
                Powered by <a href="http://www.conceptrevisions.com">Concept Revisions</a>
            </div>
        </div>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
        <script type="text/javascript" src="{$BASE_URL}resources/js/dependencies/jquery.timeago.js"></script>
        <script type="text/javascript" src="{$BASE_URL}resources/js/main.js"></script>
    </body>
</html>