<?php

if (!class_exists('_geocentric_components')) {

    require_once plugin_dir_path( __FILE__ ) . 'geocentric_settings_class.php';
    require_once plugin_dir_path( __FILE__ ) . 'geocentric_plugin_config_class.php';
    require_once plugin_dir_path( __FILE__ ) . 'geocentric_component_styles_class.php';
    require_once plugin_dir_path( __FILE__ ) . 'geocentric_userinput_data_class.php';
    require_once plugin_dir_path( __FILE__ ) . 'geocentric_api_data_class.php';

    class _geocentric_components {

        private $api_data_controller;
        private $userinput_data_controller;
        private $component_styles_controller;
        private $settings_data_controller;

        function __construct() {
            $this->api_data_controller = new _geocentric_api_data();
            $this->userinput_data_controller = new _geocentric_userinput_data();
            $this->component_styles_controller = new _geocentric_component_styles();
            $this->settings_data_controller = new _geocentric_settings();
        }

        /* 
        @Description: Weather Widget Component
        @Atts: {
            * id - location ID.
        }
        */
        public function weather_component($atts) {
            $api_data = $this->api_data_controller->get_api_data($atts['id']);
            $styles = $this->component_styles_controller->get_component_style('weatherSection');

            if (empty($api_data)) return "<pre>No data matched by id...</pre>";

            return "<a class=\"weatherwidget-io\" href=\"https://forecast7.com/en/{$api_data['weatherWidget']}\" data-label_1=\"{$api_data['name']}\" data-label_2=\"Weather\" data-theme=\"original\" data-basecolor=\"{$styles['backgroundColor']}\" data-textcolor=\"{$styles['accentColor']}\">{$api_data['name']}</a>
            <script>
            !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
            </script>";
        }

        /* 
        @Description: About Section Component
        @Atts: {
            * title - (optional) Section title
        }
        */
        public function about_component($atts) {
            $api_data = $this->api_data_controller->get_api_data($atts['id']);
            $styles = $this->component_styles_controller->get_component_style('aboutSection');

            if (empty($api_data)) return "<pre>No data matched by id...</pre>";

            $attribs = shortcode_atts(array(
                "title" => "About {$api_data['name']}"
            ), $atts);

            return "
            <style>
                ._geocentric-about_component > h2 {
                    font-size: {$styles['title']['fontSize']}px;
                    font-weight: {$styles['title']['fontWeight']};
                    color: {$styles['title']['fontColor']};
                    text-align: {$styles['title']['textAlignment']};
                    margin-bottom: 40px;
                }

                ._geocentric-about_component > p {
                    font-size: {$styles['content']['fontSize']}px;
                    color: {$styles['content']['fontColor']};
                    text-align: {$styles['content']['textAlignment']};
                    font-weight: {$styles['content']['fontWeight']};
                }
            </style>
            <div class=\"_geocentric-about_component\"><h2>{$attribs['title']}</h2><p>{$api_data['about']}</p></div>
            ";
        }

        /* 
        @Description: Neighbourhoods section component
        @Atts: {
            * title - (optional) Section title
        }
        */
        public function neighbourhoods_component($atts) {
            $api_data = $this->api_data_controller->get_api_data($atts['id']);
            $styles = $this->component_styles_controller->get_component_style('neighborhoods');
            $userinput_data = $this->userinput_data_controller->get_userinput_by_id($atts['id']);

            if (empty($userinput_data)) return "<pre>No data matched by id...</pre>";
            if (empty($userinput_data['neighbourhoods'])) return "<pre>No data to show...</pre>";

            $attribs = shortcode_atts(array(
                "title" => "Neighbourhoods in {$api_data['name']}"
            ), $atts);

            $neighbourhoods_anchors = [];

            foreach ($userinput_data['neighbourhoods'] as $neigborhood) {

                $neigborhood_query = ($neigborhood . ', ' . $api_data['name']);
                $encoded_neighbourhood_query = urlencode($neigborhood_query);

                array_push($neighbourhoods_anchors, "<a href=\"https://www.google.com/maps/search/?api=1&query={$encoded_neighbourhood_query}\" target=\"_blank\">{$neigborhood}</a>");
            }

            return "
            <style>
                ._geocentric-neighbourhoods > h2 {
                    font-size: {$styles['title']['fontSize']}px;
                    font-weight: {$styles['title']['fontWeight']};
                    color: {$styles['title']['fontColor']};
                    text-align: {$styles['title']['textAlignment']};

                    margin-bottom: 40px;
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
            <div class=\"_geocentric-neighbourhoods\"><h2>{$attribs['title']}</h2><p>".implode(', ', $neighbourhoods_anchors)."</p></div>
            ";
        }

        /* 
        @Description: Things to do component
        @Atts: {
            * title - (optional) Section title
            * hide_ratings - (optional) Wether or not to display the rating
            * limit - (optional) Limit the number of places to display
            * alt - (optinal) image alt text
        }
        */
        public function thingstodo_component($atts) {
            $api_data = $this->api_data_controller->get_api_data($atts['id']);
            $styles = $this->component_styles_controller->get_component_style('thingsToDo');

            if (empty($api_data)) return "<pre>No data matched by id...</pre>";
            if (empty($api_data['thingsToDo'])) return "<pre>No data to show...</pre>";

             $attribs = shortcode_atts(array(
                "title" => "Things To Do",
                "limit" => 1000,
                "alt" => ""
            ), $atts);

            $thingstodo_cards = [];

            

            foreach ($api_data['thingsToDo'] as $thingstodo) {

                if($attribs['limit'] == count($thingstodo_cards)) break;

                if (!isset($thingstodo['rating'])) {
                    $thingstodo['rating'] = 0;
                    $thingstodo['usersTotalRating'] = 'No ratings yet';
                }

                $ratings = !isset($atts['hide_ratings']) ? "<div><sl-rating readonly value=\"{$thingstodo['rating']}\" style=\"--symbol-size: .9rem;\"></sl-rating><small>{$thingstodo['rating']} ({$thingstodo['usersTotalRating']})</small></div>" : "";

                array_push($thingstodo_cards, "<div><div><a href=\"https://www.google.com/maps/search/?api=1&query={$thingstodo['name']}&query_place_id={$thingstodo['placeID']}\" target=\"_blank\"><img src=\"https://lh3.googleusercontent.com/places/{$thingstodo['photoID']}\" alt=\"{$attribs['alt']}\"/>{$ratings}<p>{$thingstodo['name']}</p></a></div></div>");
            }

            return "
            <script type=\"module\" src=\"https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.60/dist/components/rating/rating.js\"></script>
            <style>
                ._geocentric-thingstodo > h2 {
                    font-size: {$styles['title']['fontSize']}px;
                    font-weight: {$styles['title']['fontWeight']};
                    color: {$styles['title']['fontColor']};
                    text-align: {$styles['title']['textAlignment']};

                    margin-bottom: 40px;
                }

                ._geocentric-thingstodo > .wrapper {
                    display: flex;
                    flex-wrap: wrap;
                    gap: {$styles['items']['gap']}px;
                }

                ._geocentric-thingstodo > .wrapper > div {
                    flex: 1 1 300px;
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

                ._geocentric-thingstodo > .wrapper > div > div p {
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    width: 100%;

                    margin-bottom: 0;
                    text-align: {$styles['name']['textAlignment']};
                    color: {$styles['name']['fontColor']};
                    font-size: {$styles['name']['fontSize']}px;
                    font-weight: {$styles['name']['fontWeight']};
                }
            </style>
            <div class=\"_geocentric-thingstodo\"><h2>{$attribs['title']}</h2><div class=\"wrapper\">".implode("", $thingstodo_cards)."</div></div>
            ";
        }

        /* 
        @Description: Map embed 
        @Atts: {
            * title - (optional) Section title
        }
        */
        public function mapembed_component($atts) {
            $userinput_data = $this->userinput_data_controller->get_userinput_by_id($atts['id']);
            $styles = $this->component_styles_controller->get_component_style('mapEmbed');

            if (empty($userinput_data)) return "<pre>No data matched by id...</pre>";

            $attribs = shortcode_atts(array(
                "title" => "{$userinput_data['city']['name']}, {$userinput_data['state']['code']}"
            ), $atts);


            return "
            <style>
                ._geocentric-mapembed > h2 {
                    font-size: {$styles['title']['fontSize']}px;
                    font-weight: {$styles['title']['fontWeight']};
                    color: {$styles['title']['fontColor']};
                    text-align: {$styles['title']['textAlignment']};

                    margin-bottom: 40px;
                }

                ._geocentric-mapembed .iframe_wrapper {
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }

                ._geocentric-mapembed .iframe_wrapper > div {
                    width: {$styles['map']['width']}%;
                    height: {$styles['map']['height']}px;
                }

                ._geocentric-mapembed .iframe_wrapper > div > iframe {
                    min-width: 100%;
                }
            </style>
            <div class=\"_geocentric-mapembed\"><h2>{$attribs['title']}</h2>
            <div class=\"iframe_wrapper\"><div><iframe height=\"{$styles['map']['height']}\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" id=\"gmap_canvas\" src=\"https://maps.google.com/maps?width=520&amp;height=400&amp;hl=en&amp;q={$userinput_data['city']['name']}, {$userinput_data['state']['code']}, {$userinput_data['country']['iso2']}&amp;t=&amp;z=12&amp;ie=UTF8&amp;iwloc=B&amp;output=embed\"></iframe></div></div></div>";
        }

        /* 
        @Description: Driving Directions Component
        @Atts: {
            * title - (optional) Section title
        }
        */
        public function drivingdirections_component($atts) {
            $userinput_data = $this->userinput_data_controller->get_userinput_by_id($atts['id']);
            $styles = $this->component_styles_controller->get_component_style('drivingDirections');
            $api_data = $this->api_data_controller->get_api_data($atts['id']);
            $settings = $this->settings_data_controller->get_settings_data();
            
            if (empty($api_data)) return "<pre>No data matched by id...</pre>";

            $attribs = shortcode_atts(array(
                "title" => "{$userinput_data['city']['name']}, {$userinput_data['state']['code']} Driving Directions"
            ), $atts);

            return "
            <style>
                ._geocentric-drivingdirections > h2 {
                    font-size: {$styles['title']['fontSize']}px;
                    font-weight: {$styles['title']['fontWeight']};
                    color: {$styles['title']['fontColor']};
                    text-align: {$styles['title']['textAlignment']};

                    margin-bottom: 40px;
                }

                ._geocentric-drivingdirections {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }
            </style>
            <div class=\"_geocentric-drivingdirections\">
                <h2>{$attribs['title']}</h2>
                <div style=\"height: {$styles['map']['height']}px; width: {$styles['map']['width']}%;\" class=\"map\"></div>
            </div>
            <script>
                async function initMap() {
                    var directionsService = new google.maps.DirectionsService();
                    var directionsDisplay = new google.maps.DirectionsRenderer();
                    var map;

                    /* Fetch Streets From Geo Streets API */
                    const directions = ".json_encode($api_data['directions'])."
                    
                    /* Initialize Map ID and Options */
                    map = new google.maps.Map(document.querySelector('._geocentric-drivingdirections > .map'), {
                        zoom: 14, 
                        center: directions.destination
                    });

                    /* Pin Point Routes Into Map And Set Markers  */
                    function calculateRoute(mapOrigin, mapDestination) {
                        var request = {
                            origin: mapOrigin,
                            destination: mapDestination,
                            travelMode: 'DRIVING'
                        };

                        directionsService.route(request, function (result, status) {
                            if (status == \"OK\") {
                                var directionsDisplay = new google.maps.DirectionsRenderer({
                                    map: map
                                });
                                directionsDisplay.setDirections(result);
                            }
                        });
                    }

                    directions.origins.forEach(origin =>{
                        calculateRoute(origin, directions.destination)
                    })
                }

            </script>
            <script src=\"https://maps.googleapis.com/maps/api/js?key={$settings['restricted_google_api_key']}&callback=initMap&v=weekly\" async></script>";
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
            $styles = $this->component_styles_controller->get_component_style('reviews');
            $api_data = $this->api_data_controller->get_api_data($atts['id']);
            $place_id = $this->getPlaceID($atts['id']);

            if (empty($api_data)) return "<pre>No data matched by id...</pre>";
            if (empty($api_data['reviews'])) return "<pre>No data to show...</pre>";

            $attribs = shortcode_atts(array(
                "title" => "Reviews",
                "limit" => 1000,
                "items-on-desktop" => 3,
                "items-on-tablet" => 2,
                "items-on-mobile" => 1
            ), $atts);

            $reviewsString = [];

            foreach ($api_data['reviews'] as $review) {
                if($attribs['limit'] == count($reviewsString)) break;
                array_push($reviewsString, "<div class=\"review\"><a class=\"head\" target=\"_blank\" href=\"https://search.google.com/local/writereview?placeid={$place_id}\"><img src=\"{$review['profilePhotoUrl']}\"><div class=\"head-content\"><p class=\"name\">{$review['authorName']}</p><sl-rating readonly value=\"{$review['rating']}\" style=\"--symbol-size: .9rem;\"></sl-rating></div></a><div class=\"message-wrapper\"><p class=\"message\">{$review['text']}</p></div></div>");
            }

            $gap_style = $styles['items']['gap'] / 2;

            return "
            <script type=\"module\" src=\"https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.62/dist/components/icon/icon.js\"></script>
            <script type=\"module\" src=\"https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.60/dist/components/rating/rating.js\"></script>
            <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.css\">
            <style>
                ._geocentric-reviewscomponent *::-webkit-scrollbar-track {
                    background-color: #ebebeb;
                }

                ._geocentric-reviewscomponent *::-webkit-scrollbar {
                    width: 5px;
                    background-color: #ebebeb;
                }

                ._geocentric-reviewscomponent *::-webkit-scrollbar-thumb {
                    background-color: #363636;
                }

                ._geocentric-reviewscomponent h2 {
                    font-size: {$styles['title']['fontSize']}px;
                    font-weight: {$styles['title']['fontWeight']};
                    color: {$styles['title']['fontColor']};
                    text-align: {$styles['title']['textAlignment']};

                    margin-bottom: 40px;
                }

                ._geocentric-reviewscomponent .glider {
                    padding-top: 5px;
                }

                ._geocentric-reviewscomponent .review {
                    background: {$styles['items']['backgroundColor']};
                    display: flex;
                    flex-direction: column;
                    margin: 0 {$gap_style}px;
                    padding: {$styles['items']['padding']}px;
                    border-width: {$styles['items']['borderWidth']}px;
                    border-color: {$styles['items']['borderColor']}px;
                    border-radius: {$styles['items']['borderRadius']}px;
                    transition: .3s transform ease-in-out;
                }

                ._geocentric-reviewscomponent .review:hover {
                    transform: {$this->component_styles_controller->get_hover_effect($styles['items']['hoverEffect'])};
                }

                ._geocentric-reviewscomponent .head {
                    display: flex;
                    flex-direction: row;
                    margin-bottom: 10px;
                    align-items: center;
                    text-decoration: none;
                    color: black;
                    font-weight: 500;
                }

                ._geocentric-reviewscomponent img {
                    height: 40px;
                    margin-right: 10px;
                }

                ._geocentric-reviewscomponent .head-content {
                    display: flex;
                    flex-direction: column;
                }

                ._geocentric-reviewscomponent .name {
                    margin: 0;
                }

                ._geocentric-reviewscomponent .message-wrapper {
                    height: 100px;
                    overflow-y: hidden;
                    padding-right: 8px;
                }

                ._geocentric-reviewscomponent .message-wrapper:hover {
                    overflow-y: auto;
                    padding-right: 3px;
                }

                ._geocentric-reviewscomponent .message {
                    text-align: justify;
                    font-size: 16px;
                    line-height: 1.5em;
                }

                ._geocentric-reviewscomponent .glider-dots {
                    margin-top: 20px;
                    gap: 10px;
                }
            </style>
            <div class=\"glider-contain multiple _geocentric-reviewscomponent\">

                <h2>{$attribs['title']}</h2>

                <div class=\"glider\">".implode("", $reviewsString)."</div>

            </div>

            <script src=\"https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.js\"></script>
            <script>
                new Glider(document.querySelector('.glider'), {
                    slidesToShow: ". $attribs['items-on-desktop'] .",
                    draggable: true,
                    duration: .5,
                    responsive: [
                        {
                            breakpoint: 375,
                            settings: {
                                slidesToShow: ". $attribs['items-on-mobile'] ."
                            }
                        },
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: ". $attribs['items-on-tablet'] ."
                            }
                        },
                        {
                            breakpoint: 1333,
                            settings: {
                                slidesToShow: ". $attribs['items-on-desktop'] ."
                            }
                        }
                    ]
                })
            </script>
            ";
        }

        private function getPlaceID($id) {
            $userinput_data = $this->userinput_data_controller->get_userinput_by_id($id);

            if (!isset($userinput_data)) return "";

            if (isset($userinput_data['google_place_id'])) return $userinput_data['google_place_id'];

            foreach ($this->userinput_data_controller->get_userinput_data as $input_data) {
                if (isset($input_data['primaryLocation']) && isset($input_data['google_place_id']))
                return $input_data['google_place_id'];
            }

            return "";
        }
    }
}