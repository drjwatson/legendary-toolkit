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

		/**
		 * Settings page output
		 *
		 * @since 1.0.0
		 */
		public static function create_admin_page() { 
            // TODO: ENQUEUE ALL STYLES
            ?>

            <style>
                @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap');

                #options_header {
                    position:sticky;
                    top:32px;
                }
                #options_banner {
                    padding: 15px 30px;
                    background-color:#151515;
                    display:flex;
                    align-items: center;
                    justify-content: space-between;
                    font-family: 'Poppins', sans-serif;
                }
                #options_banner h1 {
                    color: white;
                    font-family: 'Poppins', sans-serif;
                    font-weight: 800;
                    text-transform: uppercase;
                }
                #options_banner input#submit {
                    background-color: white;
                    color: #151515;
                    border-radius: 0px;
                    border: 0px;
                }
                #logo_preview {
                    background-color: #fafafa;
                    background-repeat: no-repeat;
                    background-size: contain;
                    background-position: center center;
                    height: 300px;
                    width: 300px;
                    border-radius: 0px;
                    border: dashed 1px #151515;
                    display:block;
                    margin-bottom: 15px;
                }
                /* Style the tab */
                .tab {
                    overflow: hidden;
                    border: 1px solid #151515;
                    background-color: white;
                }

                /* Style the buttons that are used to open the tab content */
                .tab button {
                    background-color: inherit;
                    float: left;
                    border: none;
                    outline: none;
                    cursor: pointer;
                    padding: 14px 16px;
                    transition: 0.3s;
                    font-size: 1.1em;
                    font-weight: 600;
                    border-right: 1px solid #151515;
                    color: #151515;
                    /* text-transform: uppercase; */
                    font-family: 'Poppins', sans-serif;
                }

                /* Change background color of buttons on hover */
                .tab button:hover {
                    background-color: #151515;
                    color:white;
                }

                /* Create an active/current tablink class */
                .tab button.active {
                    background-color: #151515;
                    color: white;
                }

                /* Style the tab content */
                .tabcontent {
                    display: none;
                    background-color: white;
                    padding: 30px;
                    border: 1px solid #151515;
                    border-top: none;
                    font-family: 'Poppins', sans-serif;
                }
                .tabcontent {
                    animation: fadeEffect .6s; /* Fading effect takes 1 second */
                }
                .tabcontent h3 {
                    font-weight: 600;
                    font-size: 2em;
                    /* text-transform:uppercase; */
                }
                .tabcontent .button {
                    border-radius: 0px;
                    background-color: #151515;
                    color: white;
                    border: 1px solid #151515;
                }
                .tabcontent .button:hover {
                    color: #151515;
                    background-color:white;
                }

                /* Go from zero to full opacity */
                @keyframes fadeEffect {
                    from {opacity: 0;}
                    to {opacity: 1;}
                }
            </style>
			<div class="wrap">
                <div id="options_header">
                    <div id="options_banner">
                        <h1><?php esc_html_e( 'Legendary Toolkit Options', 'legendary-toolkit' ); ?></h1>
                        <?php submit_button( __( 'Save Changes', 'legendary-toolkit' ), 'primary', 'submit', true, array( 'form' => 'legendary_toolkit_form' ) ); ?>
                    </div>
                    <!-- Tab links -->
                    <div class="tab">
                        <button class="tablinks" onclick="open_settings_tab(event, 'legendary_toolkit_general')" id="legendary_toolkit_general_tab">General</button>
                        <button class="tablinks" onclick="open_settings_tab(event, 'legendary_toolkit_header')">Header</button>
                        <button class="tablinks" onclick="open_settings_tab(event, 'legendary_toolkit_typography')">Typography</button>
                        <button class="tablinks" onclick="open_settings_tab(event, 'legendary_toolkit_examples')">Examples</button>
                    </div>
                </div>
				<form method="post" action="options.php" id="legendary_toolkit_form">

					<?php settings_fields( 'theme_options' ); ?>
                    <!-- Tab content -->
                    <div id="legendary_toolkit_general" class="tabcontent">
                        <h3>General</h3>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'Logo', 'legendary-toolkit' ); ?></th>
                                <td>
                                    <?php $value = self::get_theme_option( 'logo' ); ?>
                                    <a class="button" onclick="upload_image('logo');" id="logo_preview" style="background-image: url(<?php echo esc_attr( $value ); ?>);"></a>
                                    <input type="hidden" name="theme_options[logo]" id="logo" value="<?php echo esc_attr( $value ); ?>">
                                    <a class="button" onclick="upload_image('logo');">Change Logo</a> 
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">Fill Space with this</th>
                                <td>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">Fill Space with this</th>
                                <td>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">Fill Space with this</th>
                                <td>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">Fill Space with this</th>
                                <td>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id="legendary_toolkit_header" class="tabcontent">
                        <h3>Header</h3>
                    </div>
                    <div id="legendary_toolkit_typography" class="tabcontent">
                        <h3>Typography</h3>
                    </div>
                    <div id="legendary_toolkit_examples" class="tabcontent">
                        <h3>Option Examples</h3>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'Checkbox Example', 'legendary-toolkit' ); ?></th>
                                <td>
                                    <?php $value = self::get_theme_option( 'checkbox_example' ); ?>
                                    <input type="checkbox" name="theme_options[checkbox_example]" <?php checked( $value, 'on' ); ?>> <?php esc_html_e( 'Checkbox example description.', 'legendary-toolkit' ); ?>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'Input Example', 'legendary-toolkit' ); ?></th>
                                <td>
                                    <?php $value = self::get_theme_option( 'input_example' ); ?>
                                    <input type="text" name="theme_options[input_example]" value="<?php echo esc_attr( $value ); ?>">
                                </td>
                            </tr>
                            <tr valign="top" class="legendary-toolkit-custom-admin-screen-background-section">
                                <th scope="row"><?php esc_html_e( 'Select Example', 'legendary-toolkit' ); ?></th>
                                <td>
                                    <?php $value = self::get_theme_option( 'select_example' ); ?>
                                    <select name="theme_options[select_example]">
                                        <?php
                                        $options = array(
                                            '1' => esc_html__( 'Option 1', 'legendary-toolkit' ),
                                            '2' => esc_html__( 'Option 2', 'legendary-toolkit' ),
                                            '3' => esc_html__( 'Option 3', 'legendary-toolkit' ),
                                        );
                                        foreach ( $options as $id => $label ) { ?>
                                            <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
                                                <?php echo strip_tags( $label ); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
				</form>

			</div><!-- .wrap -->
            <script>
                function open_settings_tab(evt, tabName) {
                    evt.preventDefault();
                    // Declare all variables
                    var i, tabcontent, tablinks;

                    // Get all elements with class="tabcontent" and hide them
                    tabcontent = document.getElementsByClassName("tabcontent");
                    for (i = 0; i < tabcontent.length; i++) {
                        tabcontent[i].style.display = "none";
                    }

                    // Get all elements with class="tablinks" and remove the class "active"
                    tablinks = document.getElementsByClassName("tablinks");
                    for (i = 0; i < tablinks.length; i++) {
                        tablinks[i].className = tablinks[i].className.replace(" active", "");
                    }

                    // Show the current tab, and add an "active" class to the button that opened the tab
                    document.getElementById(tabName).style.display = "block";
                    evt.currentTarget.className += " active";
                }

                (function() {
                    document.getElementById("legendary_toolkit_general_tab").click();
                })();          
            </script>
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

global $enqueued_scripts;
global $enqueued_styles;

add_action( 'wp_print_scripts', 'cyb_list_scripts' );
function cyb_list_scripts() {
    global $wp_scripts;
    global $enqueued_scripts;
    $enqueued_scripts = array();
    foreach( $wp_scripts->queue as $handle ) {
        $enqueued_scripts[] = $wp_scripts->registered[$handle]->src;
    }
}

add_action( 'wp_print_styles', 'cyb_list_styles' );
function cyb_list_styles() {
    global $wp_styles;
    global $enqueued_styles;
    $enqueued_styles = array();
    foreach( $wp_styles->queue as $handle ) {
        $enqueued_styles[] = $wp_styles->registered[$handle]->src;
    }
}

