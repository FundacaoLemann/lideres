<?php
defined( 'ABSPATH' ) || exit;

function ghostpool_page_header( $post_id = '', $type = 'gp-standard-page-header', $bg = '', $height = '' ) {

	if ( $post_id == '' ) {
		$post_id = get_the_ID();
	}

	$bg_css     = '';
	$height_css = '';

	if ( $type != 'gp-standard-page-header' or ghostpool_option( 'page_header_video_bg' ) != '' ) {

		// BuddyPress user pages
		if ( function_exists( 'bp_is_active' ) && bp_is_user() && bp_displayed_user_use_cover_image_header() ) {

			$cover_image_url = bp_attachments_get_attachment(
				'url', array(
					'members' => 'groups',
					'item_id' => bp_displayed_user_id(),
				)
			);
			if ( $cover_image_url ) {
				$bg_css = 'background-image: url(' . $cover_image_url . ');';
			}

			// BuddyPress group pages
		} elseif ( function_exists( 'bp_is_active' ) && bp_is_group_single() && bp_group_use_cover_image_header() ) {

			global $bp;
			$cover_image_url = bp_attachments_get_attachment(
				'url', array(
					'object_dir' => 'groups',
					'item_id'    => $bp->groups->current_group->id,
				)
			);
			if ( $cover_image_url ) {
				$bg_css = 'background-image: url(' . $cover_image_url . ');';
			}

			// bbPress
		} elseif ( ( function_exists( 'is_bbpress' ) && is_bbpress() ) && ( $bg && $bg['url'] != '' ) ) {
			$bg_css = 'background-image: url(' . $bg['url'] . ');';

			// WooCommerce
		} elseif ( ( function_exists( 'is_woocommerce' ) && is_shop() ) && ( $bg && $bg['url'] != '' ) ) {
			$bg_css = 'background-image: url(' . $bg['url'] . ');';

			// Page header option for posts/pages and search/author pages
		} elseif ( ( is_singular() or is_search() or is_author() ) && ( $bg && $bg['url'] != '' ) ) {
			$bg_css = 'background-image: url(' . $bg['url'] . ');';

			// Featured image option for posts/pages
		} elseif ( is_singular() && has_post_thumbnail( $post_id ) ) {
			$bg_css = 'background-image: url(' . wp_get_attachment_url( get_post_thumbnail_id( $post_id ) ) . ');';

			// Category
		} elseif ( is_archive() && ! is_search() && ! is_author() && ! is_array( $bg ) && $bg != '' ) {
			$bg_css = 'background-image: url(' . $bg . ');';

		} else {

			$bg_css = '';

		}

		// Page header height styling
		$height_css = 'height: ' . $height . ';';

	}

	?>

	<?php if ( $type == 'gp-full-page-page-header' ) { ?>
		<div id="gp-full-page-bg" style="<?php echo esc_attr( $bg_css ); ?>"></div>
	<?php } ?>

	<?php
	if (
		! is_singular( 'job_listing' ) and
		(
			$type == 'gp-fullwidth-page-header' or
			$type == 'gp-full-page-page-header' or
			( function_exists( 'bp_is_active' ) && ( bp_is_user() or bp_is_group_single() ) )
		)
	) {

		$classes = array();

		if ( ghostpool_option( 'theme_layout' ) == 'gp-boxed-layout' ) {
			$classes[] = 'gp-container';
		}

		if ( ! empty( $bg_css ) ) {
			$classes[] = 'gp-has-header-bg';
		}

		$css_classes = implode( ' ', $classes );

		?>

		<header id="gp-page-header" class="<?php echo esc_attr( $css_classes ); ?>">

			<div id="gp-page-header-inner"
			<?php
			if ( $type != 'gp-full-page-page-header' && ghostpool_option( 'page_header_video' ) == '' ) {
				?>
				 style="<?php echo esc_attr( $bg_css ); ?>"<?php } ?>">

				<div class="gp-container" style="<?php echo esc_attr( $height_css ); ?>">

					<?php ghostpool_page_header_video(); ?>

					<?php
					if ( function_exists( 'bp_is_active' ) && bp_is_user() ) {

						bp_get_template_part( 'members/single/member-header' );

					} elseif ( function_exists( 'bp_is_active' ) && bp_is_group_single() ) {

						bp_get_template_part( 'groups/single/group-header' );

					}
					?>

				</div>

			</div>

			<?php ghostpool_page_header_video_bg(); ?>

			<?php if ( function_exists( 'bp_is_active' ) && ( bp_is_user() or bp_is_group_single() ) ) { ?>
				<div id="gp-bp-header-overlay"></div>
			<?php } ?>

			<?php if ( ghostpool_option( 'theme_layout' ) != 'gp-boxed-layout' ) { ?>
				<div class="gp-blurred-bg" style="
				<?php
				if ( $type != 'gp-full-page-page-header' ) {
					echo esc_attr( $bg_css ); }
				?>
				"></div>
			<?php } ?>

		</header>

		<?php
	}

}
