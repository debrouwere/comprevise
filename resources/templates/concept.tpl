{extends "base.tpl"}
{block "title"}{$concept->name}{/block}
{block "main"}
<ul id="header-bar">
	<li{if $concept@first} class="disabled"{/if}>
	   <a href="prev">&larr; Previous Concept</a>
    </li>
	<li>
        <a href="{$concept->category->get_absolute_url()}">Back to Project Dashboard</a>
    </li>
	<li{if $concept@last} class="disabled"{/if}>
	   <a href="next">Next Concept &rarr;</a>
    </li>
    <li>
        <a href="#" onclick="hidenav()" style="position: absolute; top: 10px; right: 30px;">X</a>
    </li>
</ul>

<div id="concept">
    <img src="{$concept->get_image_url()}" />
</div>

<script language="javascript">
function hidenav() {
	document.getElementById('header-bar').style.display = "none";
	document.getElementById('concept').style.top = (0)+'px';
}
</script>
{/block}