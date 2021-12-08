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

if (isset($_POST['_location-form-submit'])) {
    $formdata = $_POST;

    if (!empty($formdata['new_key'])) {
        $existing_userinput_data = $userInputDataController->get_userinput_data();

        $new_location = array(
            "id" => $formdata['new_key'],
            "city" => array(
                "id" => $formdata['city_id'],
                "name" => $formdata['city_name']
            ),
            "state" => array(
                "code" => $formdata['state_code'],
                "name" => $formdata['state_name']
            ),
            "country" => array(
                "iso2" => $formdata['country_code'],
                "name" => $formdata['country_name']
            )
        );

        if (!empty($formdata['neighborhood'])) $new_location['neighbourhoods'] = array_map( function ($data) {
            return trim($data);
        }, explode(",", $formdata['neighborhood']));

        if (!empty($formdata['google_maps_place_id'])) $new_location['google_place_id'] = $formdata['google_maps_place_id'];
        if (!empty($formdata['driving_directions_limit'])) $new_location['drivingDirectionsLimit'] = $formdata['driving_directions_limit'];

        array_push($existing_userinput_data, $new_location);

        if ($userInputDataController->set_userinput_data($existing_userinput_data)) {
            ?>
            <div class="notice notice-success is-dismissible">
                <p><b><?php echo $config_data['plugin_name']; ?></b> - New location added successfully!</p>
            </div>
            <?php
        } else {
            ?>
            <div class="notice notice-error is-dismissible">
                <p><b><?php echo $config_data['plugin_name']; ?></b> - Failed to add new location.</p>
            </div>
            <?php
        }

    } else if (!empty($formdata['edit_key'])) {
        $editedLocation = array(
            "id" => $formdata['edit_key'],
            "city" => array(
                "id" => $formdata['city_id'],
                "name" => $formdata['city_name']
            ),
            "state" => array(
                "code" => $formdata['state_code'],
                "name" => $formdata['state_name']
            ),
            "country" => array(
                "iso2" => $formdata['country_code'],
                "name" => $formdata['country_name']
            )
        );

        if (!empty($formdata['neighborhood'])) $editedLocation['neighbourhoods'] = array_map( function ($data) {
            return trim($data);
        }, explode(",", $formdata['neighborhood']));

        if (!empty($formdata['google_maps_place_id'])) $editedLocation['google_place_id'] = $formdata['google_maps_place_id'];
        if (!empty($formdata['driving_directions_limit'])) $editedLocation['drivingDirectionsLimit'] = $formdata['driving_directions_limit'];

        $newSet = array_map(function($data) use ($editedLocation) {
            unset($data['dataIsAvailable']);
            if($data['id'] == $editedLocation['id']) { return $editedLocation; }
            else { return $data; }
        }, $userInputDataController->get_userinput_data());

        if ($userInputDataController->set_userinput_data($newSet)) {
            ?>
            <div class="notice notice-success is-dismissible">
                <p><b><?php echo $config_data['plugin_name']; ?></b> - Location updated successfully!</p>
            </div>
            <?php
        } else {
            ?>
            <div class="notice notice-error is-dismissible">
                <p><b><?php echo $config_data['plugin_name']; ?></b> - Failed to update locations.</p>
            </div>
            <?php
        }
    }
}