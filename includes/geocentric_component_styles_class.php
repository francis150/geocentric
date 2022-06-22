<?php

if (!class_exists('_geocentric_component_styles')) {
    class _geocentric_component_styles {
        
        private $styles;
        private $config_dir;

        function __construct() {
            $this->config_dir = WP_CONTENT_DIR . '/uploads/_geocentric/v2.0.0/';
            $this->load_styles_data();
        }


        /* 
        @Description loads data from component_styles.json to $this->styles
        */
        public function load_styles_data() {
            if (file_exists( $this->config_dir . 'component_styles.json' )) {
                $this->styles = json_decode(file_get_contents( $this->config_dir . 'component_styles.json' ), true);
            }
        }

        /* 
        @Description: Creates component_styles.json file & Init default styles data
        @Return: Boolean
        */
        public function init_component_styles() {
            $component_styles = "{\"general\":{\"componentsGap\":\"60\",\"componentsFontFamily\":\"Roboto sans-serif\"},\"weatherComponent\":{\"title\":{\"fontSize\":\"36\",\"fontWeight\":\"500\",\"fontColor\":\"#000000\",\"textAlignment\":\"center\"},\"backgroundColor\":\"#f5f5f5\",\"textColor\":\"#000000\",\"unit\":\"fahrenheit\"},\"aboutComponent\":{\"title\":{\"fontSize\":\"36\",\"fontWeight\":\"500\",\"fontColor\":\"#000000\",\"textAlignment\":\"center\"},\"content\":{\"fontSize\":\"16\",\"fontWeight\":\"400\",\"fontColor\":\"#000000\",\"textAlignment\":\"justify\"}},\"neighborhoodsComponent\":{\"title\":{\"fontSize\":\"36\",\"fontWeight\":\"500\",\"fontColor\":\"#000000\",\"textAlignment\":\"center\"},\"neighborhoods\":{\"fontSize\":\"16\",\"fontWeight\":\"400\",\"fontColor\":\"#0274be\",\"fontColorHovered\":\"#0188df\",\"textAlignment\":\"center\"}},\"thingsToDoComponent\":{\"title\":{\"fontSize\":\"36\",\"fontWeight\":\"500\",\"fontColor\":\"#000000\",\"textAlignment\":\"center\"},\"items\":{\"gap\":\"20\",\"backgroundColor\":\"#f5f5f5\",\"hoverEffect\":\"scaleUp\",\"borderRadius\":\"5\",\"borderWidth\":0,\"borderColor\":\"#ebebeb\",\"padding\":\"20\"},\"image\":{\"borderRadius\":\"5\",\"borderWidth\":0,\"borderColor\":\"#ebebeb\"},\"itemName\":{\"fontSize\":\"16\",\"fontWeight\":\"400\",\"fontColor\":\"#000000\",\"textAlignment\":\"center\"},\"showReviews\":true},\"busStopsComponent\":{\"title\":{\"fontSize\":\"36\",\"fontWeight\":\"500\",\"fontColor\":\"#000000\",\"textAlignment\":\"center\"},\"itemName\":{\"fontSize\":\"16\",\"fontWeight\":\"600\",\"fontColor\":\"#000000\",\"textAlignment\":\"center\"},\"items\":{\"gap\":\"20\"}},\"mapEmbedComponent\":{\"title\":{\"fontSize\":\"36\",\"fontWeight\":\"500\",\"fontColor\":\"#000000\",\"textAlignment\":\"center\"},\"map\":{\"height\":\"300\",\"width\":\"100\"}},\"drivingDirectionsComponent\":{\"title\":{\"fontSize\":\"36\",\"fontWeight\":\"500\",\"fontColor\":\"#000000\",\"textAlignment\":\"center\"},\"itemName\":{\"fontSize\":\"16\",\"fontWeight\":\"600\",\"fontColor\":\"#000000\",\"textAlignment\":\"center\"},\"items\":{\"gap\":\"20\"}},\"reviewsComponent\":{\"title\":{\"fontSize\":\"36\",\"fontWeight\":\"500\",\"fontColor\":\"#000000\",\"textAlignment\":\"center\"},\"items\":{\"gap\":\"20\",\"backgroundColor\":\"#f5f5f5\",\"borderRadius\":\"5\",\"borderWidth\":0,\"borderColor\":\"#ebebeb\",\"padding\":\"20\"},\"authorName\":{\"fontSize\":\"16\",\"fontWeight\":\"500\",\"fontColor\":\"#000000\"},\"reviewBody\":{\"fontSize\":\"16\",\"fontWeight\":\"400\",\"fontColor\":\"#000000\"}}}";

            if (wp_mkdir_p( $this->config_dir )) {
                if (file_put_contents($this->config_dir . 'component_styles.json', $component_styles)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        /* 
        @Description: Gets the component styles data
        @Returns: ArrayObject
        */
        public function get_component_styles() {
            return $this->styles;
        }

        /* 
        @Description: Updates or sets the component styles data
        @Returns: bool
        @Parans: ArrayObject $data
        */
        public function set_component_styles($data) {
            if (file_put_contents($this->config_dir . 'component_styles.json', json_encode($data, JSON_PRETTY_PRINT))) {
                $this->load_styles_data();
                return true;
            } else {
                return false;
            }
        }

        /* 
        @Description: Get styles for a specific component
        @Returns: ArrayObject
        @Params: string $key
        */
        public function get_component_style($key) {
            if (!isset($this->styles)) return array();

            return $this->styles[$key];
        }

        /**
         * @description return whether or not component_styles.json is set
         * @return boolean
         */
        public function styles_isset() {
            $this->load_styles_data();
            return isset($this->styles);
        }


        /* 
        @Description: Get hover effect css value from the userinput
        @Returns: string
        @params: string userinput value
        */
        public function get_hover_effect($input) {
            switch ($input) {
                case 'scaleUp':
                    return "scale(1.02)";
                    break;
                case 'scaleDown':
                    return "scale(0.98)";
                    break;
                case 'rise':
                    return "translateY(-10px)";
                    break;
                default:
                    return "scale(1.02)";
                    break;
            }
        }
    }
}