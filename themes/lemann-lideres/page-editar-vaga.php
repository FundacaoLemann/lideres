<?php get_header();

$header = ghostpool_option('page_header') == 'default' ? ghostpool_option('page_page_header') : ghostpool_option('page_header');

ghostpool_page_header($post_id = $post_id, $type = $header, $bg = ghostpool_option('page_header_bg'), $height = ghostpool_option('page_header_height', 'height') != '' ? ghostpool_option('page_header_height', 'height') : ghostpool_option('page_page_header_height', 'height'));

ghostpool_page_title('', $header);
?>

<div id="gp-content-wrapper" class="gp-container">
    <?php do_action('ghostpool_begin_content_wrapper'); ?>

    <div id="gp-inner-container">
        <div id="gp-content">
            <?php // $job_id = $post_id; $job_id = 100001295; get_template_part('job_manager/job-submit'); ?>
            <?php
                get_job_manager_template('job-submit.php', [
                    'form' => 'edit-job',
                    'job_id' => 100001295,
                    'resume_edit' => true,
                    'action' => wp_unslash($_SERVER['REQUEST_URI']),
                    'job_fields' => $fields['job'],
                    'company_fields' => $fields['company'],
                    'step' => 0,
                    'submit_button_text' => 'Test'
                ]);
            ?>
        </div>
    </div>

    <?php do_action('ghostpool_end_content_wrapper'); ?>

    <div class="gp-clear"></div>
</div>

<?php get_footer(); ?>