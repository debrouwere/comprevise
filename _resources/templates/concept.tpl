{extends "base.tpl"}

{block "title"}{$concepts->current()->name}{/block}

{block "head"}
<style type="text/css">
#concept { 
    background: url('{$concepts->current()->get_image_url()}') center top no-repeat;
}
{/block}

{block "main"}
<ul id="header-bar">
    <li{if $concepts->is_first()} class="disabled"{/if}>
       <a {if $concepts->prev()}href="{$concepts->prev()->get_absolute_url()}"{/if}>&larr; Previous Concept</a>
    </li>
    <li>
        {if $concepts->current()->category->name == "uncategorized"}
        <a href="{$concepts->current()->category->client->get_absolute_url()}">Back to Project Dashboard</a>
        {else}
        <a href="{$concepts->current()->category->get_absolute_url()}">Back to {$concepts->current()->category->name} overview</a>
        {/if}
    </li>
    <li{if $concepts->is_last()} class="disabled"{/if}>
       <a {if $concepts->next()}href="{$concepts->next()->get_absolute_url()}"{/if}>Next Concept &rarr;</a>
    </li>
    <li>
        <a id="close" href="#" style="position: absolute; top: 10px; right: 30px;">X</a>
    </li>
</ul>

<div id="concept">
    <img src="{$concepts->current()->get_image_url()}" />
</div>
{/block}