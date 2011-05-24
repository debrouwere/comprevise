{extends "base.tpl"}
{block "title"}Concepts for {$client->name}{/block}
{block "main"}
<div id="wrapper">
    <h1>Concepts for {$client->name}</h1>
    <p class="description">This dashboard will automatically update as new concepts and revisions are uploaded.</p>
    
    {foreach $concepts as $concept}        
        {include 'concept.partial.tpl'}
    {/foreach}

    {foreach $categories as $category}
        <h2>{$category->name}</h2>
        {foreach $category->concepts as $concept}
            {include 'concept.partial.tpl'}        
        {/foreach}
    {/foreach}
    
    <div id="footer">
        Powered by <a href="http://www.comprevise.com">Comprevise</a>
    </div>
</div>
{/block}