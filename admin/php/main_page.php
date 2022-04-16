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

?><div class="_geocentric-wrapper" data-api_server_url="<?php echo $config_data['server_url']; ?>">
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
                    <input type="text" required name="unrestricted_google_api_key" <?php if (isset($settings['unrestricted_google_api_key'])) echo "value=\"{$settings['unrestricted_google_api_key']}\""; ?>>
                    <small>This API Key will be used on our backend server and will not be visible in th front-end. <b>This must be unrestricted</b> for our servers to run. <b>API's Required:</b> Places API, Geo Coding API, Knowledge Graph Search API</small>
                </div>

                <div class="input-group">
                    <label>Google API Key (Restricted) <span>*</span></label>
                    <input type="text" name="restricted_google_api_key" required <?php if (isset($settings['restricted_google_api_key'])) echo "value=\"{$settings['restricted_google_api_key']}\""; ?>>
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
                            <label>Components Padding</label>
                            <input type="number" name="general_component-padding" value="<?php echo $component_styles['general']['componentsPadding'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Family</label>
                            <select class="general_font-family" autocomplete="on" name="general_font-family" data-setvalue="<?php echo $component_styles['general']['compooenentsFontFamily'] ?>">
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
                            <input type="number" name="neighborhoodscomponent_title_font-size" value="<?php echo $component_styles['neigborhoodsComponent']['title']['fontSize'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" name="neighborhoodscomponent_title_font-weight" value="<?php echo $component_styles['neigborhoodsComponent']['title']['fontWeight'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" name="neighborhoodscomponent_title_font-color" value="<?php echo $component_styles['neigborhoodsComponent']['title']['fontColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="neighborhoodscomponent_title_text-alignment">
                                <option <?php if ($component_styles['neigborhoodsComponent']['title']['textAlignment'] == "right") echo 'selected'; ?> value="right">Right</option>
                                <option <?php if ($component_styles['neigborhoodsComponent']['title']['textAlignment'] == "left") echo 'selected'; ?> value="left">Left</option>
                                <option <?php if ($component_styles['neigborhoodsComponent']['title']['textAlignment'] == "center") echo 'selected'; ?> value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <h4>Neighborhoods</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" name="neighborhoodscomponent_neighborhoods_font-size" value="<?php echo $component_styles['neigborhoodsComponent']['neigborhoods']['fontSize'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" name="neighborhoodscomponent_neighborhoods_font-weight" value="<?php echo $component_styles['neigborhoodsComponent']['neigborhoods']['fontWeight'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" name="neighborhoodscomponent_neighborhoods_font-color" value="<?php echo $component_styles['neigborhoodsComponent']['neigborhoods']['fontColor'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="neighborhoodscomponent_neighborhoods_text-alignment">
                                <option <?php if ($component_styles['neigborhoodsComponent']['neigborhoods']['textAlignment'] == "right") echo 'selected'; ?> value="right">Right</option>
                                <option <?php if ($component_styles['neigborhoodsComponent']['neigborhoods']['textAlignment'] == "left") echo 'selected'; ?> value="left">Left</option>
                                <option <?php if ($component_styles['neigborhoodsComponent']['neigborhoods']['textAlignment'] == "center") echo 'selected'; ?> value="center">Center</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Color (Hovered)</label>
                            <input type="text" name="neighborhoodscomponent_neighborhoods_font-color-hovered" value="<?php echo $component_styles['neigborhoodsComponent']['neigborhoods']['fontColorHovered'] ?>">
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
                            <input type="number" name="mapembedcomponent_map_width" value="<?php echo $component_styles['mapEmbedComponent']['map']['width'] ?>">
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

                    <h4>Map</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Height (px)</label>
                            <input type="number" name="drivingdirectionscomponent_map_height" value="<?php echo $component_styles['drivingDirectionsComponent']['map']['height'] ?>">
                        </div>
                        <div class="input-group">
                            <label>Width (%)</label>
                            <input type="number" name="drivingdirectionscomponent_map_width" value="<?php echo $component_styles['drivingDirectionsComponent']['map']['width'] ?>">
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
                        <div class="input-group">
                            <label>Hover Effect</label>
                            <select name="reviewscomponent_items_hover-effect">
                                <option <?php if ($component_styles['reviewsComponent']['items']['hoverEffect'] == "scaleUp") echo 'selected'; ?> value="scaleUp">Scale Up</option>
                                <option <?php if ($component_styles['reviewsComponent']['items']['hoverEffect'] == "scaleDown") echo 'selected'; ?> value="scaleDown">Scale Down</option>
                                <option <?php if ($component_styles['reviewsComponent']['items']['hoverEffect'] == "rise") echo 'selected'; ?> value="rise">Rise</option>
                            </select>
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
}

?></div><div class="footer">
    <p>Powered by © <a href="http://seorockettools.com/" target="_blank">SEO Rocket Tools</a>, 2022 🚀.</p>
    <p><a href="https://github.com/francis150/geocentric#readme">Documentation</a> | <a href="http://support.seorockettools.com/">Support</a></p>
</div></div>