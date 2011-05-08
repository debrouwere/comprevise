{extends "base.tpl"}
{block "title"}Concepts for {$client->name}{/block}
{block "main"}
<div id="wrapper">
    <h1>Concepts for {$client->name}</h1>
    <p class="description">This dashboard will automatically update as new concepts and revisions are uploaded.</p>
    
    {foreach $concepts as $concept}        
        <h3{if $concept@first} class="first"{/if}>
            <a href="{$concept->revisions[0]->get_absolute_url()}">
                <em>{$concept->name}</em>
                last updated <time datetime="{$concept->last_changed_iso}">{$concept->last_changed_iso}</time>
            </a>
        </h3>
        <ul>
            {foreach $concept->revisions as $revision}
                <li><a href="{$revision->get_absolute_url()}">{$revision->name}</a></li>
            {/foreach}
        </ul>
    {/foreach}

    {foreach $categories as $category}
        <h3>
            <a href="{$category->get_absolute_url()}">
                <em>{$category->name}</em>
                last updated <time datetime="{$concept->last_changed_iso}">{$category->last_changed_iso}</time>
            </a>
        </h3>
    {/foreach}
    
    <div id="footer">
        Powered by <a href="http://www.conceptrevisions.com">Concept Revisions</a>
    </div>
</div>
{/block}