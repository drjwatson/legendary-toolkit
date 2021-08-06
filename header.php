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

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php 

    // WordPress 5.2 wp_body_open implementation
    if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    } else {
        do_action( 'wp_body_open' );
    }

    // Get Theme Options
    $theme_options          = legendary_toolkit_get_theme_options();
    $logo                   = (array_key_exists('logo', $theme_options)) ? $theme_options['logo'] : '';
    $logo_url               = ($logo) ? esc_url(wp_get_attachment_image_url($logo, 'medium')) : '';
    $logo_height            = (array_key_exists('logo_height', $theme_options) && $theme_options['logo_height']) ? $theme_options['logo_height'] : 100;
    $admin_top_height       = (is_admin_bar_showing()) ? 32 : 0;
    $toggle_top_offset      = (array_key_exists('logo_height', $theme_options)) ? ($theme_options['logo_height'] / 2) + $admin_top_height + 8 : 0;
    $top_bar_content        = (array_key_exists('top_bar_content', $theme_options) && $theme_options['top_bar_content']) ? $theme_options['top_bar_content'] : '';
    $mobile_menu_position   = (array_key_exists('mobile_menu_position', $theme_options)) ? $theme_options['mobile_menu_position'] : 'right';
    $mobile_menu_width      = (array_key_exists('mobile_menu_width', $theme_options) && $theme_options['mobile_menu_width'] != 0) ? $theme_options['mobile_menu_width'].'px' : '300px';
    $mobile_menu_breakpoint = (array_key_exists('mobile_menu_breakpoint', $theme_options)) ? $theme_options['mobile_menu_breakpoint'].'px' : '1200px';
    $header_behavior_class  = (array_key_exists('sticky_header', $theme_options) && $theme_options['sticky_header']) ? 'sticky-top' : '';
?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wp-bootstrap-starter' ); ?></a>
    <?php if(!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' )): ?>
    <?php if ($top_bar_content) :?>
        <div class="top-bar-content">
            <?php echo $top_bar_content;?>
        </div>
    <?php endif; ?>
	<header id="masthead" class="site-header navbar-static-top <?php echo wp_bootstrap_starter_bg_class(); ?> <?=$header_behavior_class;?>" role="banner">
        <div class="container">
            <nav class="navbar navbar-expand-xl p-0">
                <div class="navbar-brand">
                    <?php if ( $logo ): ?>
                        <a href="<?php echo esc_url( home_url( '/' )); ?>">
                            <img id="site_logo" style="height:<?=$logo_height.'px';?>" src="<?php echo $logo_url; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
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
                            'depth'             => 3,
                            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                            'walker'            => new wp_bootstrap_navwalker()
                        )
                    );
                ?>
                <!-- Mobile Menu -->
                <slide-drawer width="<?=$mobile_menu_width;?>" overlayOpacity=".7" mobileWidth="<?=$mobile_menu_width;?>" mobileBreak="<?=$mobile_menu_breakpoint;?>" <?=$mobile_menu_position;?> toggleTopOffset="<?=$toggle_top_offset;?>">
                    <div id="menu-wrapper">
                        <div id="menu_top">
                            <?php if ($logo) : ?>
                            <a href="<?php echo esc_url( home_url( '/' )); ?>">
                                <img id="mobile_site_logo" style="height:<?=$logo_height.'px';?>" src="<?php echo $logo_url; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                            </a>
                            <?php else : ?>
                                <a class="site-title" href="<?php echo esc_url( home_url( '/' )); ?>"><?php esc_url(bloginfo('name')); ?></a>
                            <?php endif;?>
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
                        <div id="menu_bottom">
                            <p>bottom</p>
                        </div>
                    </div>
                </slide-drawer>
            </nav>
        </div>
	</header><!-- #masthead -->
	<div id="content" class="site-content">
		<div class="container">
			<div class="row">
                <?php endif; ?>