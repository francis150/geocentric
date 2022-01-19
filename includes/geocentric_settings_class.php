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

        /* 
        @Description: Gets the settings data
        @Returns: ArrayObject
        */
        public function get_settings_data() {
            return $this->settings;
        }

        /* 
        @Description: Updates the settings.json and settings_data
        @Returns: bool
        @Params: $data
        */
        public function set_settings_data($data) {
            if (file_put_contents($this->config_dir . 'settings.json', json_encode($data, JSON_PRETTY_PRINT))) {
                $this->load_settings();
                return true;
            } else {
                return false;
            }
        }
    }
}