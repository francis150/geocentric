<?php
/* Plugin Core Class */
if (!class_exists('_geocentric_core')) {

    require_once plugin_dir_path( __FILE__ ) . 'geocentric_plugin_config_class.php';

    class _geocentric_core {
        
        private $plugin_config_controller;
        
        function __construct() {
            $this->plugin_config_controller = new _geocentric_plugin_config();
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

    }
}