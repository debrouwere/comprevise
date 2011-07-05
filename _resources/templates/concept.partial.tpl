<h3{if $first} class="first"{/if}>
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