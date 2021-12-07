<?php

if (!class_exists('_geocentric_component_styles')) {
    class _geocentric_component_styles {
        
        private $styles;
        private $config_dir;

        function __construct() {
            $this->config_dir = WP_CONTENT_DIR . '/uploads/_geocentric/';
            $this->load_styles_data();
        }


        /* 
        @Description loads data from component_styles.json to $this->styles
        */
        private function load_styles_data() {
            if (file_exists( $this->config_dir . 'component_styles.json' )) {
                $this->styles = json_decode(file_get_contents( $this->config_dir . 'component_styles.json' ), true);
            }
        }

        /* 
        @Description: Creates component_styles.json file & Init default styles data
        @Return: Boolean
        */
        public function init_component_styles() {
            $component_styles = "{\"weatherSection\":{\"backgroundColor\":\"#144192\",\"accentColor\":\"#fff\"},\"aboutSection\":{\"title\":{\"fontSize\":36,\"fontWeight\":500,\"fontColor\":\"#000\",\"textAlignment\":\"center\"},\"content\":{\"fontSize\":16,\"fontWeight\":400,\"fontColor\":\"#000\",\"textAlignment\":\"left\"}},\"neighborhoods\":{\"title\":{\"fontSize\":36,\"fontWeight\":500,\"fontColor\":\"#000\",\"textAlignment\":\"center\"},\"neighborhoods\":{\"fontSize\":16,\"fontWeight\":400,\"fontColor\":\"#0274be\",\"fontColorHovered\":\"#0188df\",\"textAlignment\":\"center\"}},\"thingsToDo\":{\"title\":{\"fontSize\":36,\"fontWeight\":500,\"fontColor\":\"#000\",\"textAlignment\":\"center\"},\"items\":{\"gap\":20,\"backgroundColor\":\"#f5f5f5\",\"hoverEffect\":\"scaleUp\",\"borderRadius\":5,\"borderWidth\":1,\"borderColor\":\"#ebebeb\",\"padding\":20},\"image\":{\"borderRadius\":5,\"borderWidth\":0,\"borderColor\":\"#ebebeb\"},\"name\":{\"fontSize\":16,\"fontWeight\":400,\"fontColor\":\"#000\",\"textAlignment\":\"center\"}},\"mapEmbed\":{\"title\":{\"fontSize\":36,\"fontWeight\":500,\"fontColor\":\"#000\",\"textAlignment\":\"center\"},\"map\":{\"height\":300,\"width\":100}},\"drivingDirections\":{\"title\":{\"fontSize\":36,\"fontWeight\":500,\"fontColor\":\"#000\",\"textAlignment\":\"center\"},\"map\":{\"height\":300,\"width\":100}},\"reviews\":{\"title\":{\"fontSize\":36,\"fontWeight\":500,\"fontColor\":\"#000\",\"textAlignment\":\"center\"},\"items\":{\"gap\":20,\"backgroundColor\":\"#f5f5f5\",\"hoverEffect\":\"scaleUp\",\"borderRadius\":5,\"borderWidth\":1,\"borderColor\":\"#ebebeb\",\"padding\":20}}}";

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
    }
}