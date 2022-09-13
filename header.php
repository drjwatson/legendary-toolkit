<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */
global $template;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <?php
        get_template_part('template-parts/header', 'head');
    ?>
    <body <?php body_class(); ?>>
        <?php 
            if ( function_exists( 'wp_body_open' ) ) {
                wp_body_open();
            } else {
                do_action( 'wp_body_open' );
            }
        ?>
        <div id="page" class="site">
            <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'legendary-toolkit' ); ?></a>
            <?php 
                if (!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' ) && basename( $template ) != 'page-maintenance.php') {
                    get_template_part('template-parts/header', 'topbar');
                    get_template_part('template-parts/header', 'menu');
                    get_template_part('template-parts/header', 'title');
                    get_template_part('template-parts/header', 'content');
                }
            ?>
            