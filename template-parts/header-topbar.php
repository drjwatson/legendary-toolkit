<?php 

$top_bar_content = legendary_toolkit_get_theme_option('top_bar_content');

if ($top_bar_content) : ?>
    <div class="top-bar-content">
        <?=$top_bar_content;?>
    </div>
<?php endif; ?>