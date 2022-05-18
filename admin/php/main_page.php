<?php

require_once plugin_dir_path(__FILE__) . '../../includes/geocentric_settings_class.php';
$settingsController = new _geocentric_settings();

require_once plugin_dir_path(__FILE__) . '../../includes/geocentric_plugin_config_class.php';
$pluginConfigController = new _geocentric_plugin_config();

require_once plugin_dir_path(__FILE__) . '../../includes/geocentric_component_styles_class.php';
$componentStylesController = new _geocentric_component_styles();

require_once plugin_dir_path(__FILE__) . '../../includes/geocentric_api_data_class.php';
$apiDataController = new _geocentric_api_data();

$config_data = $pluginConfigController->get_plugin_config_data();

require_once plugin_dir_path(__FILE__) . 'main_page_functions.php';


$component_styles = $componentStylesController->get_component_styles();
$api_data = $apiDataController->get_all_api_data();
$settings = $settingsController->get_settings_data();

// Is the plugin configured?
$pluginConfigured = $componentStylesController->styles_isset();

//Get the active tab from the $_GET param
$default_tab = null;
$tab = !$pluginConfigured ? 'settings' : (isset($_GET['tab']) ? $_GET['tab'] : $default_tab);


?><div
    class="_geocentric-wrapper" 
    data-api_server_url="<?php echo $config_data['server_url']; ?>" 
    data-geodatabase_url="<?php echo $config_data['geodatabase_url']; ?>" 
    data-appsero_api_key="<?php echo $config_data['appsero_api_key']; ?>" 
    data-appsero_plugin_name="<?php echo $config_data['appsero_plugin_name']; ?>"
    <?php if ($pluginConfigured) { ?>
        data-primary_keyword="<?php echo $settings['primary_keyword'] ?>" 
        data-primary_location="<?php echo str_replace("\"", "&#34;" ,json_encode($apiDataController->primary_location())); ?>" 
    <?php } ?>
    >
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
        <div class="locations-tab">
            <h2>Locations 📌</h2>
            <div class="header-wrapper">
                <p>List down the all your Service Areas below to use all the goecentric data.</p>
                <a href="?page=_geocentric&tab=new-location-form"><button class="button-primary">Add location</button></a>
            </div>
            <hr>
            <div class="locations-list">
                <?php
                foreach ($api_data as $location) {
                    ?>
                    <div class="location" 
                    id="<?php echo $location['id']; ?>"
                    data-name="<?php echo $location['name']; ?>">
                        <p><?php echo $location['name']; ?></p>
                        <?php if ($location['meta']['is_primary']) echo '<span>Primary</span>'; ?>
                        <a title="Shortcodes" href="#TB_inline?height=200&width=550&inlineId=shortcode-tb-wrapper" class="thickbox shortcodes-button" ><i class="material-icons-outlined">data_array</i></a>
                        <button title="Options" class="options-button">
                            <i class="material-icons-outlined">expand_circle_down</i>
                            <div class="dropdown-menu">
                                <a class="remove-location-button" href="?page=_geocentric&remove-id=<?php echo $location['id']; ?>" <?php if($location['meta']['is_primary']) echo 'data-is-primary="true"'; ?>>Remove</a>
                                <a data-id="<?php echo $location['id']; ?>" <?php if($location['meta']['is_primary']) echo 'data-is-primary="true"'; ?> class="set-as-primary-button" href="#">Set as Primary</a>
                            </div>
                        </button>
                    </div>
                    <?php
                }
                ?>
            </div>

            <!-- shortcodes thickbox -->
            <div id="shortcode-tb-wrapper" style="display: none;">
                <div class="shortcode-tb">
                    <h3 class="shortcodes-tb-title">_LOCATION</h3>
                    <p>Add these shortcodes to your <b>Service Area Pages</b> to display the geo-relevant information.</p>
                    <textarea readonly class="shortcodes-tb-textarea" rows="11"></textarea>
                    <button id="tb-copy-shortcodes-button" class="button-secondary">Copy All</button>
                </div>
            </div>

            <form class="primary-location-form" style="display: none;" action="#" method="POST">
                <textarea class="current_api_data" name="current_api_data"><?php if (isset($api_data)) echo json_encode($api_data); ?></textarea>
                <textarea class="new_primary_api_data" name="new_primary_api_data"></textarea>
            </form>

        </div>
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
                    <label>Primary Keyword<span>*</span></label>
                    <input type="text" required name="primary_keyword" <?php if (isset($settings['primary_keyword'])) echo "value=\"{$settings['primary_keyword']}\""; ?>>
                    <small>Properly Input your Main Keyword here <b>WITHOUT LOCATION</b> for best results.</small>
                </div>

                <div class="input-group">
                    <label>Business Name<span>*</span></label>
                    <input type="text" required name="business_name" <?php if (isset($settings['business_name'])) echo "value=\"{$settings['business_name']}\""; ?>>
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
            <div class="summary">
                <p>
                    <b>Quick jump to...</b> 
                    <a href="#:~:text=Component%20%7C%20Reviews%20Component-,General,-Components%20Gap">General</a> |
                    <a href="#:~:text=Components%20Padding-,Weather%20Component,-Background%20Color">Weather Component</a> |
                    <a href="#:~:text=About%20Component,-Title">About Component</a> |
                    <a href="#:~:text=Neighborhoods%20Component,-Title">Neighborhoods Component</a> |
                    <a href="#:~:text=Things%20to%20Do%20Component,-Title">Things to Do Component</a> |
                    <a href="#:~:text=for%20each%20item%3F-,Bus%20Stops%20Component,-Title">Bus Stops Component</a> |
                    <a href="#:~:text=Map%20Embed%20Component,-Title">Map Embed Component</a> |
                    <a href="#:~:text=Width%20(%25)-,Driving%20Directions%20Component,-Title">Driving Directions Component</a> |
                    <a href="#:~:text=Width%20(%25)-,Reviews%20Component,-Title">Reviews Component</a>
                </p>
            </div>
            <hr>

            <form action="?page=_geocentric&tab=styling" method="POST">
                
                <div class="general-group group">
                    <h3  id="general">General</h3>
                    <div class="row">
                        <div class="input-group">
                            <label>Components Gap</label>
                            <input type="number" name="general_component-gap" value="<?php echo $component_styles['general']['componentsGap'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Family</label>
                            <select class="general_font-family" autocomplete="on" name="general_font-family" data-setvalue="<?php echo $component_styles['general']['componentsFontFamily'] ?>">
                            </select>
                        </div>
                    </div>
                </div>

                <div id="weathercomponent" class="weathercomponent-group group">
                    <h3>Weather Component</h3>
                    <div class="row">
                        <div class="input-group">
                            <label>Background Color</label>
                            <input type="text" name="weathercomponent_background-color" value="<?php echo $component_styles['weatherComponent']['backgroundColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Text Color</label>
                            <input type="text" name="weathercomponent_text-color"  value="<?php echo $component_styles['weatherComponent']['textColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Unit</label>
                            <select name="weathercomponent_unit">
                                <option <?php if ($component_styles['weatherComponent']['unit'] == "fahrenheit") echo 'selected'; ?> value="fahrenheit">Fahrenheit</option>
                                <option <?php if ($component_styles['weatherComponent']['unit'] == "celsius") echo 'selected'; ?> value="celsius">Celsius</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="aboutcomponent" class="aboutcomponent-group group">
                    <h3>About Component</h3>

                    <h4>Title</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" name="aboutcomponent_title_font-size" value="<?php echo $component_styles['aboutComponent']['title']['fontSize'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" name="aboutcomponent_title_font-weight" value="<?php echo $component_styles['aboutComponent']['title']['fontWeight'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" name="aboutcomponent_title_font-color" value="<?php echo $component_styles['aboutComponent']['title']['fontColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="aboutcomponent_title_text-alignment">
                                <option <?php if ($component_styles['aboutComponent']['title']['textAlignment'] == "right") echo 'selected'; ?> value="right">Right</option>
                                <option <?php if ($component_styles['aboutComponent']['title']['textAlignment'] == "left") echo 'selected'; ?> value="left">Left</option>
                                <option <?php if ($component_styles['aboutComponent']['title']['textAlignment'] == "center") echo 'selected'; ?> value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <h4>Content</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" name="aboutcomponent_content_font-size" value="<?php echo $component_styles['aboutComponent']['content']['fontSize'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" name="aboutcomponent_content_font-weight" value="<?php echo $component_styles['aboutComponent']['content']['fontWeight'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" name="aboutcomponent_content_font-color" value="<?php echo $component_styles['aboutComponent']['content']['fontColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="aboutcomponent_content_text-alignment">
                                <option <?php if ($component_styles['aboutComponent']['content']['textAlignment'] == "right") echo 'selected'; ?> value="right">Right</option>
                                <option <?php if ($component_styles['aboutComponent']['content']['textAlignment'] == "left") echo 'selected'; ?> value="left">Left</option>
                                <option <?php if ($component_styles['aboutComponent']['content']['textAlignment'] == "center") echo 'selected'; ?> value="center">Center</option>
                                <option <?php if ($component_styles['aboutComponent']['content']['textAlignment'] == "justify") echo 'selected'; ?> value="justify">Justify</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div id="neighborhoodscomponent" class="neighborhoodscomponent-group group">
                    <h3>Neighborhoods Component</h3>

                    <h4>Title</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" name="neighborhoodscomponent_title_font-size" value="<?php echo $component_styles['neighborhoodsComponent']['title']['fontSize'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" name="neighborhoodscomponent_title_font-weight" value="<?php echo $component_styles['neighborhoodsComponent']['title']['fontWeight'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" name="neighborhoodscomponent_title_font-color" value="<?php echo $component_styles['neighborhoodsComponent']['title']['fontColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="neighborhoodscomponent_title_text-alignment">
                                <option <?php if ($component_styles['neighborhoodsComponent']['title']['textAlignment'] == "right") echo 'selected'; ?> value="right">Right</option>
                                <option <?php if ($component_styles['neighborhoodsComponent']['title']['textAlignment'] == "left") echo 'selected'; ?> value="left">Left</option>
                                <option <?php if ($component_styles['neighborhoodsComponent']['title']['textAlignment'] == "center") echo 'selected'; ?> value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <h4>Neighborhoods</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" name="neighborhoodscomponent_neighborhoods_font-size" value="<?php echo $component_styles['neighborhoodsComponent']['neighborhoods']['fontSize'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" name="neighborhoodscomponent_neighborhoods_font-weight" value="<?php echo $component_styles['neighborhoodsComponent']['neighborhoods']['fontWeight'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" name="neighborhoodscomponent_neighborhoods_font-color" value="<?php echo $component_styles['neighborhoodsComponent']['neighborhoods']['fontColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="neighborhoodscomponent_neighborhoods_text-alignment">
                                <option <?php if ($component_styles['neighborhoodsComponent']['neighborhoods']['textAlignment'] == "right") echo 'selected'; ?> value="right">Right</option>
                                <option <?php if ($component_styles['neighborhoodsComponent']['neighborhoods']['textAlignment'] == "left") echo 'selected'; ?> value="left">Left</option>
                                <option <?php if ($component_styles['neighborhoodsComponent']['neighborhoods']['textAlignment'] == "center") echo 'selected'; ?> value="center">Center</option>
                                <option <?php if ($component_styles['neighborhoodsComponent']['neighborhoods']['textAlignment'] == "justify") echo 'selected'; ?> value="justify">Justify</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Color (Hovered)</label>
                            <input type="text" name="neighborhoodscomponent_neighborhoods_font-color-hovered" value="<?php echo $component_styles['neighborhoodsComponent']['neighborhoods']['fontColorHovered'] ?>">
                        </div>
                    </div>

                </div>
                
                <div id="thingstodocomponent" class="thingstodocomponent-group group">
                    <h3>Things to Do Component</h3>

                    <h4>Title</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" name="thingstodocomponent_title_font-size" value="<?php echo $component_styles['thingsToDoComponent']['title']['fontSize'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" name="thingstodocomponent_title_font-weight" value="<?php echo $component_styles['thingsToDoComponent']['title']['fontWeight'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" name="thingstodocomponent_title_font-color" value="<?php echo $component_styles['thingsToDoComponent']['title']['fontColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="thingstodocomponent_title_text-alignment">
                                <option <?php if ($component_styles['thingsToDoComponent']['title']['textAlignment'] == "right") echo 'selected'; ?> value="right">Right</option>
                                <option <?php if ($component_styles['thingsToDoComponent']['title']['textAlignment'] == "left") echo 'selected'; ?> value="left">Left</option>
                                <option <?php if ($component_styles['thingsToDoComponent']['title']['textAlignment'] == "center") echo 'selected'; ?> value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <h4>Items</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Background Color</label>
                            <input type="text" name="thingstodocomponent_items_background-color" value="<?php echo $component_styles['thingsToDoComponent']['items']['backgroundColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Border Color</label>
                            <input type="text" name="thingstodocomponent_items_border-color" value="<?php echo $component_styles['thingsToDoComponent']['items']['borderColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Border Radius</label>
                            <input type="number" name="thingstodocomponent_items_border-radius" value="<?php echo $component_styles['thingsToDoComponent']['items']['borderRadius'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Border Width</label>
                            <input type="number" name="thingstodocomponent_items_border-width" value="<?php echo $component_styles['thingsToDoComponent']['items']['borderWidth'] ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <label>Gap</label>
                            <input type="number" name="thingstodocomponent_items_gap" value="<?php echo $component_styles['thingsToDoComponent']['items']['gap'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Padding</label>
                            <input type="number" name="thingstodocomponent_items_padding" value="<?php echo $component_styles['thingsToDoComponent']['items']['padding'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Hover Effect</label>
                            <select name="thingstodocomponent_items_hover-effect">
                                <option <?php if ($component_styles['thingsToDoComponent']['items']['hoverEffect'] == "scaleUp") echo 'selected'; ?> value="scaleUp">Scale Up</option>
                                <option <?php if ($component_styles['thingsToDoComponent']['items']['hoverEffect'] == "scaleDown") echo 'selected'; ?> value="scaleDown">Scale Down</option>
                                <option <?php if ($component_styles['thingsToDoComponent']['items']['hoverEffect'] == "rise") echo 'selected'; ?> value="rise">Rise</option>
                            </select>
                        </div>
                    </div>

                    <h4>Image</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Border Color</label>
                            <input type="text" name="thingstodocomponent_image_border-color" value="<?php echo $component_styles['thingsToDoComponent']['image']['borderColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Border Radius</label>
                            <input type="number" name="thingstodocomponent_image_border-radius" value="<?php echo $component_styles['thingsToDoComponent']['image']['borderRadius'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Border Width</label>
                            <input type="number" name="thingstodocomponent_image_border-width" value="<?php echo $component_styles['thingsToDoComponent']['image']['borderWidth'] ?>">
                        </div>
                    </div>

                    <h4>Item Name</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" name="thingstodocomponent_itemname_font-size" value="<?php echo $component_styles['thingsToDoComponent']['itemName']['fontSize'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" name="thingstodocomponent_itemname_font-weight" value="<?php echo $component_styles['thingsToDoComponent']['itemName']['fontWeight'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" name="thingstodocomponent_itemname_font-color" value="<?php echo $component_styles['thingsToDoComponent']['itemName']['fontColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="thingstodocomponent_itemname_text-alignment">
                                <option <?php if ($component_styles['thingsToDoComponent']['itemName']['textAlignment'] == "right") echo 'selected'; ?> value="right">Right</option>
                                <option <?php if ($component_styles['thingsToDoComponent']['itemName']['textAlignment'] == "left") echo 'selected'; ?> value="left">Left</option>
                                <option <?php if ($component_styles['thingsToDoComponent']['itemName']['textAlignment'] == "center") echo 'selected'; ?> value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-group thingstodocomponent_showratings">
                        <input type="checkbox" name="thingstodocomponent_showratings" <?php if($component_styles['thingsToDoComponent']['showReviews']) echo 'checked'; ?>>
                        <label>Show ratings for each item?</label>
                    </div>

                </div>

                <div id="busstopscomponent" class="busstopscomponent-group group">
                    <h3>Bus Stops Component</h3>

                    <h4>Title</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" name="busstopscomponent_title_font-size" value="<?php echo $component_styles['busStopsComponent']['title']['fontSize'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" name="busstopscomponent_title_font-weight" value="<?php echo $component_styles['busStopsComponent']['title']['fontWeight'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" name="busstopscomponent_title_font-color" value="<?php echo $component_styles['busStopsComponent']['title']['fontColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="busstopscomponent_title_text-alignment">
                                <option <?php if ($component_styles['busStopsComponent']['title']['textAlignment'] == "right") echo 'selected'; ?> value="right">Right</option>
                                <option <?php if ($component_styles['busStopsComponent']['title']['textAlignment'] == "left") echo 'selected'; ?> value="left">Left</option>
                                <option <?php if ($component_styles['busStopsComponent']['title']['textAlignment'] == "center") echo 'selected'; ?> value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <h4>Item Name</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" name="busstopscomponent_itemname_font-size" value="<?php echo $component_styles['busStopsComponent']['itemName']['fontSize'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" name="busstopscomponent_itemname_font-weight" value="<?php echo $component_styles['busStopsComponent']['itemName']['fontWeight'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" name="busstopscomponent_itemname_font-color" value="<?php echo $component_styles['busStopsComponent']['itemName']['fontColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="busstopscomponent_itemname_text-alignment">
                                <option <?php if ($component_styles['busStopsComponent']['itemName']['textAlignment'] == "right") echo 'selected'; ?> value="right">Right</option>
                                <option <?php if ($component_styles['busStopsComponent']['itemName']['textAlignment'] == "left") echo 'selected'; ?> value="left">Left</option>
                                <option <?php if ($component_styles['busStopsComponent']['itemName']['textAlignment'] == "center") echo 'selected'; ?> value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <h4>Items</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Gap</label>
                            <input type="number" name="busstopscomponent_items_gap" value="<?php echo $component_styles['busStopsComponent']['items']['gap'] ?>">
                        </div>
                    </div>
                </div>

                <div id="mapembedcomponent" class="mapembedcomponent-group group">
                    <h3>Map Embed Component</h3>

                    <h4>Title</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" name="mapembedcomponent_title_font-size" value="<?php echo $component_styles['mapEmbedComponent']['title']['fontSize'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" name="mapembedcomponent_title_font-weight" value="<?php echo $component_styles['mapEmbedComponent']['title']['fontWeight'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" name="mapembedcomponent_title_font-color" value="<?php echo $component_styles['mapEmbedComponent']['title']['fontColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="mapembedcomponent_title_text-alignment">
                                <option <?php if ($component_styles['mapEmbedComponent']['title']['textAlignment'] == "right") echo 'selected'; ?> value="right">Right</option>
                                <option <?php if ($component_styles['mapEmbedComponent']['title']['textAlignment'] == "left") echo 'selected'; ?> value="left">Left</option>
                                <option <?php if ($component_styles['mapEmbedComponent']['title']['textAlignment'] == "center") echo 'selected'; ?> value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <h4>Map</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Height (px)</label>
                            <input type="number" name="mapembedcomponent_map_height" value="<?php echo $component_styles['mapEmbedComponent']['map']['height'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Width (%)</label>
                            <input max="100" min="1" type="number" name="mapembedcomponent_map_width" value="<?php echo $component_styles['mapEmbedComponent']['map']['width'] ?>">
                        </div>
                    </div>
                </div>

                <div id="drivingdirectionscomponent" class="drivingdirectionscomponent-group group">
                    <h3>Driving Directions Component</h3>

                    <h4>Title</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" name="drivingdirectionscomponent_title_font-size" value="<?php echo $component_styles['drivingDirectionsComponent']['title']['fontSize'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" name="drivingdirectionscomponent_title_font-weight" value="<?php echo $component_styles['drivingDirectionsComponent']['title']['fontWeight'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" name="drivingdirectionscomponent_title_font-color" value="<?php echo $component_styles['drivingDirectionsComponent']['title']['fontColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="drivingdirectionscomponent_title_text-alignment">
                                <option <?php if ($component_styles['drivingDirectionsComponent']['title']['textAlignment'] == "right") echo 'selected'; ?> value="right">Right</option>
                                <option <?php if ($component_styles['drivingDirectionsComponent']['title']['textAlignment'] == "left") echo 'selected'; ?> value="left">Left</option>
                                <option <?php if ($component_styles['drivingDirectionsComponent']['title']['textAlignment'] == "center") echo 'selected'; ?> value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <h4>Item Name</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" name="drivingdirectionscomponent_itemname_font-size" value="<?php echo $component_styles['drivingDirectionsComponent']['itemName']['fontSize'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" name="drivingdirectionscomponent_itemname_font-weight" value="<?php echo $component_styles['drivingDirectionsComponent']['itemName']['fontWeight'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" name="drivingdirectionscomponentt_itemname_font-color" value="<?php echo $component_styles['drivingDirectionsComponent']['itemName']['fontColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="drivingdirectionscomponent_itemname_text-alignment">
                                <option <?php if ($component_styles['drivingDirectionsComponent']['itemName']['textAlignment'] == "right") echo 'selected'; ?> value="right">Right</option>
                                <option <?php if ($component_styles['drivingDirectionsComponent']['itemName']['textAlignment'] == "left") echo 'selected'; ?> value="left">Left</option>
                                <option <?php if ($component_styles['drivingDirectionsComponent']['itemName']['textAlignment'] == "center") echo 'selected'; ?> value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <h4>Items</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Gap</label>
                            <input type="number" name="drivingdirectionscomponent_items_gap" value="<?php echo $component_styles['drivingDirectionsComponent']['items']['gap'] ?>">
                        </div>
                    </div>
                </div>

                <div id="reviewscomponent" class="reviewscomponent-group group">
                    <h3>Reviews Component</h3>

                    <h4>Title</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" name="reviewscomponent_title_font-size" value="<?php echo $component_styles['reviewsComponent']['title']['fontSize'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" name="reviewscomponent_title_font-weight" value="<?php echo $component_styles['reviewsComponent']['title']['fontWeight'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" name="reviewscomponent_title_font-color" value="<?php echo $component_styles['reviewsComponent']['title']['fontColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="reviewscomponent_title_text-alignment">
                                <option <?php if ($component_styles['reviewsComponent']['title']['textAlignment'] == "right") echo 'selected'; ?> value="right">Right</option>
                                <option <?php if ($component_styles['reviewsComponent']['title']['textAlignment'] == "left") echo 'selected'; ?> value="left">Left</option>
                                <option <?php if ($component_styles['reviewsComponent']['title']['textAlignment'] == "center") echo 'selected'; ?> value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <h4>Items</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Background Color</label>
                            <input type="text" name="reviewscomponent_items_background-color" value="<?php echo $component_styles['reviewsComponent']['items']['backgroundColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Border Color</label>
                            <input type="text" name="reviewscomponent_items_border-color" value="<?php echo $component_styles['reviewsComponent']['items']['borderColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Border Radius</label>
                            <input type="number" name="reviewscomponent_items_border-radius" value="<?php echo $component_styles['reviewsComponent']['items']['borderRadius'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Border Width</label>
                            <input type="number" name="reviewscomponent_items_border-width" value="<?php echo $component_styles['reviewsComponent']['items']['borderWidth'] ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <label>Gap</label>
                            <input type="number" name="reviewscomponent_items_gap" value="<?php echo $component_styles['reviewsComponent']['items']['gap'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Padding</label>
                            <input type="number" name="reviewscomponent_items_padding" value="<?php echo $component_styles['reviewsComponent']['items']['padding'] ?>">
                        </div>
                    </div>

                    <h4>Author Name</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" name="reviewscomponent_authorname_font-size" value="<?php echo $component_styles['reviewsComponent']['authorName']['fontSize'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" name="reviewscomponent_authorname_font-weight" value="<?php echo $component_styles['reviewsComponent']['authorName']['fontWeight'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" name="reviewscomponent_authorname_font-color" value="<?php echo $component_styles['reviewsComponent']['authorName']['fontColor'] ?>">
                        </div>
                    </div>

                    <h4>Review Body</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" name="reviewscomponent_reviewbody_font-size" value="<?php echo $component_styles['reviewsComponent']['reviewBody']['fontSize'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" name="reviewscomponent_reviewbody_font-weight" value="<?php echo $component_styles['reviewsComponent']['reviewBody']['fontWeight'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" name="reviewscomponent_reviewbody_font-color" value="<?php echo $component_styles['reviewsComponent']['reviewBody']['fontColor'] ?>">
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <input name="_style-form-update" type="submit" class="button-primary" value="Save"/>
                    <input name="_style-form-reset" type="submit" class="button-secondary" value="Reset Default Styles" style="margin-left: auto;">
                </div>

            </form>
        </div>
        <?php
        break;
    case 'new-location-form':
        ?>
        <div class="new-location-form">
            <h2>Create New Location</h2>
            <hr>
            <form action="?page=_geocentric" method="POST">

                <div class="row">
                    <div class="input-group">
                        <label>Country <span>*</span></label>
                        <select required autocomplete name="newlocationform_country" class="newlocationform_country">
                            <option value="" selected disabled>---</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label>State <span>*</span></label>
                        <select required autocomplete name="newlocationform_state" class="newlocationform_state">
                            <option value="" selected disabled>---</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label>City/Town <span>*</span></label>
                        <select required autocomplete class="newlocationform_city" name="newlocationform_city">
                            <option value="" selected disabled>---</option>
                        </select>
                    </div>
                </div>

                <div class="input-group full-width">
                    <label>Neighborhoods</label>
                    <textarea disabled name="newlocationform_neigborhoods" class="newlocationform_neigborhoods" rows="5"></textarea>
                    <small>These are the available neighbourhoods for this area on our database. You can manually add or edit them by entering your neighbourhoods here. Enter them properly and separate each with comma(,)</small>
                </div>

                <div class="input-group full-width gbp-input-group">
                    <label>GBP Place ID</label>
                    <input type="text" name="newlocationform_gbp_placeid">
                    <small>If you have physical branch in this area, you can manually enter either the Google Maps Place ID or tick the checkbox below to use street address and zip code.</small>
                </div>

                <div class="row streetzip-input-group">
                    <div class="input-group">
                        <label>Street Address <span>*</span></label>
                        <input type="text" name="newlocationform_street" class="newlocationform_street">
                    </div>
                    <div class="input-group">
                        <label>ZIP Code <span>*</span></label>
                        <input type="text" name="newlocationform_zipcode" class="newlocationform_zipcode">
                    </div>
                </div>

                <div class="input-group input-checkbox">
                    <input type="checkbox" name="newlocationform_useStreetzip" class="newlocationform_use-streetzip">
                    <label>Use <b>street address</b> and <b>zip code</b>.</label>
                </div>

                <div class="form-footer">
                    <textarea name="_newlocationform_submit_api_data" class="_newlocationform-submit-api-data" style="display: none;"></textarea>
                    <input type="checkbox" style="display: none;" name="_newlocationform_importlocation_failed">
                    <button type="button" class="button-primary create-button">Create</button>
                    <img src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/Rocket.gif'; ?>">
                    <button type="button" class="button-secondary discard-button" style="margin-left: auto;">Discard Location</button>
                </div>
            </form>
        </div>
        <?php
        break;
}

?></div>


<div class="footer">
    <p>Powered by © <a href="http://seorockettools.com/" target="_blank">SEO Rocket Tools</a>, 2022 🚀.</p>
    <p><a href="https://github.com/francis150/geocentric#readme" target="_blank">Documentation</a> | <a href="#">Community</a> | <a href="http://support.seorockettools.com/"  target="_blank">Support</a></p>
</div></div>