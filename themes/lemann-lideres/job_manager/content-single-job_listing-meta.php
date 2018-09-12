<?php
/**
 * Single view job meta box.
 *
 * Hooked into single_job_listing_start priority 20
 *
 * This template can be overridden by copying it to yourtheme/job_manager/content-single-job_listing-meta.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager
 * @category    Template
 * @since       1.14.0
 * @version     1.28.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

do_action( 'single_job_listing_meta_before' ); ?>

<ul class="job-listing-meta meta">
	<?php do_action( 'single_job_listing_meta_start' ); ?>

	<?php if ( get_option( 'job_manager_enable_types' ) ) { ?>
		<?php $types = wpjm_get_the_job_types(); ?>
		<?php if ( ! empty( $types ) ) : foreach ( $types as $type ) : ?>

			<li class="job-type <?php echo esc_attr( sanitize_title( $type->slug ) ); ?>"><?php echo esc_html( $type->name ); ?></li>

		<?php endforeach; endif; ?>
	<?php } ?>

	<li class="location"><?php the_job_location(); ?></li>

    <li class="date-posted"><?php the_job_publish_date(); ?></li>

    <?php
	$match = (array) get_user_meta( get_current_user_id(), LEMANN_MATCHES_META_KEY, true );
	if ( isset( $match[ $post->ID ] ) && $match[ $post->ID ]['match'] ) {
		$job_match = round( $match[ $post->ID ]['match'] );
		?>
		<li class="match-percentage"><strong><?php echo $job_match; ?>%</strong> de compatibilidade com a vaga</li>
		<?php
	}
	?>

	<?php if ( is_position_filled() ) : ?>
		<li class="position-filled"><?php _e( 'This position has been filled', 'wp-job-manager' ); ?></li>
	<?php elseif ( ! candidates_can_apply() && 'preview' !== $post->post_status ) : ?>
		<li class="listing-expired"><?php _e( 'Applications have closed', 'wp-job-manager' ); ?></li>
	<?php endif; ?>

	<?php do_action( 'single_job_listing_meta_end' ); ?>
</ul>

<?php do_action( 'single_job_listing_meta_after' ); ?>