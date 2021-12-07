<?php

require_once plugin_dir_path(__FILE__) . '../../includes/geocentric_settings_class.php';
$settingsController = new _geocentric_settings();

require_once plugin_dir_path(__FILE__) . '../../includes/geocentric_plugin_config_class.php';
$pluginConfigController = new _geocentric_plugin_config();

require_once plugin_dir_path(__FILE__) . '../../includes/geocentric_component_styles_class.php';
$componentStylesController = new _geocentric_component_styles();

require_once plugin_dir_path(__FILE__) . 'main_page_functions.php';

if (!$settingsController->settings_isset()) {
    $config_data = $pluginConfigController->get_plugin_config_data();

    ?>
    <div class="_geocentric-main"><section class="get-started-wrapper">
        <div class="content-wrapper">
            <img src="<?php echo $pluginConfigController->get_plugin_logo(); ?>">
            <p><?php echo $config_data['plugin_desc']; ?></p>
            <form action="#" method="POST">
                <div class="input-wrapper">
                    <input required name="_google-api-key" type="text">
                    <small>Enter your Google API Key to get started!</small>
                </div>
                <input type="submit" value="Get Started!" name="_get-started" class="get-started-btn">
            </form>
        </div>

        <img src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/homepage-illustration.svg'; ?>" class="illustration">
    </section></div>
    <?php
} else {
    ?>
    <h1>Main Page</h1>
    <?php
}