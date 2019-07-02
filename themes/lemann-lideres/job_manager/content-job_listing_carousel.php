<?php
/**
 * Job listing in the loop.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/content-job_listing.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager
 * @category    Template
 * @since       1.0.0
 * @version     1.27.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;
?>
<li <?php job_listing_class(); ?> data-longitude="<?php echo esc_attr( $post->geolocation_lat ); ?>" data-latitude="<?php echo esc_attr( $post->geolocation_long ); ?>">
	<?php
	$match = (array) get_user_meta( get_current_user_id(), LEMANN_MATCHES_META_KEY, true );
	if ( isset( $match[ $post->ID ] ) && $match[ $post->ID ]['match'] ) {
		$job_match = round( $match[ $post->ID ]['match'] );
		?>
		<div class="match-percentage<?php echo $job_match >= LEMANN_MATCH_MINIMO_EMAIL ? ' matched' : ''; ?>">Match <strong><?php echo $job_match; ?>%</strong></div>
		<?php
	}
	?>
	<?php company_logo_div('medium'); ?>
	<a class="position" href="<?php the_job_permalink(); ?>">
		<h3><?php wpjm_the_job_title(); ?></h3>
		<p>Oferecida por <strong><?php the_company_name(); ?></strong> em <strong><?php the_job_location( false ); ?></strong></p>
    </a>
    <p class="details">
        <a href="<?php the_job_permalink(); ?>">Ver vaga</a>
    </p>
</li>
