<?php

/**
Menu Item Custom Fields
http://kucrut.org/
*/

if ( ! class_exists( 'Ghostpool_Menu_Item_Custom_Fields' ) ) {
	/**
	* Menu Item Custom Fields Loader
	*/
	class GhostPool_Menu_Item_Custom_Fields {

		/**
		* Add filter
		*
		* @wp_hook action wp_loaded
		*/
		public static function load() {
			add_filter( 'wp_edit_nav_menu_walker', array( __CLASS__, '_filter_walker' ), 99 );
		}


		/**
		* Replace default menu editor walker with ours
		*
		* We don't actually replace the default walker. We're still using it and
		* only injecting some HTMLs.
		*
		* @since   0.1.0
		* @access  private
		* @wp_hook filter wp_edit_nav_menu_walker
		* @param   string $walker Walker class name
		* @return  string Walker class name
		*/
		public static function _filter_walker( $walker ) {
			$walker = 'Ghostpool_Menu_Item_Custom_Fields_Walker';
			if ( ! class_exists( $walker ) ) {
				require_once( get_template_directory() . '/lib/menus/walker-nav-menu-edit.php' );
			}

			return $walker;
		}
	}
	add_action( 'wp_loaded', array( 'Ghostpool_Menu_Item_Custom_Fields', 'load' ), 9 );
}

class Ghostpool_Menu_Item_Custom_Fields_Options {

	/**
	 * Holds our custom fields
	 *
	 * @var    array
	 * @access protected
	 * @since  Ghostpool_Menu_Item_Custom_Fields_Options 0.2.0
	 */
	protected static $fields = array();


	/**
	 * Initialize plugin
	 */
	public static function init() {
		add_action( 'wp_nav_menu_item_custom_fields', array( __CLASS__, '_fields' ), 10, 4 );
		add_action( 'wp_update_nav_menu_item', array( __CLASS__, '_save' ), 10, 3 );
		add_filter( 'manage_nav-menus_columns', array( __CLASS__, '_columns' ), 99 );

		self::$fields = array(
			'gp-type' => esc_html__( 'Menu Type', 'aardvark' ),
			'gp-icon' => esc_html__( 'Icon', 'aardvark' ),
			'gp-hide-nav-label' => esc_html__( 'Hide Navigation Label', 'aardvark' ),
			'gp-bg-image' => esc_html__( 'Background Image', 'aardvark' ),
			'gp-device-display' => esc_html__( 'Device Display', 'aardvark' ),
			'gp-user-display' => esc_html__( 'Logged In/Out Display', 'aardvark' ),
		);
	}


	/**
	 * Save custom field value
	 *
	 * @wp_hook action wp_update_nav_menu_item
	 *
	 * @param int   $menu_id         Nav menu ID
	 * @param int   $menu_item_db_id Menu item ID
	 * @param array $menu_item_args  Menu item data
	 */
	public static function _save( $menu_id, $menu_item_db_id, $menu_item_args ) {
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		//check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );

		foreach ( self::$fields as $_key => $label ) {
			$key = sprintf( 'menu-item-%s', $_key );

			// Sanitize
			if ( ! empty( $_POST[ $key ][ $menu_item_db_id ] ) ) {
				// Do some checks here...
				$value = $_POST[ $key ][ $menu_item_db_id ];
			}
			else {
				$value = null;
			}

			// Update
			if ( ! is_null( $value ) ) {
				update_post_meta( $menu_item_db_id, $key, $value );
			}
			else {
				delete_post_meta( $menu_item_db_id, $key );
			}
		}
	}


	/**
	 * Print field
	 *
	 * @param object $item  Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args  Menu item args.
	 * @param int    $id    Nav menu ID.
	 *
	 * @return string Form fields
	 */
	public static function _fields( $id, $item, $depth, $args ) {
		foreach ( self::$fields as $_key => $label ) :
			$key   = sprintf( 'menu-item-%s', $_key );
			$id    = sprintf( 'edit-%s-%s', $key, $item->ID );
			$name  = sprintf( '%s[%s]', $key, $item->ID );
			$value = get_post_meta( $item->ID, $key, true );
			$class = sprintf( 'field-%s', $_key );
			?>
				<?php if ( $_key == 'gp-type' ) { ?>
					<p class="description description-wide <?php echo esc_attr( $class ) ?>">
						<label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_attr( $label ); ?></label>
						<br/><select id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>">
							<?php if ( $_key == 'gp-type' ) { ?>
								<option value="gp-standard-menu"<?php if ( $value == 'gp-standard-menu' ) { echo 'selected'; } ?>><?php esc_html_e( 'Default', 'aardvark' ); ?></option>
								<option value="gp-megamenu"<?php if ( $value == 'gp-megamenu' ) { echo 'selected'; } ?>><?php esc_html_e( 'Mega Menu', 'aardvark' ); ?></option>
								<?php if ( $item->type == 'taxonomy' ) { ?>
									<option value="gp-content-menu"<?php if ( $value == 'gp-content-menu' ) { echo 'selected'; } ?>><?php esc_html_e( 'Content Menu', 'aardvark' ); ?></option>
									<option value="gp-tab-content-menu"<?php if ( $value == 'gp-tab-content-menu' ) { echo 'selected'; } ?>><?php esc_html_e( 'Tab Content Menu', 'aardvark' ); ?></option>
								<?php } ?>
								<option value="gp-login-link"<?php if ( $value == 'gp-login-link' ) { echo 'selected'; } ?>><?php esc_html_e( 'Login Link', 'aardvark' ); ?></option>
								<option value="gp-register-link"<?php if ( $value == 'gp-register-link' ) { echo 'selected'; } ?>><?php esc_html_e( 'Register Link', 'aardvark' ); ?></option>
								<option value="gp-logout-link"<?php if ( $value == 'gp-logout-link' ) { echo 'selected'; } ?>><?php esc_html_e( 'Logout Link', 'aardvark' ); ?></option>
								<option value="gp-scroll-to-link"<?php if ( $value == 'gp-scroll-to-link' ) { echo 'selected'; } ?>><?php esc_html_e( 'Scroll To Link', 'aardvark' ); ?></option>
								<option value="gp-menu-header"<?php if ( $value == 'gp-menu-header' ) { echo 'selected'; } ?>><?php esc_html_e( 'Header', 'aardvark' ); ?></option>
								<option value="gp-menu-text"<?php if ( $value == 'gp-menu-text' ) { echo 'selected'; } ?>><?php esc_html_e( 'Text (No Link)', 'aardvark' ); ?></option>
								<option value="gp-menu-image"<?php if ( $value == 'gp-menu-image' ) { echo 'selected'; } ?>><?php esc_html_e( 'Image', 'aardvark' ); ?></option>
								<option value="gp-notifications"<?php if ( $value == 'gp-notifications' ) { echo 'selected'; } ?>><?php esc_html_e( 'Notifications Tab', 'aardvark' ); ?></option>
							<?php } ?>	
						</select>
					</p>
				<?php } ?>

				<?php if ( $_key == 'gp-icon' ) { ?>
					<p class="description description-wide <?php echo esc_attr( $class ) ?>">
						<label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_attr( $label ); ?></label> 
						<br/><input type="text" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php if ( $value ) { echo esc_attr( $value ); } ?>" />
						<br/><span class="description"><?php esc_html_e( 'Add the class name of an icon from', 'aardvark' ); ?> <a href="http://fontawesome.io/cheatsheet/" target="_blank"><?php esc_html_e( 'here', 'aardvark' ); ?></a> <?php esc_html_e( 'e.g. fa-envelope', 'aardvark' ); ?></span>
					</p>		
				<?php } ?>
				
				<?php if ( $_key == 'gp-hide-nav-label' ) { ?>
					<p class="description description-wide <?php echo esc_attr( $class ) ?>">
						<label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_attr( $label ); ?></label> <input type="checkbox" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" value="gp-hide-nav-label"<?php if ( $value == 'gp-hide-nav-label' ) { echo 'checked'; } ?>>
						<br/><span class="description"><?php esc_html_e( 'Hide the navigation label (for example if you only want to show the icon).', 'aardvark' ); ?></span>
					</p>		
				<?php } ?>
				
				<?php if ( $_key == 'gp-bg-image' ) { ?>
					<p class="description description-wide <?php echo esc_attr( $class ) ?>">
						<label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_attr( $label ); ?></label> 
						<br/><input type="text" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php if ( $value ) { echo esc_attr( $value ); } ?>" />
						<br/><span class="description"><?php esc_html_e( 'The URL of the menu background image.', 'aardvark' ); ?></span>
					</p>		
				<?php } ?>

				<?php if ( $_key == 'gp-device-display' ) { ?>
					<p class="description description-wide <?php echo esc_attr( $class ) ?>">
						<label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_attr( $label ); ?></label>
						<br/><select id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>">
							<option value="gp-show-all"<?php if ( $value == 'gp-show-all' ) { echo 'selected'; } ?>><?php esc_html_e( 'Show on all devices', 'aardvark' ); ?></option>
							<option value="gp-hide-on-mobile"<?php if ( $value == 'gp-hide-on-mobile' ) { echo 'selected'; } ?>><?php esc_html_e( 'Only show on larger devices', 'aardvark' ); ?></option>
							<option value="gp-show-on-mobile"<?php if ( $value == 'gp-show-on-mobile' ) { echo 'selected'; } ?>><?php esc_html_e( 'Only show on smaller devices', 'aardvark' ); ?></option>
						</select>		
						<br/><span class="description"><?php esc_html_e( 'Choose what devices to show this link on.', 'aardvark' ); ?></span>	
					</p>
				<?php } ?>

				<?php if ( $_key == 'gp-user-display' ) { ?>
					<p class="description description-wide <?php echo esc_attr( $class ) ?>">
						<label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_attr( $label ); ?></label> 
						<br/><select id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>">
							<option value="gp-show-all"<?php if ( $value == 'gp-show-all' ) { echo 'selected'; } ?>><?php esc_html_e( 'Show for all users', 'aardvark' ); ?></option>
							<option value="gp-show-logged-in"<?php if ( $value == 'gp-show-logged-in' ) { echo 'selected'; } ?>><?php esc_html_e( 'Show for logged in users only', 'aardvark' ); ?></option>
							<option value="gp-show-logged-out"<?php if ( $value == 'gp-show-logged-out' ) { echo 'selected'; } ?>><?php esc_html_e( 'Show for logged out users only', 'aardvark' ); ?></option>
						</select>	
						<br/><span class="description"><?php esc_html_e( 'Choose what users see this link.', 'aardvark' ); ?></span>
					</p>		
				<?php } ?>
																
			<?php
		endforeach;
	}


	/**
	 * Add our fields to the screen options toggle
	 *
	 * @param array $columns Menu item columns
	 * @return array
	 */
	public static function _columns( $columns ) {
		$columns = array_merge( $columns, self::$fields );

		return $columns;
	}
}
Ghostpool_Menu_Item_Custom_Fields_Options::init();