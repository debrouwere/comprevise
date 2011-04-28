{extends "base.tpl"}
{block "title"}Concepts under {$category->name}{/block}
{block "main"}
<div id="wrapper">
    <h1>{$category->name}</h1>
    <p class="description">This category listing will automatically update as new concepts and revisions are uploaded.</p>
    
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