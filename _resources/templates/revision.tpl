{extends "base.tpl"}

{block "title"}{$revisions->current()->name}{/block}

{block "head"}
<style type="text/css">
#concept { 
    background: url('{$revisions->current()->get_image_url()}') center top no-repeat;
}
{/block}

{block "main"}
<ul id="header-bar">
    <li{if $revisions->is_first()} class="disabled"{/if}>
       <a {if $revisions->prev()}href="{$revisions->prev()->get_absolute_url()}"{/if}>&larr; Previous Concept</a>
    </li>
    <li>
        <a href="{$revisions->current()->concept->category->client->get_absolute_url()}">Back to Project Dashboard</a>
    </li>
    <li{if $revisions->is_last()} class="disabled"{/if}>
       <a {if $revisions->next()}href="{$revisions->next()->get_absolute_url()}"{/if}>Next Concept &rarr;</a>
    </li>
    <li>
        <a id="close" href="#" style="position: absolute; top: 10px; right: 30px;">X</a>
    </li>
</ul>

<div id="concept">
    <img src="{$revisions->current()->get_image_url()}" />
</div>
{/block}