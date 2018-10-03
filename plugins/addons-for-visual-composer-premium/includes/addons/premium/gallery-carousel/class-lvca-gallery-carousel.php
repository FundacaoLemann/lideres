<?php

/*
Widget Name: Gallery Carousel
Description: Display images or videos in a responsive carousel.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/

class LVCA_Gallery_Carousel {

    static public $gallery_counter = 0;

    protected $settings;

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_gallery_carousel', array($this, 'shortcode_func'));

        add_shortcode('lvca_gallery_carousel_item', array($this, 'child_shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

        add_action('init', array($this, 'map_child_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_script('lvca-slick-carousel', LVCA_PLUGIN_URL . 'assets/js/slick' . LVCA_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_style('lvca-slick', LVCA_PLUGIN_URL . 'assets/css/slick.css', array(), LVCA_VERSION);

        wp_enqueue_script('lvca-fancybox', LVCA_PLUGIN_URL . 'assets/js/premium/jquery.fancybox' . LVCA_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_style('lvca-fancybox', LVCA_PLUGIN_URL . 'assets/css/premium/jquery.fancybox.css', array(), LVCA_VERSION);

        wp_enqueue_style('lvca-premium-frontend-styles', LVCA_PLUGIN_URL . 'assets/css/premium/lvca-frontend.css', array(), LVCA_VERSION);

        wp_enqueue_script('lvca-gallery-carousel', plugin_dir_url(__FILE__) . 'js/gallery-carousel' . LVCA_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_style('lvca-gallery-carousel', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);

    }

    public function shortcode_func($atts, $content = null, $tag) {

        $defaults = array_merge(
            array(
                'enable_lightbox' => '',
                'image_size' => 'large',
                'display_item_tags' => '',
                'display_item_title' => '',),
            lvca_get_default_atts_carousel()
        );

        $settings = shortcode_atts($defaults, $atts);

        self::$gallery_counter++;

        $settings['gallery_class'] = !empty($settings['gallery_class']) ? sanitize_title($settings['gallery_class']) : 'gallery-carousel-' . self::$gallery_counter;

        $this->settings = $settings;

        $uniqueid = uniqid();

        $output = '<div id="lvca-gallery-carousel' . $uniqueid . '"
             class="lvca-gallery-carousel lvca-container"
             data-settings=\'' . wp_json_encode($settings) . '\'>';

        $output .= do_shortcode($content);

        $output .= '</div><!-- .lvca-gallery-carousel -->';

        return apply_filters('lvca_gallery_carousel_output', $output, $content, $settings);
    }

    public function child_shortcode_func($atts, $content = null, $tag) {

        $item_type = $name = $image = $tags = $link = $video_link = $mp4_video_link = $webm_video_link = $description = '';
        $settings = shortcode_atts(array(
            'item_type' => 'image',
            'name' => '',
            'image' => '',
            "tags" => '',
            'link' => false,
            'video_link' => '',
            'mp4_video_link' => '',
            'webm_video_link' => '',
            'description' => '',

        ), $atts);

        extract($settings);

        $style = '';
        if (!empty($tags)) {
            $terms = explode(',', $tags);

            foreach ($terms as $term) {
                $style .= ' term-' . $term;
            }
        }

        $item_type = $item_type;

        $item_class = 'lvca-' . $item_type . '-type';

        $entry_output = '<div class="lvca-gallery-carousel-item ' . $style . ' ' . $item_class . '">';

        $entry_image = '<div class="lvca-project-image">';

        if (!empty($link)) {

            if (function_exists('vc_build_link'))
                $link = vc_build_link($link);
            else
                $link = explode('|', $link);
        }

        if ($item_type == 'image' && !empty($link)):

            $image_html = '<a href="' . $link['url']
                . '" title="' . esc_html($name)
                . '" target="' . esc_attr($link['target'])
                . '">' . wp_get_attachment_image($image, $this->settings['image_size'], false, array('class' => 'lvca-image large', 'alt' => $name))
                . '</a>';
        else:

            $image_html = wp_get_attachment_image($image, $this->settings['image_size'], false, array('class' => 'lvca-image large', 'alt' => $name));

        endif;

        $entry_image .= apply_filters('lvca_gallery_carousel_thumbnail_html', $image_html, $settings);

        $image_info = '<div class="lvca-image-info">';

        $entry_info = '<div class="lvca-entry-info">';

        if ($this->settings['display_item_title']):

            $entry_title = '<h3 class="lvca-entry-title">';

            if ($item_type == 'image' && !empty($link)):

                $entry_title .= '<a href="' . $link['url']
                    . '" title="' . esc_html($name)
                    . '" target="' . esc_attr($link['target'])
                    . '">' . esc_html($name)
                    . '</a>';

            else:

                $entry_title .= esc_html($name);

            endif;

            $entry_title .= '</h3>';

            $entry_info .= apply_filters('lvca_gallery_carousel_entry_info_title', $entry_title, $settings);

        endif;

        if ($item_type == 'youtube' || $item_type == 'vimeo') :

            $video_url = $video_link;

            if (!empty($video_url)) :

                $video_lightbox = '<a class="lvca-video-lightbox" data-fancybox="' . $this->settings['gallery_class']
                    . '" href="' . $video_url
                    . '" title="' . esc_html($name)
                    . '" data-description="' . wp_kses_post($description)
                    . '">';

                $video_lightbox .= '<i class="lvca-icon-video-play"></i>';

                $video_lightbox .= '</a>';

                $entry_info .= apply_filters('lvca_gallery_carousel_video_lightbox_link', $video_lightbox, $video_url, $settings);

            endif;

        elseif ($item_type == 'html5video' && !empty($mp4_video_link)) :

            $video_id = 'lvca-video-' . $image; // will use thumbnail id as id for video for now

            $video_lightbox = '<a class="lvca-video-lightbox" data-fancybox="' . $this->settings['gallery_class']
                . '" href="#' . $video_id
                . '" title="' . esc_html($name)
                . '" data-description="' . wp_kses_post($description)
                . '">';

            $video_lightbox .= '<i class="lvca-icon-video-play"></i>';

            $video_lightbox .= '</a>';

            $video_lightbox .= '<div id="' . $video_id . '" class="lvca-fancybox-video">';

            $image_data = wp_get_attachment_image_src($image, 'full');

            $image_src = ($image_data) ? $image_data[0] : '';

            $video_lightbox .= '<video poster="' . $image_src
                . '" src="' . $mp4_video_link
                . '" autoplay="1" preload="metadata" controls controlsList="nodownload">';

            $video_lightbox .= '<source type="video/mp4" src="' . $mp4_video_link . '">';

            $video_lightbox .= '<source type="video/webm" src="' . $webm_video_link . '">';

            $video_lightbox .= '</video>';

            $video_lightbox .= '</div>';

            $entry_info .= apply_filters('lvca_gallery_carousel_html5video_lightbox_link', $video_lightbox, $settings);

        endif;
        if ($this->settings['display_item_tags']):

            $entry_info .= apply_filters('lvca_gallery_carousel_info_tags', '<span class="lvca-terms">' . esc_html($tags) . '</span>', $settings);

        endif;

        $entry_info .= '</div>';

        $image_info .= apply_filters('lvca_gallery_carousel_entry_info', $entry_info, $settings);

        if ($item_type == 'image' && $this->settings['enable_lightbox']) :

            $image_data = wp_get_attachment_image_src($image, 'full');

            if ($image_data) :

                $image_src = $image_data[0];

                $lightbox_item = '<a class="lvca-lightbox-item" data-fancybox="' . $this->settings['gallery_class']
                    . '" href="' . $image_src
                    . '" title="' . esc_html($name)
                    . '" data-description="' . wp_kses_post($description)
                    . '">';

                $lightbox_item .= '<i class="lvca-icon-full-screen"></i>';

                $lightbox_item .= '</a>';

                $image_info .= apply_filters('lvca_gallery_carousel_fancybox_lightbox_link', $lightbox_item, $settings);

            endif;

        endif;

        $image_info .= '</div><!-- .lvca-image-info -->';

        $entry_image .= apply_filters('lvca_gallery_carousel_image_info', $image_info, $settings);

        $entry_image .= '</div><!-- .lvca-project-image -->';

        $entry_output .= apply_filters('lvca_gallery_carousel_entry_image', $entry_image, $settings);

        /* Allow users to output whatever data they want to after displaying the image - at present
        we don't display anything but things can change */

        $entry_text = '';

        $entry_output .= apply_filters('lvca_gallery_carousel_entry_text', $entry_text, $settings);

        $entry_output .= '</div><!-- .lvca-gallery-carousel-item -->';

        $output = apply_filters('lvca_gallery_carousel_item_output', $entry_output, $settings);

        return $output;

    }

    function map_vc_element() {
        if (function_exists("vc_map")) {

            $carousel_params = array(
                array(
                    'type' => 'checkbox',
                    "param_name" => "enable_lightbox",
                    'heading' => __('Enable Lightbox Gallery?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true')
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
                    "param_name" => "display_item_title",
                    'heading' => __('Display Item Title?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true')
                ),

                array(
                    'type' => 'checkbox',
                    "param_name" => "display_item_tags",
                    'heading' => __('Display Item Tags?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true')
                ),
            );

            $carousel_params = array_merge($carousel_params, lvca_get_vc_map_carousel_options());

            $carousel_params = array_merge($carousel_params, lvca_get_vc_map_carousel_display_options());

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Gallery Carousel", "livemesh-vc-addons"),
                "base" => "lvca_gallery_carousel",
                "as_parent" => array('only' => 'lvca_gallery_carousel_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                "content_element" => true,
                "show_settings_on_create" => true,
                "category" => __("Livemesh Addons", "livemesh-vc-addons"),
                "is_container" => true,
                'description' => __('Display images or videos in a responsive carousel.', 'livemesh-vc-addons'),
                "js_view" => 'VcColumnView',
                "icon" => 'icon-lvca-gallery-carousel',
                "params" => $carousel_params
            ));


        }
    }


    function map_child_vc_element() {
        if (function_exists("vc_map")) {

            vc_map(array(
                    "name" => __("Gallery Carousel Item", "livemesh-vc-addons"),
                    "base" => "lvca_gallery_carousel_item",
                    "as_child" => array('only' => 'lvca_gallery_carousel'), // Use only|except attributes to limit parent (separate multiple values with comma)
                    "icon" => 'icon-lvca-carousel-item',
                    "category" => __("Livemesh Addons", "livemesh-vc-addons"),
                    "params" => array(

                        array(
                            'type' => 'dropdown',
                            'param_name' => 'item_type',
                            'heading' => __('Item Type', 'livemesh-vc-addons'),
                            'description' => __('Specify the item type - if this is an image or represents a YouTube/Vimeo/HTML5 video.', 'livemesh-vc-addons'),
                            'std' => 'image',
                            'value' => array(
                                __('Image', 'livemesh-vc-addons') => 'image',
                                __('YouTube Video', 'livemesh-vc-addons') => 'youtube',
                                __('Vimeo Video', 'livemesh-vc-addons') => 'vimeo',
                                __('HTML5 Video', 'livemesh-vc-addons') => 'html5video',
                            )
                        ),
                        array(
                            'type' => 'textfield',
                            'param_name' => 'name',
                            'heading' => __('Item Label', 'livemesh-vc-addons'),
                            'description' => __('The label or name for the gallery item.', 'livemesh-vc-addons'),
                            'admin_label' => true
                        ),
                        array(
                            'type' => 'attach_image',
                            'param_name' => 'image',
                            'heading' => __('Gallery Image.', 'livemesh-vc-addons'),
                            'description' => __('The image for the gallery item. If item type chosen is YouTube or Vimeo or MP4/WebM video, the image will be used as a placeholder image for video.', 'livemesh-vc-addons'),
                        ),
                        array(
                            'type' => 'textfield',
                            'param_name' => 'tags',
                            'heading' => __('Item Tag(s)', 'livemesh-vc-addons'),
                            'description' => __('One or more comma separated tags for the gallery item.', 'livemesh-vc-addons'),
                        ),
                        array(
                            'type' => 'vc_link',
                            'param_name' => 'link',
                            'heading' => __('Page URL', 'livemesh-vc-addons'),
                            'description' => __('The URL of the page to which the image gallery item points to (optional).', 'livemesh-vc-addons'),
                            'dependency' => array(
                                'element' => 'item_type',
                                'value' => array('image'),
                            ),
                        ),
                        array(
                            'type' => 'textfield',
                            'param_name' => 'video_link',
                            'heading' => __('Video URL', 'livemesh-vc-addons'),
                            'description' => __('The URL of the YouTube or Vimeo video.', 'livemesh-vc-addons'),
                            'dependency' => array(
                                'element' => 'item_type',
                                'value' => array('youtube', 'vimeo'),
                            ),
                        ),
                        array(
                            'type' => 'textfield',
                            'param_name' => 'mp4_video_link',
                            'heading' => __('MP4 Video URL', 'livemesh-vc-addons'),
                            'description' => __('The URL of the MP4 video.', 'livemesh-vc-addons'),
                            'dependency' => array(
                                'element' => 'item_type',
                                'value' => array('html5video'),
                            ),
                        ),
                        array(
                            'type' => 'textfield',
                            'param_name' => 'webm_video_link',
                            'heading' => __('WebM Video URL', 'livemesh-vc-addons'),
                            'description' => __('The URL of the WebM video.', 'livemesh-vc-addons'),
                            'dependency' => array(
                                'element' => 'item_type',
                                'value' => array('html5video'),
                            ),
                        ),
                        array(
                            'type' => 'textarea',
                            'param_name' => 'description',
                            'heading' => __('Item description', 'livemesh-vc-addons'),
                            'description' => __('Short description for the gallery item displayed in the lightbox gallery.(optional)', 'livemesh-vc-addons'),
                        ),
                    )

                )
            );

        }
    }

}

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_lvca_gallery_carousel extends WPBakeryShortCodesContainer {
    }
}
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_gallery_carousel_item extends WPBakeryShortCode {
    }
}

// Initialize Element Class
if (class_exists('LVCA_Gallery_Carousel')) {
    new LVCA_Gallery_Carousel();
}