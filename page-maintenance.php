<?php
/**
 * Template Name: Maintenance Mode
 */

get_header(); 
$maintenance_mode_content = legendary_toolkit_get_theme_option('maintenance_mode_content');
?>
<section id="primary" class="maintenance-mode-section content-area <?=toolkit_get_primary_column_classes();?>">
	<div id="main" class="site-main" role="main">
        <?=$maintenance_mode_content;?>
	</div><!-- #main -->
</section><!-- #primary -->
<?php
// get_sidebar();
// get_footer();