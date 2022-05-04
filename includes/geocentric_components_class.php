<?php

if (!class_exists('_geocentric_components')) {

    require_once plugin_dir_path( __FILE__ ) . 'geocentric_settings_class.php';
    require_once plugin_dir_path( __FILE__ ) . 'geocentric_plugin_config_class.php';
    require_once plugin_dir_path( __FILE__ ) . 'geocentric_component_styles_class.php';
    require_once plugin_dir_path( __FILE__ ) . 'geocentric_api_data_class.php';

    class _geocentric_components {

        private $api_data_controller;
        private $userinput_data_controller;
        private $component_styles_controller;
        private $settings_data_controller;
        private $plugin_config;

        private $general_styles;
        private $font;
        private $font_family;
        private $settings_data;

        function __construct() {
            $this->api_data_controller = new _geocentric_api_data();
            $this->component_styles_controller = new _geocentric_component_styles();
            $this->settings_data_controller = new _geocentric_settings();
            $this->plugin_config_controller = new _geocentric_plugin_config();

            if ($this->component_styles_controller->get_component_styles() !== null) {
                $this->general_styles = $this->component_styles_controller->get_component_style('general');
                $this->font = explode(" ", $this->general_styles['componentsFontFamily']);
                $this->font_family = str_replace("+", " ", $this->font[0]);

                $this->plugin_config = $this->plugin_config_controller->get_plugin_config_data();
                $this->settings_data = $this->settings_data_controller->get_settings_data();
            }   
        }

        /* 
        @Description: Weather Widget Component
        @Atts: {
            * id - location ID.
        }
        */
        public function weather_component($atts) {

            $api_data = $this->api_data_controller->get_api_data($atts['id']);
            $styles = $this->component_styles_controller->get_component_style('weatherComponent');

            if (empty($api_data)) return "<pre>No data matched by id...</pre>";

            $unit_string = $styles['unit'] == 'fahrenheit' ? '?unit=us' : '';

            return "
            <style>
                ._geocentric-component {
                    margin-bottom: {$this->general_styles['componentsGap']}px;
                }
            </style>
            <div class=\"_geocentric-component _geocentric-weather-component\"><a class=\"weatherwidget-io\" href=\"https://forecast7.com/en/{$api_data['weather_widget']}{$unit_string}\" data-label_1=\"{$api_data['name']}\" data-label_2=\"Weather\" data-theme=\"original\" data-basecolor=\"{$styles['backgroundColor']}\" data-textcolor=\"{$styles['textColor']}\">{$api_data['name']}</a>
            <script>
            !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
            </script></div>";
        }

        /* 
        @Description: About Section Component
        @Atts: {
            * title - (optional) Section title
        }
        */
        public function about_component($atts) {

            $api_data = $this->api_data_controller->get_api_data($atts['id']);
            $styles = $this->component_styles_controller->get_component_style('aboutComponent');

            if (empty($api_data)) return "<pre>No data matched by id...</pre>";

            $attribs = shortcode_atts(array(
                "title" => "About {$api_data['name']}"
            ), $atts);

            return "
            <style>
                @import url('https://fonts.googleapis.com/css2?family={$this->font[0]}&display=swap');

                ._geocentric-component {
                    margin-bottom: {$this->general_styles['componentsGap']}px;
                    font-family: '{$this->font_family}', {$this->font[1]};
                }

                ._geocentric-about-component > h2 {
                    font-size: {$styles['title']['fontSize']}px;
                    font-weight: {$styles['title']['fontWeight']};
                    color: {$styles['title']['fontColor']};
                    text-align: {$styles['title']['textAlignment']};
                    margin-bottom: 20px;
                }

                ._geocentric-about-component > p {
                    font-size: {$styles['content']['fontSize']}px;
                    color: {$styles['content']['fontColor']};
                    text-align: {$styles['content']['textAlignment']};
                    font-weight: {$styles['content']['fontWeight']};
                }
            </style>
            <div class=\"_geocentric-component _geocentric-about-component\"><h2>{$attribs['title']}</h2><p>{$api_data['about']}</p></div>
            ";
        }

        /* 
        @Description: Neighborhoods section component
        @Atts: {
            * title - (optional) Section title
        }
        */
        public function neighborhoods_component($atts) {

            $api_data = $this->api_data_controller->get_api_data($atts['id']);
            $styles = $this->component_styles_controller->get_component_style('neighborhoodsComponent');

            if (empty($api_data)) return "<pre>No data matched by id...</pre>";
            if (empty($api_data['meta']['neighborhoods'])) return "<pre>No data to show...</pre>";

            $attribs = shortcode_atts(array(
                "title" => "Neighborhoods in {$api_data['name']}"
            ), $atts);

            $neighbourhoods_anchors = [];

            foreach ($api_data['meta']['neighborhoods'] as $neigborhood) {

                $neigborhood_query = ($neigborhood . ', ' . $api_data['name']);
                $encoded_neighborhood_query = urlencode($neigborhood_query);

                array_push($neighbourhoods_anchors, "<a href=\"https://www.google.com/maps/search/?api=1&query={$encoded_neighborhood_query}\" target=\"_blank\">{$neigborhood}</a>");
            }

            return "
            <style>
                @import url('https://fonts.googleapis.com/css2?family={$this->font[0]}&display=swap');

                ._geocentric-component {
                    margin-bottom: {$this->general_styles['componentsGap']}px;
                    font-family: '{$this->font_family}', {$this->font[1]};
                }

                ._geocentric-neighbourhoods > h2 {
                    font-size: {$styles['title']['fontSize']}px;
                    font-weight: {$styles['title']['fontWeight']};
                    color: {$styles['title']['fontColor']};
                    text-align: {$styles['title']['textAlignment']};

                    margin-bottom: 20px;
                }

                ._geocentric-neighbourhoods > p {
                    font-size: {$styles['neighborhoods']['fontSize']}px;
                    text-align: {$styles['neighborhoods']['textAlignment']};
                    font-weight: {$styles['neighborhoods']['fontWeight']};
                }

                ._geocentric-neighbourhoods > p > a {
                    transition: .3s color ease-in-out;
                    color: {$styles['neighborhoods']['fontColor']};
                }

                ._geocentric-neighbourhoods > p > a:hover {
                    color: {$styles['neighborhoods']['fontColorHovered']};
                }
            </style>
            <div class=\"_geocentric-neighbourhoods _geocentric-component\"><h2>{$attribs['title']}</h2><p>".implode(', ', $neighbourhoods_anchors)."</p></div>
            ";
        }

        /* 
        @Description: Things to do component
        @Atts: {
            * title - (optional) Section title
            * limit - (optional) Limit the number of places to display
            * alt - (optinal) image alt text
        }
        */
        public function thingstodo_component($atts) {

            $api_data = $this->api_data_controller->get_api_data($atts['id']);
            $styles = $this->component_styles_controller->get_component_style('thingsToDoComponent');

            if (empty($api_data)) return "<pre>No data matched by id...</pre>";

            if (empty($api_data['things_to_do']) && empty($api_data['thingsToDo'])) return "<pre>No data to show...</pre>";

            $attribs = shortcode_atts(array(
                "title" => "Things To Do in {$api_data['name']}",
                "limit" => 1000,
                "alt" => ""
            ), $atts);

            $thingstodo_cards = [];


            foreach ($api_data['things_to_do'] as $thingstodo) {

                if($attribs['limit'] == count($thingstodo_cards)) break;

                if (!isset($thingstodo['rating'])) {
                    $thingstodo['rating'] = 0;
                    $thingstodo['users_total_rating'] = 'No ratings yet';
                }

                $star = '';
                $whole = floor($thingstodo['rating']);
                $decimal = $thingstodo['rating'] - $whole;
                $diff = 5 - ceil($thingstodo['rating']);

                for ($i=0; $i < $whole; $i++) $star = $star . '<span class="material-icons-outlined checked">star</span>';
                if ($decimal > 0) $star = $star . '<span class="material-icons-outlined half-checked">star</span>';
                for ($i=0; $i < $diff; $i++) $star = $star . '<span class="material-icons-outlined">star</span>';

                $ratings = $styles['showReviews'] ? "<div>
                <div class=\"rating-stars\">
                    {$star}
                </div>
                <small>{$thingstodo['rating']} ({$thingstodo['users_total_rating']})</small></div>" : "";

                array_push($thingstodo_cards, "<div><div><a href=\"https://www.google.com/maps/search/?api=1&query={$thingstodo['name']}&query_place_id={$thingsToDoPlaceId}\" target=\"_blank\"><img src=\"{$thingsToDoImageURL}\" alt=\"{$attribs['alt']}\"/>{$ratings}<p>{$thingstodo['name']}</p></a></div></div>");
            }

            return "
            <style>
                @import url('https://fonts.googleapis.com/icon?family=Material+Icons+Outlined');
                @import url('https://fonts.googleapis.com/css2?family={$this->font[0]}&display=swap');

                ._geocentric-component {
                    margin-bottom: {$this->general_styles['componentsGap']}px;
                    font-family: '{$this->font_family}', {$this->font[1]};
                }

                ._geocentric-thingstodo > h2 {
                    font-size: {$styles['title']['fontSize']}px;
                    font-weight: {$styles['title']['fontWeight']};
                    color: {$styles['title']['fontColor']};
                    text-align: {$styles['title']['textAlignment']};

                    margin-bottom: 20px;
                }

                ._geocentric-thingstodo > .wrapper {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: space-evenly;
                    gap: {$styles['items']['gap']}px;
                }

                ._geocentric-thingstodo > .wrapper > div {
                    width: 350px;
                }

                ._geocentric-thingstodo > .wrapper > div > div {
                    cursor: pointer;
                    background: {$styles['items']['backgroundColor']};
                    width: 100%;
                    max-width: 350px;
                    margin: 0 auto;
                    padding: {$styles['items']['padding']}px;
                    border-radius: {$styles['items']['borderRadius']}px;
                    border: solid {$styles['items']['borderColor']} {$styles['items']['borderWidth']}px;
                    transition: .3s transform ease-in-out;
                }

                ._geocentric-thingstodo > .wrapper > div > div:hover {
                    transform: {$this->component_styles_controller->get_hover_effect($styles['items']['hoverEffect'])};
                }

                ._geocentric-thingstodo > .wrapper > div > div img {
                    height: 250px;
                    width: 100%;
                    border-radius: {$styles['image']['borderRadius']}px;
                    object-fit: cover;
                    border: solid {$styles['image']['borderColor']} {$styles['image']['borderWidth']}px;
                    background: #f5f5f5;
                }

                ._geocentric-thingstodo > .wrapper > div > div a > div {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    gap: 10px;
                    padding-top: 20px;
                }

                ._geocentric-thingstodo > .wrapper > div > div a > div small {
                    color: #000;
                    opacity: .7;
                }

                ._geocentric-thingstodo > .wrapper > div > div a > div .rating-stars > span {
                    color: #b4b4b4;
                    font-size: 16px;
                }

                ._geocentric-thingstodo > .wrapper > div > div a > div .rating-stars > span.checked {
                    color: #FF9529;
                }

                ._geocentric-thingstodo > .wrapper > div > div a > div .rating-stars > span.half-checked {
                    background: linear-gradient(90deg, rgba(255,149,41,1) 50%, rgba(180,180,180,1) 50%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                }

                ._geocentric-thingstodo > .wrapper > div > div p {
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    width: 100%;

                    margin-bottom: 0;
                    text-align: {$styles['itemName']['textAlignment']};
                    color: {$styles['itemName']['fontColor']};
                    font-size: {$styles['itemName']['fontSize']}px;
                    font-weight: {$styles['itemName']['fontWeight']};
                }
            </style>
            <div class=\"_geocentric-thingstodo _geocentric-component\"><h2>{$attribs['title']}</h2><div class=\"wrapper\">".implode("", $thingstodo_cards)."</div></div>
            ";
        }

        /**
         * @Desccription: Bus Stops Component
         * @Atts: {
            * title - (optional) Section title
            * limit - (optional) Limit the number of bus stops to display
         * }
         */
        public function busstops_component($atts) {

            $styles = $this->component_styles_controller->get_component_style('busStopsComponent');
            $api_data = $this->api_data_controller->get_api_data($atts['id']);

            if (empty($api_data)) return "<pre>No data matched by id...</pre>";
            if (empty($api_data['bus_stops'])) return "<pre>No data to show...</pre>";

            $attribs = shortcode_atts(array(
                "title" => "Bus Stops  in {$api_data['name']} to {$this->settings_data['business_name']}",
                "limit" => 12,
            ), $atts);

            $busstops = [];

            foreach ($api_data['bus_stops'] as $busstop) {

                if($attribs['limit'] == count($busstops)) break;

                array_push($busstops, "<div class=\"bus-stop\">
                    <iframe src=\"https://www.google.com/maps/embed/v1/place?key={$this->plugin_config['g_api_key']}&q={$busstop['query']}\" width=\"300\" height=\"320\" style=\"border:0;\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>
                    <h3>Bus Stop in {$busstop['name']} {$api_data['name']} to {$this->settings_data['business_name']}</h3>
                </div>");
            }

            return "<style>
                @import url('https://fonts.googleapis.com/css2?family={$this->font[0]}&display=swap');

                ._geocentric-component {
                    margin-bottom: {$this->general_styles['componentsGap']}px;
                    font-family: '{$this->font_family}', {$this->font[1]};
                }

                ._geocentric-busstops > h2 {
                    font-size: {$styles['title']['fontSize']}px;
                    font-weight: {$styles['title']['fontWeight']};
                    color: {$styles['title']['fontColor']};
                    text-align: {$styles['title']['textAlignment']};
                    margin-bottom: 20px;
                }

                ._geocentric-busstops .busstops {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: space-evenly;
                    gap: {$styles['items']['gap']}px;
                }

                ._geocentric-busstops .bus-stop {
                    margin-bottom: 10px;
                    width: 350px;
                }

                ._geocentric-busstops .bus-stop h3 {
                    font-size: {$styles['itemName']['fontSize']}px;
                    font-weight: {$styles['itemName']['fontWeight']};
                    color: {$styles['itemName']['fontColor']};
                    text-align: {$styles['itemName']['textAlignment']};
                    margin: 0;
                }
            </style>
            <div class=\"_geocentric-busstops _geocentric-component\">
                <h2>{$attribs['title']}</h2>
                <div class=\"busstops\">"
                    .implode("", $busstops).
                "</div>
            </div>";
        }

        /* 
        @Description: Map embed 
        @Atts: {
            * title - (optional) Section title
        }
        */
        public function mapembed_component($atts) {

            $styles = $this->component_styles_controller->get_component_style('mapEmbedComponent');
            $api_data = $this->api_data_controller->get_api_data($atts['id']);

            if (empty($api_data)) return "<pre>No data matched by id...</pre>";

            $attribs = shortcode_atts(array(
                "title" => "Map of {$api_data['name']}"
            ), $atts);

            $query = '';

            if (isset($api_data['meta']['place_id'])) {
                $query = "place_id:" . $api_data['meta']['place_id'];
            } else {
                $query = $api_data['name'] . " " . $api_data['meta']['country']['iso2'];
            }

            return "
            <style>
                @import url('https://fonts.googleapis.com/css2?family={$this->font[0]}&display=swap');

                ._geocentric-component {
                    margin-bottom: {$this->general_styles['componentsGap']}px;
                    font-family: '{$this->font_family}', {$this->font[1]};
                }

                ._geocentric-mapembed > h2 {
                    font-size: {$styles['title']['fontSize']}px;
                    font-weight: {$styles['title']['fontWeight']};
                    color: {$styles['title']['fontColor']};
                    text-align: {$styles['title']['textAlignment']};

                    margin-bottom: 20px;
                }

                ._geocentric-mapembed .iframe_wrapper {
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }

                ._geocentric-mapembed .iframe_wrapper > div {
                    width: {$styles['map']['width']}%;
                }

                ._geocentric-mapembed .iframe_wrapper > div > iframe {
                    min-width: 100%;
                }
            </style>
            <div class=\"_geocentric-mapembed _geocentric-component\"><h2>{$attribs['title']}</h2>
            <div class=\"iframe_wrapper\"><div>
            <iframe src=\"https://www.google.com/maps/embed/v1/place?key={$this->plugin_config['g_api_key']}&q={$query}\" width=\"600\" height=\"{$styles['map']['height']}\" style=\"border:0;\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>
            </div></div></div>";
        }

        /* 
        @Description: Driving Directions Component
        @Atts: {
            * title - (optional) Section title
            * limit - (optional) Limit the number of driving directions to display
        }
        */
        public function drivingdirections_component($atts) {

            $styles = $this->component_styles_controller->get_component_style('drivingDirectionsComponent');
            $api_data = $this->api_data_controller->get_api_data($atts['id']);
            
            if (empty($api_data)) return "<pre>No data matched by id...</pre>";

            $attribs = shortcode_atts(array(
                "title" => "Driving Directions in {$api_data['name']} to {$this->settings_data['business_name']}",
                "limit" => 12
            ), $atts);

            $driving_directions = [];

            foreach ($api_data['directions']['origins'] as $origin) {

                if($attribs['limit'] == count($driving_directions)) break;

                array_push($driving_directions, "<div class=\"direction\">
                    <iframe src=\"https://www.google.com/maps/embed/v1/directions?key={$this->plugin_config['g_api_key']}&origin={$origin['query']}&destination={$api_data['directions']['destination']['query']}\" width=\"600\" height=\"320\" style=\"border:0;\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>
                    <h3>Driving Directions from {$origin['name']} to {$api_data['directions']['destination']['name']}</h3>
                </div>");
            }

            return "
            <style>
                @import url('https://fonts.googleapis.com/css2?family={$this->font[0]}&display=swap');

                ._geocentric-component {
                    margin-bottom: {$this->general_styles['componentsGap']}px;
                    font-family: '{$this->font_family}', {$this->font[1]};
                }

                ._geocentric-drivingdirections > h2 {
                    font-size: {$styles['title']['fontSize']}px;
                    font-weight: {$styles['title']['fontWeight']};
                    color: {$styles['title']['fontColor']};
                    text-align: {$styles['title']['textAlignment']};
                    margin-bottom: 20px;
                }

                ._geocentric-drivingdirections .drivingdirections {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: space-evenly;
                    gap: {$styles['items']['gap']}px;
                }

                ._geocentric-drivingdirections .direction {
                    margin-bottom: 10px;
                    width: 350px;
                }

                ._geocentric-drivingdirections .direction h3 {
                    font-size: {$styles['itemName']['fontSize']}px;
                    font-weight: {$styles['itemName']['fontWeight']};
                    color: {$styles['itemName']['fontColor']};
                    text-align: {$styles['itemName']['textAlignment']};
                    margin: 0;
                }

            </style>
            <div class=\"_geocentric-drivingdirections _geocentric-component\">
            <h2>{$attribs['title']}</h2>
            <div class=\"drivingdirections\">"
            .implode("", $driving_directions).
            "</div>
            </div>";
        }

        /* 
        @Description: Reviews Component
        @Atts: {
            * title - (optional) Section title
            * limit - (optional) Limit the number of places to display
            * items-on-desktop - (optional) items to show per page on desktop
            * items-on-tablet - (optional) items to show per page on tablet
            * items-on-mobile - (optional) items to show per page on mobile
        }
        */
        public function reviews_component($atts) {
            $api_data = $this->api_data_controller->get_api_data($atts['id']);
            $styles = $this->component_styles_controller->get_component_style('reviewsComponent');

            if (empty($api_data)) return "<pre>No data matched by id...</pre>";
            if (!isset($api_data['reviews'])) return "<pre>No data to show...</pre>";
            
            $attribs = shortcode_atts(array(
                "title" => "Reviews for {$this->settings_data['business_name']} {$api_data['name']}",
                "limit" => 6
            ), $atts);

            $reviews = [];

            foreach ($api_data['reviews'] as $review) {

                if($attribs['limit'] == count($reviews)) break;

                $star = '';
                $whole = floor($review['rating']);
                $decimal = $review['rating'] - $whole;
                $diff = 5 - ceil($review['rating']);

                for ($i=0; $i < $whole; $i++) $star = $star . '<span class="material-icons-outlined checked">star</span>';
                if ($decimal > 0) $star = $star . '<span class="material-icons-outlined half-checked">star</span>';
                for ($i=0; $i < $diff; $i++) $star = $star . '<span class="material-icons-outlined">star</span>';
                
                array_push($reviews, "<div class=\"review\">
                    <a href=\"{$review['author_url']}\" target=\"_blank\" class=\"head\">
                        <img src=\"{$review['profile_photo_url']}\" alt=\"{$this->settings_data['business_name']} Reviews\">
                        <div class=\"info\">
                            <h3>{$review['author_name']}</h3>
                            <div class=\"stars\">
                                {$star} <span>({$review['rating']})</span>
                            </div>
                        </div>
                    </a>
                    <p>{$review['text']}</p>
                </div>");
            }

            return "
            <style>
                @import url('https://fonts.googleapis.com/icon?family=Material+Icons+Outlined');
                @import url('https://fonts.googleapis.com/css2?family={$this->font[0]}&display=swap');

                ._geocentric-component {
                    margin-bottom: {$this->general_styles['componentsGap']}px;
                    font-family: '{$this->font_family}', {$this->font[1]};
                }

                ._geocentric-reviews > h2 {
                    font-size: {$styles['title']['fontSize']}px;
                    font-weight: {$styles['title']['fontWeight']};
                    color: {$styles['title']['fontColor']};
                    text-align: {$styles['title']['textAlignment']};

                    margin-bottom: 20px;
                }

                ._geocentric-reviews .reviews {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: space-evenly;
                    gap: {$styles['items']['gap']}px;
                }

                ._geocentric-reviews .review {
                    padding: {$styles['items']['padding']}px;
                    border-radius: {$styles['items']['borderRadius']}px;
                    border-width: {$styles['items']['borderWidth']}px;
                    border-color: {$styles['items']['borderColor']}px;
                    background: {$styles['items']['backgroundColor']};
                    flex: 1 1 300px;
                }

                ._geocentric-reviews .review a {
                    color: #000000;
                    display: flex;
                    align-items: center;
                    margin-bottom: 5px;
                }

                ._geocentric-reviews .review a img {
                    height: 45px;
                    margin-right: 10px;
                }

                ._geocentric-reviews .review a h3 {
                    margin-bottom: 3px;
                    font-size: {$styles['authorName']['fontSize']}px;
                    font-weight: {$styles['authorName']['fontWeight']};
                    color: {$styles['authorName']['fontColor']};
                }

                ._geocentric-reviews .review p {
                    font-size: {$styles['reviewBody']['fontSize']}px;
                    font-weight: {$styles['reviewBody']['fontWeight']};
                    color: {$styles['reviewBody']['fontColor']};
                }

                ._geocentric-reviews .review .stars .material-icons-outlined {
                    color: #b4b4b4;
                    font-size: 16px;
                }

                ._geocentric-reviews .review .stars .material-icons-outlined.checked {
                    color: #FF9529;
                }

                ._geocentric-reviews .review .stars .material-icons-outlined.half-checked {
                    background: linear-gradient(90deg, rgba(255,149,41,1) 50%, rgba(180,180,180,1) 50%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                }
                
            </style>
            <div class=\"_geocentric-reviews _geocentric-component\">
                <h2>{$attribs['title']}</h2>
                <div class=\"reviews\">".implode("", $reviews)."</div>
            </div>";
        }

        private function getPlaceID($id) {
            $userinput_data = $this->userinput_data_controller->get_userinput_by_id($id);

            if (!isset($userinput_data)) return "";

            if (isset($userinput_data['google_place_id'])) return $userinput_data['google_place_id'];

            foreach ($this->userinput_data_controller->get_userinput_data() as $input_data) {
                if (isset($input_data['primaryLocation']) && isset($input_data['google_place_id']))
                return $input_data['google_place_id'];
            }

            return "";
        }
    }
}