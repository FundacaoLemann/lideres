<?php

global $woothemes_sensei;

/**
 * Enqueue Sensei stylesheet
 *
 */
if ( ! function_exists( 'ghostpool_sensei_enqueue_styles' ) ) {	
	function ghostpool_sensei_enqueue_styles() {
		wp_enqueue_style( 'gp-sensei', get_template_directory_uri() . '/lib/css/sensei.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'ghostpool_sensei_enqueue_styles' );

/**
 * Set default option values for Sensei
 *
 */
if ( get_option( 'ghostpool_sensei_defaults' ) !== '1' ) {
	
	function ghostpool_sensei_defaults() {	

		$fields = get_option( 'woothemes-sensei-settings' );
	
		$fields['access_permission'] = false;	
		$fields['course_author'] = true;
		$fields['course_archive_image_enable'] = true;
		$fields['course_archive_image_width'] = 250;
		$fields['course_archive_image_height'] = 135;
		$fields['course_archive_image_hard_crop'] = true;
		$fields['course_single_image_enable'] = true;
		$fields['course_single_image_width'] = 864;
		$fields['course_single_image_height'] = 467;
		$fields['course_single_image_hard_crop'] = true;
		$fields['course_lesson_image_enable'] = true;
		$fields['lesson_archive_image_width'] = 250;
		$fields['lesson_archive_image_height'] = 135;
		$fields['lesson_archive_image_hard_crop'] = true;
		$fields['lesson_single_image_enable'] = true;
		$fields['lesson_single_image_width'] = 864;
		$fields['lesson_single_image_height'] = 467;
		$fields['lesson_single_image_hard_crop'] = true;
		$fields['course_archive_featured_enable'] = true;
		$fields['lesson_comments'] = true;
		$fields['lesson_author'] = true;
		$fields['learner_profile_enable'] = true;
		$fields['learner_profile_show_courses'] = true;
		$fields['woocommerce_enabled'] = true;
				
		update_option( 'woothemes-sensei-settings', $fields );	
	
	}	
	add_action( 'init', 'ghostpool_sensei_defaults', 1 );	
	update_option( 'ghostpool_sensei_defaults', '1' );	
}

/**
 * Remove default Sensei elements
 *
 */

// Wrapper
remove_action( 'sensei_before_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper' ), 10 );
remove_action( 'sensei_after_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper_end' ), 10 );

// Course archive
remove_action( 'sensei_archive_before_course_loop', array( 'Sensei_Course', 'archive_header' ), 10 );

// Course loop
remove_action( 'sensei_course_content_inside_before', array( 'Sensei_Templates', 'the_title' ), 5 );
remove_action( 'sensei_course_content_inside_before', array( $woothemes_sensei->course, 'course_image' ), 10 );

// Lesson loop
remove_action( 'sensei_single_course_inside_before_lesson', array( 'Sensei_Lesson', 'the_lesson_meta' ), 5 );
remove_action( 'sensei_single_course_inside_before_lesson', array( 'Sensei_Lesson', 'the_lesson_thumbnail' ), 8 );

// Course results
remove_action( 'sensei_course_results_content_inside_before', array( $woothemes_sensei->course, 'course_image' ) );

// Learner profile
remove_action( 'sensei_learner_profile_inside_content_before', array( 'Sensei_Learner_Profiles', 'learner_profile_courses_heading' ), 30 );

// Single course
remove_action( 'sensei_single_course_content_inside_before', array( 'Sensei_Course', 'the_title' ), 10 );
remove_action( 'sensei_single_course_content_inside_before', array( $woothemes_sensei->course, 'course_image' ), 20 );
remove_action( 'sensei_single_course_content_inside_before', array( $woothemes_sensei->course, 'the_progress_statement' ), 15 );
remove_action( 'sensei_single_course_content_inside_before', array( $woothemes_sensei->course, 'the_progress_meter' ), 16 );
remove_action( 'sensei_single_course_content_inside_before', array( 'Sensei_Course', 'the_course_enrolment_actions' ), 30 );
remove_action( 'sensei_single_course_content_inside_before', array( 'Sensei_Course', 'the_course_video' ), 40 );
remove_action( 'sensei_single_course_content_inside_after', array( 'Sensei_Frontend', 'sensei_pagination' ), 30 );
 
// Single lesson
remove_action( 'sensei_single_lesson_content_inside_before', array( 'Sensei_Lesson', 'the_title' ), 15 );
remove_action( 'sensei_single_lesson_content_inside_before', array( 'Sensei_Lesson', 'the_lesson_image' ), 17 );
remove_action( 'sensei_single_lesson_content_inside_after', array( $woothemes_sensei->frontend, 'sensei_breadcrumb' ), 30 );

// Single quiz
remove_action( 'sensei_single_quiz_content_inside_before', array( 'Sensei_Quiz', 'the_title' ), 20 );

// Course category
remove_action( 'sensei_loop_course_before', array( 'Sensei_Course', 'course_category_title' ), 70 );

// Module tax
remove_action( 'sensei_loop_lesson_inside_before', array( $woothemes_sensei->lesson, 'the_archive_header' ), 20 );
remove_action( 'sensei_loop_lesson_inside_before', array( $woothemes_sensei->modules, 'module_archive_description' ), 30 );

// Lessons archive/tag
remove_action( 'sensei_loop_lesson_inside_before', array( $woothemes_sensei->frontend, 'lesson_tag_archive_description' ), 11 );
remove_action( 'sensei_content_lesson_inside_before', array( 'Sensei_Lesson', 'the_lesson_meta' ), 20 );
remove_action( 'sensei_content_lesson_inside_before', array( 'Sensei_Lesson', 'the_lesson_thumbnail' ), 30 );
 
// Remove teahcer login redirect
remove_filter( 'wp_login', array( Sensei()->teacher, 'teacher_login_redirect' ) );

/**
 * Add custom course archive titles
 *
 */
if ( ! function_exists( 'ghostpool_sensei_course_loop_content_class' ) ) {	
	function ghostpool_sensei_course_loop_content_class( $extra_classes ) {
		$extra_classes[] = 'gp-post-item';
		return $extra_classes;
	}
}
add_filter( 'sensei_course_loop_content_class', 'ghostpool_sensei_course_loop_content_class' );

/**
 * Add custom Sensei titles
 *
 */
if ( ! function_exists( 'ghostpool_sensei_archive_header' ) ) {	
	function ghostpool_sensei_archive_header() {

        if ( isset( $_GET[ 'course_filter' ] ) && '' != $_GET[ 'course_filter' ] ) {
            $query_type = $_GET[ 'course_filter' ];
        } else {
        	$query_type = '';
        }
        switch ( $query_type ) {
            case 'new':
                $title = esc_html__( 'New Courses', 'aardvark' ); break;
            case 'featured':
                $title = esc_html__( 'Featured Courses', 'aardvark' ); break;
            case 'free':
                $title = esc_html__( 'Free Courses', 'aardvark' ); break;
            case 'paid':
                $title = esc_html__( 'Paid Courses', 'aardvark' ); break;
            default:
                $title = esc_html__( 'Courses', 'aardvark' );
        }
        
		echo esc_attr( $title ); 
	}
}

/**
 * Change lesson archive slug
 *
 */
if ( ! function_exists( 'ghostpool_sensei_lesson_slug' ) ) {	
	function ghostpool_sensei_lesson_slug() {
		return 'lessons';
	}      
}
add_filter( 'sensei_lesson_slug', 'ghostpool_sensei_lesson_slug' );
    
/**
 * Change purchase/start course button text
 *
 */
if ( ! function_exists( 'ghostpool_wc_single_add_to_cart_button_text' ) ) {	
	function ghostpool_wc_single_add_to_cart_button_text() {
		return esc_html__( 'Purchase This Course', 'aardvark' );
	}
}
add_filter( 'sensei_wc_single_add_to_cart_button_text', 'ghostpool_wc_single_add_to_cart_button_text' );

/**
 * Purchase course button
 *
 */
if ( ! function_exists( 'ghostpool_purchase_course_button' ) ) {
	function ghostpool_purchase_course_button( $post_id = 0 ) { 
	
		if ( ! $post_id ) {
			return 0;
		}
			
		if ( function_exists( 'is_woocommerce' ) && isset( $GLOBALS['ghostpool_course_purchase_button'] ) && $GLOBALS['ghostpool_course_purchase_button'] == '1' ) {
			
			$course_product_id = Sensei_WC::get_course_product_id( absint( get_the_ID() ) ); 
			if ( $course_product_id ) {
				
				return '<form action="/?add-to-cart=' . $course_product_id . '" class="cart" method="post" enctype="multipart/form-data">
					<input type="hidden" name="product_id" value="' . $course_product_id . '">
					<input type="hidden" name="quantity" value="1">
					<button type="submit" class="single_add_to_cart_button gp-loop-purchase-button">' . esc_html__( 'Purchase', 'aardvark' ) . '</button>
				</form>';
				
			} 
			
		}
		
	}
}

/**
 * Count number of learners for each course
 *
 */
if ( ! function_exists( 'ghostpool_course_participant_count' ) ) {
	function ghostpool_course_participant_count( $post_id = 0 ) {

		if ( ! $post_id ) {
			return 0;
		}

		$activity_args = array(
			'post_id' => $post_id,
			'type' => 'sensei_course_status',
			'count' => true,
			'number' => 0,
			'offset' => 0,
			'status' => 'any',
		);

		$course_learners = WooThemes_Sensei_Utils::sensei_check_for_activity( $activity_args, false );

		if ( $course_learners == 1 ) {
			return '<div class="gp-course-learner-count">' . $course_learners . ' ' . esc_html__( 'learner on this course', 'aardvark' ) . '</div>';
		} else {
			return '<div class="gp-course-learner-count">' . $course_learners . ' ' . esc_html__( 'learners on this course', 'aardvark' ) . '</div>';
		}
	}
}
		
/**
 * Course price
 *
 */
if ( ! function_exists( 'ghostpool_course_price' ) ) {
	function ghostpool_course_price( $post_id = 0 ) {

		if ( ! $post_id ) {
			return 0;
		}

		if ( function_exists( 'is_woocommerce' ) ) {

			$output = '';
	
			$output .= '<div class="gp-loop-price">';

				// Check if this course can be purchased
				$course_product_id = Sensei_WC::get_course_product_id( absint( $post_id ) ); 
		
				if ( $course_product_id ) {
		
					// Get course product details					
					$product = wc_get_product( $course_product_id );
					$price = $product->get_price();
					if ( $price > 0 ) {
			
						$output .= $product->get_price_html();
			
					} else {
			
						$output .= esc_html__( 'Free', 'aardvark' );
			
					}	
		
				} else {
		
					$output .= esc_html__( 'Free', 'aardvark' );
				}
		
			$output .= '</div>';
			
			return $output;
	
		}
	}
}

/**
 * Register link
 *
 */
if ( ! function_exists( 'ghostpool_the_register_button' ) ) {
	function ghostpool_the_register_button( $post_id = '' ) {
		
		global $current_user, $post;
		
		if ( ! get_option( 'users_can_register' ) || 'course' != get_post_type( $post_id ) || ! empty( $current_user->caps ) || Sensei_WC::get_course_product_id( absint( $post_id ) ) ) {
			return;
		}
		
		echo '<a href="' . ghostpool_login_link() . '" class="gp-course-register-link">' . esc_html__( 'Login or register to take this course', 'aardvark' ) . '</a>';
		
	}
}
	
/**
 * Get BuddyPress group URL
 *
 */
if ( ! function_exists( 'ghostpool_bp_group_url' ) ) {
	function ghostpool_bp_group_url( $post_id = 0 ) {

		if ( ! $post_id ) {
			return 0;
		}

		if ( function_exists( 'bp_is_active' ) ) { 
			
			$group_id = get_post_meta( get_the_ID(), 'bp_course_group', true ); 
			
			if ( $group_id ) { 
			
				$group = groups_get_group( $group_id ); 
				$group_url = bp_get_group_permalink( $group );
				
				return '<div class="gp-course-stat"><a href="' . esc_url( $group_url ) . '" class="gp-course-discussion-link">' . esc_html__( 'Course Discussion', 'aardvark' ) . '</a></div>';
				
			} 
		}
	}
}

/**
 * Opening Sensei content wrappers 
 *
 */
if ( ! function_exists( 'ghostpool_sensei_page_wrapper_start' ) ) {
	function ghostpool_sensei_page_wrapper_start() {

		// Page options
		if ( is_singular( 'lesson' ) ) {
			$header = redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'page_header' ) == 'default' ? ghostpool_option( 'lesson_page_header' ) : redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'page_header' );
			$bg = get_post_meta( get_the_ID(), 'page_header_bg', true );
			$height = get_post_meta( get_the_ID(), 'page_header_height', true ) && get_post_meta( get_the_ID(), 'page_header_height', true )['height'] != '' ? get_post_meta( get_the_ID(), 'page_header_height', true )['height'] : ghostpool_option( 'lesson_page_header_height', 'height' );
		 } elseif ( is_singular( 'course' ) ) {
			$header = redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'page_header' ) == 'default' ? ghostpool_option( 'course_page_header' ) : redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'page_header' );
			$bg = get_post_meta( get_the_ID(), 'page_header_bg', true );
			$height = get_post_meta( get_the_ID(), 'page_header_height', true ) && get_post_meta( get_the_ID(), 'page_header_height', true )['height'] != '' ? get_post_meta( get_the_ID(), 'page_header_height', true )['height'] : ghostpool_option( 'course_page_header_height', 'height' );
		} else {
			$header = ghostpool_option( 'courses_page_header' );
			$bg = ghostpool_option( 'courses_page_header_bg' );
			$height = ghostpool_option( 'courses_page_header_height', 'height' );
		} ?>

		<?php ghostpool_page_header( 
			$post_id = get_the_ID(), 
			$type = $header,  
			$bg = $bg,
			$height = $height	
		); ?>

		<?php ghostpool_page_title( '', $header ); ?>
	
		<div id="gp-content-wrapper" class="gp-container">
	
			<?php do_action( 'ghostpool_begin_content_wrapper' ); ?>

			<div id="gp-inner-container">

				<div id="gp-content">
				
<?php }
}
add_action( 'sensei_before_main_content', 'ghostpool_sensei_page_wrapper_start', 10 );

/**
* Closing WooCommerce content wrappers 
*
*/
if ( ! function_exists( 'ghostpool_sensei_page_wrapper_end' ) ) {
function ghostpool_sensei_page_wrapper_end() { ?>
				
					<?php get_template_part( 'lib/sections/sensei/sensei-details' ); ?>
				
				</div>
		
				<?php get_sidebar( 'left' ); ?>
	
				<?php get_sidebar( 'right' ); ?>

			</div>
	
			<?php do_action( 'ghostpool_begin_content_wrapper' ); ?>

		   <div class="gp-clear"></div>

		</div>

	<?php }
}
add_action( 'sensei_after_main_content', 'ghostpool_sensei_page_wrapper_end', 10 );

?>