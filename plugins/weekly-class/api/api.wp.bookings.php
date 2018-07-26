<?php

class WcsBookingsWPRestApi {

  private $_version;
  private $_namespace;

  public function __construct(){

    $this->_version = '1';
    $this->_namespace = "weekly-class/v{$this->_version}";

    add_action( 'rest_api_init', array( $this, 'register_api_routes' ) );

  }

  function register_api_routes(){

    register_rest_route( $this->_namespace, '/bookings', array(
      array(
          'methods'  => WP_REST_Server::READABLE,
          'callback' => array( $this, 'get_bookings' ),
          'permission_callback' => array( $this, 'get_private_data_permissions_check' )
      ),
    ));

  }

  public function get_bookings( $request ){

    $start = strtotime( $request->get_param( 'start' ) ) ;
    $end = strtotime( $request->get_param( 'end' ) );

    $orders = array();

    $classes = new WP_Query(
      array(
        'post_status' => array( 'publish' ),
        'posts_per_page' => -1,
        'post_type' => 'class',
        'meta_key'  => '_wcs_timestamp',
        'orderby'   => 'meta_value_num',
        'order'     => 'ASC'
      )
    );


    if ( $classes->have_posts() ) : while ( $classes->have_posts() ) : $classes->the_post();
      $class = new CurlyWeeklyClassEvent( $classes->post, $start, $end );
      $orders = array_merge( $orders, $class->render_bookings() );

    endwhile; endif;

    wp_reset_query();

    usort( $orders, function( $a, $b ){
      return $a['timestamp']>$b['timestamp'];
    });
    
    return rest_ensure_response( $orders );
  }

  function get_private_data_permissions_check() {
    if ( ! current_user_can('edit_posts') ) {
      return new WP_Error( 'rest_forbidden', esc_html__( 'OMG you can not view private data.', 'my-text-domain' ), array( 'status' => 401 ) );
    }

    return true;
  }



}

new WcsBookingsWPRestApi();
