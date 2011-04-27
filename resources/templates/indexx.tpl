        <p class="description">This dashboard will automatically update as new concepts and revisions are uploaded.</p>
    
    {section name=folder loop=$concept_folders}
        <h3 {if folder.is_first()}class="first"{/if}>
            <a href="{$folder->latest_concept->url}">{$folder->latest_concept->name}</a>
            {$folder->latest_concept->upload_time}
        </h3>

        <ul>
            {section name=concept loop=$folder->concepts}
                <li class="{$concept->cls}"><a href="{$concept->url}">{$concept->name}</a></li>
            {/section}
        </ul>
    {/section}

    {section name=category loop=$category_folders}
        <h2>{$category->name}</h2>
        
        <h3><a href="{$category->latest_concept->url}">{$category->latest_concept->name}{$category->latest_concept->upload_time}</a></h3>    
            <ul>
                {section name=concept loop=$category->concepts}
                    <li class="{$concept->revision_url}"><a href="{$concept->revision_url}">{$concept->revision_name}</a></li>
                {/section}
            </ul>
    {/section}
    
