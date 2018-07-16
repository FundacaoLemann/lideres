<?php if ( function_exists( 'bp_is_active' ) ) {

	if ( ! function_exists( 'ghostpool_wpb_buddypress_options' ) ) {
		function ghostpool_wpb_buddypress_options() {

			// BuddyPress Activity
			vc_map( array( 
				'name' => esc_html__( 'Activity', 'aardvark' ),
				'base' => 'gp_activity',
				'description' => esc_html__( 'BuddyPress activity stream.', 'aardvark' ),
				'class' => 'wpb_vc_bp_activity',
				'controls' => 'full',
				'icon' => 'gp-icon-bp-activity',
				'category' => esc_html__( 'Theme', 'aardvark' ),
				'params' => array(

					array( 
						'heading' => esc_html__( 'Title', 'aardvark' ),
						'param_name' => 'title',
						'type' => 'textfield',
						'value' => '',
					),			
					array( 
					'heading' => esc_html__( 'Post Form', 'aardvark' ),
					'param_name' => 'post_form',
					'value' => array( 
						esc_html__( 'Enabled', 'aardvark' ) => 'enabled', 
						esc_html__( 'Disabled', 'aardvark' ) => 'disabled' ),
					'type' => 'dropdown',
					),
					array( 
					'heading' => esc_html__( 'Scope', 'aardvark' ),
					'param_name' => 'scope',
					'type' => 'checkbox',
					'value' => array( 
						esc_html__( 'Single User', 'aardvark' ) => 'just-me', 
						esc_html__( 'Friends', 'aardvark' ) => 'friends', 
						esc_html__( 'Groups', 'aardvark' ) => 'groups', 
						esc_html__( 'Favorites', 'aardvark' ) => 'favorites', 
						esc_html__( 'Mentions', 'aardvark' ) => 'mentions' 
					),
					'description' => esc_html__( 'Pre-defined filtering of the activity stream. Show only activity for the scope you pass (based on the logged in user or a user_id you pass).', 'aardvark' ),
					),									
					array( 
					'heading' => esc_html__( 'Display Comments', 'aardvark' ),
					'description' => esc_html__( 'Whether or not to display comments along with activity items. Threaded will show comments threaded under the activity. Stream will show comments within the actual stream in chronological order along with activity items.', 'aardvark' ),
					'param_name' => 'display_comments',
					'value' => array( 
						esc_html__( 'Threaded', 'aardvark' ) => 'threaded', 
						esc_html__( 'Stream', 'aardvark' ) => 'stream', 
						esc_html__( 'Disable', 'aardvark' ) => 'false' 
					),
					'type' => 'dropdown',
					),	
					array( 
					'heading' => esc_html__( 'Allow Commenting', 'aardvark' ),
					'description' => esc_html__( 'Whether or not users can post comments in the activity loop.', 'aardvark' ),
					'param_name' => 'allow_comments',
					'value' => array( 
						esc_html__( 'Enabled', 'aardvark' ) => 'gp-comments-enabled', 
						esc_html__( 'Disabled', 'aardvark' ) => 'gp-comments-disabled' 
					),
					'type' => 'dropdown',
					),						
					array( 
					'heading' => esc_html__( 'Exclude Activity Types', 'aardvark' ),
					'description' => esc_html__( 'Note: Loading more content does not retain the excluded content. The activity types to exclude e.g. updated_profile, new_member, new_avatar, friendship_accepted, friendship_created, created_group, joined_group, group_details_updated, bbp_topic_create, bbp_reply_create, rtmedia_update.', 'aardvark' ),
					'param_name' => 'exclude_types',
					'type' => 'textfield',
					'value' => '',
					),			
					array( 
					'heading' => esc_html__( 'Include', 'aardvark' ),
					'description' => esc_html__( 'To only show specific activity entries enter the activity IDs, separating each with a comma e.g. 5, 101, 89', 'aardvark' ),
					'param_name' => 'include',
					'type' => 'textfield',
					'value' => '',
					),	
					array( 
					'heading' => esc_html__( 'Order', 'aardvark' ),
					'description' => esc_html__( 'The order of the activity entries.', 'aardvark' ),
					'param_name' => 'order',
					'value' => array(
						esc_html__( 'Newest', 'aardvark' ) => 'DESC',
						esc_html__( 'Oldest', 'aardvark' ) => 'ASC',
					),
					'type' => 'dropdown',
					),				
					array( 
					'heading' => esc_html__( 'Items Per Page', 'aardvark' ),
					'description' => esc_html__( 'The number of activity items on each page.', 'aardvark' ),
					'param_name' => 'per_page',
					'value' => '5',
					'type' => 'textfield',
					),
					array( 
					'heading' => esc_html__( 'Maximum Items', 'aardvark' ),
					'description' => esc_html__( 'The maximum number of activity entries to show.', 'aardvark' ),
					'param_name' => 'max',
					'value' => '',
					'type' => 'textfield',
					),						
					array( 
					'heading' => esc_html__( 'Show Hidden Items', 'aardvark' ),
					'description' => esc_html__( 'Show entries that have been hidden site wide such as private or hidden group posts.', 'aardvark' ),
					'param_name' => 'show_hidden',
					'value' => array( 
						esc_html__( 'Disabled', 'aardvark' ) => 'disabled', 
						esc_html__( 'Enabled', 'aardvark' ) => 'enabled' 
					),
					'type' => 'dropdown',
					),
					array( 
					'heading' => esc_html__( 'Search Terms', 'aardvark' ),
					'description' => esc_html__( 'Return only activity entries that match these search terms.', 'aardvark' ),
					'param_name' => 'search_terms',
					'value' => '',
					'type' => 'textfield',
					),	
					array( 
					'heading' => esc_html__( 'User ID', 'aardvark' ),
					'description' => esc_html__( 'Limit activity items to a specific user ID.', 'aardvark' ),
					'param_name' => 'user_id',
					'value' => '',
					'type' => 'textfield',
					),		
					array( 
					'heading' => esc_html__( 'Object', 'aardvark' ),
					'description' => esc_html__( 'The object type to filter by (can be any active component object or custom component object e.g. groups, friends, profile, status, blogs).', 'aardvark' ),
					'param_name' => 'object',
					'value' => '',
					'type' => 'textfield',
					),
					array( 
					'heading' => esc_html__( 'Action', 'aardvark' ),
					'description' => esc_html__( 'The action type to filter by (can be any active component action or custom component action e.g. bbp_reply_create, new_blog_comment new_blog_post, friendship_created, joined_group, created_group, activity_update).', 'aardvark' ),
					'param_name' => 'action',
					'value' => '',
					'type' => 'textfield',
					),	
					array( 
					'heading' => esc_html__( 'Primary ID', 'aardvark' ),
					'description' => esc_html__( 'The ID to filter by for a specific object. For example if you used "groups" as the object you could pass a group ID as the primary ID and restrict entries to that group.', 'aardvark' ),
					'param_name' => 'primary_id',
					'value' => '',
					'type' => 'textfield',
					),	
					array( 
					'heading' => esc_html__( 'Secondary ID', 'aardvark' ),
					'description' => esc_html__( 'The secondary ID to filter by for a specific object. For example if you used blogs as the object you could pass a blog ID as the primary ID and a post ID as the secondary ID then list all comments for that post using "new_blog_comment" as the action.', 'aardvark' ),
					'param_name' => 'secondary_id',
					'value' => '',
					'type' => 'textfield',
					),
					array( 
					'heading' => esc_html__( 'Extra Class Name', 'aardvark' ),
					'param_name' => 'classes',
					'value' => '',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'aardvark' ),
					'type' => 'textfield',
					),					
					array(
					'heading' => esc_html__( 'CSS', 'aardvark' ),
					'type' => 'css_editor',
					'param_name' => 'css',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					),
																																		
				 )
			) );
				
			// BuddyPress Groups
			vc_map( array( 
				'name' => esc_html__( 'Groups', 'aardvark' ),
				'base' => 'gp_bp_groups',
				'description' => esc_html__( 'Recently active, popular, and newest groups.', 'aardvark' ),
				'class' => 'wpb_vc_bp_groups',
				'controls' => 'full',
				'icon' => 'gp-icon-bp-groups',
				'category' => esc_html__( 'Theme', 'aardvark' ),
				'params' => array(

					array( 
						'heading' => esc_html__( 'Title', 'aardvark' ),
						'param_name' => 'title',
						'type' => 'textfield',
						'value' => '',
					),			
					array( 
					'heading' => esc_html__( 'Format', 'aardvark' ),
					'param_name' => 'format',
					'value' => array(
						esc_html__( 'Rounded Avatars', 'aardvark' ) => 'gp-bp-round-avatars',
						esc_html__( 'Grid Avatars', 'aardvark' ) => 'gp-bp-grid-avatars',
						esc_html__( 'Masonry', 'aardvark' ) => 'gp-posts-masonry',
						esc_html__( 'List', 'aardvark' ) => 'gp-posts-list',
					),
					'std' => 'gp-posts-masonry',
					'type' => 'dropdown',
					),			
					array( 
					'heading' => esc_html__( 'Maximum Groups', 'aardvark' ),
					'param_name' => 'max_groups',
					'type' => 'textfield',
					'value' => 8,
					),								
					array( 
					'heading' => esc_html__( 'Filters', 'aardvark' ),
					'param_name' => 'filters',
					'value' => array(
						esc_html__( 'Enabled', 'aardvark' ) => 'enabled',
						esc_html__( 'Disabled', 'aardvark' ) => 'disabled',
					),
					'std' => 'disabled',
					'type' => 'dropdown',
					'dependency' => array( 'element' => 'format', 'value' => array( 'gp-bp-round-avatars', 'gp-bp-grid-avatars', 'gp-posts-list' ) ),
					),	
					array( 
					'heading' => esc_html__( 'Default Display', 'aardvark' ),
					'param_name' => 'group_default',
					'value' => array(
						esc_html__( 'Newest', 'aardvark' ) => 'newest',
						esc_html__( 'Popular', 'aardvark' ) => 'popular',
						esc_html__( 'Active', 'aardvark' ) => 'active',
						esc_html__( 'Alphabetical', 'aardvark' ) => 'alphabetical',
						esc_html__( 'My Groups', 'aardvark' ) => 'my-groups',
					),
					'type' => 'dropdown',
					),	
					array( 
					'heading' => esc_html__( 'Cover Images', 'aardvark' ),
					'param_name' => 'cover_images',
					'value' => array(
						esc_html__( 'Enabled', 'aardvark' ) => 'enabled',
						esc_html__( 'Disabled', 'aardvark' ) => 'disabled',
					),
					'type' => 'dropdown',
					'dependency' => array( 'element' => 'format', 'value' => 'gp-posts-masonry' ),
					),				
					array( 
					'heading' => esc_html__( 'Extra Class Name', 'aardvark' ),
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'aardvark' ),
					'param_name' => 'classes',
					'value' => '',
					'type' => 'textfield',
					),						
					array(
						'param_name' => 'styling_divider_begin',
						'type' => 'gp_divider',
						'edit_field_class' => 'vc_col-xs-12',
						'group' => esc_html__( 'Design Options', 'aardvark' ),
					),	
					array( 
					'heading' => esc_html__( 'Filter Link Color', 'aardvark' ),
					'param_name' => 'link_color',
					'type' => 'colorpicker',
					'dependency' => array( 'element' => 'filters', 'value' => 'enabled' ),
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
					),											
					array( 
					'heading' => esc_html__( 'Masonry Background Color', 'aardvark' ),
					'param_name' => 'masonry_bg_color',
					'type' => 'colorpicker',
					'dependency' => array( 'element' => 'format', 'value' => 'gp-posts-masonry' ),
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
					),									
					array( 
					'heading' => esc_html__( 'Avatar/Masonry Border Color', 'aardvark' ),
					'param_name' => 'masonry_border_color',
					'type' => 'colorpicker',
					'dependency' => array( 'element' => 'format', 'value' => array( 'gp-bp-round-avatars', 'gp-posts-masonry' ) ),
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
					),										
					array( 
					'heading' => esc_html__( 'Title Color', 'aardvark' ),
					'param_name' => 'title_color',
					'type' => 'colorpicker',
					'dependency' => array( 'element' => 'format', 'value' => 'gp-posts-masonry' ),
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
					),										
					array( 
					'heading' => esc_html__( 'Text Color', 'aardvark' ),
					'param_name' => 'text_color',
					'type' => 'colorpicker',
					'dependency' => array( 'element' => 'format', 'value' => 'gp-posts-masonry' ),
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
					),						
					array(
						'param_name' => 'styling_divider_end',
						'type' => 'gp_divider',
						'edit_field_class' => 'vc_col-xs-12',
						'group' => esc_html__( 'Design Options', 'aardvark' ),
					),
					array(
					'heading' => esc_html__( 'CSS', 'aardvark' ),
					'type' => 'css_editor',
					'param_name' => 'css',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					),	
						
				 )
			) );		

			// BuddyPress Members
			vc_map( array( 
				'name' => esc_html__( 'Members', 'aardvark' ),
				'base' => 'gp_bp_members',
				'description' => esc_html__( 'Recently active, popular, and newest members.', 'aardvark' ),
				'class' => 'wpb_vc_bp_members',
				'controls' => 'full',
				'icon' => 'gp-icon-bp-members',
				'category' => esc_html__( 'Theme', 'aardvark' ),
				'params' => array(				

					array( 
						'heading' => esc_html__( 'Title', 'aardvark' ),
						'param_name' => 'title',
						'type' => 'textfield',
						'value' => '',
					),					
					array( 
					'heading' => esc_html__( 'Format', 'aardvark' ),
					'param_name' => 'format',
					'value' => array(
						esc_html__( 'Rounded Avatars', 'aardvark' ) => 'gp-bp-round-avatars',
						esc_html__( 'Grid Avatars', 'aardvark' ) => 'gp-bp-grid-avatars',
						esc_html__( 'Masonry', 'aardvark' ) => 'gp-posts-masonry',
						esc_html__( 'List', 'aardvark' ) => 'gp-posts-list',
					),
					'type' => 'dropdown',
					),
					array( 
					'heading' => esc_html__( 'Maximum Members', 'aardvark' ),
					'param_name' => 'max_members',
					'type' => 'textfield',
					'value' => 22,
					),					
					array( 
					'heading' => esc_html__( 'Filters', 'aardvark' ),
					'param_name' => 'filters',
					'value' => array(
						esc_html__( 'Enabled', 'aardvark' ) => 'enabled',
						esc_html__( 'Disabled', 'aardvark' ) => 'disabled',
					),
					'std' => 'disabled',
					'type' => 'dropdown',
					'dependency' => array( 'element' => 'format', 'value' => array( 'gp-bp-round-avatars', 'gp-bp-grid-avatars', 'gp-posts-list' ) ),
					),
					array( 
					'heading' => esc_html__( 'Default Display', 'aardvark' ),
					'param_name' => 'member_default',
					'value' => array(
						esc_html__( 'Newest', 'aardvark' ) => 'newest',
						esc_html__( 'Active', 'aardvark' ) => 'active',
						esc_html__( 'Popular', 'aardvark' ) => 'popular',
					),
					'type' => 'dropdown',
					),		
					array( 
					'heading' => esc_html__( 'Cover Images', 'aardvark' ),
					'param_name' => 'cover_images',
					'value' => array(
						esc_html__( 'Enabled', 'aardvark' ) => 'enabled',
						esc_html__( 'Disabled', 'aardvark' ) => 'disabled',
					),
					'type' => 'dropdown',
					'dependency' => array( 'element' => 'format', 'value' => 'gp-posts-masonry' ),
					),				
					array( 
					'heading' => esc_html__( 'Extra Class Name', 'aardvark' ),
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'aardvark' ),
					'param_name' => 'classes',
					'value' => '',
					'type' => 'textfield',
					),								
					array(
						'param_name' => 'styling_divider_begin',
						'type' => 'gp_divider',
						'edit_field_class' => 'vc_col-xs-12',
						'group' => esc_html__( 'Design Options', 'aardvark' ),
					),	
					array( 
					'heading' => esc_html__( 'Filter Link Color', 'aardvark' ),
					'param_name' => 'link_color',
					'type' => 'colorpicker',
					'dependency' => array( 'element' => 'filters', 'value' => 'enabled' ),
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
					),											
					array( 
					'heading' => esc_html__( 'Masonry Background Color', 'aardvark' ),
					'param_name' => 'masonry_bg_color',
					'type' => 'colorpicker',
					'dependency' => array( 'element' => 'format', 'value' => 'gp-posts-masonry' ),
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
					),									
					array( 
					'heading' => esc_html__( 'Avatar/Masonry Border Color', 'aardvark' ),
					'param_name' => 'masonry_border_color',
					'type' => 'colorpicker',
					'dependency' => array( 'element' => 'format', 'value' => array( 'gp-bp-round-avatars', 'gp-posts-masonry' ) ),
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
					),										
					array( 
					'heading' => esc_html__( 'Title Color', 'aardvark' ),
					'param_name' => 'title_color',
					'type' => 'colorpicker',
					'dependency' => array( 'element' => 'format', 'value' => 'gp-posts-masonry' ),
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
					),										
					array( 
					'heading' => esc_html__( 'Text Color', 'aardvark' ),
					'param_name' => 'text_color',
					'type' => 'colorpicker',
					'dependency' => array( 'element' => 'format', 'value' => 'gp-posts-masonry' ),
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
					),							
					array(
						'param_name' => 'styling_divider_end',
						'type' => 'gp_divider',
						'edit_field_class' => 'vc_col-xs-12',
						'group' => esc_html__( 'Design Options', 'aardvark' ),
					),				
					array(
					'heading' => esc_html__( 'CSS', 'aardvark' ),
					'type' => 'css_editor',
					'param_name' => 'css',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					),	
					
				 )
			) );

			// BuddyPress Who's Online
			vc_map( array( 
				'name' => esc_html__( 'Whos Online', 'aardvark' ),
				'base' => 'gp_bp_whos_online',
				'description' => esc_html__( 'Avatars of online users.', 'aardvark' ),
				'class' => 'wpb_vc_bp_whos_online',
				'controls' => 'full',
				'icon' => 'gp-icon-bp-whos-online',
				'category' => esc_html__( 'Theme', 'aardvark' ),
				'params' => array(				

					array( 
						'heading' => esc_html__( 'Title', 'aardvark' ),
						'param_name' => 'title',
						'type' => 'textfield',
						'value' => '',
					),					
					array( 
					'heading' => esc_html__( 'Format', 'aardvark' ),
					'param_name' => 'format',
					'value' => array(
						esc_html__( 'Large Avatars', 'aardvark' ) => 'gp-large-avatars',
						esc_html__( 'Small Avatars', 'aardvark' ) => 'gp-small-avatars',
					),
					'type' => 'dropdown',
					),
					array( 
					'heading' => esc_html__( 'Maximum Members', 'aardvark' ),
					'param_name' => 'max_members',
					'type' => 'textfield',
					'value' => 20,
					),	
					array( 
					'heading' => esc_html__( 'Extra Class Name', 'aardvark' ),
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'aardvark' ),
					'param_name' => 'classes',
					'value' => '',
					'type' => 'textfield',
					),						
					array( 
					'heading' => esc_html__( 'Border Color', 'aardvark' ),
					'param_name' => 'avatar_border_color',
					'type' => 'colorpicker',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					'edit_field_class' => 'vc_col-xs-4',
					),					
					array(
					'heading' => esc_html__( 'CSS', 'aardvark' ),
					'type' => 'css_editor',
					'param_name' => 'css',
					'group' => esc_html__( 'Design Options', 'aardvark' ),
					),
				
				 )
			) );
	
		}	
	}		
	add_action( 'vc_before_init', 'ghostpool_wpb_buddypress_options' ); 

} ?>