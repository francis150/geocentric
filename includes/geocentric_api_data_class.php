<?php

if (!class_exists('_geocentric_api_data')) {
    class _geocentric_api_data {

        private $api_data;
        private $config_dir;
        
        function __construct() {
            $this->config_dir = WP_CONTENT_DIR . '/uploads/_geocentric/v2.0.0/';
            $this->clear_junk();
            $this->load_api_data();
        }

        /* 
        @Description: Loads data from api_data.json to $this->api_data
        */
        private function load_api_data() {
            if (file_exists( $this->config_dir . 'api_data.json' )) {
                $this->api_data = json_decode(file_get_contents( $this->config_dir . 'api_data.json' ), true);
            }
        }

        /* 
        @Description: Gets all the available api data stored in api_data.json
        @Return: ArrayObject
        */
        public function get_all_api_data() {
            if (!isset($this->api_data)) return array();
            return $this->api_data;
        }

        /* 
        @Description: Gets a specific api dataset from the $id
        @Return: ArrayObject
        @Params: string $id
        */
        public function get_api_data($id) {
            if (!isset($this->api_data)) return;

            foreach ($this->get_all_api_data() as $data) {
                if (isset($data['id']) && $data['id'] == $id) return $data;
            }
        }

        /* 
        @Description: Checks wether or not specific api data Object is available according to the ID
        @Return: boolean
        @Params: string $id
        */
        public function api_data_is_available($id) {
            if (!isset($this->api_data)) return false;

            $res = false;

            foreach ($this->api_data as $data) {
                if (isset($data['id']) && $data['id'] == $id) {
                    $res = true;
                    break;
                }
            }

            return $res;
        }

        /* 
        @Description: Add or Update an api_data object
        @Returns: boolean
        @Params: string $single_api_data
        */
        public function set_single_api_data($single_api_data) {
            $modified = [];
            $recvd = json_decode(stripslashes($single_api_data), true);

            if (empty($recvd['id'])) return false;

            if ($this->api_data_is_available($recvd['id'])) {
                $modified = array_map(function($data) use ($recvd) {

                    if ($data['id'] == $recvd['id']) {
                        return $recvd;
                    } else {
                        return $data;
                    }

                }, $this->get_all_api_data());
            } else {
                $modified = $this->get_all_api_data();
                array_push($modified, $recvd);
            }

            if (file_put_contents($this->config_dir . 'api_data.json', json_encode($modified, JSON_PRETTY_PRINT))) {
                $this->load_api_data();
                return true;
            } else {
                return false;
            }
        }

        /* 
        @Description: Replace all data in api_data.json
        @Return: boolean
        @Params: string $bulk_data
        */
        public function set_all_api_data($bulk_data) {
            $new_api_data = json_decode(stripslashes($bulk_data), true);

            if (file_put_contents($this->config_dir . 'api_data.json', json_encode($new_api_data))) {
                $this->load_api_data();
                return true;
            } else {
                return false;
            }
        }

        /* 
        @Description: Remove all api_data
        @Returns: boolean
        */
        public function remove_all_data() {
            if (!isset($this->api_data)) return true;

            if (unlink($this->config_dir . 'api_data.json')) {
                unset($this->api_data);
                return true;
            } else {
                return false;
            }
        }

        /** 
         * @Description: Remove an array object from datafile by ID
         * @Returns: boolean
         * @Params: string $id
        */
        public function remove_data_by_id($id) {
            $modified = array();

            foreach ($this->api_data as $data) {
                if ($data['id'] !== $id) {
                    array_push($modified, $data);
                }
            }

            if (file_put_contents($this->config_dir . 'api_data.json', json_encode($modified, JSON_PRETTY_PRINT))) {
                $this->load_api_data();
                return true;
            } else {
                return false;
            }
        }
        
        /**
         * @Description: Returns the primary location if is set
         * @Returns: ArrayObject
         */
        public function primary_location() {
            if (!isset($this->api_data)) return;

            $primaryLocations = array_filter($this->api_data, function($val, $key) {
                return $val['meta']['is_primary'];
            }, ARRAY_FILTER_USE_BOTH);

            return $primaryLocations[0]['meta'] ?? NULL;
        }

        /**
         * @Description: Check if the location is primary by ID
         * @Returns: boolean
         * @params: string $id
         */
        public function is_primary($id) {
            if (!isset($this->api_data)) return;

            $location = $this->get_api_data($id);
            return (isset($location['meta']['is_primary']) && $location['meta']['is_primary']) ? true : false;
        }

        /**
         * @description: Clean for junks (null) in the api_data.json file
         */
        private function clear_junk() {
            if (file_exists( $this->config_dir . 'api_data.json' )) {
                $api_data = json_decode(file_get_contents( $this->config_dir . 'api_data.json' ), true);

                $clean_api_data = array_filter($api_data, function ($v, $k) {
                    return isset($v['id']);
                }, ARRAY_FILTER_USE_BOTH);

                file_put_contents($this->config_dir . 'api_data.json', json_encode($clean_api_data, JSON_PRETTY_PRINT));
            }
        }
    }
}