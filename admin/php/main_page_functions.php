<?php

// Get started button
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

// Location form submit
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

// Remove location
if (!empty($_POST['remove_key'])) {

    $modified = array();

    foreach ($userInputDataController->get_userinput_data() as $data) {
        if ($_POST['remove_key'] !== $data['id']) array_push($modified, $data);
    }

    if ($userInputDataController->set_userinput_data($modified)) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><b><?php echo $config_data['plugin_name']; ?></b> - Location removed successfully!</p>
        </div>
        <?php
    } else {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><b><?php echo $config_data['plugin_name']; ?></b> - Failed to remove location.</p>
        </div>
        <?php
    }
}

// Set as Primary Location
if (!empty($_POST['mainlocation_key'])) {
    
    $modified = array_map(function($data) {

        if ($data['id'] == $_POST['mainlocation_key']) {
            $data['primaryLocation'] = true;
        } else {
            unset($data['primaryLocation']);
        }

        unset($data['dataIsAvailable']);

        return $data;

    }, $userInputDataController->get_userinput_data());

    if ($userInputDataController->set_userinput_data($modified)) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><b><?php echo $config_data['plugin_name']; ?></b> - Primary location updated!</p>
        </div>
        <?php
    } else {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><b><?php echo $config_data['plugin_name']; ?></b> - Failed to set primary location!</p>
        </div>
        <?php
    }

}

// Update component styles
if (isset($_POST['_style-form-update'])) {
    $formdata = $_POST;

    $styledata = array(
        "weatherSection" => array(
            "backgroundColor" => !empty($formdata['wsBackgroundColor']) ? $formdata['wsBackgroundColor'] : "#00000000",
            "accentColor" => !empty($formdata['wsTextColor']) ? $formdata['wsTextColor'] : "#00000000"
        ),
        "aboutSection" => array(
            "title" => array(
                "fontSize" => !empty($formdata['asTitleFontSize']) ? (int)$formdata['asTitleFontSize'] : 36,
                "fontWeight" => !empty($formdata['asTitleFontWeight']) ? (int)$formdata['asTitleFontWeight'] : 500,
                "fontColor" => !empty($formdata['asTitleFontColor']) ? $formdata['asTitleFontColor'] : "#00000000",
                "textAlignment" => !empty($formdata['asTitleTextAligment']) ? $formdata['asTitleTextAligment'] : "center"
            ),
            "content" => array(
                "fontSize" => !empty($formdata['asContentFontSize']) ? (int)$formdata['asContentFontSize'] : 16,
                "fontWeight" => !empty($formdata['asContentFontWeight']) ? (int)$formdata['asContentFontWeight'] : 400,
                "fontColor" => !empty($formdata['asContentFontColor']) ? $formdata['asContentFontColor'] : "#00000000",
                "textAlignment" => !empty($formdata['asContentTextAligment']) ? $formdata['asContentTextAligment'] : "left"
            )
        ),
        "neighborhoods" => array(
            "title" => array(
                "fontSize" => !empty($formdata['nhTitleFontSize']) ? (int)$formdata['nhTitleFontSize'] : 36,
                "fontWeight" => !empty($formdata['nhTitleFontWeight']) ? (int)$formdata['nhTitleFontWeight'] : 500,
                "fontColor" => !empty($formdata['nhTitleFontColor']) ? $formdata['nhTitleFontColor'] : "#00000000",
                "textAlignment" => !empty($formdata['nhTitleTextAligment']) ? $formdata['nhTitleTextAligment'] : "center"
            ),
            "neighborhoods" => array(
                "fontSize" => !empty($formdata['nhLinksFontSize']) ? (int)$formdata['nhLinksFontSize'] : 16,
                "fontWeight" => !empty($formdata['nhLinksFontWeight']) ? (int)$formdata['nhLinksFontWeight'] : 400,
                "fontColor" => !empty($formdata['nhLinksFontColor']) ? $formdata['nhLinksFontColor'] : "#00000000",
                "fontColorHovered" => !empty($formdata['nhLinksHoveredFontColor']) ? $formdata['nhLinksHoveredFontColor'] : "#00000000",
                "textAlignment" => !empty($formdata['nhLinksTextAligment']) ? $formdata['nhLinksTextAligment'] : "center"
            )
        ),
        "thingsToDo" => array(
            "title" => array(
                "fontSize" => !empty($formdata['ttdTitleFontSize']) ? (int)$formdata['ttdTitleFontSize'] : 36,
                "fontWeight" => !empty($formdata['ttdTitleFontWeight']) ? (int)$formdata['ttdTitleFontWeight'] : 500,
                "fontColor" => !empty($formdata['ttdTitleFontColor']) ? $formdata['ttdTitleFontColor'] : "#00000000",
                "textAlignment" => !empty($formdata['ttdTitleTextAligment']) ? $formdata['ttdTitleTextAligment'] : "#00000000"
            ),
            "items" => array(
                "gap" => !empty($formdata['ttdItemsGap']) ? (int)$formdata['ttdItemsGap'] : 20,
                "backgroundColor" => !empty($formdata['ttdItemsBackgroundColor']) ? $formdata['ttdItemsBackgroundColor'] : "#00000000",
                "hoverEffect" => !empty($formdata['ttdItemsHoverEffect']) ? $formdata['ttdItemsHoverEffect'] : "scaleUp",
                "borderRadius" => !empty($formdata['ttdItemsBorderRadius']) ? (int)$formdata['ttdItemsBorderRadius'] : 5,
                "borderWidth" => !empty($formdata['ttdItemsBorderWidth']) ? (int)$formdata['ttdItemsBorderWidth'] : 1,
                "borderColor" => !empty($formdata['ttdItemsBorderColor']) ? $formdata['ttdItemsBorderColor'] : "#00000000",
                "padding" => !empty($formdata['ttdItemsPadding']) ? (int)$formdata['ttdItemsPadding'] : 20
            ),
            "image" => array(
                "borderRadius" => !empty($formdata['ttdImageBorderRadius']) ? (int)$formdata['ttdImageBorderRadius'] : 5,
                "borderWidth" => !empty($formdata['ttdImageBorderWidth']) ? (int)$formdata['ttdImageBorderWidth'] : 0,
                "borderColor" => !empty($formdata['ttdImageBorderColor']) ? $formdata['ttdImageBorderColor'] : "#00000000"
            ),
            "name" => array(
                "fontSize" => !empty($formdata['ttdNameFontSize']) ? (int)$formdata['ttdNameFontSize'] : 16,
                "fontWeight" => !empty($formdata['ttdNameFontWeight']) ? (int)$formdata['ttdNameFontWeight'] : 400,
                "fontColor" => !empty($formdata['ttdNameFontColor']) ? $formdata['ttdNameFontColor'] : "#00000000",
                "textAlignment" => !empty($formdata['ttdNameTextAligment']) ? $formdata['ttdNameTextAligment'] : "left",
            )
        ),
        "mapEmbed" => array(
            "title" => array(
                "fontSize" => !empty($formdata['meTitleFontSize']) ? (int)$formdata['meTitleFontSize'] : 36,
                "fontWeight" => !empty($formdata['meTitleFontWeight']) ? (int)$formdata['meTitleFontWeight'] : 500,
                "fontColor" => !empty($formdata['meTitleFontColor']) ? $formdata['meTitleFontColor'] : "#00000000",
                "textAlignment" => !empty($formdata['meTitleTextAligment']) ? $formdata['meTitleTextAligment'] : "center"
            ),
            "map" => array(
                "height" => !empty($formdata['meMapHeight']) ? (int)$formdata['meMapHeight'] : 400,
                "width" => !empty($formdata['meMapWidth']) ? (int)$formdata['meMapWidth'] : 100
            )
        ),
        "drivingDirections" => array(
            "title" => array(
                "fontSize" => !empty($formdata['ddTitleFontSize']) ? (int)$formdata['ddTitleFontSize'] : 36,
                "fontWeight" => !empty($formdata['ddTitleFontWeight']) ? (int)$formdata['ddTitleFontWeight'] : 500,
                "fontColor" => !empty($formdata['ddTitleFontColor']) ? $formdata['ddTitleFontColor'] : "#00000000",
                "textAlignment" => !empty($formdata['ddTitleTextAligment']) ? $formdata['ddTitleTextAligment'] : "center"
            ),
            "map" => array(
                "height" => !empty($formdata['ddMapHeight']) ? (int)$formdata['ddMapHeight'] : 400,
                "width" => !empty($formdata['ddMapWidth']) ? (int)$formdata['ddMapWidth'] : 100
            )
        )
    );

    if ($componentStylesController->set_component_styles($styledata)) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><b><?php echo $config_data['plugin_name']; ?></b> - Component Styles Updated Successfully!</p>
        </div>
        <?php
    } else {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><b><?php echo $config_data['plugin_name']; ?></b> - Failed to update Component Styles.</p>
        </div>
        <?php
    }
}

// User Submits Settings Form
if (isset($_POST['_settings-form-update'])) {
    $formdata = $_POST;

    $settings = array(
        "google_api_key" => $_POST['settingsGoogleAPIKey']
    );

    if ($settingsController->set_settings_data($settings)) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><b><?php echo $config_data['plugin_name']; ?></b> - Settings Updated Successfully!</p>
        </div>
        <?php
    } else {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><b><?php echo $config_data['plugin_name']; ?></b> - Failed to update Settings.</p>
        </div>
        <?php
    }
}