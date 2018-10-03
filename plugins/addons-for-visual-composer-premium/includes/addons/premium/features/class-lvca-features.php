<?php

/*
Widget Name: Features
Description: Display product features or services offered.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/

class LVCA_Features {

    protected $image_size;

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_features', array($this, 'shortcode_func'));

        add_shortcode('lvca_feature', array($this, 'child_shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

        add_action('init', array($this, 'map_child_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_style('lvca-premium-frontend-styles', LVCA_PLUGIN_URL . 'assets/css/premium/lvca-frontend.css', array(), LVCA_VERSION);

        wp_enqueue_style('lvca-features', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);
    }

    public function shortcode_func($atts, $content = null, $tag) {

        $id = $class = $tiled = $image_size = '';

        $settings = shortcode_atts(array(
            'id' => '',
            'class' => '',
            'image_size' => 'large',
            'tiled' => ''

        ), $atts);

        extract($settings);

        $this->image_size = $image_size;

        $class = ((!empty($tiled)) ? 'lvca-tiled ' . $class : $class);

        $id = (!empty($id)) ? 'id="' . $id . '"' : '';

        $output = '<div ' . esc_attr($id) . ' class="lvca-features ' . esc_attr($class) . '">';

        $output .= do_shortcode($content);

        $output .= '</div>';

        return apply_filters('lvca_features_output', $output, $content, $settings);
    }

    public function child_shortcode_func($atts, $content = null, $tag) {

        $image_animation = $text_animation = $image = $subtitle = $title = '';

        $settings = shortcode_atts(array(
            'image_animation' => 'none',
            'text_animation' => 'none',
            'image' => '',
            'subtitle' => '',
            'title' => ''
        ), $atts);

        extract($settings);

        $output = '<div class="lvca-feature lvca-image-text-toggle">';

        list($animate_class, $animation_attr) = lvca_get_animation_atts($image_animation);

        $output .= '<div class="lvca-feature-image lvca-image-content ' . $animate_class . '" ' . $animation_attr . '>';

        $output .= wp_get_attachment_image($image, $this->image_size, false, array('class' => 'lvca-image full'));

        $output .= '</div>';

        list($animate_class, $animation_attr) = lvca_get_animation_atts($text_animation);

        $output .= '<div class="lvca-feature-text lvca-text-content ' . $animate_class . '" ' . $animation_attr . '>';

        $output .= '<div class="lvca-subtitle">' . esc_html($subtitle) . '</div>';

        $output .= '<h3 class="lvca-title">' . esc_html($title) . '</h3>';

        $output .= '<div class="lvca-feature-details">' . do_shortcode($content) . '</div>';

        $output .= '</div>';

        $output .= '</div>';

        return apply_filters('lvca_feature_item_output', $output, $content, $settings);

    }

    function map_vc_element() {

        if (function_exists("vc_map")) {

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Features", "livemesh-vc-addons"),
                "base" => "lvca_features",
                "as_parent" => array('only' => 'lvca_feature'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                "content_element" => true,
                "show_settings_on_create" => false,
                "category" => __("Livemesh Addons", "livemesh-vc-addons"),
                "is_container" => true,
                'description' => __('Display product features or services offered.', 'livemesh-vc-addons'),
                "js_view" => 'VcColumnView',
                "icon" => 'icon-lvca-features',
                "params" => array(

                    array(
                        'type' => 'textfield',
                        'param_name' => 'id',
                        'heading' => __('Features Container ID', 'livemesh-vc-addons'),
                        'description' => __('The CSS ID for the features container DIV element.', 'livemesh-vc-addons'),
                    ),
                    array(
                        'type' => 'textfield',
                        'param_name' => 'class',
                        'heading' => __('Features Container Class', 'livemesh-vc-addons'),
                        'description' => __('The CSS class for the feature container DIV element.', 'livemesh-vc-addons'),
                    ),

                    array(
                        'type' => 'dropdown',
                        'param_name' => 'image_size',
                        'heading' => __('Image Size', 'livemesh-vc-addons'),
                        'std' => 'large',
                        'value' => lvca_get_image_sizes()
                    ),

                    array(
                        'type' => 'checkbox',
                        'param_name' => 'tiled',
                        'heading' => __('Apply tiled design', 'livemesh-vc-addons'),
                        'description' => __('Specify if you want to apply tiled design by removing spacing between feature items.', 'livemesh-vc-addons'),
                    ),

                ),
            ));


        }
    }

    function map_child_vc_element() {
        if (function_exists("vc_map")) {
            vc_map(array(
                    "name" => __("Feature", "my-text-domain"),
                    "base" => "lvca_feature",
                    "content_element" => true,
                    "as_child" => array('only' => 'lvca_features'), // Use only|except attributes to limit parent (separate multiple values with comma)
                    "icon" => 'icon-lvca-feature-add',
                    "params" => array(
                        // add params same as with any other content element
                        array(
                            'type' => 'textfield',
                            'param_name' => 'class',
                            'heading' => __('Feature Class', 'livemesh-vc-addons'),
                            'description' => __('The CSS class for the feature DIV element.', 'livemesh-vc-addons'),
                        ),
                        array(
                            'type' => 'textfield',
                            'param_name' => 'title',
                            "admin_label" => true,
                            'heading' => __('Feature Title', 'livemesh-vc-addons'),
                            'description' => __('The title for the feature.', 'livemesh-vc-addons'),
                        ),
                        array(
                            'type' => 'textfield',
                            'param_name' => 'subtitle',
                            'heading' => __('Feature Subtitle', 'livemesh-vc-addons'),
                            'description' => __('The subtitle for the feature.', 'livemesh-vc-addons'),
                        ),
                        array(
                            'type' => 'attach_image',
                            'param_name' => 'image',
                            'heading' => __('Feature Image', 'livemesh-vc-addons'),
                            'description' => __('An icon image or a bitmap which best represents the feature we are capturing.', 'livemesh-vc-addons'),
                        ),
                        array(
                            'type' => 'textarea_html',
                            'param_name' => 'content',
                            'heading' => __('Feature Text', 'livemesh-vc-addons'),
                            'description' => __('The feature content.', 'livemesh-vc-addons'),
                        ),
                        array(
                            "type" => "dropdown",
                            "param_name" => "image_animation",
                            "heading" => __("Choose Animation for Feature Image", "livemesh-vc-addons"),
                            'value' => lvca_get_animation_options(),
                            'std' => 'none',
                        ),
                        array(
                            "type" => "dropdown",
                            "param_name" => "text_animation",
                            "heading" => __("Choose Animation for Feature Text", "livemesh-vc-addons"),
                            'value' => lvca_get_animation_options(),
                            'std' => 'none',
                        ),
                    )
                )

            );

        }
    }

}

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_lvca_features extends WPBakeryShortCodesContainer {
    }
}
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_feature extends WPBakeryShortCode {
    }
}

// Initialize Element Class
if (class_exists('LVCA_Features')) {
    $LVCA_Features = new LVCA_Features();
}