<?php

if (!class_exists('_geocentric_plugin_config')) {
    class _geocentric_plugin_config {
        
        private $plugin_config_dir;
        private $config;
        
        function __construct() {
            $this->plugin_config_dir = WP_CONTENT_DIR . '/plugins/geocentric/config/';;

            $this->load_config_data();
        }

        /* 
        @Description: Loads data from config/config.json file to $this->config
        */
        private function load_config_data() {
            if (file_exists($this->plugin_config_dir . 'config.json')) {
                $this->config = json_decode(file_get_contents( $this->plugin_config_dir . 'config.json' ), true);
            }
        }

        /* 
        @Description: Returns the config array Object
        @Return: ArrayObject = []
        */
        public function get_plugin_config_data() {
            if (!isset($this->config)) return array();
            return $this->config; 
        }

        /* 
        @Description: Return the admin menu icon
        @Return: string
        */
        public function get_admin_menu_icon() {
            return plugin_dir_url(__FILE__) . '../config/admin-menu-icon.svg';
        }

    }
}