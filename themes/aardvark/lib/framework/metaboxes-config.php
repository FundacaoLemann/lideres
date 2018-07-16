<?php

// INCLUDE THIS BEFORE you load your ReduxFramework object config file.


// You may replace $redux_opt_name with a string if you wish. If you do so, change loader.php
// as well as all the instances below.
$redux_opt_name = "ghostpool_aardvark";

if ( !function_exists( "ghostpool_add_metaboxes" ) ):
    function ghostpool_add_metaboxes($metaboxes) {

    $metaboxes = array();
             
             
	/*--------------------------------------------------------------
	Blog Page Template Options
	--------------------------------------------------------------*/	

    $blog_options = array();
    $blog_options[] = array(
		//'title' => esc_html__( 'Blog', 'aardvark' ),
		'fields' => array(
					        
			array(
				'id'       => 'blog_cats',
				'type'     => 'select',
				'multi'    => true,
				'title'    => esc_html__( 'Categories', 'aardvark' ),
				'data' => 'terms',
				'args' => array( 'taxonomies' => 'category', 'hide_empty' => false ),
				'default' => '',
			),
			
			array( 
				'id' => 'blog_post_types',
				'title' => esc_html__( 'Post Types', 'aardvark' ),
				'type' => 'select',
				'multi' => true,				
				'options' => array(
					'post' => esc_html__( 'Post', 'aardvark' ),
					'page' => esc_html__( 'Page', 'aardvark' ),
				),
				'default' => array( 'post' ),
			),
													
			array( 
				'id' => 'blog_format',
				'title' => esc_html__( 'Format', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-posts-list' => esc_html__( 'List', 'aardvark' ),
					'gp-posts-large' => esc_html__( 'Large', 'aardvark' ),
					'gp-posts-columns-2' => esc_html__( '2 Columns', 'aardvark' ),
					'gp-posts-columns-3' => esc_html__( '3 Columns', 'aardvark' ),
					'gp-posts-columns-4' => esc_html__( '4 Columns', 'aardvark' ),
					'gp-posts-masonry' => esc_html__( 'Masonry', 'aardvark' ),
				),
				'default' => 'gp-posts-list',
			),						
						
			array( 
				'id' => 'blog_style',
				'title' => esc_html__( 'Style', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-style-classic' => esc_html__( 'Classic', 'aardvark' ),
					'gp-style-modern' => esc_html__( 'Modern', 'aardvark' ),
				),
				'default' => 'gp-style-classic',
			),						
						
			array( 
				'id' => 'blog_alignment',
				'title' => esc_html__( 'Content Alignment', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'gp-align-left' => esc_html__( 'Left Aligned', 'aardvark' ),
					'gp-align-center' => esc_html__( 'Center Aligned', 'aardvark' ),
				),
				'default' => 'gp-align-left',
			),

			array(  
				'id' => 'blog_orderby',
				'title' => esc_html__( 'Order By', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'newest' => esc_html__( 'Newest', 'aardvark' ),
					'oldest' => esc_html__( 'Oldest', 'aardvark' ),
					'title_az' => esc_html__( 'Title (A-Z)', 'aardvark' ),
					'title_za' => esc_html__( 'Title (Z-A)', 'aardvark' ),
					'comment_count' => esc_html__( 'Most Comments', 'aardvark' ),
					'views' => esc_html__( 'Most Views', 'aardvark' ),
					'likes' => esc_html__( 'Most Likes', 'aardvark' ),
					'menu_order' => esc_html__( 'Menu Order', 'aardvark' ),
					'rand' => esc_html__( 'Random', 'aardvark' ),
				),
				'default' => 'newest',
			),
			                    										
			array(
				'id'       => 'blog_per_page',
				'type'     => 'spinner',
				'title'    => esc_html__( 'Items Per Page', 'aardvark' ),
				'min' => 1,
				'max' => 999999,
				'default' => 8,
			),
			
			array(
				'id'       => 'blog_image_size',
				'title'    => esc_html__( 'Image Size', 'aardvark' ),
				'type'     => 'select',
				'data' => 'custom_image_size',
				'desc' => esc_html__( 'Choose from one of the default image sizes or you can register your own image size as explained', 'aardvark' ) . ' <a href="' . esc_url( 'https://ghostpool.ticksy.com/article/10923' ) . '" target="_blank">'. esc_html__( 'here', 'aardvark' ) . '</a>.',
				'default' => 'default',
			),
												
			array( 
				'id' => 'blog_content_display',
				'title' => esc_html__( 'Content Display', 'aardvark' ),
				'type' => 'button_set',
				'options' => array(
					'excerpt' => esc_html__( 'Excerpt', 'aardvark' ),
					'full_content' => esc_html__( 'Full Content', 'aardvark' ),
				),
				'default' => 'excerpt',
			),
		
			array( 
				'id' => 'blog_excerpt_length',
				'title' => esc_html__( 'Excerpt Length', 'aardvark' ),
				'required'  => array( 'blog_content_display', '=', 'excerpt' ),
				'type' => 'spinner',
				'desc' => esc_html__( 'The number of characters in excerpts.', 'aardvark' ),
				'min' => 0,
				'max' => 999999,
				'default' => 100,
			),

			array(
				'id'        => 'blog_meta',
				'type'      => 'checkbox',
				'title'     => esc_html__( 'Post Meta', 'aardvark' ),
				'options'   => array(
					'author' => esc_html__( 'Author Name', 'aardvark' ),
					'date' => esc_html__( 'Post Date', 'aardvark' ),
					'comment_count' => esc_html__( 'Comment Count', 'aardvark' ),
                    'views' => esc_html__( 'Views', 'aardvark' ),
					'likes' => esc_html__( 'Likes', 'aardvark' ),
					'cats' => esc_html__( 'Categories', 'aardvark' ),
					'tags' => esc_html__( 'Post Tags', 'aardvark' ),
				),
				'default'   => array(
					'author' => '1',
					'date' => '1', 
					'comment_count' => '1',
					'views' => '0',
					'likes' => '0',
					'cats' => '0',
					'tags' => '0',
				),
			),

			array(
				'id'        => 'blog_filters',
				'type'      => 'checkbox',
				'title'     => esc_html__( 'Filters (Sorting)', 'aardvark' ),
				'desc' => esc_html__( 'Filters disabled if using load more button.', 'aardvark' ),
				'options'   => array(
					'date' => esc_html__( 'Date', 'aardvark' ),
					'title' => esc_html__( 'Title', 'aardvark' ),
					'comment_count' => esc_html__( 'Comment Count', 'aardvark' ),
					'views' => esc_html__( 'Views', 'aardvark' ),
					'likes' => esc_html__( 'Likes', 'aardvark' ),
				),
				'default'   => array(
					'date' => '1',
					'title' => '1',
					'comment_count' => '1',
					'views' => '1',
					'likes' => '1',
				)
			),

			array(
				'id'       => 'blog_filter_cat_id',
				'type'     => 'select',
				'required'  => array( 'blog_filter', '=', 'enabled' ),
				'title'    => esc_html__( 'Filter (Categories)', 'aardvark' ),
				'data' => 'terms',
				'args' => array( 'taxonomies' => 'category', 'hide_empty' => false ),
				'desc' => esc_html__( 'Leave blank to display all categories.', 'aardvark' ),
				'subtitle' => esc_html__( 'The sub categories of this category will also be displayed.', 'aardvark' ),
				'default' => '',
			),
									
			array(  
				'id' => 'blog_read_more_link',
				'title' => esc_html__( 'Read More Link', 'aardvark' ),
				'type' => 'button_set',
				'options' => array(
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'disabled',
			),
														
		),
	);
    $metaboxes[] = array(
        'id' => 'blog-options',
        'title' => esc_html__( 'Blog Options', 'aardvark' ),
        'post_types' => array( 'page' ),
        'page_template' => array( 'blog-template.php' ),
        'position' => 'normal',
        'priority' => 'high',
        'sections' => $blog_options,
    );
    
    
	/*--------------------------------------------------------------
	Link Page Template Options
	--------------------------------------------------------------*/	

    $link_template_options = array();
    $link_template_options[] = array(
        'fields' => array(
        
			array( 
				'id' => 'link_template_link',
				'title' => esc_html__( 'Link', 'aardvark' ),
				'type' => 'text',
				'default' => '',
				'validate' => 'url',
			),

			array( 
				'id' => 'link_template_link_target',
				'title' => esc_html__( 'Link Target', 'aardvark' ),
				'type' => 'button_set',
				'options' => array(
					'_blank' => esc_html__( 'New Window', 'aardvark' ),
					'_self' => esc_html__( 'Same Window', 'aardvark' ),
				),
				'default' => '_self',
			),
															 
		),
	);	
    $metaboxes[] = array(
        'id' => 'link-options',
        'title' => esc_html__( 'Link Options', 'aardvark' ),
        'post_types' => array( 'page' ),
        'page_template' => array( 'link-template.php' ),
        'position' => 'normal',
        'priority' => 'high',
        'sections' => $link_template_options,
    );
    
    

                
	/*--------------------------------------------------------------
	Post Options
	--------------------------------------------------------------*/

	// Audio Post Format Options
    $audio_format_options = array();
    $audio_format_options[] = array(
		'fields' => array(
						        
			array(
				'id'        => 'audio_mp3_url',
				'type'      => 'media',
				'title'     => esc_html__( 'MP3 Audio File', 'aardvark' ),
				'mode'      => false,
			),

			array(
				'id'        => 'audio_ogg_url',
				'type'      => 'media',
				'title'     => esc_html__( 'OGG Audio File', 'aardvark' ),
				'mode'      => false,
			),
					
		),
	);	
    $metaboxes[] = array(
        'id' => 'audio-format-options',
        'title' => esc_html__( 'Audio Options', 'aardvark' ),
        'post_types' => array( 'post' ),
        'post_format' => array( 'audio' ),
        'position' => 'normal',
        'priority' => 'high',
        'sections' => $audio_format_options,
    );
    
    // Video Format Options   
    $video_format_options = array();
    $video_format_options[] = array(
        'fields' => array(
			
			array(
				'id'        => 'video_embed_url',
				'type'      => 'text',
				'title'     => esc_html__( 'Video URL', 'aardvark' ),
				'desc'      => esc_html__( 'Video URL uploaded to one of the major video sites e.g. YouTube, Vimeo, blip.tv, etc.', 'aardvark' ),
				'validate'  => 'url',
				'default' => '',
			),

			$fields = array(
			   'id' => 'video_format_section',
			   'type' => 'section',
			   'title' => esc_html__( 'Self-hosted Video', 'aardvark' ),
			   'indent' => true,
		   ),
		     
				array(
					'id'        => 'video_m4v_url',
					'type'      => 'media',
					'title'     => esc_html__( 'M4V Video', 'aardvark' ),
					'mode'      => false,
					'default' => '',
				),

				array(
					'id'        => 'video_mp4_url',
					'type'      => 'media',
					'title'     => esc_html__( 'MP4 Video', 'aardvark' ),
					'mode'      => false,
					'default' => '',
				),

				array(
					'id'        => 'video_webm_url',
					'type'      => 'media',
					'title'     => esc_html__( 'WebM Video', 'aardvark' ),
					'mode'      => false,
					'default' => '',
				),
			
				array(
					'id'        => 'video_ogv_url',
					'type'      => 'media',
					'title'     => esc_html__( 'OGV Video', 'aardvark' ),
					'mode'      => false,
					'default' => '',
				),
						
			array(
				'id'     => 'video_format_section',
				'type'   => 'section',
				'indent' => false,
			),
					
		),
	);	
    $metaboxes[] = array(
        'id' => 'video-format-options',
        'title' => esc_html__( 'Video Options', 'aardvark' ),
        'post_types' => array( 'post' ),
        'post_format' => array( 'video' ),
        'position' => 'normal',
        'priority' => 'high',
        'sections' => $video_format_options,
    ); 
    	
	// Gallery Slider Post Format Options
    $gallery_format_options = array();
    $gallery_format_options[] = array(
        'fields' => array(						        
			array(
				'id'        => 'gallery_slider',
				'type'      => 'gallery',
				'title'     => esc_html__( 'Gallery Slider', 'aardvark' ),
				 'subtitle'  => esc_html__( 'Create a new gallery slider by selecting an existing image or uploading new ones using the WordPress native uploader.', 'aardvark' ),
			),
		),
	);		
    $metaboxes[] = array(
        'id' => 'gallery-format-options',
        'title' => esc_html__( 'Gallery Slider Options', 'aardvark' ),
        'post_types' => array( 'post' ),
        'post_format' => array( 'gallery' ),
        'position' => 'normal',
        'priority' => 'high',
        'sections' => $gallery_format_options,
    );
    
    // Link Format Options   
    $link_format_options = array();
    $link_format_options[] = array(
        'fields' => array(		        
			array(
				'id'       => 'link',
				'type'     => 'text',
				'title'    => esc_html__( 'Link', 'aardvark' ),
				'validate' => 'url',
			),
			array( 
				'id' => 'link_target',
				'title' => esc_html__( 'Link Target', 'aardvark' ),
				'type' => 'button_set',
				'options' => array(
					'_blank' => esc_html__( 'New Window', 'aardvark' ),
					'_self' => esc_html__( 'Same Window', 'aardvark' ),
				),
				'default' => '_blank',
			),
					 
		),
	);		
    $metaboxes[] = array(
        'id' => 'link-format-options',
        'title' => esc_html__( 'Link Options', 'aardvark' ),
        'post_types' => array( 'post' ),
        'post_format' => array( 'link' ),
        'position' => 'normal',
        'priority' => 'high',
        'sections' => $link_format_options,
    );
            
    // General Page Options	
	$page_options = array();			
    $page_options[] = array(
    	'title' => esc_html__( 'General', 'aardvark' ),	
		'desc' => esc_html__( 'By default most of these options are set from the Theme Options page to change all pages at once, but you can overwrite these options here so this page has different settings.', 'aardvark' ),
		'icon' => 'el-icon-cogs',
		'fields' => array(

			array( 
				'id' => 'page_header_layout',
				'title' => esc_html__( 'Layout', 'aardvark' ),
				'type' => 'image_select',
				'options' => array( 
					'default' => array( 'title' => esc_html__( 'Default', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/default.jpg' ),
					'gp-header-logo-left-1' => array( 'title' => esc_html__( 'Header 1', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-left-1.jpg' ),
					'gp-header-logo-left-2' => array( 'title' => esc_html__( 'Header 2', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-left-2.jpg' ),
					'gp-header-logo-right-1' => array( 'title' => esc_html__( 'Header 3', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/logo-right-1.jpg' ),
					'gp-header-nav-bottom-1' => array( 'title' => esc_html__( 'Header 4', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-1.jpg' ),
					'gp-header-nav-bottom-2' => array( 'title' => esc_html__( 'Header 5', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-2.jpg' ),
					'gp-header-nav-bottom-3' => array( 'title' => esc_html__( 'Header 6', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/nav-bottom-3.jpg' ),
					'gp-header-side-menu' => array( 'title' => esc_html__( 'Header 7', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/side-menu.jpg' ),
				),
				'default' => 'default',
			),		
			
			array( 
				'id' => 'page_header_display',
				'title' => esc_html__( 'Header Display', 'aardvark' ),
				'type' => 'select',
				'options' => array( 
					'default' => esc_html__( 'Default', 'aardvark' ),
					'gp-header-above-content' => esc_html__( 'Above Content', 'aardvark' ),
					'gp-header-over-content' => esc_html__( 'Over Content', 'aardvark' ),
					'gp-header-disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'default',
			),

			array( 
				'id' => 'page_footer_display',
				'title' => esc_html__( 'Footer Display', 'aardvark' ),
				'type' => 'select',
				'options' => array( 
					'default' => esc_html__( 'Default', 'aardvark' ),
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'default',
			),
																															
			array( 
				'id' => 'page_header',
				'title' => esc_html__( 'Page Header', 'aardvark' ),
				'type' => 'select',
				'options' => array(
					'default' => esc_html__( 'Default', 'aardvark' ),
					'gp-standard-page-header' => esc_html__( 'Standard', 'aardvark' ),
					'gp-fullwidth-page-header' => esc_html__( 'Full Width', 'aardvark' ),
					'gp-full-page-page-header' => esc_html__( 'Full Page', 'aardvark' ),
				),
				'default' => 'default',
			),
				
			array(
				'id' => 'page_header_bg', 
				'title' => esc_html__( 'Page Header Image Background', 'aardvark' ),
				'type'      => 'media',		
				'mode'      => false,
				'default' => '',
			),	

			array( 
				'id' => 'page_header_height',
				'title' => esc_html__( 'Page Header Height', 'aardvark' ),
				'units' => 'px',
				'type' => 'dimensions',
				'width' => false,
				'default'       => array(
					'height' => '',
				),		
			 ),

			array(
				'id' => 'page_header_video', 
				'title' => esc_html__( 'Page Header Video', 'aardvark' ),
				'subtitle' => esc_html__( 'Supports YouTube, Vimeo and HTML5 video. For multiple HTML5 formats, each video should have exactly the same filename but remove the extension (e.g. .mp4) from the filename in the text box.', 'aardvark' ),
				'type'      => 'text',	
				'validate'  => 'url',
				'default' => '',
			),
			 								
			array(
				'id' => 'page_header_video_bg', 
				'title' => esc_html__( 'Page Header Video Background', 'aardvark' ),
				'subtitle' => esc_html__( 'Supports YouTube, Vimeo and HTML5 video. For multiple HTML5 formats, each video should have exactly the same filename but remove the extension (e.g. .mp4) from the filename in the text box.', 'aardvark' ),
				'type'      => 'text',	
				'validate'  => 'url',
				'default' => '',
			),
						        
			array( 
				'id' => 'custom_title',
				'title' => esc_html__( 'Custom Title', 'aardvark' ),
				'type' => 'text',
				'subtitle' => esc_html__( 'Overwrites the default title.', 'aardvark' ),
				'default' => '',
			),
									
			array( 
				'id' => 'subtitle',
				'title' => esc_html__( 'Subtitle', 'aardvark' ),
				'type' => 'textarea',
				'default' => '',
			),
		
			array( 
				'id' => 'layout',
				'title' => esc_html__( 'Page Layout', 'aardvark' ),					
				'type' => 'image_select',
				'options' => array(
					'default' => array( 'title' => esc_html__( 'Default', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/default.png' ),
					'gp-left-sidebar' => array( 'title' => esc_html__( 'Left Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cl.png' ),
					'gp-right-sidebar' => array( 'title' => esc_html__( 'Right Sidebar', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png' ),
					'gp-both-sidebars' => array( 'title' => esc_html__( 'Both Sidebars', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/both-sidebars.png' ),
					'gp-no-sidebar' => array( 'title' => esc_html__( 'No Sidebar', 'aardvark' ), 'img' => get_template_directory_uri() . '/lib/framework/images/no-sidebar.png' ),
					'gp-fullwidth' => array( 'title' => esc_html__( 'Full Width', 'aardvark' ), 'img' => ReduxFramework::$_url . 'assets/img/1col.png' ),
				),	
				'default' => 'default',
			),
			
			array(
				'id'      => 'left_sidebar',
				'type'    => 'select',
				'title'   => esc_html__( 'Left Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars_default',
				'default' => 'default',
			),

			array(
				'id'      => 'right_sidebar',
				'type'    => 'select',
				'title'   => esc_html__( 'Right Sidebar', 'aardvark' ),
				'data'    => 'custom_sidebars_default',
				'default' => 'default',
			),

			array(  
				'id' => 'image',
				'title' => esc_html__( 'Featured Image', 'aardvark' ),
				'type' => 'button_set',
				'options' => array(
					'default' => esc_html__( 'Default', 'aardvark' ),
					'enabled' => esc_html__( 'Enabled', 'aardvark' ),
					'disabled' => esc_html__( 'Disabled', 'aardvark' ),
				),
				'default' => 'default',
			),
			
		),
	);

    $metaboxes[] = array(
        'id' => 'page-options',
        'title' => esc_html__( 'Page Options', 'aardvark' ),
        'post_types' => array( 'post', 'page', 'product', 'course', 'lesson', 'event' ),
        'post_format' => array( '0', 'audio', 'gallery', 'quote', 'video' ),
        'position' => 'normal',
        'priority' => 'high',
        'sections' => $page_options
    ); 
    
            
    // Kind of overkill, but ahh well.  ;)
    $metaboxes = apply_filters( 'ghostpool_redux_metabox_options', $metaboxes, $page_options, $blog_options, $link_template_options );

    return $metaboxes;
  }
  add_action('redux/metaboxes/'.$redux_opt_name.'/boxes', 'ghostpool_add_metaboxes');
endif;

// The loader will load all of the extensions automatically based on your $redux_opt_name
require_once( get_template_directory() .'/lib/framework/loader.php' );