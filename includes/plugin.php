<?php



namespace ElementorCustomProduct;



use ElementorCustomProduct\PageSettings\Page_Settings;



/**

 * Class Plugin

 *

 * Main Plugin class

 * @since 1.2.0

 */

class Plugin

{



    /**

     * Addon Version

     *

     * @since 1.0.0

     * @var string The addon version.

     */

    const VERSION = '1.0.0';
    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';


    /**

     * Minimum PHP Version

     *

     * @since 1.0.0

     * @var string Minimum PHP version required to run the addon.

     */

    const MINIMUM_PHP_VERSION = '7.3';



    /**

     * Instance

     *

     * @since 1.0.0

     * @access private

     * @static

     * @var \ElementorCustomProduct\Plugin The single instance of the class.

     */

    private static $_instance = null;

    /**

     * Instance

     *

     * Ensures only one instance of the class is loaded or can be loaded.

     *

     * @since 1.0.0

     * @access public

     * @static

     * @return \ElementorCustomProduct\Plugin An instance of the class.

     */

    public static function instance()

    {



        if (is_null(self::$_instance)) {

            self::$_instance = new self();
        }

        return self::$_instance;
    }



    /**

     * Constructor

     *

     * Perform some compatibility checks to make sure basic requirements are meet.

     * If all compatibility checks pass, initialize the functionality.

     *

     * @since 1.0.0

     * @access public

     */

    public function __construct()

    {



        if (

            $this->is_compatible()

        ) {

            add_action('elementor/init', [$this, 'init']);
        }
    }



    /**

     * Compatibility Checks

     *

     * Checks whether the site meets the addon requirement.

     *

     * @since 1.0.0

     * @access public

     */

    public function is_compatible()

    {



        // Check if Elementor installed and activated

        if (

            !did_action('elementor/loaded')

        ) {

            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);

            return false;
        }



        // Check for required Elementor version

        if (

            !version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')

        ) {

            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);

            return false;
        }



        // Check for required PHP version

        if (

            version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')

        ) {

            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);

            return false;
        }



        return true;
    }



    /**

     * Admin notice

     *

     * Warning when the site doesn't have Elementor installed or activated.

     *

     * @since 1.0.0

     * @access public

     */

    public function admin_notice_missing_main_plugin()

    {



        if (

            isset($_GET['activate'])

        ) unset($_GET['activate']);



        $message = sprintf(

            /* translators: 1: Plugin name 2: Elementor */

            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'elementor-custom-product'),

            '<strong>' . esc_html__('ElementorCustomProduct', 'elementor-custom-product') . '</strong>',

            '<strong>' . esc_html__('Elementor', 'elementor-custom-product') . '</strong>'

        );



        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }



    /**

     * Admin notice

     *

     * Warning when the site doesn't have a minimum required Elementor version.

     *

     * @since 1.0.0

     * @access public

     */

    public function admin_notice_minimum_elementor_version()

    {



        if (

            isset($_GET['activate'])

        ) unset($_GET['activate']);



        $message = sprintf(

            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */

            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-custom-product'),

            '<strong>' . esc_html__('ElementorCustomProduct', 'elementor-custom-product') . '</strong>',

            '<strong>' . esc_html__('Elementor', 'elementor-custom-product') . '</strong>',

            self::MINIMUM_ELEMENTOR_VERSION

        );



        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }



    /**

     * Admin notice

     *

     * Warning when the site doesn't have a minimum required PHP version.

     *

     * @since 1.0.0

     * @access public

     */

    public function admin_notice_minimum_php_version()

    {



        if (

            isset($_GET['activate'])

        ) unset($_GET['activate']);



        $message = sprintf(

            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */

            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-custom-product'),

            '<strong>' . esc_html__('ElementorCustomProduct', 'elementor-custom-product') . '</strong>',

            '<strong>' . esc_html__('PHP', 'elementor-custom-product') . '</strong>',

            self::MINIMUM_PHP_VERSION

        );



        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }





    /**

     * widget_scripts

     *

     * Load required plugin core files.

     *

     * @since 1.2.0

     * @access public

     */



    // public function init()

    // {



    // }



    public function frontend_styles()

    {



        wp_register_style('frontend-style-1', plugins_url('assets/css/custom-product.css', __FILE__));



        wp_enqueue_style('frontend-style-1');
    }



    public function frontend_scripts()

    {



        wp_register_script('frontend-script-1', plugins_url('assets/js/custom_product.js', __FILE__));



        wp_enqueue_script('frontend-script-1');
    }



    /**

     * Initialize

     *

     * Load the addons functionality only after Elementor is initialized.

     *

     * Fired by `elementor/init` action hook.

     *

     * @since 1.0.0

     * @access public

     */

    public function init()

    {



        add_action('elementor/widgets/register', [$this, 'register_widgets']);



        add_action('elementor/frontend/after_enqueue_styles', [$this, 'frontend_styles']);



        add_action('elementor/frontend/after_register_scripts', [$this, 'frontend_scripts']);



        // add_action('elementor/controls/register', [$this, 'register_controls']);

    }





    /**

     * Register Widgets

     *

     * Register new Elementor widgets.

     *

     * @since 1.2.0

     * @access public

     *

     * @param Widgets_Manager $widgets_manager Elementor widgets manager.

     */

    public function register_widgets($widgets_manager)
    {
        // It's now safe to include the widget file
        require_once(plugin_dir_path(__FILE__) . '/widgets/custom_products_grid.php');

        // Register the Custom_Products widget
        $widgets_manager->register(new \ElementorCustomProduct\Widgets\Custom_Products());
    }
}
