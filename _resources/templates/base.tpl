<!DOCTYPE html>
<html>
    <head>
        <title>{block "title"}Comprevise{/block}</title>
        <meta content="charset" value="utf-8" />
        <link rel="stylesheet" type="text/css" href="{$BASE_URL}/_resources/css/{$THEME}.css">
        <link rel="stylesheet" type="text/css" media="print" href="{$BASE_URL}/_resources/css/print.css" />   
        <style>
        {if $NAV_POSITION == 'no'}
        ul#header-bar {
            display: none;
        }
        {else}
        ul#header-bar {
            position: fixed;
            top: auto !important;
            {$NAV_POSITION}: 0;
        }
        {/if}
        {if $ANIMATE == 1 or $NAV_POSITION == 'bottom'}
        #concept {
            top: 0;
        }
        {/if}
        </style>
        <!-- scripts at the top to avoid a timeago flash -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
        <script type="text/javascript" src="{$BASE_URL}/_resources/js/dependencies/jquery.timeago.js"></script>
        <script type="text/javascript">
        var ANIMATE = {if $ANIMATE == 0}false{else}true{/if};
        var NAV_POSITION = '{$NAV_POSITION}';
        </script>
        <script type="text/javascript" src="{$BASE_URL}/_resources/js/main.js"></script>
        {block "head"}
        {/block}
    </head>
    <body class="{$NAV_POSITION} {$ALIGNMENT}-aligned">
        {block "main"}
        <p>This is an empty page.</p>
        {/block}
    </body>
</html>