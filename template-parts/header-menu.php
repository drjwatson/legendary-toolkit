<?php
$scrolling_logo = legendary_toolkit_get_theme_option('scrolling_logo');
$header_container_class = (legendary_toolkit_get_theme_option('full_width_header')) ? 'container-fluid' : 'container';
$header_behavior_class = (legendary_toolkit_get_theme_option('sticky_header')) ? 'sticky_header' : '';
$transparent_header = (legendary_toolkit_get_theme_option('transparent_header')) ? legendary_toolkit_get_theme_option('transparent_header') : '';
switch ($transparent_header) {
    case 'home':
        if (is_front_page()) {
            $transparent_class = 'is_transparent';
        }
        break;
    case 'inside':
        if (!is_front_page()) {
            $transparent_class = 'is_transparent';
        }
        break;
    case 'all':
        $transparent_class = 'is_transparent';
        break;
    default:
        $transparent_class = '';
        break;
}
// $transparent_class = (legendary_toolkit_get_theme_option('transparent_header')) ? 'is_transparent' : '';
$mobile_menu_width = (legendary_toolkit_get_theme_option('mobile_menu_width')) ? legendary_toolkit_get_theme_option('mobile_menu_width') . 'px' : '100%';
$mobile_menu_breakpoint = (legendary_toolkit_get_theme_option('mobile_menu_breakpoint')) ? legendary_toolkit_get_theme_option('mobile_menu_breakpoint') : 1200;
$mobile_menu_position = (legendary_toolkit_get_theme_option('mobile_menu_position')) ? legendary_toolkit_get_theme_option('mobile_menu_position') : 'right';
$mobile_menu_top_content = legendary_toolkit_get_theme_option('mobile_menu_top_content');
$mobile_menu_bottom_content = legendary_toolkit_get_theme_option('mobile_menu_bottom_content');
?>

<header id="masthead" class="site-header navbar-static-top <?=$header_behavior_class;?> <?=$transparent_class;?>" role="banner">
    <div class="<?=$header_container_class;?>">
        <nav class="navbar navbar-expand p-0">
            <div class="navbar-brand">
                <?php get_template_part('template-parts/header', 'logo', ['id' => 'site_logo']);?>
                <?php
                    if ($header_behavior_class == 'sticky_header' && $scrolling_logo) {
                        get_template_part('template-parts/header', 'logo', ['id' => 'scrolling_site_logo', 'type' => 'scrolling', 'class' => 'd-none']);
                    } 
                ?>
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
            <slide-drawer style="display:none;" width="<?=$mobile_menu_width;?>" overlayOpacity=".7" mobileWidth="<?=$mobile_menu_width;?>" mobileBreak="<?=$mobile_menu_breakpoint;?>" <?=$mobile_menu_position;?>>
                <div id="menu-wrapper";>
                    <div id="menu_top">
                        <?php 
                        $mobile_logo_template_args = ['id' => 'mobile_site_logo'];
                        if ($scrolling_logo) {
                            $mobile_logo_template_args['type'] = 'scrolling';
                        }
                        get_template_part('template-parts/header', 'logo', $mobile_logo_template_args);?>
                        <div id="mobile-menu-top-content">
                            <?php echo wpautop($mobile_menu_top_content);?>
                        </div>
                    </div>
                    <?php
                        wp_nav_menu(
                            array(
                                'theme_location'    => 'primary',
                                'container'         => false,
                                'menu_id'           => 'mobile_menu',
                                'fallback_cb'       => 'toolkit_mobile_navwalker::fallback',
                                'walker'            => new toolkit_mobile_navwalker()
                            )
                        );
                    ?>
                    
                    <div id="mobile_menu_bottom">
                        <div id="mobile-menu-bottom-content">
                            <?php echo wpautop($mobile_menu_bottom_content);?>
                        </div>
                    </div>
                </div>
            </slide-drawer>
        </nav>
    </div>
</header><!-- #masthead -->