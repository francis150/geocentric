<?php
/* Plugin Core Class */
if (!class_exists('_geocentric_core')) {

    require_once plugin_dir_path( __FILE__ ) . 'geocentric_plugin_config_class.php';
    require_once plugin_dir_path( __FILE__ ) . 'geocentric_components_class.php';
    require_once plugin_dir_path( __FILE__ ) . 'geocentric_components_class.php';
    require_once plugin_dir_path( __FILE__ ) . 'geocentric_appsero_class.php';

    class _geocentric_core {
        
        private $plugin_config_controller;
        private $component_controller;
        private $appsero_controller;
        private $config_data;
        
        function __construct() {
            $this->plugin_config_controller = new _geocentric_plugin_config();
            $this->component_controller = new _geocentric_components();
            $this->appsero_controller = new _geocentric_appsero();

            add_action( 'admin_menu', array($this, 'add_admin_menu_items'));
            add_action('admin_head', array($this, 'addto_admin_head'));
            add_action('admin_footer', array($this, 'addto_admin_footer'));
            add_action('init', array($this, 'init_component_shortcodes'));

            $this->config_data =  $this->plugin_config_controller->get_plugin_config_data();
        }

        public function add_admin_menu_items() {
            add_menu_page(
                $this->config_data['plugin_name'],
                $this->config_data['plugin_name'],
                'manage_options',
                $this->config_data['plugin_slug'],
                array($this, 'navto_main_admin_page'),
                $this->plugin_config_controller->get_admin_menu_icon(),
                120
            );
        }

        public function init_component_shortcodes() {

            if (!$this->appsero_controller->appsero_check_license()) return;
            
            add_shortcode('geocentric_weather', array($this->component_controller, 'weather_component'));
            add_shortcode('geocentric_about', array($this->component_controller, 'about_component'));
            add_shortcode('geocentric_neighborhoods', array($this->component_controller, 'neighborhoods_component'));
            add_shortcode('geocentric_thingstodo', array($this->component_controller, 'thingstodo_component'));
            add_shortcode('geocentric_busstops', array($this->component_controller, 'busstops_component'));
            add_shortcode('geocentric_mapembed', array($this->component_controller, 'mapembed_component'));
            add_shortcode('geocentric_drivingdirections', array($this->component_controller, 'drivingdirections_component'));
            add_shortcode('geocentric_reviews', array($this->component_controller, 'reviews_component'));
        }

        public function navto_main_admin_page() {
            if ($this->appsero_controller->appsero_check_license()) {
                require_once plugin_dir_path(__FILE__) . '../admin/php/main_page.php';
            } else {
                $this->appsero_controller->appsero_invalid_license_page();
            }
        }

        public function addto_admin_footer() {
            // Admin page script file
            wp_enqueue_script('_geocentric_adminpage_scripts', plugins_url( '../admin/js/main_page.js', __FILE__ ), array(), $this->config_data['plugin_version']);
            
            // npm-uuid cdn import
            wp_enqueue_script('_geocentric_uuid_cdn_script', 'https://cdn.jsdelivr.net/npm/uuid@latest/dist/umd/uuidv4.min.js');
        }

        public function addto_admin_head() {
            // WP Thickbox
            add_thickbox();
            // Admin page style file
            wp_enqueue_style('_geocentric_adminpage_styles', plugins_url( '../admin/styles/main_page.css', __FILE__ ), array(), $this->config_data['plugin_version']);
            // axios
            wp_enqueue_script('_geocentric_axios_cdn_script', 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js');
        }

    }
}