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

if (!$settingsController->settings_isset()) {
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
    <script type="module" src="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.55/dist/shoelace.js"></script>    

    <div class="_geocentric-main">

        <section class="overlay-form newlocation-form">
            <form action="#" method="POST">

                <!-- Hidden feilds -->
                <input type="text" style="display: none;" class="new_key" name="new_key">
                <input type="text" style="display: none;" class="edit_key" name="edit_key">
                <input type="text" style="display: none;" class="remove_key" name="remove_key">
                <input type="text" style="display: none;" class="mainlocation_key" name="mainlocation_key" value="">
                
                <input type="text" style="display: none;" class="city_name" name="city_name" value="">
                <input type="text" style="display: none;" class="state_name" name="state_name" value="">
                <input type="text" style="display: none;" class="country_name" name="country_name" value="">

                <input type="text" style="display: none;" class="is_primary" name="is_primary">

                <div class="head">
                    <h2>...</h2>
                    <sl-icon-button class="close-button" name="x-lg" label="Close"></sl-icon-button>
                </div>

                <sl-divider></sl-divider>

                <div class="three-col-div">

                    <div class="input-wrapper">
                        <label>Country <span>*</span></label>
                        <select class="country" autocomplete="on" name="country_code" required>
                            <option value="" selected disabled>Choose a country...</option>
                            <option value="US">United States</option>
                            <option value="AF">Afghanistan</option>
                            <option value="AX">Aland Islands</option>
                            <option value="AL">Albania</option>
                            <option value="DZ">Algeria</option>
                            <option value="AS">American Samoa</option>
                            <option value="AD">Andorra</option>
                            <option value="AO">Angola</option>
                            <option value="AI">Anguilla</option>
                            <option value="AQ">Antarctica</option>
                            <option value="AG">Antigua And Barbuda</option>
                            <option value="AR">Argentina</option>
                            <option value="AM">Armenia</option>
                            <option value="AW">Aruba</option>
                            <option value="AU">Australia</option>
                            <option value="AT">Austria</option>
                            <option value="AZ">Azerbaijan</option>
                            <option value="BS">Bahamas The</option>
                            <option value="BH">Bahrain</option>
                            <option value="BD">Bangladesh</option>
                            <option value="BB">Barbados</option>
                            <option value="BY">Belarus</option>
                            <option value="BE">Belgium</option>
                            <option value="BZ">Belize</option>
                            <option value="BJ">Benin</option>
                            <option value="BM">Bermuda</option>
                            <option value="BT">Bhutan</option>
                            <option value="BO">Bolivia</option>
                            <option value="BA">Bosnia and Herzegovina</option>
                            <option value="BW">Botswana</option>
                            <option value="BV">Bouvet Island</option>
                            <option value="BR">Brazil</option>
                            <option value="IO">British Indian Ocean Territory</option>
                            <option value="BN">Brunei</option>
                            <option value="BG">Bulgaria</option>
                            <option value="BF">Burkina Faso</option>
                            <option value="BI">Burundi</option>
                            <option value="KH">Cambodia</option>
                            <option value="CM">Cameroon</option>
                            <option value="CA">Canada</option>
                            <option value="CV">Cape Verde</option>
                            <option value="KY">Cayman Islands</option>
                            <option value="CF">Central African Republic</option>
                            <option value="TD">Chad</option>
                            <option value="CL">Chile</option>
                            <option value="CN">China</option>
                            <option value="CX">Christmas Island</option>
                            <option value="CC">Cocos (Keeling) Islands</option>
                            <option value="CO">Colombia</option>
                            <option value="KM">Comoros</option>
                            <option value="CG">Congo</option>
                            <option value="CD">Democratic Republic of the Congo</option>
                            <option value="CK">Cook Islands</option>
                            <option value="CR">Costa Rica</option>
                            <option value="CI">Cote D'Ivoire (Ivory Coast)</option>
                            <option value="HR">Croatia</option>
                            <option value="CU">Cuba</option>
                            <option value="CY">Cyprus</option>
                            <option value="CZ">Czech Republic</option>
                            <option value="DK">Denmark</option>
                            <option value="DJ">Djibouti</option>
                            <option value="DM">Dominica</option>
                            <option value="DO">Dominican Republic</option>
                            <option value="TL">East Timor</option>
                            <option value="EC">Ecuador</option>
                            <option value="EG">Egypt</option>
                            <option value="SV">El Salvador</option>
                            <option value="GQ">Equatorial Guinea</option>
                            <option value="ER">Eritrea</option>
                            <option value="EE">Estonia</option>
                            <option value="ET">Ethiopia</option>
                            <option value="FK">Falkland Islands</option>
                            <option value="FO">Faroe Islands</option>
                            <option value="FJ">Fiji Islands</option>
                            <option value="FI">Finland</option>
                            <option value="FR">France</option>
                            <option value="GF">French Guiana</option>
                            <option value="PF">French Polynesia</option>
                            <option value="TF">French Southern Territories</option>
                            <option value="GA">Gabon</option>
                            <option value="GM">Gambia The</option>
                            <option value="GE">Georgia</option>
                            <option value="DE">Germany</option>
                            <option value="GH">Ghana</option>
                            <option value="GI">Gibraltar</option>
                            <option value="GR">Greece</option>
                            <option value="GL">Greenland</option>
                            <option value="GD">Grenada</option>
                            <option value="GP">Guadeloupe</option>
                            <option value="GU">Guam</option>
                            <option value="GT">Guatemala</option>
                            <option value="GG">Guernsey and Alderney</option>
                            <option value="GN">Guinea</option>
                            <option value="GW">Guinea-Bissau</option>
                            <option value="GY">Guyana</option>
                            <option value="HT">Haiti</option>
                            <option value="HM">Heard Island and McDonald Islands</option>
                            <option value="HN">Honduras</option>
                            <option value="HK">Hong Kong S.A.R.</option>
                            <option value="HU">Hungary</option>
                            <option value="IS">Iceland</option>
                            <option value="IN">India</option>
                            <option value="ID">Indonesia</option>
                            <option value="IR">Iran</option>
                            <option value="IQ">Iraq</option>
                            <option value="IE">Ireland</option>
                            <option value="IL">Israel</option>
                            <option value="IT">Italy</option>
                            <option value="JM">Jamaica</option>
                            <option value="JP">Japan</option>
                            <option value="JE">Jersey</option>
                            <option value="JO">Jordan</option>
                            <option value="KZ">Kazakhstan</option>
                            <option value="KE">Kenya</option>
                            <option value="KI">Kiribati</option>
                            <option value="KP">North Korea</option>
                            <option value="KR">South Korea</option>
                            <option value="KW">Kuwait</option>
                            <option value="KG">Kyrgyzstan</option>
                            <option value="LA">Laos</option>
                            <option value="LV">Latvia</option>
                            <option value="LB">Lebanon</option>
                            <option value="LS">Lesotho</option>
                            <option value="LR">Liberia</option>
                            <option value="LY">Libya</option>
                            <option value="LI">Liechtenstein</option>
                            <option value="LT">Lithuania</option>
                            <option value="LU">Luxembourg</option>
                            <option value="MO">Macau S.A.R.</option>
                            <option value="MK">Macedonia</option>
                            <option value="MG">Madagascar</option>
                            <option value="MW">Malawi</option>
                            <option value="MY">Malaysia</option>
                            <option value="MV">Maldives</option>
                            <option value="ML">Mali</option>
                            <option value="MT">Malta</option>
                            <option value="IM">Man (Isle of)</option>
                            <option value="MH">Marshall Islands</option>
                            <option value="MQ">Martinique</option>
                            <option value="MR">Mauritania</option>
                            <option value="MU">Mauritius</option>
                            <option value="YT">Mayotte</option>
                            <option value="MX">Mexico</option>
                            <option value="FM">Micronesia</option>
                            <option value="MD">Moldova</option>
                            <option value="MC">Monaco</option>
                            <option value="MN">Mongolia</option>
                            <option value="ME">Montenegro</option>
                            <option value="MS">Montserrat</option>
                            <option value="MA">Morocco</option>
                            <option value="MZ">Mozambique</option>
                            <option value="MM">Myanmar</option>
                            <option value="NA">Namibia</option>
                            <option value="NR">Nauru</option>
                            <option value="NP">Nepal</option>
                            <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                            <option value="NL">Netherlands</option>
                            <option value="NC">New Caledonia</option>
                            <option value="NZ">New Zealand</option>
                            <option value="NI">Nicaragua</option>
                            <option value="NE">Niger</option>
                            <option value="NG">Nigeria</option>
                            <option value="NU">Niue</option>
                            <option value="NF">Norfolk Island</option>
                            <option value="MP">Northern Mariana Islands</option>
                            <option value="NO">Norway</option>
                            <option value="OM">Oman</option>
                            <option value="PK">Pakistan</option>
                            <option value="PW">Palau</option>
                            <option value="PS">Palestinian Territory Occupied</option>
                            <option value="PA">Panama</option>
                            <option value="PG">Papua new Guinea</option>
                            <option value="PY">Paraguay</option>
                            <option value="PE">Peru</option>
                            <option value="PH">Philippines</option>
                            <option value="PN">Pitcairn Island</option>
                            <option value="PL">Poland</option>
                            <option value="PT">Portugal</option>
                            <option value="PR">Puerto Rico</option>
                            <option value="QA">Qatar</option>
                            <option value="RE">Reunion</option>
                            <option value="RO">Romania</option>
                            <option value="RU">Russia</option>
                            <option value="RW">Rwanda</option>
                            <option value="SH">Saint Helena</option>
                            <option value="KN">Saint Kitts And Nevis</option>
                            <option value="LC">Saint Lucia</option>
                            <option value="PM">Saint Pierre and Miquelon</option>
                            <option value="VC">Saint Vincent And The Grenadines</option>
                            <option value="BL">Saint-Barthelemy</option>
                            <option value="MF">Saint-Martin (French part)</option>
                            <option value="WS">Samoa</option>
                            <option value="SM">San Marino</option>
                            <option value="ST">Sao Tome and Principe</option>
                            <option value="SA">Saudi Arabia</option>
                            <option value="SN">Senegal</option>
                            <option value="RS">Serbia</option>
                            <option value="SC">Seychelles</option>
                            <option value="SL">Sierra Leone</option>
                            <option value="SG">Singapore</option>
                            <option value="SK">Slovakia</option>
                            <option value="SI">Slovenia</option>
                            <option value="SB">Solomon Islands</option>
                            <option value="SO">Somalia</option>
                            <option value="ZA">South Africa</option>
                            <option value="GS">South Georgia</option>
                            <option value="SS">South Sudan</option>
                            <option value="ES">Spain</option>
                            <option value="LK">Sri Lanka</option>
                            <option value="SD">Sudan</option>
                            <option value="SR">Suriname</option>
                            <option value="SJ">Svalbard And Jan Mayen Islands</option>
                            <option value="SZ">Swaziland</option>
                            <option value="SE">Sweden</option>
                            <option value="CH">Switzerland</option>
                            <option value="SY">Syria</option>
                            <option value="TW">Taiwan</option>
                            <option value="TJ">Tajikistan</option>
                            <option value="TZ">Tanzania</option>
                            <option value="TH">Thailand</option>
                            <option value="TG">Togo</option>
                            <option value="TK">Tokelau</option>
                            <option value="TO">Tonga</option>
                            <option value="TT">Trinidad And Tobago</option>
                            <option value="TN">Tunisia</option>
                            <option value="TR">Turkey</option>
                            <option value="TM">Turkmenistan</option>
                            <option value="TC">Turks And Caicos Islands</option>
                            <option value="TV">Tuvalu</option>
                            <option value="UG">Uganda</option>
                            <option value="UA">Ukraine</option>
                            <option value="AE">United Arab Emirates</option>
                            <option value="GB">United Kingdom</option>
                            <option value="UM">United States Minor Outlying Islands</option>
                            <option value="UY">Uruguay</option>
                            <option value="UZ">Uzbekistan</option>
                            <option value="VU">Vanuatu</option>
                            <option value="VA">Vatican City State (Holy See)</option>
                            <option value="VE">Venezuela</option>
                            <option value="VN">Vietnam</option>
                            <option value="VG">Virgin Islands (British)</option>
                            <option value="VI">Virgin Islands (US)</option>
                            <option value="WF">Wallis And Futuna Islands</option>
                            <option value="EH">Western Sahara</option>
                            <option value="YE">Yemen</option>
                            <option value="ZM">Zambia</option>
                            <option value="ZW">Zimbabwe</option>
                            <option value="XK">Kosovo</option>
                            <option value="CW">Curaçao</option>
                            <option value="SX">Sint Maarten (Dutch part)</option>
                        </select>
                    </div>

                    <div class="input-wrapper">
                        <label>State <span>*</span></label>
                        <select class="state" autocomplete="on" name="state_code" required>
                            <option value="" selected disabled>---</option>
                        </select>
                    </div>

                    <div class="input-wrapper">
                        <label>City/Town <span>*</span></label>
                        <select class="city" autocomplete="on" name="city_id" required>
                            <option value="" selected disabled>---</option>
                        </select>
                    </div>

                </div>

                <div class="one-col-div">
                    <div class="input-wrapper">
                        <label>Neighbourhoods</label>
                        <textarea name="neighborhood" class="neighborhood" rows="5"></textarea>
                        <small>These are the available neighbourhoods for this area on our database. You can manually add or edit them by entering your neighbourhoods here. Enter them properly and separate each with comma(,)</small>
                    </div>
                </div>

                <div class="pinpoint-address">
                    <div class="one-col-div place_id">
                        <div class="input-wrapper">
                            <label>Google Maps Place ID</label>
                            <input class="google_maps_place_id" name="google_maps_place_id" type="text">
                            <small>If you have physical branch in this area, you can manually enter either the Google Maps Place ID or tick the checkbox below to use street address and zip code.</small>
                        </div>
                    </div>

                    <div class="two-col-div street_address_zipcode">
                        <div class="input-wrapper">
                            <label>Street Address <span>*</span></label>
                            <input class="street_address" name="street_address" type="text">
                        </div>

                        <div class="input-wrapper">
                            <label>ZIP Code <span>*</span></label>
                            <input class="zip_code" name="zip_code" type="text">
                        </div>
                    </div>

                    <input type="checkbox" class="place_id_unavailable" name="place_id_unavailable" /><span>Use <b>street address</b> and <b>zip code</b>.</span>
                </div>

                <div class="bottom">
                    <input class="_location-form-submit" name="_location-form-submit" type="submit" />
                </div>

            </form>
        </section>

        <section class="overlay-form loading-screen">
            <div class="wrapper">
                <img src="<?php echo $pluginConfigController->get_plugin_logo_small(); ?>" class="logo">
                <div><sl-spinner style="font-size: 1.2rem;"></sl-spinner> <p>...</p></div>
            </div>
        </section>
        
        <section class="main-view-wrapper">
            <img src="<?php echo $pluginConfigController->get_plugin_logo_small(); ?>" class="main-screen-logo">

            <sl-tab-group class="main-tab-group">
                <sl-tab slot="nav" panel="locations" active>Locations</sl-tab>
                <sl-tab slot="nav" panel="design">Design</sl-tab>
                <sl-tab slot="nav" panel="settings">Settings</sl-tab>

                <sl-tab-panel name="locations" class="locations-panel">
                    <div class="head">
                        <p>Embed your shortcodes to your service area pages.</p>
                        <sl-tooltip content="Add Service Area">
                            <sl-icon-button class="add-location-button" name="plus-lg" label="Add Service Area"></sl-icon-button>
                        </sl-tooltip>
                        <button class="_geocentric_import_all_data" 
                        data-site_domain="<?php echo get_site_url(); ?>" 
                        data-google_api_key="<?php echo $settings['google_api_key']; ?>" 
                        data-api_server_url="<?php echo $config_data['server_url']; ?>" 
                        data-appsero_api_key="<?php echo $config_data['appsero_api_key']; ?>" 
                        data-appsero_plugin_name="<?php echo $config_data['appsero_plugin_name']; ?>" 
                        ><sl-icon name="cloud-download"></sl-icon>Import All Data</button>
                    </div>
                    <div class="locations-list">

                        <?php
                            if (!empty($userInputDataController->get_userinput_data())) {
                                foreach ($userInputDataController->get_userinput_data() as $serviceArea) {
                                    ?>
                                    <div class="location-item" 
                                    data-id="<?php echo $serviceArea['id']; ?>" 
                                    data-city_name="<?php echo $serviceArea['city']['name']; ?>" 
                                    data-city_id="<?php echo $serviceArea['city']['id']; ?>" 
                                    data-state_name="<?php echo $serviceArea['state']['name']; ?>" 
                                    data-state_code="<?php echo $serviceArea['state']['code']; ?>" 
                                    data-country_name="<?php echo $serviceArea['country']['name']; ?>" 
                                    data-country_iso2="<?php echo $serviceArea['country']['iso2']; ?>" 
                                    
                                    <?php
                                    if(isset($serviceArea['neighbourhoods'])) {
                                        ?>
                                        data-neighbourhoods="<?php echo implode(", ", $serviceArea['neighbourhoods']); ?>"
                                        <?php
                                    }

                                    if(isset($serviceArea['google_place_id'])) {
                                        ?>
                                        data-google_place_id="<?php echo $serviceArea['google_place_id']; ?>"
                                        <?php
                                    }

                                    if(isset($serviceArea['street'])) {
                                        ?>
                                        data-street="<?php echo $serviceArea['street']; ?>"
                                        <?php
                                    }

                                    if(isset($serviceArea['zip_code'])) {
                                        ?>
                                        data-zip_code="<?php echo $serviceArea['zip_code']; ?>"
                                        <?php
                                    }

                                    if (isset($serviceArea['primaryLocation'])) {
                                        ?>
                                        data-primary_location="true" 
                                        <?php
                                    }
                                    ?>

                                    >
                                        <sl-icon name="<?php echo isset($serviceArea['primaryLocation']) ? 'geo-alt-fill' : ''; ?>"></sl-icon>
                                        <p><?php echo "{$serviceArea['city']['name']}, {$serviceArea['state']['code']} ({$serviceArea['country']['name']})"; ?></p>
                                        <?php echo $apiDataController->api_data_is_available($serviceArea['id']) ? '<span class="available">Available</span>' : '<span class="unavailable">Not Available</span>'; ?>
                                        <sl-dropdown class="shortcodes-dropdown" <?php echo !$apiDataController->api_data_is_available($serviceArea['id']) ? 'disabled' : '' ?>>
                                            <sl-tooltip slot="trigger" content="Shortcodes">
                                                <sl-icon-button <?php echo !$apiDataController->api_data_is_available($serviceArea['id']) ? 'disabled' : '' ?> name="code-slash" label="Shortcodes"></sl-icon-button>
                                            </sl-tooltip>
                                            <sl-menu>
                                                <sl-menu-label>Click to Copy</sl-menu-label>
                                                <sl-menu-item data-shortcode="[geocentric-weather id=&quot;<?php echo $serviceArea['id']; ?>&quot;]">[geocentric-weather id="..."/]</sl-menu-item>
                                                <sl-menu-item data-shortcode="[geocentric-about id=&quot;<?php echo $serviceArea['id']; ?>&quot;]">[geocentric-about id="..."/]</sl-menu-item>
                                                <sl-menu-item data-shortcode="[geocentric-neighbourhoods id=&quot;<?php echo $serviceArea['id']; ?>&quot;]">[geocentric-neighbourhoods id="..."/]</sl-menu-item>
                                                <sl-menu-item data-shortcode="[geocentric-thingstodo id=&quot;<?php echo $serviceArea['id']; ?>&quot;]">[geocentric-thingstodo id="..."/]</sl-menu-item>
                                                <sl-menu-item data-shortcode="[geocentric-mapembed id=&quot;<?php echo $serviceArea['id']; ?>&quot;]">[geocentric-mapembed id="..."/]</sl-menu-item>
                                                <sl-menu-item data-shortcode="[geocentric-drivingdirections id=&quot;<?php echo $serviceArea['id']; ?>&quot;]">[geocentric-drivingdirections id="..."/]</sl-menu-item>
                                                <sl-menu-item data-shortcode="[geocentric-reviews id=&quot;<?php echo $serviceArea['id']; ?>&quot;]">[geocentric-reviews id="..."/]</sl-menu-item>
                                                <sl-divider></sl-divider>
                                                <sl-menu-item data-shortcode="[geocentric-weather id=&quot;<?php echo $serviceArea['id']; ?>&quot;][geocentric-about id=&quot;<?php echo $serviceArea['id']; ?>&quot;][geocentric-neighbourhoods id=&quot;<?php echo $serviceArea['id']; ?>&quot;][geocentric-thingstodo id=&quot;<?php echo $serviceArea['id']; ?>&quot;][geocentric-mapembed id=&quot;<?php echo $serviceArea['id']; ?>&quot;][geocentric-drivingdirections id=&quot;<?php echo $serviceArea['id']; ?>&quot;][geocentric-reviews id=&quot;<?php echo $serviceArea['id']; ?>&quot;]">
                                                    Copy All Components
                                                </sl-menu-item>
                                            </sl-menu>
                                        </sl-dropdown>
                                        <sl-dropdown class="moreoptions-dropdown">
                                            <sl-icon-button name="three-dots-vertical" label="More Options" slot="trigger"></sl-icon-button>
                                            <sl-menu>
                                                <sl-menu-item class="edit-location-button">Edit<sl-icon slot="prefix" name="pencil-square"></sl-icon></sl-menu-item>
                                                <sl-menu-item class="remove-location-button">Remove<sl-icon slot="prefix" name="trash"></sl-icon></sl-menu-item>
                                                <sl-divider></sl-divider>
                                                <sl-menu-item class="import-data-button" 
                                                data-site_domain="<?php echo get_site_url(); ?>" 
                                                data-google_api_key="<?php echo $settings['google_api_key']; ?>" 
                                                data-api_server_url="<?php echo $config_data['server_url']; ?>" 
                                                data-appsero_api_key="<?php echo $config_data['appsero_api_key']; ?>" 
                                                data-appsero_plugin_name="<?php echo $config_data['appsero_plugin_name']; ?>"
                                                >Import Data<sl-icon slot="prefix" name="cloud-download"></sl-icon></sl-menu-item>
                                                <sl-menu-item class="main-location-button">Set as Primary Location<sl-icon slot="prefix" name="geo-alt-fill"></sl-icon></sl-menu-item>
                                            </sl-menu>
                                        </sl-dropdown>
                                    </div>
                                    <?php
                                }
                            } else {echo '<p class="placeholder">No Service Areas added yet...</p>';}
                        ?>

                    </div>
                </sl-tab-panel>

                <sl-tab-panel name="design" class="design-panel">
                    <form action="#" method="POST">

                        <div class="head">
                            <p>You can style the Rank Geo Sections here.</p>
                            <input type="submit" name="_style-form-update" class="style-form-update" value="Save Style Changes"/>
                        </div>

                        <sl-details summary="Weather Section">
                            <div class="four-col-div">
                                <div class="input-wrapper">
                                    <label>Background Color</label>
                                    <input type="text" name="wsBackgroundColor" placeholder="#00000000" value="<?php echo $component_styles['weatherSection']['backgroundColor']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Text Color</label>
                                    <input type="text" name="wsTextColor" placeholder="#00000000" value="<?php echo $component_styles['weatherSection']['accentColor']; ?>">
                                </div>
                            </div>
                        </sl-details>

                        <sl-details summary="About Section">
                            <h3>Title</h3>
                            <div class="four-col-div">
                                <div class="input-wrapper">
                                    <label>Font Size</label>
                                    <input type="number" name="asTitleFontSize" value="<?php echo $component_styles['aboutSection']['title']['fontSize']; ?>" placeholder="36">
                                </div>
                                <div class="input-wrapper">
                                    <label>Font Weight</label>
                                    <input type="number" name="asTitleFontWeight" value="<?php echo $component_styles['aboutSection']['title']['fontWeight']; ?>" placeholder="500">
                                </div>
                                <div class="input-wrapper">
                                    <label>Font Color</label>
                                    <input type="text" name="asTitleFontColor" value="<?php echo $component_styles['aboutSection']['title']['fontColor']; ?>" placeholder="#00000000">
                                </div>
                                <div class="input-wrapper">
                                    <label>Text Alignment</label>
                                    <select name="asTitleTextAligment" value="<?php echo $component_styles['aboutSection']['title']['textAlignment']; ?>">
                                        <option value="center" <?php if($component_styles['aboutSection']['title']['textAlignment'] == "center") echo "selected"; ?>>Center</option>
                                        <option value="right" <?php if($component_styles['aboutSection']['title']['textAlignment'] == "right") echo "selected"; ?>>Right</option>
                                        <option value="left" <?php if($component_styles['aboutSection']['title']['textAlignment'] == "left") echo "selected"; ?>>Left</option>
                                    </select>
                                </div>
                            </div>

                            <h3>Content</h3>
                            <div class="four-col-div">
                                <div class="input-wrapper">
                                    <label>Font Size</label>
                                    <input type="number" name="asContentFontSize" placeholder="16" value="<?php echo $component_styles['aboutSection']['content']['fontSize']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Font Weight</label>
                                    <input type="number" name="asContentFontWeight" placeholder="400" value="<?php echo $component_styles['aboutSection']['content']['fontWeight']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Font Color</label>
                                    <input type="text" name="asContentFontColor" placeholder="#00000000" value="<?php echo $component_styles['aboutSection']['content']['fontColor']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Text Alignment</label>
                                    <select name="asContentTextAligment" value="<?php echo $component_styles['aboutSection']['content']['textAlignment']; ?>">
                                        <option value="center" <?php if($component_styles['aboutSection']['content']['textAlignment'] == "center") echo "selected"; ?>>Center</option>
                                        <option value="right" <?php if($component_styles['aboutSection']['content']['textAlignment'] == "right") echo "selected"; ?>>Right</option>
                                        <option value="left" <?php if($component_styles['aboutSection']['content']['textAlignment'] == "left") echo "selected"; ?>>Left</option>
                                        <option value="justify" <?php if($component_styles['aboutSection']['content']['textAlignment'] == "justify") echo "selected"; ?>>Justify</option>
                                    </select>
                                </div>
                            </div>
                        </sl-details>

                        <sl-details summary="Neighborhoods">
                            <h3>Title</h3>
                            <div class="four-col-div">
                                <div class="input-wrapper">
                                    <label>Font Size</label>
                                    <input type="number" name="nhTitleFontSize" placeholder="36" value="<?php echo $component_styles['neighborhoods']['title']['fontSize']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Font Weight</label>
                                    <input type="number" name="nhTitleFontWeight" placeholder="500" value="<?php echo $component_styles['neighborhoods']['title']['fontWeight']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Font Color</label>
                                    <input type="text" name="nhTitleFontColor" placeholder="#00000000" value="<?php echo $component_styles['neighborhoods']['title']['fontColor']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Text Alignment</label>
                                    <select name="nhTitleTextAligment" value="<?php echo $component_styles['neighborhoods']['title']['textAlignment']; ?>">
                                        <option value="center" <?php if($component_styles['neighborhoods']['title']['textAlignment'] == "center") echo "selected"; ?>>Center</option>
                                        <option value="right" <?php if($component_styles['neighborhoods']['title']['textAlignment'] == "right") echo "selected"; ?>>Right</option>
                                        <option value="left" <?php if($component_styles['neighborhoods']['title']['textAlignment'] == "left") echo "selected"; ?>>Left</option>
                                    </select>
                                </div>
                            </div>

                            <h3>Neighborhoods Link</h3>
                            <div class="four-col-div">
                                <div class="input-wrapper">
                                    <label>Font Size</label>
                                    <input type="number" name="nhLinksFontSize" placeholder="16" value="<?php echo $component_styles['neighborhoods']['neighborhoods']['fontSize']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Font Weight</label>
                                    <input type="number" name="nhLinksFontWeight" placeholder="400" value="<?php echo $component_styles['neighborhoods']['neighborhoods']['fontWeight']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Font Color</label>
                                    <input type="text" name="nhLinksFontColor" placeholder="#00000000" value="<?php echo $component_styles['neighborhoods']['neighborhoods']['fontColor']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Font Color [Hovered]</label>
                                    <input type="text" name="nhLinksHoveredFontColor" placeholder="#00000000" value="<?php echo $component_styles['neighborhoods']['neighborhoods']['fontColorHovered']; ?>">
                                </div>
                            </div>
                            <div class="four-col-div">
                                <div class="input-wrapper">
                                    <label>Text Alignment</label>
                                    <select name="nhLinksTextAligment" value="<?php echo $component_styles['neighborhoods']['neighborhoods']['textAlignment']; ?>">
                                        <option value="center" <?php if($component_styles['neighborhoods']['neighborhoods']['textAlignment'] == "center") echo "selected"; ?>>Center</option>
                                        <option value="right" <?php if($component_styles['neighborhoods']['neighborhoods']['textAlignment'] == "right") echo "selected"; ?>>Right</option>
                                        <option value="left" <?php if($component_styles['neighborhoods']['neighborhoods']['textAlignment'] == "left") echo "selected"; ?>>Left</option>
                                    </select>
                                </div>
                            </div>
                        </sl-details>

                        <sl-details summary="Things To Do">

                            <h3>Title</h3>
                            <div class="four-col-div">
                                <div class="input-wrapper">
                                    <label>Font Size</label>
                                    <input type="number" name="ttdTitleFontSize" placeholder="36" value="<?php echo $component_styles['thingsToDo']['title']['fontSize']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Font Weight</label>
                                    <input type="number" name="ttdTitleFontWeight" placeholder="500" value="<?php echo $component_styles['thingsToDo']['title']['fontWeight']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Font Color</label>
                                    <input type="text" name="ttdTitleFontColor" placeholder="#00000000" value="<?php echo $component_styles['thingsToDo']['title']['fontColor']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Text Alignment</label>
                                    <select name="ttdTitleTextAligment" value="<?php echo $component_styles['thingsToDo']['title']['textAlignment']; ?>">
                                        <option value="center" <?php if($component_styles['thingsToDo']['title']['textAlignment'] == "center") echo "selected"; ?>>Center</option>
                                        <option value="right" <?php if($component_styles['thingsToDo']['title']['textAlignment'] == "right") echo "selected"; ?>>Right</option>
                                        <option value="left" <?php if($component_styles['thingsToDo']['title']['textAlignment'] == "left") echo "selected"; ?>>Left</option>
                                    </select>
                                </div>
                            </div>

                            <h3>Items</h3>
                            <div class="four-col-div">
                                <div class="input-wrapper">
                                    <label>Padding</label>
                                    <input type="number" name="ttdItemsPadding" placeholder="20" value="<?php echo $component_styles['thingsToDo']['items']['padding']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Gap</label>
                                    <input type="number" name="ttdItemsGap" placeholder="20" value="<?php echo $component_styles['thingsToDo']['items']['gap']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Background Color</label>
                                    <input type="text" name="ttdItemsBackgroundColor" placeholder="#00000000" value="<?php echo $component_styles['thingsToDo']['items']['backgroundColor']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Hover Effect</label>
                                    <select name="ttdItemsHoverEffect" value="<?php echo $component_styles['thingsToDo']['items']['hoverEffect']; ?>">
                                        <option value="scaleUp" <?php if($component_styles['thingsToDo']['items']['hoverEffect'] == "scaleUp") echo "selected"; ?>>Scale Up</option>
                                        <option value="scaleDown" <?php if($component_styles['thingsToDo']['items']['hoverEffect'] == "scaleDown") echo "selected"; ?>>Scale Down</option>
                                        <option value="rise" <?php if($component_styles['thingsToDo']['items']['hoverEffect'] == "rise") echo "selected"; ?>>Rise</option>
                                    </select>
                                </div>
                            </div>
                            <div class="four-col-div">
                                <div class="input-wrapper">
                                    <label>Border Radius</label>
                                    <input type="number" name="ttdItemsBorderRadius" placeholder="5" value="<?php echo $component_styles['thingsToDo']['items']['borderRadius']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Border Width</label>
                                    <input type="number" name="ttdItemsBorderWidth" placeholder="1" value="<?php echo $component_styles['thingsToDo']['items']['borderWidth']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Border Color</label>
                                    <input type="text" name="ttdItemsBorderColor" placeholder="#00000000" value="<?php echo $component_styles['thingsToDo']['items']['borderColor']; ?>">
                                </div>
                            </div>

                            <h3>Image</h3>
                            <div class="four-col-div">
                                <div class="input-wrapper">
                                    <label>Border Radius</label>
                                    <input type="number" name="ttdImageBorderRadius" placeholder="5" value="<?php echo $component_styles['thingsToDo']['image']['borderRadius']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Border Width</label>
                                    <input type="number" name="ttdImageBorderWidth" placeholder="0" value="<?php echo $component_styles['thingsToDo']['image']['borderWidth']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Border Color</label>
                                    <input type="text" name="ttdImageBorderColor" placeholder="#00000000" value="<?php echo $component_styles['thingsToDo']['image']['borderColor']; ?>">
                                </div>
                            </div>

                            <h3>Name</h3>
                            <div class="four-col-div">
                                <div class="input-wrapper">
                                    <label>Font Size</label>
                                    <input type="number" name="ttdNameFontSize" placeholder="16" value="<?php echo $component_styles['thingsToDo']['name']['fontSize']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Font Weight</label>
                                    <input type="number" name="ttdNameFontWeight" placeholder="400" value="<?php echo $component_styles['thingsToDo']['name']['fontWeight']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Font Color</label>
                                    <input type="text" name="ttdNameFontColor" placeholder="#00000000" value="<?php echo $component_styles['thingsToDo']['name']['fontColor']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Text Alignment</label>
                                    <select name="ttdNameTextAligment" value="<?php echo $component_styles['thingsToDo']['name']['textAlignment']; ?>">
                                        <option value="center" <?php if($component_styles['thingsToDo']['name']['textAlignment'] == "center") echo "selected"; ?>>Center</option>
                                        <option value="right" <?php if($component_styles['thingsToDo']['name']['textAlignment'] == "right") echo "selected"; ?>>Right</option>
                                        <option value="left" <?php if($component_styles['thingsToDo']['name']['textAlignment'] == "left") echo "selected"; ?>>Left</option>
                                    </select>
                                </div>
                            </div>

                        </sl-details>

                        <sl-details summary="Map Embed">

                            <h3>Title</h3>
                            <div class="four-col-div">
                                <div class="input-wrapper">
                                    <label>Font Size</label>
                                    <input type="number" name="meTitleFontSize" placeholder="36" value="<?php echo $component_styles['mapEmbed']['title']['fontSize']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Font Weight</label>
                                    <input type="number" name="meTitleFontWeight" placeholder="500" value="<?php echo $component_styles['mapEmbed']['title']['fontWeight']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Font Color</label>
                                    <input type="text" name="meTitleFontColor" placeholder="#00000000" value="<?php echo $component_styles['mapEmbed']['title']['fontColor']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Text Alignment</label>
                                    <select name="meTitleTextAligment" value="<?php echo $component_styles['mapEmbed']['title']['textAlignment']; ?>">
                                        <option value="center" <?php if($component_styles['mapEmbed']['title']['textAlignment'] == "center") echo "selected"; ?>>Center</option>
                                        <option value="right" <?php if($component_styles['mapEmbed']['title']['textAlignment'] == "right") echo "selected"; ?>>Right</option>
                                        <option value="left" <?php if($component_styles['mapEmbed']['title']['textAlignment'] == "left") echo "selected"; ?>>Left</option>
                                    </select>
                                </div>
                            </div>

                            <h3>Map</h3>
                            <div class="four-col-div">
                                <div class="input-wrapper">
                                    <label>Height (px)</label>
                                    <input type="number" name="meMapHeight" placeholder="400" value="<?php echo $component_styles['mapEmbed']['map']['height']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Width (%)</label>
                                    <input min="10" max="100" type="number" name="meMapWidth" placeholder="100" value="<?php echo $component_styles['mapEmbed']['map']['width']; ?>">
                                </div>
                            </div>
                        </sl-details>

                        <sl-details summary="Driving Directions">
                            <h3>Title</h3>
                            <div class="four-col-div">
                                <div class="input-wrapper">
                                    <label>Font Size</label>
                                    <input type="number" name="ddTitleFontSize" placeholder="36" value="<?php echo $component_styles['drivingDirections']['title']['fontSize']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Font Weight</label>
                                    <input type="number" name="ddTitleFontWeight" placeholder="500" value="<?php echo $component_styles['drivingDirections']['title']['fontWeight']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Font Color</label>
                                    <input type="text" name="ddTitleFontColor" placeholder="#00000000" value="<?php echo $component_styles['drivingDirections']['title']['fontColor']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Text Alignment</label>
                                    <select name="ddTitleTextAligment" value="<?php echo $component_styles['drivingDirections']['title']['textAlignment']; ?>">
                                        <option value="center" <?php if($component_styles['drivingDirections']['title']['textAlignment'] == "center") echo "selected"; ?>>Center</option>
                                        <option value="right" <?php if($component_styles['drivingDirections']['title']['textAlignment'] == "right") echo "selected"; ?>>Right</option>
                                        <option value="left" <?php if($component_styles['drivingDirections']['title']['textAlignment'] == "left") echo "selected"; ?>>Left</option>
                                    </select>
                                </div>
                            </div>
                            
                            <h3>Map</h3>
                            <div class="four-col-div">
                                <div class="input-wrapper">
                                    <label>Height (px)</label>
                                    <input type="number" name="ddMapHeight" placeholder="400" value="<?php echo $component_styles['drivingDirections']['map']['height']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Width (%)</label>
                                    <input min="10" max="100" type="number" name="ddMapWidth" placeholder="100" value="<?php echo $component_styles['drivingDirections']['map']['width']; ?>">
                                </div>
                            </div>
                        </sl-details>

                        <sl-details summary="Reviews">
                            <h3>Title</h3>
                            <div class="four-col-div">
                                <div class="input-wrapper">
                                    <label>Font Size</label>
                                    <input type="number" name="rvTitleFontSize" placeholder="36" value="<?php echo $component_styles['reviews']['title']['fontSize']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Font Weight</label>
                                    <input type="number" name="rvTitleFontWeight" placeholder="500" value="<?php echo $component_styles['reviews']['title']['fontWeight']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Font Color</label>
                                    <input type="text" name="rvTitleFontColor" placeholder="#00000000" value="<?php echo $component_styles['reviews']['title']['fontColor']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Text Alignment</label>
                                    <select name="rvTitleTextAligment" value="<?php echo $component_styles['reviews']['title']['textAlignment']; ?>">
                                        <option value="center" <?php if($component_styles['reviews']['title']['textAlignment'] == "center") echo "selected"; ?>>Center</option>
                                        <option value="right" <?php if($component_styles['reviews']['title']['textAlignment'] == "right") echo "selected"; ?>>Right</option>
                                        <option value="left" <?php if($component_styles['reviews']['title']['textAlignment'] == "left") echo "selected"; ?>>Left</option>
                                    </select>
                                </div>
                            </div>

                            <h3>Items</h3>
                            <div class="four-col-div">
                                <div class="input-wrapper">
                                    <label>Padding</label>
                                    <input type="number" name="rvItemsPadding" placeholder="20" value="<?php echo $component_styles['reviews']['items']['padding']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Gap</label>
                                    <input type="number" name="rvItemsGap" placeholder="20" value="<?php echo $component_styles['reviews']['items']['gap']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Background Color</label>
                                    <input type="text" name="rvItemsBackgroundColor" placeholder="#00000000" value="<?php echo $component_styles['reviews']['items']['backgroundColor']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Hover Effect</label>
                                    <select name="rvItemsHoverEffect" value="<?php echo $component_styles['reviews']['items']['hoverEffect']; ?>">
                                        <option value="scaleUp" <?php if($component_styles['reviews']['items']['hoverEffect'] == "scaleUp") echo "selected"; ?>>Scale Up</option>
                                        <option value="scaleDown" <?php if($component_styles['reviews']['items']['hoverEffect'] == "scaleDown") echo "selected"; ?>>Scale Down</option>
                                        <option value="rise" <?php if($component_styles['reviews']['items']['hoverEffect'] == "rise") echo "selected"; ?>>Rise</option>
                                    </select>
                                </div>
                            </div>
                            <div class="four-col-div">
                                <div class="input-wrapper">
                                    <label>Border Radius</label>
                                    <input type="number" name="rvItemsBorderRadius" placeholder="5" value="<?php echo $component_styles['thingsToDo']['items']['borderRadius']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Border Width</label>
                                    <input type="number" name="rvItemsBorderWidth" placeholder="1" value="<?php echo $component_styles['thingsToDo']['items']['borderWidth']; ?>">
                                </div>
                                <div class="input-wrapper">
                                    <label>Border Color</label>
                                    <input type="text" name="rvItemsBorderColor" placeholder="#00000000" value="<?php echo $component_styles['thingsToDo']['items']['borderColor']; ?>">
                                </div>
                            </div>
                        </sl-details>

                    </form>
                </sl-tab-panel>

                <sl-tab-panel name="settings" class="settings-panel">
                    <form action="#" method="POST">
                        
                        <div class="head">
                            <p>Modify plugin settings.</p>
                            <input type="submit" name="_settings-form-update" class="settings-form-update" value="Save Settings Changes"/>
                        </div>

                        <div class="two-col-div">
                            <div class="input-wrapper">
                                <label>Google API Key</label>
                                <input type="password" class="google-api-key" name="settingsGoogleAPIKey" placeholder="API key not set..." value="<?php echo $settings['google_api_key']; ?>" require>
                            </div>
                        </div>

                    </form>
                </sl-tab-panel>
            </sl-tab-group>

            <sl-divider></sl-divider>

            <div class="footer">
                <p>Powered by © <a href="#">Rank Fortress</a>, 2021 🤘.</p>
            </div>
        </section>

        <section class="hidden-form" style="display: none;">
            <form action="#" method="POST">
               <input type="text" name="_single_api_data" /> 
               <input type="text" name="_bulk_api_data" /> 
               <input type="text" name="_api_request_failed" /> 
               <input type="text" id="_copy_shortcode" name="_copy_shortcode" />
            </form>
        </section>
    </div>
    <?php
}