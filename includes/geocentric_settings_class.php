<?php

if (!class_exists('_geocentric_settings')) {
    class _geocentric_settings {

        private $config_dir;
        private $settings;

        function __construct() {
            $this->config_dir = WP_CONTENT_DIR . '/uploads/_geocentric/';

            $this->load_settings();
        }
        
        /* 
        @Description: Loads data from settings.json to $this->settings
        */
        private function load_settings() {
            if (file_exists( $this->config_dir . 'settings.json' )) {
                $this->settings = json_decode(file_get_contents( $this->config_dir . 'settings.json' ), true);
            }
        }


        /* 
        * @Description: Checks wether or not settings.json exists
        * @Return: boolean
        */
        public function settings_isset() {
            return isset($this->settings);
        }
    }
}