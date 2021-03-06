<?php

class LVCA_Block_Header_6 extends LVCA_Block_Header {

    function get_block_taxonomy_filter() {

        $output = '';

        $terms = $this->get_block_filter_terms();

        if (empty($terms) || is_wp_error($terms))
            return '';

        $output .= '<div class="lvca-taxonomy-filter">';

        $output .= '<div class="lvca-filter-item segment-0 lvca-active"><a data-term-id="" data-taxonomy="" href="#">' . esc_html__('All', 'livemesh-vc-addons') . '</a></div>';

        $segment_count = 1;
        foreach ($terms as $term) {

            $output .= '<div class="lvca-filter-item segment-' . intval($segment_count) . '"><a href="#" data-term-id="' . $term->term_id . '" data-taxonomy="' . $term->taxonomy . '" title="' . esc_html__('View all items filed under ', 'livemesh-vc-addons') . esc_attr($term->name) . '">' . esc_html($term->name) . '</a></div>';

            $segment_count++;
        }

        $output .= '</div>';

        return $output;

    }

    function get_block_header_class() {

        return 'lvca-block-header-expanded lvca-block-header-6';

    }
}