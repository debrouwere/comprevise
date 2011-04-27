<!DOCTYPE html>
<html>
<head>
    <title>{$category->title}</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="../_resources/style.css">
</head>
<body>
<div id="wrapper">
    <h1>{$category->title}</h1>
        <p class="description">This category listing will automatically update as new concepts and revisions are uploaded.<br><a href="../">&laquo; Back to dashboard</a></p>

    {section name=folder loop=$category->concept_folders}

        <h3 {if folder.is_first()}class="first"{/if}>
            <a href="{$category->latest_concept->url}">
                <em>{$category->latest_concept->name}</em>
                {$category->latest_concept->upload_time}
            </a>
        </h3>

        <ul>
            {section name=concept loop=$category->concepts}
                <li class="{$concept->cls}">
                    <a href="{$concept->url}">{$concept->revision_name}</a>
                </li>
            {/section}
        </ul>

    {/section}

    {section name=folder loop=$category->folders}
        <h2>{category_name()}</h2>

        <!-- while(have_category_concept_folders()) : -->

            <h3><a href="{latest_concept_url_in_category()}"><em>{concept_name_in_category()}</em> {latest_concept_upload_time_in_category()}</a></h3>

            <ul>

                {section name=concept loop=$category->concepts}
                    <li class="$concept->cls">
                        <a href="{$concept->url}">{$concept->revision_name}</a>
                    </li>
                {/section}

            </ul>

        <!-- endwhile} -->

    {/section}

    <div id="footer">
        Powered by <a href="http://www.conceptrevisions.com">Concept Revisions</a>
    </div>
</div>
</body>
</html>