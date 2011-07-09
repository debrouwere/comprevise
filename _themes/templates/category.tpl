{extends "base.tpl"}
{block "title"}Concepts under {$category->name}{/block}
{block "main"}
<div id="wrapper">
    <ul id="header-bar">
        <li>
            <a href="{$category->client->get_absolute_url()}">Back to Project Dashboard</a>
        </li>
    </ul>

    <h1 style="margin-top: 80px;">{$category->name}</h1>

    <p class="description">This category listing will automatically update as new concepts and revisions are uploaded.</p>
    
    {foreach $concepts as $concept}        
        <h3{if $concept@first} class="first"{/if}>
            <a href="{$concept->get_latest_revision()->get_absolute_url()}">
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
    
    <div id="footer">
        Powered by <a href="http://www.comprevise.com">Comprevise</a>
    </div>
</div>
{/block}