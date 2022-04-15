<?php

require_once plugin_dir_path(__FILE__) . '../../includes/geocentric_settings_class.php';
$settingsController = new _geocentric_settings();

require_once plugin_dir_path(__FILE__) . '../../includes/geocentric_plugin_config_class.php';
$pluginConfigController = new _geocentric_plugin_config();

require_once plugin_dir_path(__FILE__) . '../../includes/geocentric_component_styles_class.php';
$componentStylesController = new _geocentric_component_styles();

require_once plugin_dir_path(__FILE__) . '../../includes/geocentric_userinput_data_class.php';
$userInputDataController = new _geocentric_userinput_data();

require_once plugin_dir_path(__FILE__) . '../../includes/geocentric_api_data_class.php';
$apiDataController = new _geocentric_api_data();

$config_data = $pluginConfigController->get_plugin_config_data();

require_once plugin_dir_path(__FILE__) . 'main_page_functions.php';

$component_styles = $componentStylesController->get_component_styles();
$settings = $settingsController->get_settings_data();


?><div class="_geocentric-wrapper">
    <div class="header"><h1>Geocentric Plugin</h1> <a href="http://seorockettools.com/"><img src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/seorocket-text-logo.svg'; ?>" alt="SEO Rocket Tools"></a></div><div class="_inner-wrapper">
    <?php

if (!$componentStylesController->styles_isset()) {
    ?>
    <div class="_welcome-page">
        <input type="text" placeholder="This is a test...">
    </div>
    <?php
} else {

}

?></div><div class="footer">
    <p>Powered by © <a href="http://seorockettools.com/" target="_blank">SEO Rocket Tools</a>, 2022 🤘.</p>
    <p><a href="https://github.com/francis150/geocentric#readme">Documentation</a> | <a href="http://support.seorockettools.com/">Support</a></p>
</div></div>