{extends "base.tpl"}
{block "title"}Concepts for {$client->name}{/block}
{block "main"}
<div id="wrapper">
    <h1>Concepts for {$client->name}</h1>
    <p class="description">This dashboard will automatically update as new concepts and revisions are uploaded.</p>
    
    {foreach $folders as $folder}        
        <h3{if $folder@first} class="first"{/if}>
            <a href="{$folder->concepts[0]->revisions[0]->get_absolute_url()}">
                <em>{$folder->name}</em>
                last updated <time datetime="{$folder->last_changed_iso}">{$folder->last_changed_iso}</time>
            </a>
        </h3>
        <ul>
            {foreach $folder->concepts as $concept}
                <li><a href="{$concept->get_absolute_url()}">{$concept->name}</a></li>
            {/foreach}
        </ul>
    {/foreach}

    {foreach $concepts as $concept}
        <h3>
            <a href="{$concept->get_absolute_url()}">
                <em>{$concept->name}</em>
                last updated <time datetime="{$concept->last_changed_iso}">{$concept->last_changed_iso}</time>
            </a>
        </h3>
    {/foreach}
    
    <div id="footer">
        Powered by <a href="http://www.conceptrevisions.com">Concept Revisions</a>
    </div>
</div>
{/block}