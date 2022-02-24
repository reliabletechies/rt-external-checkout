<?php
/**
 * Plugin Name: RT External Checkout
 * Description: Allow your customers to checkout from external website 
 * Plugin URI: https://reliabletechies.com/products/plugins
 * Author: Md Shamir
 * Author URI: https://shamir.tech
 * Version: 1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class RTE_Checkout {

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0.0';

    /**
     * Class construcotr
     */
    private function __construct() {
        $this->define_constants();

        // register_activation_hook( __FILE__, [ $this, 'activate' ] );

        // add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initializes a singleton instance
     *
     * @return \RTE_Checkout
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'RTE_CHECKOUT_VERSION', self::version );
        define( 'RTE_CHECKOUT_FILE', __FILE__ );
        define( 'RTE_CHECKOUT_PATH', __DIR__ );
        define( 'RTE_CHECKOUT_URL', plugins_url( '', RTE_CHECKOUT_FILE ) );
        define( 'RTE_CHECKOUT_ASSETS', RTE_CHECKOUT_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {

        if ( is_admin() ) {
            new RTE\Checkout\Admin();
        } else {
            new RTE\Checkout\Frontend();
        }

    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installed = get_option( 'rte_checkout_installed' );

        if ( ! $installed ) {
            update_option( 'rte_checkout_installed', time() );
        }

        update_option( 'rte_checkout_version', RTE_CHECKOUT_VERSION );
    }
}

/**
 * Initializes the main plugin
 *
 * @return \RTE_Checkout
 */
function rte_checkout() {
    return RTE_Checkout::init();
}

// kick-off the plugin
rte_checkout();