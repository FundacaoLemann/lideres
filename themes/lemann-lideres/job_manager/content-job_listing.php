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

// Based in: https://www.the-art-of-web.com/php/truncate/
$truncate_text = function($string) {
	if (strlen($string) <= 100) return $string;

	if (false !== ($breakpoint = strpos($string, ' ', 100))) {
	    if ($breakpoint < strlen($string) - 1) {
		    $string = substr($string, 0, $breakpoint) . ' ';
	    }
	}

	return $string . '...';
};

global $post;
?>
<li <?php job_listing_class(); ?> data-longitude="<?php echo esc_attr( $post->geolocation_lat ); ?>" data-latitude="<?php echo esc_attr( $post->geolocation_long ); ?>">
	<div class="match">Fit <strong>50%</strong></div>
	<?php the_company_logo(); ?>
	<a class="position" href="<?php the_job_permalink(); ?>">
		<h3><?php wpjm_the_job_title(); ?></h3>
		<p>Oferecida por <strong><?php the_company_name(); ?></strong> em <strong><?php the_job_location( false ); ?></strong></p>
		<p><?php echo $truncate_text( strip_tags( wpjm_get_the_job_description() )); ?></p>
	</a>
</li>