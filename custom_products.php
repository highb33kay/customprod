<?php



/**

 * Plugin Name: Custom Products

 * Description: Elementor widgets plugin.

 * Plugin URI:  #

 * Version:     1.2.1

 * Author:      Highb33kay

 * Author URI: #

 * Text Domain: elementor-custom-products

 * Elementor tested up to: 3.5.0

 * Elementor Pro tested up to: 3.5.0

 */





if (!defined('ABSPATH')) exit; // Exit if accessed directly



/**

 * Main Elementor Hello World Class

 *

 * The init class that runs the Hello World plugin.

 * Intended To make sure that the plugin's minimum requirements are met.

 *

 * You should only modify the constants to match your plugin's needs.

 *

 * Any custom code should go inside Plugin Class in the plugin.php file.

 * @since 1.2.0

 */



function elementor_custom_pro()

{

    // Load plugin file

    require_once(__DIR__ . '/includes/plugin.php');



    // Run the plugin

    \ElementorCustomProduct\Plugin::instance();
}

add_action('plugins_loaded', 'elementor_custom_pro');
