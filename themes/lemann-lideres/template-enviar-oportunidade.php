<?php
/**
 * Template Name: Enviar oportunidade
 */

if (!is_user_logged_in()) {
	wp_redirect( home_url( '/' ) );
	exit;
}

get_header();

// Page options
$header = ghostpool_option( 'page_header' ) == 'default' ? ghostpool_option( 'page_page_header' ) : ghostpool_option( 'page_header' );

ghostpool_page_header(
    $post_id = get_the_ID(),
    $type = $header,
    $bg = ghostpool_option( 'page_header_bg' ),
    $height = ghostpool_option( 'page_header_height', 'height' ) != '' ? ghostpool_option( 'page_header_height', 'height' ) : ghostpool_option( 'page_page_header_height', 'height' )
);

ghostpool_page_title( '', $header ); ?>

<div id="gp-content-wrapper" class="gp-container contain-embed">

    <?php do_action( 'ghostpool_begin_content_wrapper' ); ?>

    <div id="gp-inner-container">

        <div id="gp-content">

            <iframe id="embed" src="/wp-admin/post-new.php?post_type=oportunidade&hide_menu=1" frameborder="0" scrolling="auto" style="width: 100%;"></iframe>
            <script type="text/javascript" src="https://unpkg.com/iframe-resizer@4.1.1/js/iframeResizer.min.js"></script>
            <script type="text/javascript">
                document.querySelector('.gp-fullwidth').classList.remove('gp-fullwidth');
                iFrameResize({
                    heightCalculationMethod: 'lowestElement',
                    log: false
                }, '#embed');
            </script>
        </div>

        <?php get_sidebar( 'left' ); ?>

        <?php get_sidebar( 'right' ); ?>

    </div>

    <?php do_action( 'ghostpool_end_content_wrapper' ); ?>

    <div class="gp-clear"></div>

</div>

<?php get_footer(); ?>
