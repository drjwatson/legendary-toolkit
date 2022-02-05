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

    // Get Theme Options
    $theme_options             = legendary_toolkit_get_theme_options();
    $logo                      = (array_key_exists('logo', $theme_options)) ? $theme_options['logo'] : '';
    $logo_url                  = ($logo) ? esc_url(wp_get_attachment_image_url($logo, 'medium')) : '';
    $logo_height               = (array_key_exists('logo_height', $theme_options) && $theme_options['logo_height']) ? $theme_options['logo_height'] : 100;
    $transparent_class         = (array_key_exists('transparent_header', $theme_options) && $theme_options['transparent_header']) ? ' is_transparent' : '';
    $top_bar_content           = (array_key_exists('top_bar_content', $theme_options) && $theme_options['top_bar_content']) ? $theme_options['top_bar_content'] : '';
    $mobile_menu_position      = (array_key_exists('mobile_menu_position', $theme_options)) ? $theme_options['mobile_menu_position'] : 'right';
    $mobile_menu_width         = (array_key_exists('mobile_menu_width', $theme_options) && $theme_options['mobile_menu_width'] != 0) ? $theme_options['mobile_menu_width'].'px' : '100%';
    $mobile_menu_breakpoint    = (array_key_exists('mobile_menu_breakpoint', $theme_options)) ? $theme_options['mobile_menu_breakpoint'] : 1200;
    $header_behavior_class     = (array_key_exists('sticky_header', $theme_options) && $theme_options['sticky_header']) ? 'sticky-top' : '';
    $favicon                   = (array_key_exists('favicon', $theme_options)) ? $theme_options['favicon'] : '';
    $favicon_url               = ($favicon) ? esc_url(wp_get_attachment_image_url($favicon, 'medium')) : '';
    $page_title                = (array_key_exists('page_title', $theme_options)) ? $theme_options['page_title'] : 0;
    $page_title_content        = (array_key_exists('page_title_content', $theme_options) && $theme_options['page_title_content']) ? $theme_options['page_title_content'] : '';

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
    <?php if ( $favicon ) : ?>
      <link rel="shortcut icon" href="<?php echo $favicon_url; ?>" />
    <?php endif; ?>
</head>

<body <?php body_class(); ?>>

<?php 

    // WordPress 5.2 wp_body_open implementation
    if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    } else {
        do_action( 'wp_body_open' );
    }
?>
   
    <div id="page" class="site" <?php if($header_behavior_class == 'sticky-top'){echo 'style="margin-top:'.$logo_height.'px"';};?>>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wp-bootstrap-starter' ); ?></a>
    <?php if(!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' )): ?>
    <?php if ($top_bar_content) :?>
        <div class="top-bar-content">
            <?php echo $top_bar_content;?>
        </div>
    <?php endif; ?>
	<header id="masthead" class="site-header navbar-static-top <?php echo wp_bootstrap_starter_bg_class(); ?> <?=$header_behavior_class;?><?=$transparent_class;?>" role="banner">
        <div class="container">
            <nav class="navbar navbar-expand-xl p-0">
                <div class="navbar-brand">
                    <?php if ( $logo ): ?>
                        <a href="<?php echo esc_url( home_url( '/' )); ?>">
                            <img id="site_logo" src="<?php echo $logo_url; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                        </a>
                    <?php else : ?>
                        <a class="site-title" href="<?php echo esc_url( home_url( '/' )); ?>"><?php esc_url(bloginfo('name')); ?></a>
                    <?php endif; ?>

                </div>
                <?php
                    // Desktop Menu
                    wp_nav_menu(
                        array(
                            'theme_location'    => 'primary',
                            'container'         => 'div',
                            'container_id'      => 'main-nav',
                            'container_class'   => 'collapse navbar-collapse justify-content-end',
                            'menu_id'           => false,
                            'menu_class'        => 'navbar-nav',
                            'depth'             => 10,
                            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                            'walker'            => new wp_bootstrap_navwalker()
                        )
                    );
                ?>
                <!-- Mobile Menu -->
                <slide-drawer width="<?=$mobile_menu_width;?>" overlayOpacity=".7" mobileWidth="<?=$mobile_menu_width;?>" mobileBreak="<?=$mobile_menu_breakpoint;?>" <?=$mobile_menu_position;?>>
                    <div id="menu-wrapper" style="display:none";>
                        <div id="menu_top">
                            <?php if ($logo) : ?>
                            <a href="<?php echo esc_url( home_url( '/' )); ?>">
                                <img id="mobile_site_logo" src="<?php echo $logo_url; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                            </a>
                            <?php else : ?>
                                <a class="site-title" href="<?php echo esc_url( home_url( '/' )); ?>"><?php esc_url(bloginfo('name')); ?></a>
                            <?php endif;?>
                            <p style="font-size:12px;color:white;">[Add Theme Settings Mobile Content Top]</p>
                        </div>
                        <?php
                            wp_nav_menu(
                                array(
                                'theme_location'    => 'primary',
                                'container'         => false,
                                'menu_id'           => 'mobile_menu',
                                )
                            );
                        ?>
                        
                        <div id="mobile_menu_bottom">
                            <p style="font-size:12px;color:white;">[Add Theme Settings Bottom]</p>
                        </div>
                    </div>
                </slide-drawer>
            </nav>
        </div>
	</header><!-- #masthead -->
    <?php if ($page_title && !is_front_page()) : ?>
        <div id="page_title">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <?php echo do_shortcode($page_title_content);?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>
	<div id="content" class="site-content">
            <?php endif; ?>