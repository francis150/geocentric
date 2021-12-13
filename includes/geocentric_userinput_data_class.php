<?php

if (!class_exists('_geocentric_userinput_data')) {
    class _geocentric_userinput_data {
        
        private $config_dir;
        private $userinput_data;

        function __construct() {
            $this->config_dir = WP_CONTENT_DIR . '/uploads/_geocentric/';
            $this->load_userinput_data();
        }

        /* 
        @Description: Loads data from userinput_data.json to $this->settings
        */
        private function load_userinput_data() {
            if (file_exists( $this->config_dir . 'userinput_data.json' )) {
                $this->userinput_data = json_decode(file_get_contents( $this->config_dir . 'userinput_data.json' ), true);
            }
        }


        /* 
        @Description: Gets the userinput data
        @Return: ArrayObject
        */
        public function get_userinput_data() {
            if (!isset($this->userinput_data)) return array();
            return $this->userinput_data;
        }

        /* 
        @Description: Gets the userinput data according to $id
        @Return: ArrayObject
        @Params: string $id
        */
        public function get_userinput_by_id($id) {
            if (!isset($this->userinput_data)) return;

            foreach ($this->get_userinput_data() as $data) {
                if ($data['id'] == $id) return $data;
            }
        }

        /* 
        @Description: Set or update userinput_data
        @Returns: boolean
        @Params: ArrayObject $data
        */
        public function set_userinput_data($data) {
            if (file_put_contents($this->config_dir . 'userinput_data.json', json_encode($data, JSON_PRETTY_PRINT))) {
                $this->load_userinput_data();
                return true;
            } else {
                return false;
            }
        }
    }
}