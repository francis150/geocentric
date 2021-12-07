<?php

if (isset($_POST['_get-started'])) {
    $config_data = $pluginConfigController->get_plugin_config_data();

    if ($componentStylesController->init_component_styles()) {
        if ($settingsController->init_settings_with_google_api_key($_POST['_google-api-key'])) {
        } else {
            ?>
            <div class="notice notice-error is-dismissible">
                <p><b><?php echo $config_data['plugin_name']; ?></b> - Failed to create <kbd>settings.json</kbd> file.</p>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><b><?php echo $config_data['plugin_name']; ?></b> - Failed to initialize <kbd>component_styles.json</kbd> file.</p>
        </div>
        <?php
    }
}