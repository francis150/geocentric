<?php

if (!class_exists('_geocentric_appsero')) {

    require __DIR__ . '/../vendor/autoload.php';
    require_once plugin_dir_path( __FILE__ ) . 'geocentric_plugin_config_class.php';

    class _geocentric_appsero {

        private $license;
        private $geocentricConfigController;
        private $configData;

        function __construct() {
            $this->geocentricConfigController = new _geocentric_plugin_config();
            $this->configData = $this->geocentricConfigController->get_plugin_config_data();
            $this->appsero_init_appsero();
        }

        private function appsero_init_appsero() {
            $client = $this->get_appsero_client();

            // Active insights
            $client->insights()->init();

            // Active automatic updater
            $client->updater();

            $this->appsero_page_checker($client);
        }


        private function get_appsero_client() {
            return new Appsero\Client( $this->configData['appsero_api_key'], $this->configData['appsero_plugin_name'], WP_PLUGIN_DIR . '/geocentric/geocentric.php' );
        }

        private function appsero_page_checker($client){
            // Active license page and checker
            $args = array(
                'type' => 'submenu',
                'parent_slug' => $this->configData['plugin_slug'],
                'menu_title' => 'License Settings',
                'page_title' => 'License Settings',
                'menu_slug'  => $this->configData['plugin_slug'] . '_license',
            );
            $client->license()->add_settings_page( $args );
        }

        public function appsero_check_license() {
            $client = $this->get_appsero_client();

            $this->license = $client->license();
            
            return $this->license->is_valid();
        }

        public function appsero_invalid_license_page() {
            ?>
            <div>
                <h2><?php echo $this->configData['plugin_name']; ?></h2>
                <p>Please activate your license on this <a href="<?php echo menu_page_url($this->configData['plugin_slug'] . '_license', false); ?>">page</a></p>
            </div>
            <?php
        }

    }
}