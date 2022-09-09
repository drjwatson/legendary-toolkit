<?php
    $content_container = (toolkit_get_sidebar_selection() || is_page_template('blank-page.php') || is_page_template('page-full-width.php')) ? 'container-fluid' : 'container';
?>
<div id="content" class="site-content <?=$content_container;?>">
    <div class="row">