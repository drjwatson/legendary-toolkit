<?php

    // Check if it's a single post page
    $is_blog_single = is_single();


    $content_container = (toolkit_get_sidebar_selection() || is_page_template('blank-page.php') || is_page_template('page-full-width.php') || $is_blog_single) ? 'container-fluid' : 'container';

?>
<div id="content" class="site-content <?=$content_container;?>">
    <div class="row">