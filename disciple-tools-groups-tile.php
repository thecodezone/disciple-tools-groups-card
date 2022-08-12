<?php
/**
 * Plugin Name: Disciple.Tools - Groups Tile
 * Plugin URI: https://github.com/thecodezone/disciple-tools-groups-tile
 * Description: This is a simple plugin that adds a group tile to the Disciple.Tools dashboard. It provides a simple way to search groups, filter groups by user, and view a group’s info and health.
 * Text Domain: disciple-tools-groups-tile
 * Domain Path: /languages
 * Version:  0.1
 * Author URI: https://github.com/DiscipleTools
 * GitHub Plugin URI: https://github.com/DiscipleTools/disciple-tools-groups-tile
 * Requires at least: 4.7.0
 * (Requires 4.7+ because of the integration of the REST API at 4.7 and the security requirements of this milestone version.)
 * Tested up to: 5.6
 *
 * @package Disciple_Tools
 * @link    https://github.com/DiscipleTools
 * @license GPL-2.0 or later
 *          https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Refactoring (renaming) this plugin as your own:
 */

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Gets the instance of the `Disciple_Tools_Groups_Tile` class.
 *
 * @return object|bool
 * @since  0.1
 * @access public
 */
function disciple_tools_groups_tile() {
    $disciple_tools_groups_tile_required_dt_theme_version = '1.19';
    $wp_theme = wp_get_theme();
    $version = $wp_theme->version;

    /*
     * Check if the Disciple.Tools theme is loaded and is the latest required version
     */
    $is_theme_dt = class_exists( "Disciple_Tools" );
    if ( $is_theme_dt && version_compare( $version, $disciple_tools_groups_tile_required_dt_theme_version, "<" ) ) {
        add_action( 'admin_notices', 'disciple_tools_groups_tile_hook_admin_notice' );
        add_action( 'wp_ajax_dismissed_notice_handler', 'dt_hook_ajax_notice_handler' );
        return false;
    }
    if ( !$is_theme_dt ) {
        return false;
    }
    /**
     * Load useful function from the theme
     */
    if ( !defined( 'DT_FUNCTIONS_READY' ) ) {
        require_once get_template_directory() . '/dt-core/global-functions.php';
    }

    return Disciple_Tools_Groups_Tile::instance();

}

add_action( 'after_setup_theme', 'disciple_tools_groups_tile', 20 );

/**
 * Singleton class for setting up the plugin.
 *
 * @since  0.1
 * @access public
 */
class Disciple_Tools_Groups_Tile {

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {
        $is_rest = dt_is_rest();

        //Load dashboard tile class
        require_once plugin_dir_path( __FILE__ ) . 'dashboard/groups-tile.php';

        $this->i18n();
    }

    /**
     * Method that runs only when the plugin is activated.
     *
     * @return void
     * @since  0.1
     * @access public
     */
    public static function activation() {
        // add elements here that need to fire on activation
    }

    /**
     * Method that runs only when the plugin is deactivated.
     *
     * @return void
     * @since  0.1
     * @access public
     */
    public static function deactivation() {
        // add functions here that need to happen on deactivation
        delete_option( 'dismissed-disciple-tools-groups-tile' );
    }

    /**
     * Loads the translation files.
     *
     * @return void
     * @since  0.1
     * @access public
     */
    public function i18n() {
        $domain = 'disciple-tools-groups-tile';
        load_plugin_textdomain( $domain, false, trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) . 'languages' );
    }

    /**
     * Magic method to output a string if trying to use the object as a string.
     *
     * @return string
     * @since  0.1
     * @access public
     */
    public function __toString() {
        return 'disciple-tools-groups-tile';
    }

    /**
     * Magic method to keep the object from being cloned.
     *
     * @return void
     * @since  0.1
     * @access public
     */
    public function __clone() {
        _doing_it_wrong( __FUNCTION__, 'Whoah, partner!', '0.1' );
    }

    /**
     * Magic method to keep the object from being unserialized.
     *
     * @return void
     * @since  0.1
     * @access public
     */
    public function __wakeup() {
        _doing_it_wrong( __FUNCTION__, 'Whoah, partner!', '0.1' );
    }

    /**
     * Magic method to prevent a fatal error when calling a method that doesn't exist.
     *
     * @param string $method
     * @param array $args
     * @return null
     * @since  0.1
     * @access public
     */
    public function __call( $method = '', $args = [] ) {
        _doing_it_wrong( "disciple_tools_groups_tile::" . esc_html( $method ), 'Method does not exist.', '0.1' );
        unset( $method, $args );
        return null;
    }
}


// Register activation hook.
register_activation_hook( __FILE__, [ 'Disciple_Tools_Groups_Tile', 'activation' ] );
register_deactivation_hook( __FILE__, [ 'Disciple_Tools_Groups_Tile', 'deactivation' ] );


if ( !function_exists( 'disciple_tools_groups_tile_hook_admin_notice' ) ) {
    function disciple_tools_groups_tile_hook_admin_notice() {
        global $disciple_tools_groups_tile_required_dt_theme_version;
        $wp_theme = wp_get_theme();
        $current_version = $wp_theme->version;
        $message = "'Disciple.Tools - Groups Tile' plugin requires 'Disciple.Tools' theme to work. Please activate 'Disciple.Tools' theme or make sure it is latest version.";
        if ( $wp_theme->get_template() === "disciple-tools-theme" ) {
            $message .= ' ' . sprintf( esc_html( 'Current Disciple.Tools version: %1$s, required version: %2$s' ), esc_html( $current_version ), esc_html( $disciple_tools_groups_tile_required_dt_theme_version ) );
        }
        // Check if it's been dismissed...
        if ( !get_option( 'dismissed-disciple-tools-groups-tile', false ) ) { ?>
            <div class="notice notice-error notice-disciple-tools-groups-tile is-dismissible"
                 data-notice="disciple-tools-groups-tile">
                <p><?php echo esc_html( $message ); ?></p>
            </div>
            <script>
                jQuery(function ($) {
                    $(document).on('click', '.notice-disciple-tools-groups-tile .notice-dismiss', function () {
                        $.ajax(ajaxurl, {
                            type: 'POST',
                            data: {
                                action: 'dismissed_notice_handler',
                                type: 'disciple-tools-groups-tile',
                                security: '<?php echo esc_html( wp_create_nonce( 'wp_rest_dismiss' ) ) ?>'
                            }
                        })
                    });
                });
            </script>
        <?php }
    }
}

/**
 * AJAX handler to store the state of dismissible notices.
 */
if ( !function_exists( "dt_hook_ajax_notice_handler" ) ) {
    function dt_hook_ajax_notice_handler() {
        check_ajax_referer( 'wp_rest_dismiss', 'security' );
        if ( isset( $_POST["type"] ) ) {
            $type = sanitize_text_field( wp_unslash( $_POST["type"] ) );
            update_option( 'dismissed-' . $type, true );
        }
    }
}

/**
 * Check for plugin updates even when the active theme is not Disciple.Tools
 *
 * Below is the publicly hosted .json file that carries the version information. This file can be hosted
 * anywhere as long as it is publicly accessible. You can download the version file listed below and use it as
 * a template.
 * Also, see the instructions for version updating to understand the steps involved.
 * @see https://github.com/DiscipleTools/disciple-tools-version-control/wiki/How-to-Update-the-Starter-Plugin
 */
add_action( 'plugins_loaded', function () {
    if ( is_admin() && !( is_multisite() && class_exists( "DT_Multisite" ) ) || wp_doing_cron() ) {
        // Check for plugin updates
        if ( !class_exists( 'Puc_v4_Factory' ) ) {
            if ( file_exists( get_template_directory() . '/dt-core/libraries/plugin-update-checker/plugin-update-checker.php' ) ) {
                require( get_template_directory() . '/dt-core/libraries/plugin-update-checker/plugin-update-checker.php' );
            }
        }
        if ( class_exists( 'Puc_v4_Factory' ) ) {
            Puc_v4_Factory::buildUpdateChecker(
                'https://raw.githubusercontent.com/thecodezone/disciple-tools-groups-tile/master/version-control.json',
                __FILE__,
                'disciple-tools-groups-tile'
            );

        }
    }
} );
