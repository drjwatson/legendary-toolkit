<?php
/**
 * Create A Simple Theme Options Panel
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'Legendary_Toolkit_Theme_Options' ) ) {

	class Legendary_Toolkit_Theme_Options {

		/**
		 * Start things up
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// We only need to register the admin panel on the back-end

			if ( is_admin() ) {
                add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' ); 
                add_action( 'admin_enqueue_scripts', array( 'Legendary_Toolkit_Theme_Options' , 'legendary_toolkit_options_enqueue_scripts' ) );
				add_action( 'admin_menu', array( 'Legendary_Toolkit_Theme_Options', 'add_admin_menu' ) );
				add_action( 'admin_init', array( 'Legendary_Toolkit_Theme_Options', 'register_settings' ) );

			}

		}

        public static function legendary_toolkit_options_enqueue_scripts() {
            wp_register_script( 'legendary_toolkit_uploader', get_template_directory_uri() .'/inc/assets/js/uploader.js', array('jquery','media-upload','thickbox') );
            if ( 'toplevel_page_theme-settings' == get_current_screen()->id ) {
                wp_enqueue_script('legendary_toolkit_uploader');
                wp_enqueue_style( 'wp-color-picker' ); 
                wp_enqueue_style( 'legendary_toolkit_admin_styles', get_template_directory_uri() . '/inc/assets/css/admin-styles.css' ); 
                wp_enqueue_script( 'legendary_toolkit_color_picker', get_template_directory_uri() . '/inc/assets/js/color-picker.js', array( 'wp-color-picker' ), false, true ); 
                wp_enqueue_script( 'legendary_toolkit_google_font_selector', get_template_directory_uri() . '/inc/assets/js/google-font-selector.js'); 
                wp_enqueue_script( 'legendary_toolkit_admin_scripts', get_template_directory_uri() . '/inc/assets/js/admin-scripts.js', array('jquery'), false, true); 
            }

        }

		/**
		 * Returns all theme options
		 *
		 * @since 1.0.0
		 */
		public static function get_theme_options() {
			return get_option( 'theme_options' );
		}

		/**
		 * Returns single theme option
		 *
		 * @since 1.0.0
		 */
		public static function get_theme_option( $id ) {
			$options = self::get_theme_options();
			if ( isset( $options[$id] ) ) {
				return $options[$id];
			}
		}

		/**
		 * Add sub menu page
		 *
		 * @since 1.0.0
		 */
		public static function add_admin_menu() {
			add_menu_page(
				esc_html__( 'Theme Settings', 'legendary-toolkit' ),
				esc_html__( 'Theme Settings', 'legendary-toolkit' ),
				'manage_options',
				'theme-settings',
				array( 'Legendary_Toolkit_Theme_Options', 'create_admin_page' )
			);
		}

		/**
		 * Register a setting and its sanitization callback.
		 *
		 * We are only registering 1 setting so we can store all options in a single option as
		 * an array. You could, however, register a new setting for each option
		 *
		 * @since 1.0.0
		 */
		public static function register_settings() {
			register_setting( 'theme_options', 'theme_options', array( 'Legendary_Toolkit_Theme_Options', 'sanitize' ) );
		}

		/**
		 * Sanitization callback
		 *
		 * @since 1.0.0
		 */
		public static function sanitize( $options ) {

			// If we have options lets sanitize them
			if ( $options ) {

				// Logo
				if ( ! empty( $options['logo'] ) ) {
					$options['logo'] = sanitize_text_field( $options['logo'] );
				} else {
					unset( $options['logo'] ); // Remove from options if empty
				}

                // ============
                // Examples
                // ============
				// Checkbox
				if ( ! empty( $options['checkbox_example'] ) ) {
					$options['checkbox_example'] = 'on';
				} else {
					unset( $options['checkbox_example'] ); // Remove from options if not checked
				}

				// Input
				if ( ! empty( $options['input_example'] ) ) {
					$options['input_example'] = sanitize_text_field( $options['input_example'] );
				} else {
					unset( $options['input_example'] ); // Remove from options if empty
				}

				// Select
				if ( ! empty( $options['select_example'] ) ) {
					$options['select_example'] = sanitize_text_field( $options['select_example'] );
				}

			}

			// Return sanitized options
			return $options;

		}

        public static function get_google_fonts() {
            $google_api_key = "AIzaSyCzOdFDkLRrWOePEGIribIpUV3BM2SuO9s";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/webfonts/v1/webfonts?key=" . $google_api_key. "&sort=popularity");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json"
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
            $fonts_list = json_decode(curl_exec($ch), true);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if($http_code != 200) 
                exit('Error : Failed to get Google Fonts list');
    
            // echo out list of fonts
            
            $google_fonts = $fonts_list["items"];
            return $google_fonts;
        }

        public static function typography_field($id, $has_size = true, $has_transform = false) {
            
            ob_start();
            ?>
            <table data-type="<?=$id;?>" class="inner-form-table">
                <tr valign="top">
                    <td>
                        <div class="legendary-toolkit-input-group">
                            <?php $value = self::get_theme_option( $id . '_font_family' );?>
                            <label class="prefix" for="theme_options[<?=$id;?>_font_family]">Family</label>
                            <select data-type="<?=$id;?>" class="font-selector" name="theme_options[<?=$id;?>_font_family]">
                                <option>Select Font Family</option>
                                <?php foreach (self::get_google_fonts() as $i => $font) : ?>
                                    <option value="<?=$font['family'];?>" <?php selected( $value, $font['family'], true );?>>
                                        <?=$font['family'];?>
                                    </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="legendary-toolkit-input-group">
                            <?php $value = self::get_theme_option( $id . '_font_weight' );?>
                            <label class="prefix" for="theme_options[<?=$id;?>_font_weight]">Weight</label>
                            <select data-type="<?=$id;?>" data-selected="<?=esc_attr( $value );?>" name="theme_options[<?=$id;?>_font_weight]" class="font-selector-weight"></select>
                        </div>
                    </td>
                    <td>
                        <?php $value = self::get_theme_option( $id . '_font_color' );?>
                        <input class="color-field" type="text" name="theme_options[<?=$id;?>_font_color]" value="<?=esc_attr( $value );?>">
                    </td>
                    
                    <td>
                        <?php if ($has_size) : ?>
                            <div class="legendary-toolkit-input-group">
                                <?php $value = self::get_theme_option( $id . '_font_size' );?>
                                <label class="prefix" for="theme_options[<?=$id;?>_font_size]">Size</label>
                                <input type="number" name="theme_options[<?=$id;?>_font_size]" value="<?=esc_attr($value);?>">
                                <label class="suffix" for="theme_options[<?=$id;?>_font_size]">px</label>
                            </div>
                        <?php endif;?>
                    </td>

                    <td>
                        <?php if ($has_transform) : ?>
                            <div class="legendary-toolkit-input-group">
                                <?php $value = self::get_theme_option( $id . '_font_transform' );?>
                                <label class="prefix" for="theme_options[<?=$id;?>_font_transform]">Transform</label>
                                <select name="theme_options[<?=$id;?>_font_transform]">
                                    <option value="none">None</option>
                                    <?php
                                    $options = array(
                                        'uppercase' => 'Uppercase',
                                        'lowercase' => 'Lowercase',
                                    );
                                    foreach ( $options as $id => $label ) { ?>
                                        <option value="<?=esc_attr( $id );?>" <?php selected( $value, $id, true );?>>
                                            <?=strip_tags( $label );?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php endif;?>
                    </td>
                </tr>
            </table>
            
            <?php $files = self::get_theme_option( 'font_files' );?>
            <div class="files-field" style="display:none;" data-type="<?=$id;?>"></div>
            <?php
            return ob_get_clean();
        }

		/**
		 * Settings page output
		 *
		 * @since 1.0.0
		 */
		public static function create_admin_page() { 
            ?>
			<div class="wrap">
                <div id="options_header">
                    <div id="options_banner">
                        <h1><?php esc_html_e( 'Legendary Toolkit Options', 'legendary-toolkit' );?></h1>
                        <?php submit_button( __( 'Save Changes', 'legendary-toolkit' ), 'primary', 'submit', true, array( 'form' => 'legendary_toolkit_form' ) );?>
                    </div>
                    <!-- Tab links -->
                    <div class="tab">
                        <button class="tablinks" onclick="open_settings_tab(event, 'legendary_toolkit_general')" id="legendary_toolkit_general_tab">General</button>
                        <button class="tablinks" onclick="open_settings_tab(event, 'legendary_toolkit_header')">Header</button>
                        <button class="tablinks" onclick="open_settings_tab(event, 'legendary_toolkit_footer')">Footer</button>
                        <button class="tablinks" onclick="open_settings_tab(event, 'legendary_toolkit_typography')">Typography</button>
                        <button class="tablinks" onclick="open_settings_tab(event, 'legendary_toolkit_examples')">Examples</button>
                    </div>
                </div>
				<form method="post" action="options.php" id="legendary_toolkit_form">

					<?php settings_fields( 'theme_options' );?>
                    <!-- Tab content -->
                    <div id="legendary_toolkit_general" class="tabcontent">
                        <h3>General</h3>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'Logo', 'legendary-toolkit' );?></th>
                                <td>
                                    <?php $value = self::get_theme_option( 'logo' ); ?>
                                    <input type="hidden" name="theme_options[logo]" id="logo" value="<?php echo $value; ?>" />
                                    <div id="logo_preview" class="logo btn_logo" style="background-image:url(<?php echo wp_get_attachment_image_url($value, 'medium'); ?>)" ></div>
                                    <button id="btn_logo" class="button default btn_logo">Select Logo</button>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'Primary Color', 'legendary-toolkit' );?></th>
                                <td>
                                    <?php $value = self::get_theme_option( 'primary_color' );?>
                                    <input class="color-field" type="text" name="theme_options[primary_color]" value="<?=esc_attr( $value );?>">
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'Secondary Color', 'legendary-toolkit' );?></th>
                                <td>
                                    <?php $value = self::get_theme_option( 'secondary_color' );?>
                                    <input class="color-field" type="text" name="theme_options[secondary_color]" value="<?=esc_attr( $value );?>">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id="legendary_toolkit_header" class="tabcontent">
                        <h3>Header</h3>
                    </div>
                    <div id="legendary_toolkit_footer" class="tabcontent">
                        <h3>Footer</h3>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'Footer Columns', 'legendary-toolkit' );?></th>
                                <td style="display:flex; align-items: center; ">
                                    <?php $value = self::get_theme_option( 'footer_columns' );?>
                                    <input type="range" min="0" max="4" step="1" name="theme_options[footer_columns]" oninput="this.nextElementSibling.value = this.value" value="<?=(esc_attr( $value )) ? esc_attr($value) : 4;?>">
                                    <output style="margin-left:10px;"><?=(esc_attr( $value )) ? esc_attr( $value ) : 4;?></output>
                                </td>
                            </tr>
                            <?php $footer_column_count = self::get_theme_option('footer_columns');?>
                            <?php $hidden = ( $footer_column_count < 1 ) ? 'hidden' : '';?>
                            <tr valign="top" id="footer_column_row_1" class="<?=$hidden;?>">
                                <th scope="row"><?php esc_html_e( 'Footer Column 1', 'legendary-toolkit' );?></th>
                                <td>
                                    <?php $value = self::get_theme_option( 'footer_column_1' );?>
                                    <?php echo wp_editor( $value, 'footer_column_1', $settings = array('textarea_rows'=> '10', 'textarea_name' => 'theme_options[footer_column_1]') );?>
                                </td>
                            </tr>
                            <?php $hidden = ( $footer_column_count < 2 ) ? 'hidden' : '';?>
                            <tr valign="top" id="footer_column_row_2" class="<?=$hidden;?>">
                                <th scope="row"><?php esc_html_e( 'Footer Column 2', 'legendary-toolkit' );?></th>
                                <td>
                                    <?php $value = self::get_theme_option( 'footer_column_2' );?>
                                    <?php echo wp_editor( $value, 'footer_column_2', $settings = array('textarea_rows'=> '10', 'textarea_name' => 'theme_options[footer_column_2]') );?>
                                </td>
                            </tr>
                            <?php $hidden = ( $footer_column_count < 3 ) ? 'hidden' : '';?>
                            <tr valign="top" id="footer_column_row_3" class="<?=$hidden;?>">
                                <th scope="row"><?php esc_html_e( 'Footer Column 3', 'legendary-toolkit' );?></th>
                                <td>
                                    <?php $value = self::get_theme_option( 'footer_column_3' );?>
                                    <?php echo wp_editor( $value, 'footer_column_3', $settings = array('textarea_rows'=> '10', 'textarea_name' => 'theme_options[footer_column_3]') );?>
                                </td>
                            </tr>
                            <?php $hidden = ( $footer_column_count < 4 ) ? 'hidden' : '';?>
                            <tr valign="top" id="footer_column_row_4" class="<?=$hidden;?>">
                                <th scope="row"><?php esc_html_e( 'Footer Column 4', 'legendary-toolkit' );?></th>
                                <td>
                                    <?php $value = self::get_theme_option( 'footer_column_4' );?>
                                    <?php echo wp_editor( $value, 'footer_column_4', $settings = array('textarea_rows'=> '10', 'textarea_name' => 'theme_options[footer_column_4]') );?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id="legendary_toolkit_typography" class="tabcontent">
                        <h3>Typography</h3>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'Body', 'legendary-toolkit' );?></th>
                                <td><?php echo self::typography_field('body');?></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'All Headings', 'legendary-toolkit' );?></th>
                                <td><?php echo self::typography_field('all', false);?></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'Heading 1', 'legendary-toolkit' );?></th>
                                <td><?php echo self::typography_field('h1');?></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'Heading 2', 'legendary-toolkit' );?></th>
                                <td><?php echo self::typography_field('h2');?></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'Heading 3', 'legendary-toolkit' );?></th>
                                <td><?php echo self::typography_field('h3');?></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'Heading 4', 'legendary-toolkit' );?></th>
                                <td><?php echo self::typography_field('h4');?></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'Heading 5', 'legendary-toolkit' );?></th>
                                <td><?php echo self::typography_field('h5');?></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'Heading 6', 'legendary-toolkit' );?></th>
                                <td><?php echo self::typography_field('h6');?></td>
                            </tr>
                        </table>
                    </div>
                    <div id="legendary_toolkit_examples" class="tabcontent">
                        <h3>Option Examples</h3>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'Checkbox Example', 'legendary-toolkit' );?></th>
                                <td>
                                    <?php $value = self::get_theme_option( 'checkbox_example' );?>
                                    <input type="checkbox" name="theme_options[checkbox_example]" <?php checked( $value, 'on' );?>> <?php esc_html_e( 'Checkbox example description.', 'legendary-toolkit' );?>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'Input Example', 'legendary-toolkit' );?></th>
                                <td>
                                    <?php $value = self::get_theme_option( 'input_example' );?>
                                    <input type="text" name="theme_options[input_example]" value="<?=esc_attr( $value );?>">
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'Select Example', 'legendary-toolkit' );?></th>
                                <td>
                                    <?php $value = self::get_theme_option( 'select_example' );?>
                                    <select name="theme_options[select_example]">
                                        <?php
                                        $options = array(
                                            '1' => esc_html__( 'Option 1', 'legendary-toolkit' ),
                                            '2' => esc_html__( 'Option 2', 'legendary-toolkit' ),
                                            '3' => esc_html__( 'Option 3', 'legendary-toolkit' ),
                                        );
                                        foreach ( $options as $id => $label ) { ?>
                                            <option value="<?=esc_attr( $id );?>" <?php selected( $value, $id, true );?>>
                                                <?=strip_tags( $label );?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'Range Example', 'legendary-toolkit' );?></th>
                                <td style="display:flex; align-items: center; ">
                                    <?php $value = self::get_theme_option( 'range_example' );?>
                                    <input type="range" min="0" max="4" step="1" name="theme_options[range_example]" oninput="this.nextElementSibling.value = this.value" value="<?=(esc_attr( $value )) ? esc_attr($value) : 4;?>">
                                    <output style="margin-left:10px;"><?=(esc_attr( $value )) ? esc_attr( $value ) : 4;?></output>
                                </td>
                            </tr>
                        </table>
                    </div>
				</form>

			</div><!-- .wrap -->
            <?php 
            // =================
            // Debug Console
            // =================
                echo '<h3>Debug Console</h3>';
                echo '<pre style="height:200px; width: 100%; overflow:scroll; white-space: pre-wrap; resize:vertical">';

                    echo '<hr><strong>get_theme_options()</strong><hr>';
                    print_r(self::get_theme_options());

                    // echo '<hr><strong>get_google_fonts()</strong><hr>';
                    // print_r(self::get_google_fonts());

                echo '</pre>';
            ?>
		<?php 
        // TODO: ENQUEUE ALL SCRIPTS
        }

	}
}
new Legendary_Toolkit_Theme_Options();

// Helper function to use in your theme to return a theme option value
function legendary_toolkit_get_theme_option( $id = '' ) {
	return Legendary_Toolkit_Theme_Options::get_theme_option( $id );
}
function legendary_toolkit_get_theme_options() {
	return Legendary_Toolkit_Theme_Options::get_theme_options();
}


global $enqueued_scripts;
global $enqueued_styles;

add_action( 'wp_print_scripts', 'legendary_toolkit_list_scripts' );
function legendary_toolkit_list_scripts() {
    global $wp_scripts;
    global $enqueued_scripts;
    $enqueued_scripts = array();
    foreach( $wp_scripts->queue as $handle ) {
        $enqueued_scripts[] = $wp_scripts->registered[$handle]->src;
    }
}

add_action( 'wp_print_styles', 'legendary_toolkit_list_styles' );
function legendary_toolkit_list_styles() {
    global $wp_styles;
    global $enqueued_styles;
    $enqueued_styles = array();
    foreach( $wp_styles->queue as $handle ) {
        $enqueued_styles[] = $wp_styles->registered[$handle]->src;
    }
}

