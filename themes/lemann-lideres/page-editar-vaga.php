<?php get_header();

$header = ghostpool_option('page_header') == 'default' ? ghostpool_option('page_page_header') : ghostpool_option('page_header');

ghostpool_page_header($post_id = $post_id, $type = $header, $bg = ghostpool_option('page_header_bg'), $height = ghostpool_option('page_header_height', 'height') != '' ? ghostpool_option('page_header_height', 'height') : ghostpool_option('page_page_header_height', 'height'));

ghostpool_page_title('', $header);

$_REQUEST['job_id'] = get_the_ID();
$jobs = WP_Job_Manager_Forms::instance();
?>

<div id="gp-content-wrapper" class="gp-container">
    <?php do_action('ghostpool_begin_content_wrapper'); ?>

    <div id="gp-inner-container">
        <div id="gp-content">
            <?= $jobs->get_form('edit-job'); ?>
        </div>
    </div>

    <?php do_action('ghostpool_end_content_wrapper'); ?>

    <div class="gp-clear"></div>
</div>

<?php get_footer(); ?>
<?php die(); ?>