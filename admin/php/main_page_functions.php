<?php

// User Submits Settings Form
if (isset($_POST['_settings-form-update'])) {
    $formdata = $_POST;

    $settings = array(
        "primary_keyword" => $_POST['primary_keyword'],
        "business_name" => $_POST['business_name']
    );

    //  init component styles
    if ($componentStylesController->init_component_styles()) {

        $componentStylesController->load_styles_data();
        
        // save settings data
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

    } else {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><b><?php echo $config_data['plugin_name']; ?></b> - Failed to initialize <kbd>component_styles.json</kbd> file.</p>
        </div>
        <?php
    }

    
}

// Update components styles
if (isset($_POST['_style-form-update'])) {
    $formdata = $_POST;

    $styleData = array (
        'general' => 
        array (
          'componentsGap' => !empty($formdata['general_component-gap']) ? $formdata['general_component-gap'] : 60,
          'componentsFontFamily' => !empty($formdata['general_font-family']) ? $formdata['general_font-family'] : 'Roboto sans-serif',
        ),
        'weatherComponent' => 
        array (
          'title' => 
          array(
            'fontSize' => !empty($formdata['weathercomponent_title_font-size']) ? $formdata['weathercomponent_title_font-size'] : 36,
            'fontWeight' => !empty($formdata['weathercomponent_title_font-weight']) ? $formdata['weathercomponent_title_font-weight'] : 500,
            'fontColor' => !empty($formdata['weathercomponent_title_font-color']) ? $formdata['weathercomponent_title_font-color'] : '#000000',
            'textAlignment' => !empty($formdata['weathercomponent_title_text-alignment']) ? $formdata['weathercomponent_title_text-alignment'] : 'center',
          ),
          'backgroundColor' => !empty($formdata['weathercomponent_background-color']) ? $formdata['weathercomponent_background-color'] : '#1F567C',
          'textColor' => !empty($formdata['weathercomponent_text-color']) ? $formdata['weathercomponent_text-color'] : '#FFFFFF',
          'unit' => !empty($formdata['weathercomponent_unit']) ? $formdata['weathercomponent_unit'] : 'fahrenheit',
        ),
        'aboutComponent' => 
        array (
          'title' => 
          array (
            'fontSize' => !empty($formdata['aboutcomponent_title_font-size']) ? $formdata['aboutcomponent_title_font-size'] : 36,
            'fontWeight' => !empty($formdata['aboutcomponent_title_font-weight']) ? $formdata['aboutcomponent_title_font-weight'] : 500,
            'fontColor' => !empty($formdata['aboutcomponent_title_font-color']) ? $formdata['aboutcomponent_title_font-color'] : '#000000',
            'textAlignment' => !empty($formdata['aboutcomponent_title_text-alignment']) ? $formdata['aboutcomponent_title_text-alignment'] : 'center',
          ),
          'content' => 
          array (
            'fontSize' => !empty($formdata['aboutcomponent_content_font-size']) ? $formdata['aboutcomponent_content_font-size'] : 16,
            'fontWeight' => !empty($formdata['aboutcomponent_content_font-weight']) ? $formdata['aboutcomponent_content_font-weight'] : 400,
            'fontColor' => !empty($formdata['aboutcomponent_content_font-color']) ? $formdata['aboutcomponent_content_font-color'] : '#000000',
            'textAlignment' => !empty($formdata['aboutcomponent_content_text-alignment']) ? $formdata['aboutcomponent_content_text-alignment'] : 'justify',
          ),
        ),
        'neighborhoodsComponent' => 
        array (
          'title' => 
          array (
            'fontSize' => !empty($formdata['neighborhoodscomponent_title_font-size']) ? $formdata['neighborhoodscomponent_title_font-size'] : 36,
            'fontWeight' => !empty($formdata['neighborhoodscomponent_title_font-weight']) ? $formdata['neighborhoodscomponent_title_font-weight'] : 500,
            'fontColor' => !empty($formdata['neighborhoodscomponent_title_font-color']) ? $formdata['neighborhoodscomponent_title_font-color'] : '#000000',
            'textAlignment' => !empty($formdata['neighborhoodscomponent_title_text-alignment']) ? $formdata['neighborhoodscomponent_title_text-alignment'] : 'center',
          ),
          'neighborhoods' => 
          array (
            'fontSize' => !empty($formdata['neighborhoodscomponent_neighborhoods_font-size']) ? $formdata['neighborhoodscomponent_neighborhoods_font-size'] : 16,
            'fontWeight' => !empty($formdata['neighborhoodscomponent_neighborhoods_font-weight']) ? $formdata['neighborhoodscomponent_neighborhoods_font-weight'] : 400,
            'fontColor' => !empty($formdata['neighborhoodscomponent_neighborhoods_font-color']) ? $formdata['neighborhoodscomponent_neighborhoods_font-color'] : '#0274be',
            'fontColorHovered' => !empty($formdata['neighborhoodscomponent_neighborhoods_font-color-hovered']) ? $formdata['neighborhoodscomponent_neighborhoods_font-color-hovered'] : '#0188df',
            'textAlignment' => !empty($formdata['neighborhoodscomponent_neighborhoods_text-alignment']) ? $formdata['neighborhoodscomponent_neighborhoods_text-alignment'] : 'center',
          ),
        ),
        'thingsToDoComponent' => 
        array (
          'title' => 
          array (
            'fontSize' => !empty($formdata['thingstodocomponent_title_font-size']) ? $formdata['thingstodocomponent_title_font-size'] : 36,
            'fontWeight' => !empty($formdata['thingstodocomponent_title_font-weight']) ? $formdata['thingstodocomponent_title_font-weight'] : 500,
            'fontColor' => !empty($formdata['thingstodocomponent_title_font-color']) ? $formdata['thingstodocomponent_title_font-color'] : '#000000',
            'textAlignment' => !empty($formdata['thingstodocomponent_title_text-alignment']) ? $formdata['thingstodocomponent_title_text-alignment'] : 'center',
          ),
          'items' => 
          array (
            'gap' => !empty($formdata['thingstodocomponent_items_gap']) ? $formdata['thingstodocomponent_items_gap'] : 20,
            'backgroundColor' => !empty($formdata['thingstodocomponent_items_background-color']) ? $formdata['thingstodocomponent_items_background-color'] : '#f5f5f5',
            'hoverEffect' => !empty($formdata['thingstodocomponent_items_hover-effect']) ? $formdata['thingstodocomponent_items_hover-effect'] : 'scaleUp',
            'borderRadius' => !empty($formdata['thingstodocomponent_items_border-radius']) ? $formdata['thingstodocomponent_items_border-radius'] : 5,
            'borderWidth' => !empty($formdata['thingstodocomponent_items_border-width']) ? $formdata['thingstodocomponent_items_border-width'] : 0,
            'borderColor' => !empty($formdata['thingstodocomponent_items_border-color']) ? $formdata['thingstodocomponent_items_border-color'] : '#ebebeb',
            'padding' => !empty($formdata['thingstodocomponent_items_padding']) ? $formdata['thingstodocomponent_items_padding'] : 20,
          ),
          'image' => 
          array (
            'borderRadius' => !empty($formdata['thingstodocomponent_image_border-radius']) ? $formdata['thingstodocomponent_image_border-radius'] : 5,
            'borderWidth' => !empty($formdata['thingstodocomponent_image_border-width']) ? $formdata['thingstodocomponent_image_border-width'] : 0,
            'borderColor' => !empty($formdata['thingstodocomponent_image_border-color']) ? $formdata['thingstodocomponent_image_border-color'] : '#ebebeb',
          ),
          'itemName' => 
          array (
            'fontSize' => !empty($formdata['thingstodocomponent_itemname_font-size']) ? $formdata['thingstodocomponent_itemname_font-size'] : 16,
            'fontWeight' => !empty($formdata['thingstodocomponent_itemname_font-weight']) ? $formdata['thingstodocomponent_itemname_font-weight'] : 400,
            'fontColor' => !empty($formdata['thingstodocomponent_itemname_font-color']) ? $formdata['thingstodocomponent_itemname_font-color'] : '#000000',
            'textAlignment' => !empty($formdata['thingstodocomponent_itemname_text-alignment']) ? $formdata['thingstodocomponent_itemname_text-alignment'] : 'center',
          ),
          'showReviews' => isset($formdata['thingstodocomponent_showratings']),
        ),
        'busStopsComponent' => 
        array (
          'title' => 
          array (
            'fontSize' => !empty($formdata['busstopscomponent_title_font-size']) ? $formdata['busstopscomponent_title_font-size'] : 36,
            'fontWeight' => !empty($formdata['busstopscomponent_title_font-weight']) ? $formdata['busstopscomponent_title_font-weight'] : 500,
            'fontColor' => !empty($formdata['busstopscomponent_title_font-color']) ? $formdata['busstopscomponent_title_font-color'] : '#000000',
            'textAlignment' => !empty($formdata['busstopscomponent_title_text-alignment']) ? $formdata['busstopscomponent_title_text-alignment'] : 'center',
          ),
          'itemName' => 
          array (
            'fontSize' => !empty($formdata['busstopscomponent_itemname_font-size']) ? $formdata['busstopscomponent_itemname_font-size'] : 16,
            'fontWeight' => !empty($formdata['busstopscomponent_itemname_font-weight']) ? $formdata['busstopscomponent_itemname_font-weight'] : 600,
            'fontColor' => !empty($formdata['busstopscomponent_itemname_font-color']) ? $formdata['busstopscomponent_itemname_font-color'] : '#000000',
            'textAlignment' => !empty($formdata['busstopscomponent_itemname_text-alignment']) ? $formdata['busstopscomponent_itemname_text-alignment'] : 'center',
          ),
          'items' => 
          array (
            'gap' => !empty($formdata['busstopscomponent_items_gap']) ? $formdata['busstopscomponent_items_gap'] : 20,
          ),
        ),
        'mapEmbedComponent' => 
        array (
          'title' => 
          array (
            'fontSize' => !empty($formdata['mapembedcomponent_title_font-size']) ? $formdata['mapembedcomponent_title_font-size'] : 36,
            'fontWeight' => !empty($formdata['mapembedcomponent_title_font-weight']) ? $formdata['mapembedcomponent_title_font-weight'] : 500,
            'fontColor' => !empty($formdata['mapembedcomponent_title_font-color']) ? $formdata['mapembedcomponent_title_font-color'] : '#000000',
            'textAlignment' => !empty($formdata['mapembedcomponent_title_text-alignment']) ? $formdata['mapembedcomponent_title_text-alignment'] : 'center',
          ),
          'map' => 
          array (
            'height' => !empty($formdata['mapembedcomponent_map_height']) ? $formdata['mapembedcomponent_map_height'] : 300,
            'width' => !empty($formdata['mapembedcomponent_map_width']) ? $formdata['mapembedcomponent_map_width'] : 100,
          ),
        ),
        'drivingDirectionsComponent' => 
        array (
          'title' => 
          array (
            'fontSize' => !empty($formdata['drivingdirectionscomponent_title_font-size']) ? $formdata['drivingdirectionscomponent_title_font-size'] : 36,
            'fontWeight' => !empty($formdata['drivingdirectionscomponent_title_font-weight']) ? $formdata['drivingdirectionscomponent_title_font-weight'] : 500,
            'fontColor' => !empty($formdata['drivingdirectionscomponent_title_font-color']) ? $formdata['drivingdirectionscomponent_title_font-color'] : '#000000',
            'textAlignment' => !empty($formdata['drivingdirectionscomponent_title_text-alignment']) ? $formdata['drivingdirectionscomponent_title_text-alignment'] : 'center',
          ),
          'itemName' => 
          array (
            'fontSize' => !empty($formdata['drivingdirectionscomponent_itemname_font-size']) ? $formdata['drivingdirectionscomponent_itemname_font-size'] : 16,
            'fontWeight' => !empty($formdata['drivingdirectionscomponent_itemname_font-weight']) ? $formdata['drivingdirectionscomponent_itemname_font-weight'] : 600,
            'fontColor' => !empty($formdata['drivingdirectionscomponentt_itemname_font-color']) ? $formdata['drivingdirectionscomponentt_itemname_font-color'] : '#000000',
            'textAlignment' => !empty($formdata['drivingdirectionscomponent_itemname_text-alignment']) ? $formdata['drivingdirectionscomponent_itemname_text-alignment'] : 'center',
          ),
          'items' => 
          array (
            'gap' => !empty($formdata['drivingdirectionscomponent_items_gap']) ? $formdata['drivingdirectionscomponent_items_gap'] : 20,
          ),
        ),
        'reviewsComponent' => 
        array (
          'title' => 
          array (
            'fontSize' => !empty($formdata['reviewscomponent_title_font-size']) ? $formdata['reviewscomponent_title_font-size'] : 36,
            'fontWeight' => !empty($formdata['reviewscomponent_title_font-weight']) ? $formdata['reviewscomponent_title_font-weight'] : 500,
            'fontColor' => !empty($formdata['reviewscomponent_title_font-color']) ? $formdata['reviewscomponent_title_font-color'] : '#000000',
            'textAlignment' => !empty($formdata['reviewscomponent_title_text-alignment']) ? $formdata['reviewscomponent_title_text-alignment'] : 'center',
          ),
          'items' => 
          array (
            'gap' => !empty($formdata['reviewscomponent_items_gap']) ? $formdata['reviewscomponent_items_gap'] : 20,
            'backgroundColor' => !empty($formdata['reviewscomponent_items_background-color']) ? $formdata['reviewscomponent_items_background-color'] : '#f5f5f5',
            'borderRadius' => !empty($formdata['reviewscomponent_items_border-radius']) ? $formdata['reviewscomponent_items_border-radius'] : 5,
            'borderWidth' => !empty($formdata['reviewscomponent_items_border-width']) ? $formdata['reviewscomponent_items_border-width'] : 0,
            'borderColor' => !empty($formdata['reviewscomponent_items_border-color']) ? $formdata['reviewscomponent_items_border-color'] : '#ebebeb',
            'padding' => !empty($formdata['reviewscomponent_items_padding']) ? $formdata['reviewscomponent_items_padding'] : 20,
          ),
          'authorName' => 
          array (
            'fontSize' => !empty($formdata['reviewscomponent_authorname_font-size']) ? $formdata['reviewscomponent_authorname_font-size'] : 16,
            'fontWeight' => !empty($formdata['reviewscomponent_authorname_font-weight']) ? $formdata['reviewscomponent_authorname_font-weight'] : 500,
            'fontColor' => !empty($formdata['reviewscomponent_authorname_font-color']) ? $formdata['reviewscomponent_authorname_font-color'] : '#000000',
          ),
          'reviewBody' => 
          array (
            'fontSize' => !empty($formdata['reviewscomponent_reviewbody_font-size']) ? $formdata['reviewscomponent_reviewbody_font-size'] : 16,
            'fontWeight' => !empty($formdata['reviewscomponent_reviewbody_font-weight']) ? $formdata['reviewscomponent_reviewbody_font-weight'] : 400,
            'fontColor' => !empty($formdata['reviewscomponent_reviewbody_font-color']) ? $formdata['reviewscomponent_reviewbody_font-color'] : '#000000',
          ),
        ),
    );

    if ($componentStylesController->set_component_styles($styleData)) {

        $componentStylesController->load_styles_data();

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

// Reset compoenents styles
if (isset($_POST['_style-form-reset'])) {
    if ($componentStylesController->init_component_styles()) {
        $componentStylesController->load_styles_data();

        ?>
        <div class="notice notice-success is-dismissible">
            <p><b><?php echo $config_data['plugin_name']; ?></b> - Component Styles Restored to Default!</p>
        </div>
        <?php
    } else {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><b><?php echo $config_data['plugin_name']; ?></b> - Component Styles Failed to Restore Default!</p>
        </div>
        <?php
    }
}

// Create new location form submit
if (isset($_POST['_newlocationform_submit_api_data'])) {

  if ($apiDataController->set_single_api_data($_POST['_newlocationform_submit_api_data'])) {
    ?>
    <div class="notice notice-success is-dismissible">
        <p><b><?php echo $config_data['plugin_name']; ?></b> - Location successfully created!</p>
    </div>
    <?php
  } else {
    ?>
    <div class="notice notice-success is-dismissible">
        <p><b><?php echo $config_data['plugin_name']; ?></b> - Failed to create location!</p>
    </div>
    <?php
  }
}

// Remove location
if (isset($_GET['remove-id'])) {

    if (!$apiDataController->api_data_is_available($_GET['remove-id'])) return;

    if ($apiDataController->remove_data_by_id($_GET['remove-id'])) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><b><?php echo $config_data['plugin_name']; ?></b> - Location Removed!</p>
        </div>
        <?php
    } else {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><b><?php echo $config_data['plugin_name']; ?></b> - Failed to remove Location.</p>
        </div>
        <?php
    }
}

// When new primary location is set
if (isset($_POST['new_primary_api_data'])) {
  if ($apiDataController->set_all_api_data($_POST['new_primary_api_data'])) {
    ?>
    <div class="notice notice-success is-dismissible">
        <p><b><?php echo $config_data['plugin_name']; ?></b> - Primary Location updated!</p>
    </div>
    <?php
  } else {
    ?>
    <div class="notice notice-error is-dismissible">
        <p><b><?php echo $config_data['plugin_name']; ?></b> - Failed to update Primary Location.</p>
    </div>
    <?php
  }
}