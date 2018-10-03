<?php

/**
 * Gallery class.
 *
 */
class LVCA_Gallery_Common {

    /**
     * Holds the class object.
     */
    public static $instance;

    /**
     * Primary class constructor.
     * 
     */
    public function __construct() {

        add_filter('attachment_fields_to_edit', array($this, 'attachment_field_grid_width'), 10, 2);
        add_filter('attachment_fields_to_save', array($this, 'attachment_field_grid_width_save'), 10, 2);

        // Ajax calls
        add_action('wp_ajax_lvca_load_gallery_items', array( $this, 'load_gallery_items_callback'));
        add_action('wp_ajax_nopriv_lvca_load_gallery_items', array( $this, 'load_gallery_items_callback'));

    }

    public function attachment_field_grid_width( $form_fields, $post ) {
        $form_fields['lvca_grid_width'] = array(
            'label' => esc_html__( 'Masonry Width', 'livemesh-vc-addons' ),
            'input' => 'html',
            'html' => '
<select name="attachments[' . $post->ID . '][lvca_grid_width]" id="attachments-' . $post->ID . '-lvca_grid_width">
  <option ' . selected(get_post_meta( $post->ID, 'lvca_grid_width', true ), "lvca-default", false) .' value="lvca-default">' . esc_html__('Default', 'livemesh-vc-addons') .'</option>
  <option ' . selected(get_post_meta( $post->ID, 'lvca_grid_width', true ), "lvca-wide", false) .' value="lvca-wide">' . esc_html__('Wide', 'livemesh-vc-addons') .'</option>
</select>',
            'value' => get_post_meta( $post->ID, 'lvca_grid_width', true ),
            'helps' => esc_html__('Width of the image in masonry gallery grid', 'livemesh-vc-addons')
        );

        return $form_fields;
    }

    public function attachment_field_grid_width_save( $post, $attachment ) {
        if( isset( $attachment['lvca_grid_width'] ) )
            update_post_meta( $post['ID'], 'lvca_grid_width', $attachment['lvca_grid_width'] );

        return $post;
    }


    function load_gallery_items_callback() {
        $items = $this->parse_items($_POST['items']);
        $settings = $this->parse_gallery_settings($_POST['settings']);
        $paged = intval($_POST['paged']);

        echo $this->build_gallery($items, $settings);

        wp_die();

    }

    function parse_items($items) {

        $parsed_items = array();

        foreach ($items as $item):

            // Remove encoded quotes or other characters
            $item['name'] = stripslashes($item['name']);

            $item['description'] = stripslashes($item['description']);

            $item['link'] = isset($item['link']) ? filter_var($item['link'], FILTER_DEFAULT) : '';

            $item['video_link'] = isset($item['video_link']) ? filter_var($item['video_link'], FILTER_DEFAULT) : '';

            $item['mp4_video_link'] = isset($item['mp4_video_link']) ? filter_var($item['mp4_video_link'], FILTER_DEFAULT) : '';

            $item['webm_video_link'] = isset($item['webm_video_link']) ? filter_var($item['webm_video_link'], FILTER_DEFAULT) : '';

            $item['display_video_inline'] = isset($item['display_video_inline']) ? filter_var($item['display_video_inline'], FILTER_VALIDATE_BOOLEAN) : false;

            $parsed_items[] = $item;

        endforeach;

        return apply_filters('lvca_gallery_parsed_items', $parsed_items, $items);
    }

    function parse_gallery_settings($settings) {

        $s = $settings;

        $s['gallery_class'] = filter_var($s['gallery_class'], FILTER_DEFAULT);

        $s['filterable'] = filter_var($s['filterable'], FILTER_VALIDATE_BOOLEAN);

        $s['per_line'] = filter_var($s['per_line'], FILTER_VALIDATE_INT);

        $s['per_line_tablet'] = filter_var($s['per_line_tablet'], FILTER_VALIDATE_INT);

        $s['per_line_mobile'] = filter_var($s['per_line_mobile'], FILTER_VALIDATE_INT);

        $s['items_per_page'] = filter_var($s['items_per_page'], FILTER_VALIDATE_INT);

        $s['enable_lightbox'] = filter_var($s['enable_lightbox'], FILTER_VALIDATE_BOOLEAN);

        $s['display_item_tags'] = filter_var($s['display_item_tags'], FILTER_VALIDATE_BOOLEAN);

        $s['display_item_title'] = filter_var($s['display_item_title'], FILTER_VALIDATE_BOOLEAN);

        return apply_filters('lvca_gallery_parsed_settings', $s);
    }

    function build_gallery($items, $settings) {

        $output = '';

        $gallery_video = LVCA_Gallery_Video::get_instance();

        foreach ($items as $item):

            $item_type = $item['item_type'];

            // No need to populate anything if no image is provided for the image
            if ($item_type == 'image' && empty($item['image']))
                continue;

            $style = '';
            if (!empty($item['tags'])) {
                $terms = array_map('trim', explode(',', $item['tags']));

                foreach ($terms as $term) {
                    // Get rid of spaces before adding the term
                    $style .= ' term-' . preg_replace('/\s+/', '-', $term);
                }
            }
            $item_class = 'lvca-' . $item_type . '-type';

            $custom_class = get_post_meta($item['image'], 'lvca_grid_width', true);

            if ($custom_class !== '')
                $item_class .= ' ' . $custom_class;

            $entry_output = '<div class="lvca-grid-item lvca-gallery-item ' . $style . ' ' . $item_class . '">';

            if ($gallery_video->is_inline_video($item, $settings)):

                $entry_output .= $gallery_video->get_inline_video($item, $settings);

            else:

                $entry_image = '<div class="lvca-project-image">';

                $link = NULL;

                if (!empty($item['link'])) {

                    if (function_exists('vc_build_link'))
                        $link = vc_build_link($item['link']);
                    else
                        $link = explode('|', $item['link']);
                }

                if ($gallery_video->is_gallery_video($item, $settings)):

                    $image_html = '';

                    if (isset($item['image']) && !empty($item['image'])):

                        $image_html = wp_get_attachment_image($item['image'], $settings['image_size'], false, array('class' => 'lvca-image large', 'alt' => $item['name']));

                    elseif ($item_type == 'youtube' || $item_type == 'vimeo') :

                        $thumbnail_url = $gallery_video->get_video_thumbnail_url($item['video_link'], $settings);

                        if (!empty($thumbnail_url)):

                            $image_html = sprintf('<img src="%s" title="%s" alt="%s" class="lvca-image"/>', esc_attr($thumbnail_url), esc_html($item['name']), esc_html($item['name']));

                        endif;

                    endif;

                    $entry_image .= apply_filters('lvca_gallery_video_thumbnail_html', $image_html, $item, $settings);

                else:

                    $image_html = wp_get_attachment_image($item['image'], $settings['image_size'], false, array('class' => 'lvca-image large', 'alt' => $item['name']));

                    if ($item_type == 'image' && !empty($link['url'])):

                        $image_html = '<a href="' . esc_url($link['url']) 
                            . '" title="' . esc_html($item['name'])
                            . '" target="' . esc_html($link['target'])
                            . '">' . $image_html . '</a>';

                    endif;

                    $entry_image .= apply_filters('lvca_gallery_thumbnail_html', $image_html, $item, $settings);

                endif;

                $image_info = '<div class="lvca-image-info">';

                $entry_info = '<div class="lvca-entry-info">';

                if ($settings['display_item_title']):

                    $entry_title = '<h3 class="lvca-entry-title">';

                    if ($item_type == 'image' && !empty($link)):

                        $entry_title .= '<a href="' . esc_url($link['url']) 
                            . '" title="' . esc_html($link['title'])
                            . '" target="' . esc_html($link['target']) 
                            . '">' . esc_html($item['name']) . '</a>';

                    else:

                        $entry_title .= esc_html($item['name']);

                    endif;

                    $entry_title .= '</h3>';

                    $entry_info .= apply_filters('lvca_gallery_entry_info_title', $entry_title, $item, $settings);

                endif;

                if ($gallery_video->is_gallery_video($item, $settings)):

                    $entry_info .= $gallery_video->get_video_lightbox_link($item, $settings);

                endif;

                if ($settings['display_item_tags']):

                    $entry_info .= apply_filters('lvca_gallery_info_tags', '<span class="lvca-terms">' . esc_html($item['tags']) . '</span>', $item , $settings);

                endif;

                $entry_info .= '</div><!-- .lvca-entry-info -->';

                $image_info .= apply_filters('lvca_gallery_entry_info', $entry_info, $item, $settings);

                if ($item_type == 'image' && !empty($item['image']) && $settings['enable_lightbox']) :

                    $anchor_type = (empty($link['url']) ? 'lvca-click-anywhere' : 'lvca-click-icon');

                    $image_info .= $this->display_image_lightbox_link($item, $settings, $anchor_type);

                endif;

                $image_info .= '</div><!-- .lvca-image-info -->';

                $entry_image .= apply_filters('lvca_gallery_image_info', $image_info, $item, $settings);

                $entry_image .= '</div><!-- .lvca-project-image -->';

                $entry_output .= apply_filters('lvca_gallery_entry_image', $entry_image, $item, $settings);

            endif;

            /* Allow users to output whatever data they want to after displaying the image - at present
            we don't display anything but things can change */

            $entry_text = '';

            $entry_output .= apply_filters('lvca_gallery_entry_text', $entry_text, $item, $settings);

            $entry_output .= '</div>';

            $output .= apply_filters('lvca_gallery_item_output', $entry_output, $item, $settings);

        endforeach;

        return $output;

    }

    function display_image_lightbox_link($item, $settings, $anchor_type) {

        $image_data = wp_get_attachment_image_src($item['image'], 'full');

        if ($image_data) :

            $image_src = $image_data[0];

            $output = '<a class="lvca-lightbox-item ' . $anchor_type
                . '" data-fancybox="' . $settings['gallery_class']
                . '" href="' . $image_src
                . '" title="' . esc_html($item['name'])
                . '" data-description="' . wp_kses_post($item['description']) . '">';

            $output .= '<i class="lvca-icon-full-screen"></i>';

            $output .= '</a>';

            $output = apply_filters('lvca_gallery_fancybox_lightbox_link', $output, $item, $settings);

        endif;

        return apply_filters('lvca_gallery_image_lightbox_link', $output, $item, $settings);
    }

    function get_gallery_terms($items) {

        $tags = $terms = array();

        foreach ($items as $item) {
            $tags = array_merge($tags, explode(',', $item['tags']));
        }

        // trim whitespaces before applying array_unique
        $tags = array_map('trim', $tags);

        $terms = array_values(array_unique($tags));

        return apply_filters('lvca_gallery_terms', $terms);

    }

    function get_items_to_display($items, $paged, $items_per_page) {

        $offset = $items_per_page * ($paged - 1);

        $items = array_slice($items, $offset, $items_per_page);

        return $items;
    }

    function paginate_gallery($items, $settings) {

        $pagination_type = $settings['pagination'];

        // no pagination required if option is not chosen by user or if all posts are already displayed
        if ($pagination_type == 'none' || count($items) <= $settings['items_per_page'])
            return;

        $max_num_pages = ceil(count($items) / $settings['items_per_page']);

        $output = '<div class="lvca-pagination">';

        if ($pagination_type == 'load_more') {

            $load_more_output = '<a href="#" class="lvca-load-more lvca-button">';

            $load_more_output .= esc_html__('Load More', 'livemesh-vc-addons');

            if ($settings['show_remaining'])
                $load_more_output .= ' - ' . '<span>' . (count($items) - $settings['items_per_page']) . '</span>';

            $load_more_output .= '</a>';

            $output .= apply_filters('lvca_gallery_load_more_output', $load_more_output, $items, $settings);
        }
        else {
            $page_links = array();

            for ($n = 1; $n <= $max_num_pages; $n++) :
                $page_links[] = '<a class="lvca-page-nav lvca-numbered' . ($n == 1 ? ' lvca-current-page' : '') . '" href="#" data-page="' . $n . '">' . number_format_i18n($n) . '</a>';
            endfor;

            $page_links_output = join("\n", $page_links);

            if (!empty($page_links)) {

                $prev_link = '<a class="lvca-page-nav lvca-disabled" href="#" data-page="prev"><i class="lvca-icon-arrow-left3"></i></a>';

                $next_link = '<a class="lvca-page-nav" href="#" data-page="next"><i class="lvca-icon-arrow-right3"></i></a>';

                $page_links_output = $prev_link . "\n" . $page_links_output . "\n" . $next_link;

                $output .= apply_filters('lvca_gallery_page_links_output', $page_links_output, $items, $settings);
            }
        }

        $output .= '<span class="lvca-loading"></span>';

        $output .= '</div>';

        return apply_filters('lvca_gallery_pagination', $output, $items, $settings);

    }

    /** Isotope filtering support for Gallery * */

    function get_gallery_terms_filter($terms) {

        $output = '';

        if (!empty($terms)) {

            $output .= '<div class="lvca-taxonomy-filter">';

            $output .= '<div class="lvca-filter-item segment-0 lvca-active"><a data-value="*" href="#">' . esc_html__('All', 'livemesh-vc-addons') . '</a></div>';

            $segment_count = 1;

            foreach ($terms as $term) {

                if (trim($term) !== '') {

                    $output .= '<div class="lvca-filter-item segment-' . intval($segment_count) . '"><a href="#" data-value=".term-' . preg_replace('/\s+/', '-', $term) . '" title="' . esc_html__('View all items filed under ', 'livemesh-vc-addons') . esc_attr($term) . '">' . esc_html($term) . '</a></div>';

                    $segment_count++;
                }
            }

            $output .= '</div>';

        }

        return apply_filters('lvca_gallery_terms_filter', $output, $terms);
    }

    /**
     * Returns the singleton instance of the class.
     * 
     */
    public static function get_instance() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof LVCA_Gallery_Common ) ) {
            self::$instance = new LVCA_Gallery_Common();
        }

        return self::$instance;

    }

}

// Load the metabox class.
$lvca_gallery_common = LVCA_Gallery_Common::get_instance();


