<?php
/**
 * Legendary Toolkit functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package legendary_toolkit
 */

require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/legendary-lion/legendary-toolkit',
	__FILE__,
	'legendary-toolkit'
);
$myUpdateChecker->setBranch('master');
$myUpdateChecker->getVcsApi()->enableReleaseAssets();

if ( ! function_exists( 'legendary_toolkit_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function legendary_toolkit_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Legendary Toolkit, use a find and replace
	 * to change 'legendary-toolkit' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'legendary-toolkit', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'legendary-toolkit' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'legendary_toolkit_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

    function wp_boostrap_starter_add_editor_styles() {
        add_editor_style( 'custom-editor-style.css' );
    }
    add_action( 'admin_init', 'wp_boostrap_starter_add_editor_styles' );

}
endif;
add_action( 'after_setup_theme', 'legendary_toolkit_setup' );


/**
 * Add Welcome message to dashboard
 */
// function legendary_toolkit_reminder(){
//         $theme_page_url = 'https://afterimagedesigns.com/wp-bootstrap-starter/?dashboard=1';

//             if(!get_option( 'triggered_welcomet')){
//                 $message = sprintf(__( 'Welcome to Legendary Toolkit Theme! Before diving in to your new theme, please visit the <a style="color: #fff; font-weight: bold;" href="%1$s" target="_blank">theme\'s</a> page for access to dozens of tips and in-depth tutorials.', 'legendary-toolkit' ),
//                     esc_url( $theme_page_url )
//                 );

//                 printf(
//                     '<div class="notice is-dismissible" style="background-color: #6C2EB9; color: #fff; border-left: none;">
//                         <p>%1$s</p>
//                     </div>',
//                     $message
//                 );
//                 add_option( 'triggered_welcomet', '1', '', 'yes' );
//             }

// }
// add_action( 'admin_notices', 'legendary_toolkit_reminder' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function legendary_toolkit_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'legendary_toolkit_content_width', 1170 );
}
add_action( 'after_setup_theme', 'legendary_toolkit_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function legendary_toolkit_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'legendary-toolkit' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'legendary-toolkit' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__( 'Footer 1', 'legendary-toolkit' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Add widgets here.', 'legendary-toolkit' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__( 'Footer 2', 'legendary-toolkit' ),
        'id'            => 'footer-2',
        'description'   => esc_html__( 'Add widgets here.', 'legendary-toolkit' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__( 'Footer 3', 'legendary-toolkit' ),
        'id'            => 'footer-3',
        'description'   => esc_html__( 'Add widgets here.', 'legendary-toolkit' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'legendary_toolkit_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function legendary_toolkit_scripts() {
	// load bootstrap css
    if ( get_theme_mod( 'cdn_assets_setting' ) === 'yes' ) {
        wp_enqueue_style( 'legendary-toolkit-bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css' );
        wp_enqueue_style( 'legendary-toolkit-fontawesome-cdn', 'https://use.fontawesome.com/releases/v5.15.1/css/all.css' );
    } else {
        wp_enqueue_style( 'legendary-toolkit-bootstrap-css', get_template_directory_uri() . '/inc/assets/css/bootstrap.min.css' );
        wp_enqueue_style( 'legendary-toolkit-fontawesome-cdn', get_template_directory_uri() . '/inc/assets/css/fontawesome.min.css' );
    }
	// load bootstrap css
	// load AItheme styles
	// load Legendary Toolkit styles
	wp_enqueue_style( 'legendary-toolkit-style', get_stylesheet_uri() );
	wp_enqueue_script('jquery');
    
    // Internet Explorer HTML5 support
    wp_enqueue_script( 'html5hiv',get_template_directory_uri().'/inc/assets/js/html5.js', array(), '3.7.0', false );
    wp_script_add_data( 'html5hiv', 'conditional', 'lt IE 9' );

    // bootstrap and popperjs
    wp_enqueue_script('legendary-toolkit-popper', get_template_directory_uri() . '/inc/assets/js/popper.min.js', array(), '', true );
    wp_enqueue_script('legendary-toolkit-bootstrapjs', get_template_directory_uri() . '/inc/assets/js/bootstrap.min.js', array(), '', true );
    
    // theme js
    wp_enqueue_script('legendary-toolkit-themejs', get_template_directory_uri() . '/inc/assets/js/theme-script.min.js', array(), '', true );
	wp_enqueue_script( 'legendary-toolkit-skip-link-focus-fix', get_template_directory_uri() . '/inc/assets/js/skip-link-focus-fix.min.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

    // parent styles
    wp_enqueue_style('legendary_toolkit_styles', get_template_directory_uri() . '/style.css');

    // append theme options stylesheet after parent theme styles
    wp_add_inline_style( 'legendary_toolkit_styles', legendary_toolkit_theme_options_css() );

    // theme styles from settings
    wp_enqueue_style('legendary_toolkit_theme_settings_styles', get_template_directory_uri() . '/inc/assets/css/theme-styles.css');

    // temporary stylesheet for development
    wp_enqueue_style('legendary_toolkit_development_css', get_template_directory_uri() . '/inc/assets/css/theme-styles-development.css');

}
add_action( 'wp_enqueue_scripts', 'legendary_toolkit_scripts' );


function legendary_toolkit_theme_options_css() {
    $custom_css = '';
    
    // Define variables for theme options stylesheet
    
    $theme_options = legendary_toolkit_get_theme_options();

    // Add Google Fonts to stylesheet

    $font_files = $theme_options['font_files'];

    foreach ($font_files as $family => $files) {
        foreach ($files as $style => $file_url) {
            $font_style = (strpos($style, 'italic') !== false) ? 'italic' : 'normal';

            $weight = (!preg_match('/\\d/', $style)) ? 'normal' : (int) filter_var($style, FILTER_SANITIZE_NUMBER_INT);

            $ext = pathinfo($file_url, PATHINFO_EXTENSION);

            $format = 'truetype';

            switch ($ext) {
                case "ttf":
                    $format = 'truetype';
                    break;
                case "otf":
                    $format = 'opentype';
                    break;
                case "woff":
                    $format = 'woff';
                    break;
                case "woff2":
                    $format = 'woff2';
                    break;
                case "svg":
                    $format = 'svg';
                    break;
                default:
                    $format = 'truetype';
            }

            $custom_css .= "
                @font-face {
                    font-family: '$family';
                    src: url('$file_url') format('$format');
                    font-weight: $weight;
                    font-style: $font_style;
                }
            ";

        }
    }

    $primary_color = $theme_options['primary_color'];
    $secondary_color = $theme_options['secondary_color'];

    function get_saved_font_family($option, $options) {
        if (!array_key_exists($option, $options)) { return; }
        if (!$options[$option]) { return; }
        if ($options[$option] == 'Select Font Family') { return; }
        $option = $options[$option];
        return $option;
    }
    function get_saved_font_color($option, $options) {
        if (!array_key_exists($option, $options)) { return; }
        if (!$options[$option]) { return; }
        $option = $options[$option];
        return $option;
    }
    function get_saved_font_style($option, $options) {
        if (!array_key_exists($option, $options)) { return; }
        if (!$options[$option]) { return; }
        $option = $options[$option];
        return ( strpos($option, 'italic') !== false ) ? 'italic' : 'normal';
    }
    function get_saved_font_weight($option, $options) {
        if (!array_key_exists($option, $options)) { return; }
        if (!$options[$option]) { return; }
        $option = $options[$option];
        return ( preg_match('/\\d/', $option) ) ? (int) filter_var($option, FILTER_SANITIZE_NUMBER_INT) : 'regular';
    }
    function get_saved_font_size($option, $options) {
        if (!array_key_exists($option, $options)) { return; }
        if (!$options[$option]) { return; }
        $option = $options[$option];
        return $option . 'px';
    }

    function define_font_variables($id, $options) {
        $font_family = get_saved_font_family($id . '_font_family', $options);
        $font_color = get_saved_font_color($id . '_font_color', $options);
        $font_style = get_saved_font_style($id . '_font_style', $options);
        $font_weight = get_saved_font_weight($id . '_font_weight', $options);
        $font_size = get_saved_font_size($id . '_font_size', $options);

        $style_return = "";
        $style_return .= ($font_family) ? "--".$id."_font_family : ".$font_family.";" : '';
        $style_return .= ($font_color) ? "--".$id."_font_color : ".$font_color.";" : '';
        $style_return .= ($font_style) ? "--".$id."_font_style : ".$font_style.";" : '';
        $style_return .= ($font_weight) ? "--".$id."_font_weight : ".$font_weight.";" : '';
        $style_return .= ($font_size) ? "--".$id."_font_size : ".$font_size.";" : '';

        return $style_return;
    }

    // Add CSS variables
    $custom_css .= "
        :root {
            --primary_color : $primary_color;
            --secondary_color : $secondary_color;
            " . define_font_variables('body', $theme_options) . "
            " . define_font_variables('h1', $theme_options) . "
            " . define_font_variables('h2', $theme_options) . "
            " . define_font_variables('h3', $theme_options) . "
            " . define_font_variables('h4', $theme_options) . "
            " . define_font_variables('h5', $theme_options) . "
            " . define_font_variables('h6', $theme_options) . "
            " . define_font_variables('all', $theme_options) . "
        }
    ";
    // print_r($custom_css);
    return $custom_css;
}




/**
 * Add Preload for CDN scripts and stylesheet
 */
function legendary_toolkit_preload( $hints, $relation_type ){
    if ( 'preconnect' === $relation_type && get_theme_mod( 'cdn_assets_setting' ) === 'yes' ) {
        $hints[] = [
            'href'        => 'https://cdn.jsdelivr.net/',
            'crossorigin' => 'anonymous',
        ];
        $hints[] = [
            'href'        => 'https://use.fontawesome.com/',
            'crossorigin' => 'anonymous',
        ];
    }
    return $hints;
} 

add_filter( 'wp_resource_hints', 'legendary_toolkit_preload', 10, 2 );



function legendary_toolkit_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = '<form action="' . esc_url( home_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
    <div class="d-block mb-3">' . __( "To view this protected post, enter the password below:", "legendary-toolkit" ) . '</div>
    <div class="form-group form-inline"><label for="' . $label . '" class="mr-2">' . __( "Password:", "legendary-toolkit" ) . ' </label><input name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" class="form-control mr-2" /> <input type="submit" name="Submit" value="' . esc_attr__( "Submit", "legendary-toolkit" ) . '" class="btn btn-primary"/></div>
    </form>';
    return $o;
}
add_filter( 'the_password_form', 'legendary_toolkit_password_form' );



/**
 * Implement the Custom Header feature.
 */
// require get_template_directory() . '/inc/custom-header.php'; // commented to remove customizer options

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
// require get_template_directory() . '/inc/customizer.php'; // commented to remove customizer options

/**
 * Load plugin compatibility file.
 */
require get_template_directory() . '/inc/plugin-compatibility/plugin-compatibility.php';

/**
 * Load custom WordPress nav walker.
 */
if ( ! class_exists( 'wp_bootstrap_navwalker' )) {
    require_once(get_template_directory() . '/inc/wp_bootstrap_navwalker.php');
}


require get_template_directory() . '/inc/options.php';

// TODO: Remove unwanted mods


// allow svg uploads
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

// skip cropping
function logo_size_change(){
	remove_theme_support( 'custom-logo' );
	add_theme_support( 'custom-logo', array(
	    'height'      => 100,
	    'width'       => 400,
	    'flex-height' => true,
	    'flex-width'  => true,
	) );
}
add_action( 'after_setup_theme', 'logo_size_change', 11 );