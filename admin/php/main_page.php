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

// Is the plugin configured?
$pluginConfigured = $componentStylesController->styles_isset();

//Get the active tab from the $_GET param
$default_tab = null;
$tab = !$pluginConfigured ? 'settings' : (isset($_GET['tab']) ? $_GET['tab'] : $default_tab);

?><div class="_geocentric-wrapper">
    <div class="header"><h1>Geocentric Plugin</h1> <a href="http://seorockettools.com/"><img src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/seorocket-text-logo.svg'; ?>" alt="SEO Rocket Tools"></a></div>
    
    <div class="nav">
        <nav class="nav-tab-wrapper">
            <a href="?page=_geocentric" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">Locations</a>
            <a href="?page=_geocentric&tab=styling" class="nav-tab <?php if($tab==="styling"):?>nav-tab-active<?php endif; ?>">Styling</a>
            <a href="?page=_geocentric&tab=settings" class="nav-tab <?php if($tab==="settings"):?>nav-tab-active<?php endif; ?>">Settings</a>
        </nav>
    </div>
    
    <div class="_inner-wrapper">
    <?php

switch ($tab) {
    default:
        ?>
        <h2>Locations Tab</h2>
        <?php
        break;
    case 'settings':
        ?>
        <div class="settings-tab">
            <h2>Plugin Settings ⚙</h2>
            <p>⛔ You can't proceed with the plugin unless this form is set.</p>
            <hr>
            <form action="#" method="POST">
                <div class="input-group">
                    <label>Google API Key (Unrestricted) <span>*</span></label>
                    <input type="text" required name="unrestricted_google_api_key">
                    <small>This API Key will be used on our backend server and will not be visible in th front-end. <b>This must be unrestricted</b> for our servers to run. <b>API's Required:</b> Places API, Geo Coding API, Knowledge Graph Search API</small>
                </div>

                <div class="input-group">
                    <label>Google API Key (Restricted) <span>*</span></label>
                    <input type="text" name="restricted_google_api_key" required>
                    <small>This API key will be used by the Driving Directions Component and is visible to the front-end. <b>This must be restricted</b> for it to be used only by your domain. Read <a href="https://github.com/francis150/geocentric#-google-api-key-setup" target="_blank">the docs</a> here to know how to restrict your API Key. <b>API's Required:</b> Maps JavaScript API, Directions API</small>
                </div>

                <div class="form-footer">
                    <input name="_settings-form-update" type="submit" class="button-primary" value="Save"/>
                </div>
            </form>
        </div>
        <?php
        break;
    case 'styling':
        ?>
        <div class="styling-tab">
            <h2>Component Styling 🎨</h2>
            <p>Style how your geocentric data gets displayed on your page.</p>
            <hr>
            <form action="?page=_geocentric&tab=styling" method="POST">
                

                <div class="form-footer">
                    <input name="___" type="submit" class="button-primary" value="Save"/>
                    <input name="___" type="button" class="button-secondary" value="Reset Default Styles" style="margin-left: auto;">
                </div>
            </form>
        </div>
        <?php
        break;
}

?></div><div class="footer">
    <p>Powered by © <a href="http://seorockettools.com/" target="_blank">SEO Rocket Tools</a>, 2022 🚀.</p>
    <p><a href="https://github.com/francis150/geocentric#readme">Documentation</a> | <a href="http://support.seorockettools.com/">Support</a></p>
</div></div>