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
            <hr>

            <!-- <div class="summary">
                <h4>Quick jump to...</h4>
                <p>
                    <a href="#">General</a> |
                    <a href="#">Weather Component</a> |
                    <a href="#">About Component</a> |
                    <a href="#">Neighborhoods Component</a> |
                    <a href="#">Things to Do Component</a> |
                    <a href="#">Bus Stops Component</a> |
                    <a href="#">Map Embed Component</a> |
                    <a href="#">Driving Directions Component</a> |
                    <a href="#">Reviews Component</a>
                </p>
            </div> -->

            <form action="?page=_geocentric&tab=styling" method="POST">
                
                <div class="general-group group">
                    <h3>General</h3>
                    <div class="row">
                        <div class="input-group">
                            <label>Components Gap</label>
                            <input type="number" required name="general_component-gap">
                        </div>
                        <div class="input-group">
                            <label>Components Padding</label>
                            <input type="number" required name="general_component-padding">
                        </div>
                    </div>
                </div>

                <div class="weathercomponent-group group">
                    <h3>Weather Component</h3>
                    <div class="row">
                        <div class="input-group">
                            <label>Background Color</label>
                            <input type="text" required name="weathercomponent_background-color">
                        </div>
                        <div class="input-group">
                            <label>Text Color</label>
                            <input type="text" required name="weathercomponent_text-color">
                        </div>
                        <div class="input-group">
                            <label>Unit</label>
                            <select name="weathercomponent_unit">
                                <option selected value="fahrenheit">Fahrenheit</option>
                                <option value="celsius">Celsius</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="aboutcomponent-group group">
                    <h3>About Component</h3>

                    <h4>Title</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" required name="aboutcomponent_title_font-size">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" required name="aboutcomponent_title_font-weight">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" required name="aboutcomponent_title_font-color">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="aboutcomponent_title_text-alignment">
                                <option value="right">Right</option>
                                <option value="left">Left</option>
                                <option value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <h4>Content</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" required name="aboutcomponent_content_font-size">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" required name="aboutcomponent_content_font-weight">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" required name="aboutcomponent_content_font-color">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="aboutcomponent_content_text-alignment">
                                <option value="right">Right</option>
                                <option value="left">Left</option>
                                <option value="center">Center</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="neighborhoodscomponent-group group">
                    <h3>Neighborhoods Component</h3>

                    <h4>Title</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" required name="neighborhoodscomponent_title_font-size">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" required name="neighborhoodscomponent_title_font-weight">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" required name="neighborhoodscomponent_title_font-color">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="neighborhoodscomponent_title_text-alignment">
                                <option value="right">Right</option>
                                <option value="left">Left</option>
                                <option value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <h4>Neighborhoods</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" required name="neighborhoodscomponent_neighborhoods_font-size">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" required name="neighborhoodscomponent_neighborhoods_font-weight">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" required name="neighborhoodscomponent_neighborhoods_font-color">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="neighborhoodscomponent_neighborhoods_text-alignment">
                                <option value="right">Right</option>
                                <option value="left">Left</option>
                                <option value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <h4>Neighborhoods [Hovered]</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" required name="neighborhoodscomponent_neighborhoodshovered_font-size">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" required name="neighborhoodscomponent_neighborhoodshovered_font-weight">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" required name="neighborhoodscomponent_neighborhoodshovered_font-color">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="neighborhoodscomponent_neighborhoodshovered_text-alignment">
                                <option value="right">Right</option>
                                <option value="left">Left</option>
                                <option value="center">Center</option>
                            </select>
                        </div>
                    </div>

                </div>
                
                <div class="thingstodocomponent-group group">
                    <h3>Things to Do Component</h3>

                    <h4>Title</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" required name="thingstodocomponent_title_font-size">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" required name="thingstodocomponent_title_font-weight">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" required name="thingstodocomponent_title_font-color">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="thingstodocomponent_title_text-alignment">
                                <option value="right">Right</option>
                                <option value="left">Left</option>
                                <option value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <h4>Items</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Background Color</label>
                            <input type="text" required name="thingstodocomponent_items_background-color">
                        </div>
                        <div class="input-group">
                            <label>Border Color</label>
                            <input type="text" required name="thingstodocomponent_items_border-color">
                        </div>
                        <div class="input-group">
                            <label>Border Radius</label>
                            <input type="number" required name="thingstodocomponent_items_border-radius">
                        </div>
                        <div class="input-group">
                            <label>Border Width</label>
                            <input type="number" required name="thingstodocomponent_items_border-width">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <label>Gap</label>
                            <input type="number" required name="thingstodocomponent_items_gap">
                        </div>
                        <div class="input-group">
                            <label>Padding</label>
                            <input type="number" required name="thingstodocomponent_items_padding">
                        </div>
                        <div class="input-group">
                            <label>Hover Effect</label>
                            <select name="thingstodocomponent_items_hover-effect">
                                <option value="">Option 1</option>
                                <option value="">Option 2</option>
                                <option value="">Option 3</option>
                            </select>
                        </div>
                    </div>

                    <h4>Image</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Border Color</label>
                            <input type="text" required name="thingstodocomponent_image_border-color">
                        </div>
                        <div class="input-group">
                            <label>Border Radius</label>
                            <input type="text" required name="thingstodocomponent_image_border-radius">
                        </div>
                        <div class="input-group">
                            <label>Border Width</label>
                            <input type="text" required name="thingstodocomponent_image_border-width">
                        </div>
                    </div>

                    <h4>Item Name</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" required name="thingstodocomponent_itemname_font-size">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" required name="thingstodocomponent_itemname_font-weight">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" required name="thingstodocomponent_itemname_font-color">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="thingstodocomponent_itemname_text-alignment">
                                <option value="right">Right</option>
                                <option value="left">Left</option>
                                <option value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-group thingstodocomponent_showratings">
                        <input type="checkbox" required name="thingstodocomponent_showratings">
                        <label>Show ratings for each item?</label>
                    </div>

                </div>

                <div class="busstopscomponent-group group">
                    <h3>Bus Stops Component</h3>

                    <h4>Title</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" required name="busstopscomponent_title_font-size">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" required name="busstopscomponent_title_font-weight">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" required name="busstopscomponent_title_font-color">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="busstopscomponent_title_text-alignment">
                                <option value="right">Right</option>
                                <option value="left">Left</option>
                                <option value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <h4>Items</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Background Color</label>
                            <input type="text" required name="busstopscomponent_items_background-color">
                        </div>
                        <div class="input-group">
                            <label>Border Color</label>
                            <input type="text" required name="busstopscomponent_items_border-color">
                        </div>
                        <div class="input-group">
                            <label>Border Radius</label>
                            <input type="number" required name="busstopscomponent_items_border-radius">
                        </div>
                        <div class="input-group">
                            <label>Border Width</label>
                            <input type="number" required name="busstopscomponent_items_border-width">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <label>Gap</label>
                            <input type="number" required name="busstopscomponent_items_gap">
                        </div>
                        <div class="input-group">
                            <label>Padding</label>
                            <input type="number" required name="busstopscomponent_items_padding">
                        </div>
                        <div class="input-group">
                            <label>Hover Effect</label>
                            <select name="busstopscomponent_items_hover-effect">
                                <option value="">Option 1</option>
                                <option value="">Option 2</option>
                                <option value="">Option 3</option>
                            </select>
                        </div>
                    </div>

                    <h4>Item Name</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" required name="busstopscomponent_itemname_font-size">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" required name="busstopscomponent_itemname_font-weight">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" required name="busstopscomponent_itemname_font-color">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="busstopscomponent_itemname_text-alignment">
                                <option value="right">Right</option>
                                <option value="left">Left</option>
                                <option value="center">Center</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mapembedcomponent-group group">
                    <h3>Map Embed Component</h3>

                    <h4>Title</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" required name="mapembedcomponent_title_font-size">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" required name="mapembedcomponent_title_font-weight">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" required name="mapembedcomponent_title_font-color">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="mapembedcomponent_title_text-alignment">
                                <option value="right">Right</option>
                                <option value="left">Left</option>
                                <option value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <h4>Map</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Height (px)</label>
                            <input type="number" required name="mapembedcomponent_map_height">
                        </div>
                        <div class="input-group">
                            <label>Width (%)</label>
                            <input type="number" required name="mapembedcomponent_map_width">
                        </div>
                    </div>
                </div>

                <div class="drivingdirectionscomponent-group group">
                    <h3>Driving Directions Component</h3>

                    <h4>Title</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" required name="drivingdirectionscomponent_title_font-size">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" required name="drivingdirectionscomponent_title_font-weight">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" required name="drivingdirectionscomponent_title_font-color">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="drivingdirectionscomponent_title_text-alignment">
                                <option value="right">Right</option>
                                <option value="left">Left</option>
                                <option value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <h4>Map</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Height (px)</label>
                            <input type="number" required name="drivingdirectionscomponent_map_height">
                        </div>
                        <div class="input-group">
                            <label>Width (%)</label>
                            <input type="number" required name="drivingdirectionscomponent_map_width">
                        </div>
                    </div>
                </div>

                <div class="reviewscomponent-group group">
                    <h3>Reviews Component</h3>

                    <h4>Title</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" required name="reviewscomponent_title_font-size">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" required name="reviewscomponent_title_font-weight">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" required name="reviewscomponent_title_font-color">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="reviewscomponent_title_text-alignment">
                                <option value="right">Right</option>
                                <option value="left">Left</option>
                                <option value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <h4>Items</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Background Color</label>
                            <input type="text" required name="reviewscomponent_items_background-color">
                        </div>
                        <div class="input-group">
                            <label>Border Color</label>
                            <input type="text" required name="reviewscomponent_items_border-color">
                        </div>
                        <div class="input-group">
                            <label>Border Radius</label>
                            <input type="number" required name="reviewscomponent_items_border-radius">
                        </div>
                        <div class="input-group">
                            <label>Border Width</label>
                            <input type="number" required name="reviewscomponent_items_border-width">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <label>Gap</label>
                            <input type="number" required name="reviewscomponent_items_gap">
                        </div>
                        <div class="input-group">
                            <label>Padding</label>
                            <input type="number" required name="reviewscomponent_items_padding">
                        </div>
                        <div class="input-group">
                            <label>Hover Effect</label>
                            <select name="reviewscomponent_items_hover-effect">
                                <option value="">Option 1</option>
                                <option value="">Option 2</option>
                                <option value="">Option 3</option>
                            </select>
                        </div>
                    </div>

                    <h4>Author Name</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" required name="reviewscomponent_authorname_font-size">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" required name="reviewscomponent_authorname_font-weight">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" required name="reviewscomponent_authorname_font-color">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="reviewscomponent_authorname_text-alignment">
                                <option value="right">Right</option>
                                <option value="left">Left</option>
                                <option value="center">Center</option>
                            </select>
                        </div>
                    </div>

                    <h4>Review Body</h4>
                    <div class="row">
                        <div class="input-group">
                            <label>Font Size</label>
                            <input type="number" required name="reviewscomponent_reviewbody_font-size">
                        </div>
                        <div class="input-group">
                            <label>Font Weight</label>
                            <input type="number" required name="reviewscomponent_reviewbody_font-weight">
                        </div>
                        <div class="input-group">
                            <label>Font Color</label>
                            <input type="text" required name="reviewscomponent_reviewbody_font-color">
                        </div>
                        <div class="input-group">
                            <label>Text Alignment</label>
                            <select name="reviewscomponent_reviewbody_text-alignment">
                                <option value="right">Right</option>
                                <option value="left">Left</option>
                                <option value="center">Center</option>
                            </select>
                        </div>
                    </div>
                </div>

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