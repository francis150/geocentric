<?php
/* Plugin Core Class */
if (!class_exists('_geocentric_core')) {

    require_once plugin_dir_path( __FILE__ ) . 'geocentric_plugin_config_class.php';

    class _geocentric_core {
        
        private $plugin_config_controller;
        
        function __construct() {
            $this->plugin_config_controller = new _geocentric_plugin_config();

            add_action( 'admin_menu', array($this, 'add_admin_menu_items'));

            add_action('admin_head', array($this, 'addto_admin_head'));
            add_action('admin_footer', array($this, 'addto_admin_footer'));
            add_action('wp_head', array($this, 'add_to_wp_head'));
        }

        public function add_admin_menu_items() {
            $conig_data = $this->plugin_config_controller->get_plugin_config_data();

            add_menu_page(
                $conig_data['plugin_name'],
                $conig_data['plugin_name'],
                'manage_options',
                $conig_data['plugin_slug'],
                array($this, 'navto_main_admin_page'),
                $this->plugin_config_controller->get_admin_menu_icon(),
                120
            );
        }

        public function navto_main_admin_page() {
            require_once plugin_dir_path(__FILE__) . '../admin/php/main_page.php';
        }



        public function add_to_wp_head() {
            // Shoelace
            wp_enqueue_style('_geocentric_wp_shoelace_styles', 'https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.60/dist/themes/light.css');
        }

        public function addto_admin_footer() {
            // Admin page script file
            wp_enqueue_script('_geocentric_adminpage_scripts', plugins_url( '../admin/js/main_page.js', __FILE__ ));
            
            // npm-uuid cdn import
            wp_enqueue_script('_geocentric_uuid_cdn_script', 'https://cdn.jsdelivr.net/npm/uuid@latest/dist/umd/uuidv4.min.js');
        }

        public function addto_admin_head() {
            // Admin page style file
            wp_enqueue_style('_geocentric_adminpage_styles', plugins_url( '../admin/styles/main_page.css', __FILE__ ));

            // Shoelace styles
            wp_enqueue_style('_geocentric_adminpage_shoelace_styles', 'https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.60/dist/themes/light.css');
        }

    }
}