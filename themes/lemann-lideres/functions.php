<?php
defined( 'ABSPATH' ) || exit;

/**
 * Campos do BuddyPress usado como "Outros (especifique)".
 * Indexado pelo ID do campo original, valorado com o ID do campo outros.
 */
define( 'LEMANN_BP_OUTROS', [
    32  => 574,
    83  => 257,
    90  => 258,
    108 => 259,
    144 => 260,
    163 => 261,
    207 => 263,
    235 => 264,
    245 => 265,
] );

// Cria as roles e capabilities personalizadas do site.
require get_stylesheet_directory() . '/includes/roles-capabilities.php';

// Inclui arquivo com as alterações do BuddyPress feitas via tema.
require get_stylesheet_directory() . '/includes/buddypress/index.php';

// Inclui arquivo com as funcionalidades do match.
require get_stylesheet_directory() . '/includes/match/index.php';

// Inclui o arquivo com a função que exibe o Posts Carousel do plugin Aardvark.
require get_stylesheet_directory() . '/includes/carousel-posts.php';

// RT Media Gallery.
require get_stylesheet_directory() . '/includes/rt-media-gallery.php';

// Custom Post Types e seus campos.
require get_stylesheet_directory() . '/post-types/index.php';

// Page builder.
require get_stylesheet_directory() . '/page-builder/index.php';

// Page builder.
require get_stylesheet_directory() . '/includes/search/search.php';

// WP Job Manager.
require get_stylesheet_directory() . '/job_manager/wp-job-manager.php';

// Funções do cabeçalho.
require get_stylesheet_directory() . '/lib/inc/page-header.php';

// Migrações
require get_stylesheet_directory() . '/includes/migrations.php';

add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/assets/css/style.css' );
    wp_enqueue_style( 'vue-multiselect', get_stylesheet_directory_uri() . '/assets/css/vue-multiselect.min.css' );

    wp_enqueue_style( 'js_composer_front' );

    wp_enqueue_script( 'lemann-scripts', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'vue', get_stylesheet_directory_uri() . '/assets/js/vue/vue.min.js', [], '2.6.10', true );
    wp_enqueue_script( 'vue-multiselect', get_stylesheet_directory_uri() . '/assets/js/vue/vue-multiselect.min.js', ['vue'], '2.1.0', true );

    /**
     * Gera o js com os países, estados e cidades.
     */
    $countries_states_city = '/includes/countries-states-cities/countries-states-cities.js';
    if ( ! file_exists( get_theme_file_path( $countries_states_city ) ) ) {
        $countries = get_theme_file_path( '/includes/countries-states-cities/countries.json' );
        $countries = file_get_contents( $countries );
        $countries = json_decode( $countries );
        $countries = $countries->countries;
        $countries = wp_list_pluck( $countries, 'name' );
        sort( $countries );
        foreach ( $countries as $key => $country ) {
            if ( 'Brazil' == $country ) {
                $countries[ $key ] = 'Brasil';
            }
        }

        $states_raw = get_theme_file_path( '/includes/countries-states-cities/states.csv' );
        $states_raw = array_map( 'str_getcsv', file( $states_raw ) );
        unset( $states_raw[0] );
        $states_raw = wp_list_sort( $states_raw, '2' );
        $states_tmp = [];
        foreach ( $states_raw as $state ) {
            $states_tmp[ $state[0] ] = [
                'name'   => $state[1],
                'code'   => trim( $state[2] ),
                'cities' => [],
            ];
        }

        $cities = get_theme_file_path( '/includes/countries-states-cities/cities.csv' );
        $cities = array_map( 'str_getcsv', file( $cities ) );
        $cities = wp_list_sort( $cities, '2' );
        unset( $cities[0] );
        foreach ( $cities as $city ) {
            $states_tmp[ $city[0] ]['cities'][] = $city[2];
        }

        $states = [];
        foreach ( $states_tmp as $state ) {
            $states[ $state['code'] ] = $state['cities'];
        }

        $json = [
            'countries'     => $countries,
            'states-cities' => $states,
        ];
        $json = 'var lemann_coutries = ' . wp_json_encode( $json );
        file_put_contents( get_stylesheet_directory() . $countries_states_city, $json );
    }
    wp_enqueue_script( 'lemann-countries-states-cities', get_stylesheet_directory_uri() . $countries_states_city, array( 'jquery' ), null, true );
    wp_enqueue_script( 'lemann-countries-states-cities-script', get_stylesheet_directory_uri() . '/includes/countries-states-cities/scripts.js', array( 'jquery', 'lemann-countries-states-cities' ), null, true );

});

add_action( 'admin_enqueue_scripts', function () {
    wp_enqueue_script( 'lemann-countries-states-cities', get_stylesheet_directory_uri() . '/includes/countries-states-cities/countries-states-cities.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'lemann-countries-states-cities-script', get_stylesheet_directory_uri() . '/includes/countries-states-cities/scripts.js', array( 'jquery', 'lemann-countries-states-cities' ), null, true );
    wp_enqueue_script( 'lemann-admin', get_stylesheet_directory_uri() . '/assets/js/admin.js', array( 'jquery' ) );
});

/**
 * Redireciona o usuário para a paǵina de login colocando
 * a mensagem de erro em uma variável de sessão.
 */
add_filter( 'authenticate', function( $user, $username, $password ) {
    if ( empty( $username ) || empty( $password ) || is_wp_error( $user ) || null == $user ) {

        if ( ! session_id() ) {
            session_start();
        }

        if ( empty( $username ) || empty( $password ) ) {
            $_SESSION["login_error"] = 'Usuário e senha são obrigatórios.';
        } else {
            $_SESSION["login_error"] = 'Usuário ou senha inválidos. <a href="#lost-password/"  class="lost-password-trigger">Esqueceu sua senha?</a>';
        }

        wp_redirect( get_permalink( 100000179 ) );
        exit;

    }
    return $user;
}, 9999, 3 );

/**
 * Útil para determinar se estamos ou não no mês do evento.
 *
 * @return boolean
 */
function is_event_month() {
    return 8 == date_i18n( 'n' );
}

/**
 * Verifica a visibilidade de um determinado grupo de campos do xprofile
 * de um usuário para outro. Roda *fora* e *antes* do sistema do BuddyPress.
 *
 * @param int      $group_id ID do grupo.
 * @param int|null $user_id  ID do usuário vendo o perfil. O ID do usuário dono do perfil é pego automaticamente.
 * @return bool
 */
function lemann_user_can_see_group( $group_id, $user_id = null ) {
    if ( ! $user_id ) {
        $user_id = get_current_user_id();
    }

    $profile_user_id = bp_displayed_user_id();

    // Administradores (e o próprio usuário) sempre veem tudo.
    if ( is_super_admin( $user_id ) || $user_id == $profile_user_id ) {
        return true;
    }

    $group_fields_visibility = [
        8  => 420,
        9  => 422,
        10 => 424,
        11 => 426,
    ];

    $visible_to_friends = false;
    if (
        isset( $group_fields_visibility[ $group_id ] ) &&
        'sim' == xprofile_get_field_data( $group_fields_visibility[ $group_id ], $profile_user_id ) &&
        friends_check_friendship( $user_id, $profile_user_id )
        ) {
        $visible_to_friends = true;
    }

    $user = get_userdata( $user_id );
    if ( ! empty( $user ) ) {
        switch ( $group_id ) {
            case 9: // Disponibilidade para Oportunidade.
                if ( in_array( 'contratante', $user->roles ) || $visible_to_friends ) {
                    return true;
                }
                break;

            case 8: // Evento Anual.
            case 10: // Contribuição/Apoio para a Rede de Lideres Lemann.
            case 11: // Contribuição/Apoio da Fundação Lemann.
                if ( $visible_to_friends ) {
                    return true;
                }
                break;
        }
    }

    return false;
}

add_filter('wp_login', function($user_login, $user) {
    if(in_array('inativo', $user->roles)){
        if(false) $user = new WP_User;

        $user->remove_role('inativo');

        groups_join_group( 46, $user->ID ); //@TODO id do grupo ser definido de alguma forma

        wp_redirect(get_bloginfo('url') . "/conheca-a-rede/{$user->user_login}/profile/edit/group/1/#buddypress");
        exit;
//        $_SESSION['first_login'] = true;

    }
    wp_redirect(get_bloginfo('url'));

}, 10, 2);


if(isset($_SESSION['first_login']) && $_SESSION['first_login']){
    unset($_SESSION['first_login']);
}

function ghostpool_bp_activity( $atts, $content = null ) {

    global $exclude_types;

    extract( shortcode_atts( array(
        'title' => '',
        'post_form' => 'enabled',
        'scope' => '',
        'display_comments' => 'threaded',
        'allow_comments' => 'gp-comments-enabled',
        'exclude_types' => '',
        'include' => '',
        'order' => 'DESC',
        'per_page' => '5',
        'max' => '',
        'show_hidden' => '',
        'search_terms' => '',
        'user_id' => '',
        'object' => '',
        'action' => '',
        'primary_id' => '',
        'secondary_id' => '',
        'classes' => '',
        'css' => '',
    ), $atts ) );

    // Unique Name
    STATIC $i = 0;
    $i++;
    $name = 'gp_bp_activity_' . $i;

    // Classes
    $css_classes = array(
        'activity',
        $allow_comments,
        $classes,
    );
    $css_classes = trim( implode( ' ', array_filter( array_unique( $css_classes ) ) ) );
    $css_classes = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_classes . vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );

    // Exclude activity types
    if ( ! empty( $exclude_types ) ) {
        if ( ! function_exists( 'ghostpool_exclude_activity_types' ) ) {
            function ghostpool_exclude_activity_types( $a, $activities ) {

                global $exclude_types;

                if ( ! bp_is_blog_page() )
                    return $activities;

                $exclude_types = preg_replace( '/\s+/', '', $exclude_types );
                $types = explode( ',', $exclude_types );

                foreach ( $activities->activities as $key => $activity ) {

                    foreach( $types as $type ) {

                        if ( $activity->type == $type ) {
                            unset( $activities->activities[$key] );
                            $activities->activity_count = $activities->activity_count - 1;
                            $activities->total_activity_count = $activities->total_activity_count - 1;
                            $activities->pag_num = $activities->pag_num - 1;
                        }
                    }

                }

                $activities_new = array_values( $activities->activities );
                $activities->activities = $activities_new;
                return $activities;
            }
        }
        add_action( 'bp_has_activities','ghostpool_exclude_activity_types', 10, 2 );

    }

    // Activity query
    $query_string = "scope=$scope&display_comments=$display_comments&include=$include&sort=$order&per_page=$per_page&max=$max&show_hidden=$show_hidden&search_terms=$search_terms&user_id=$user_id&object=$object&action=$action&primary_id=$primary_id&secondary_id=$secondary_id&count_total=count_query&page_arg=actsc";

    // Add to option for use in ajax function
    if ( ! update_option( 'ghostpool_activity_query', $query_string ) ) {
        add_option( 'ghostpool_activity_query', $query_string );
    } else {
        update_option( 'ghostpool_activity_query', $query_string );
    }

    ob_start(); ?>

    <div id="buddypress">

        <div id="<?php echo sanitize_html_class( $name ); ?>" class="<?php echo esc_attr( $css_classes ); ?>">

            <?php if ( $title ) { ?><h3 class="widgettitle"><?php echo esc_attr( $title ); ?></h3><?php } ?>

            <?php if ( is_user_logged_in() && $post_form == 'enabled' ) { bp_get_template_part( 'activity/post-form' ); } ?>

            <?php

            do_action( 'bp_before_activity_loop' ); ?>

            <?php

            if ( bp_has_activities( $query_string ) ) : ?>

                <?php if ( empty( $_POST['page'] ) ) : ?>

                    <ul id="activity-stream" class="gp-section-loop activity-list item-list">

                <?php endif; ?>

                <?php while ( bp_activities() ) : bp_the_activity(); ?>

                    <?php bp_get_template_part( 'activity/entry' ); ?>

                <?php endwhile; ?>

                <?php if ( bp_activity_has_more_items() ) : ?>

                    <?php if ( function_exists( 'bp_activity_load_more_link' ) ) { ?>

                        <li class="load-more">
                            <a href="<?php bp_activity_load_more_link(); ?>"><?php esc_html_e( 'Load More', 'aardvark-plugin' ); ?></a>
                        </li>

                    <?php } ?>

                <?php endif; ?>

                <?php if ( empty( $_POST['page'] ) ) : ?>

                    </ul>

                <?php endif; ?>

            <?php endif; ?>

            <?php do_action( 'bp_after_activity_loop' ); ?>

            <?php if ( empty( $_POST['page'] ) ) : ?>

                <form name="activity-loop-form" id="activity-loop-form" method="post">

                    <?php wp_nonce_field( 'activity_filter', '_wpnonce_activity_filter' ); ?>

                </form>

            <?php endif; ?>

        </div>

    </div>

    <?php

    $output_string = ob_get_contents();
    ob_end_clean();
    return $output_string;

}

/**
 * Filtra os campos exibidos pelo BuddyPress
 *
 * @param string $value    Valor a ser exibido.
 * @param string $type     Tipo do campo.
 * @param int    $field_id ID do campo.
 * @return string
 */
function lemann_valor_campo_outros( $value, $type, $field_id ) {
    if ( in_array( $field_id, array_keys( LEMANN_BP_OUTROS ) ) ) {
        $outros_especifique = xprofile_get_field_data( LEMANN_BP_OUTROS[ $field_id ] );
        if ( ! empty( $outros_especifique ) ) {
            if ( empty( $value ) ) {
                $value = $outros_especifique;
            } else {
                $separador = ( false === strpos( $value, ',' ) ) ? ' ' : ', ';
                $value     = preg_replace( '/,?\s*Outros?\s*/', '', $value );
                $value    .= $separador . $outros_especifique;
            }
        }
    }
    return $value;
}
add_filter( 'bp_get_the_profile_field_value', 'lemann_valor_campo_outros', 0, 3 );

/**
 * Exibe a descrição do campo *antes* do input e evita que ela seja repetida depois dele.
 */
function lemann_bp_edit_show_description() {
    global $field;
    echo apply_filters( 'bp_get_the_profile_field_description', $field->description );
    $field->description = '';
}

/**
 * Verifica se o campo realmente pode ser exibido para o usuário.
 *
 * @param mixed $value    Valor a ser exibido.
 * @param int   $field_id ID do campo.
 * @param int   $user_id  ID do usuário.
 * @return mixed
 */
function lemann_bp_check_field_visibility( $value, $field_id, $user_id ) {

        $field_level = xprofile_get_field_visibility_level($field_id, $user_id);
        $hidden_levels = bp_xprofile_get_hidden_field_types_for_user($user_id, get_current_user_id());

        if(in_array($field_level, $hidden_levels) ){
            return '';
        }

    return $value;
}
add_filter( 'xprofile_get_field_data', 'lemann_bp_check_field_visibility', 10, 3 );


add_action( 'widgets_init', function() {
    register_sidebar( array(
        'name'          => 'Oportunidades',
        'id'            => 'oportunidades',
        'description'   => 'Barra lateral da área de oportunidades',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => 'Jornadas',
        'id'            => 'jornadas',
        'description'   => 'Barra lateral da área de jornadas',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle">',
        'after_title'   => '</h3>',
    ) );
} );

/**
 * Sobrescreve as variáveis do tema.
 */
function ghostpool_custom_init_variables() {
    global $ghostpool_layout;

    // Exibe o conteúdo das oportunidades e das vagas no layout certo.
    if ( is_singular( [ 'oportunidade', 'jornada' ] ) ) {
        $ghostpool_layout = 'gp-sidebar-right';
    } elseif ( is_singular( 'job_listing' ) ) {
        $ghostpool_layout = 'gp-no-sidebar';
    }
}

/**
 * E-mail de redefinição de senha: altera o assunto (padrão WP).
 */
add_filter( 'retrieve_password_title', function( $title ) {
    if ( is_multisite() ) {
        $site_name = get_network()->site_name;
    } else {
        $site_name = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
    }

    return sprintf(
        /* translators: Site name */
        __( '[%s] Solicitação de redefinição de senha', 'lemann-lideres' ),
        $site_name
    );
} );

/**
 * E-mail de redefinição de senha: altera a mensagem (padrão WP e Aardvark).
 *
 * @param string  $message    Mensagem original.
 * @param string  $key        Chave para redefinição de senha.
 * @param string  $user_login Login do usuário.
 * @param WP_User $user_data  Dados do usuário.
 * @return sring
 */
function lemann_retrieve_password_message( $message, $key, $user_login, $user_data ) {

    $user = get_user_by('login', $user_login);
    $key = get_password_reset_key( $user );

    $new_message   = [];
    $new_message[] = __( 'Foi feita uma solicitação para que a senha da seguinte conta fosse redefinida', 'lemann-lideres' );
    $new_message[] = network_site_url();
    $new_message[] = sprintf( __( 'Nome de usuário: %s'), $user_login );
    $new_message[] = __( 'Se foi um engano, apenas ignore este e-mail e nada acontecerá.', 'lemann-lideres' );
    $new_message[] = __( 'Para redefinir sua senha, visite o seguinte endereço:', 'lemann-lideres' );
    $new_message[] = network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' );

    return implode( "\r\n\r\n", $new_message );
}
add_filter( 'retrieve_password_message', 'lemann_retrieve_password_message', 10, 4 );
add_filter( 'ghostpool_retrieve_password_message', 'lemann_retrieve_password_message', 10, 4 );


add_action('job_application_form_fields_end', function(){
    global $post;
    $email = get_post_meta($post->ID, '_application', true);

    echo "<p>contato da vaga <a href=\"mailto:$email\">$email</a></p>";
});

// envia os emails de aplicação para
if($application_email_to = @$_ENV['APPLICATION_EMAIL_TO']){
    add_filter('create_job_application_notification_recipient', function($from_email, $job_id, $application_id) use($application_email_to){
        return $application_email_to;
    }, 0, 3);
}

// corrige candidaturas
if(!get_option('_candidaturas_atualizadas')){
    /**
     * @var wpdb
     */
    global $wpdb;

    $posts = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type = 'job_application'");

    foreach($posts as $p){
        $p = (object) $p;

        $uid = get_post_meta($p->ID, '_candidate_user_id', true);
        $user = get_user_by('ID', $uid);
        $wpdb->query("UPDATE $wpdb->postmeta SET meta_value = '{$user->user_email}' WHERE post_id = $p->ID AND meta_key = '_candidate_email'");
        $wpdb->query("UPDATE $wpdb->posts SET post_title = '{$user->display_name}' WHERE ID = $p->ID");
    }
    update_option('_candidaturas_atualizadas', true);
}

add_action('wp', function(){
    if(is_singular('job_listing')){
        $users = get_post_meta(get_the_ID(), '_user_views', true);

        if(!$users){
            $users = [];
        }

        $current_user_id = 'u:' . get_current_user_id();

        if(!isset($users[$current_user_id])){
            $users[$current_user_id] = [];
        }
        $users[$current_user_id][date('Y-m-d.H')] = date('d/m/Y') . ' às ' . date('H:i');

        update_post_meta(get_the_ID(), '_user_views', $users);
    }
});

function get_job_users_views($post_id){
    $users = get_post_meta(get_the_ID(), '_user_views', true);

    if(!$users){
        $users = [];
    }

    $result = [];
    foreach($users as $user_id => $views){
        $user_id = substr($user_id, 2);
        $result[] = [
            'uid' => $user_id,
            'user' => get_user_by('id', $user_id),
            'views' => count($views),
            'last' => array_pop($views)
        ];
    }

    usort($result, function($a,$b){
        if($a['views'] > $b['views']){
            return -1;
        } else if($a['views'] < $b['views']){
            return 1;
        } else {
            $dateFormat = 'd/m/Y à\\s H:i';
            return date_create_from_format($dateFormat, $b['last']) <=> date_create_from_format($dateFormat, $a['last']);
        }
    });

    return $result;
}

add_filter( 'password_reset_expiration', function( $expiration ) {
    return MONTH_IN_SECONDS;
});

/**
 * Handles sending password retrieval email to user.
 *
 * @uses $wpdb WordPress Database object
 * @param int $user_id User ID
 * @return bool true on success false on error
 */
function send_activation_email_message($user_id) {
    if(!current_user_can('manage_options')){
        return false;
    }

    $user_data = get_user_by( 'id', trim( $user_id ) );

    if ( !$user_data ) return false;

    // redefining user_login ensures we return the right case in the email
    $user_login = $user_data->user_login;
    $user_email = $user_data->user_email;

    do_action('lostpassword_post');

    do_action('retreive_password', $user_login);  // Misspelled and deprecated
    do_action('retrieve_password', $user_login);

    $allow = apply_filters('allow_password_reset', true, $user_data->ID);

    if ( ! $allow )
        return false;
    else if ( is_wp_error($allow) )
        return false;

    $key = get_password_reset_key( $user_data );
    do_action('retrieve_password_key', $user_login, $key);

    $message = __('Seja bem-vindo à rede de Líderes da Fundação Lemann:') . "\r\n\r\n";
    $message .= network_home_url( '/' ) . "\r\n\r\n";
    $message .= sprintf(__('Seu nome de usuário é: %s'), $user_login) . "\r\n\r\n";
    $message .= __('Para definir sua senha acesse o link abaixo:') . "\r\n\r\n";
    $message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . "\r\n";
    if ( is_multisite() )
    $blogname = $GLOBALS['current_site']->site_name;
    else
    // The blogname option is escaped with esc_html on the way into the database in sanitize_option
    // we want to reverse this for the plain text arena of emails.
    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

    $title = sprintf( __('[%s] Seja Bem-vindo'), $blogname );

    if($_mail = @$_ENV['MATCH_EMAIL_TO']){
        $user_email = $_mail;
    }

    if (wp_mail($user_email, $title, $message) ){
        update_user_meta($user_id, '_activation_email_datetime', date('d/m/Y') . ' às ' . date('H:i:s'));
        return ['ID'=>$user_id, 'email' => $user_email, 'name' => $user_data->display_name, 'datetime' => date('d/m/Y') . ' às ' . date('H:i:s')];
    }

    return false;
}

add_action('after_setup_theme', function(){
    remove_action('init', 'ghostpool_login_redirect');
},1000);

function filter_oportunidades( $query ) {
    if ($query->is_archive() && $query->is_main_query() && get_query_var('post_type') == 'oportunidade') {
        if ($_GET['cat']) {
            $query->set('tax_query', [
                [
                    'taxonomy' => 'temas_oportunidade',
                    'field'    => 'slug',
                    'terms'    => $_GET['cat']
                ]
            ]);
        }
        $meta_query = ['relation' => 'AND'];
        if ($_GET['data_inicial']) {
            $meta_query[] = [
                'key' => 'data_inicial',
                'value' => $_GET['data_inicial'],
                'compare' => '>=',
                'type' => 'DATE',
            ];
        }
        if ($_GET['data_final']) {
            $meta_query[] = [
                'key' => 'data_final',
                'value' => $_GET['data_final'],
                'compare' => '<=',
                'type' => 'DATE',
            ];
        }
        $query->set('meta_query', $meta_query);
    }
}
add_action( 'pre_get_posts', 'filter_oportunidades' );

function temas_interesse_taxonomy () {
    $term = 'temas_oportunidade';
    register_taxonomy($term, ['oportunidade'], [
        'hierarchical'          => false,
        'labels'                => [
            'name'          => __('Categorias', 'lemann-lideres-oportunidades'),
            'singular_name' => __('Categoria', 'lemann-lideres-oportunidades')
        ],
        'public'                => true,
        'show_in_rest'          => true,
        'query_var'             => true,
        'capabilities'          => [
            'assign_terms' => 'edit_oportunidades',
        ],
    ]);
    wp_insert_term('Gestão Pública', $term, ['description' => 'Gestão Pública', 'slug' => 'gestao-publica']);
    wp_insert_term('Saúde', $term, ['description' => 'Saúde', 'slug' => 'saude']);
    wp_insert_term('Educação', $term, ['description' => 'Educação', 'slug' => 'educacao']);
    wp_insert_term('Direitos Humanos', $term, ['description' => 'Direitos Humanos', 'slug' => 'direitos-humanos']);
    wp_insert_term('Ciência', $term, ['description' => 'Ciência', 'slug' => 'ciencia']);
    wp_insert_term('Segurança Pública', $term, ['description' => 'Segurança Pública', 'slug' => 'seguranca-publica']);
    wp_insert_term('Empreendedorismo', $term, ['description' => 'Empreendedorismo', 'slug' => 'empreendedorismo']);
    wp_insert_term('Democracia e Política', $term, ['description' => 'Democracia e Política', 'slug' => 'democracia']);
    wp_insert_term('Sustentabilidade', $term, ['description' => 'Sustentabilidade', 'slug' => 'sustentabilidade']);
    wp_insert_term('Desenvolvimento Econômico', $term, ['description' => 'Desenvolvimento Econômico', 'slug' => 'desenvolvimento-economico']);
    wp_insert_term('Outros', $term, ['description' => 'Outros', 'slug' => 'outros']);
}
add_action('init', 'temas_interesse_taxonomy');

function cmb2_oportunidades_metaboxes () {
    $cmb2_oportunidade = new_cmb2_box([
        'id'           => 'oportunidade_periodo',
        'title'        => __('Período', 'lemann-lideres-oportunidades'),
        'object_types' => ['oportunidade'],
        'context'      => 'side',
        'priority'     => 'default',
    ]);
    $cmb2_oportunidade->add_field([
        'name'        => __('Data inicial', 'lemann-lideres-oportunidades'),
        'id'          => 'data_inicial',
        'type'        => 'text_date',
        'date_format' => 'Y-m-d',
        'attributes'  => [
            'data-datepicker' => json_encode([
                'formatDate' => 'yy-mm-dd',
            ])
        ],
    ]);
    $cmb2_oportunidade->add_field([
        'name'        => __('Data final', 'lemann-lideres-oportunidades'),
        'description' => __('Pode ser a mesma da data inicial.', 'lemann-lideres-oportunidades'),
        'id'          => 'data_final',
        'type'        => 'text_date',
        'date_format' => 'Y-m-d',
        'attributes'  => [
            'data-datepicker' => json_encode([
                'formatDate' => 'yy-mm-dd',
            ])
        ],
    ]);
}
add_action('cmb2_admin_init', 'cmb2_oportunidades_metaboxes');

add_action('admin_menu', function(){
    add_users_page('Ativação de usuários inativos', 'Ativação de usuários inativos', 'manage_options', 'ativacao-usuarios-inativos', 'page_ativacao_usuarios');
});

add_action('admin_head', 'remove_admin');
function remove_admin(){
    if ($_GET['hide_menu'] && $_GET['hide_menu'] == '1') { ?>
        <style type="text/css">
            body { margin: 0; }
            .block-editor__container .components-navigate-regions { height: auto; }
            .edit-post-layout__content { margin-left: 0 !important; }
            .auto-fold .edit-post-header { left: 0; }
            #wpcontent, #footer { margin-left: 0px; }
        </style>
        <script type="text/javascript">
            jQuery(document).ready( function($) {
                $('#wpadminbar').remove();
                $('#adminmenuback, #adminmenuwrap').remove();
            });
        </script>
        <script type="text/javascript" src="https://unpkg.com/iframe-resizer@4.1.1/js/iframeResizer.contentWindow.min.js"></script>
    <?php
    }
}

function page_ativacao_usuarios(){
    $users = get_users(['role' => 'inativo']);

    if(isset($_POST['action']) && $_POST['action'] === 'send-activation-email'){
        set_time_limit(0);
        $users_log = [];
        foreach($_POST['users'] as $user_id){
            if($user = send_activation_email_message($user_id)){
                $users_log[] = (object) $user;
            }
        }
        $logs = get_option('_activation_email_logs', []);

        $logs[] = (object)['datetime'=>date('d/m/Y H:i:s'), 'current_user_id' => get_current_user_id(), 'users' => $users_log];
        update_option('_activation_email_logs', $logs, false);

    }

    include __DIR__ . '/includes/admin-ativacao-usuarios.php';
}

function lideres_login_styles() {
    ?>
    <style type="text/css">
        body {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/login_bg_2.png) !important;
            background-size: cover !important;
        }
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo_negativo_branco.png);
            height:65px;
            width:320px;
            background-size: 220px;
            background-repeat: no-repeat;
        	padding-bottom: 30px;
        }

        form {
            box-shadow: 0 0 0px 10px rgba(8, 48, 80, 0.3) !important;
            border-radius: 5px !important;
            background-color: rgba(255, 255, 255, 0.8) !important;
        }


    a, a:hover { color: white !important; }
    </style>
    <?php
}
add_action( 'login_enqueue_scripts', 'lideres_login_styles' );

function bps_template_stack_lemann ($stack)
{
    $stack[] = __DIR__ . '/bps-templates';
	return $stack;
}
add_filter ('bp_get_template_stack', 'bps_template_stack_lemann', 20);

function bps_templates_lemann ($templates)
{
    return array_merge($templates, ['lemann/lideres']);
}
add_filter('bps_templates', 'bps_templates_lemann');

function company_logo_div ($size = 'thumbnail', $default = null, $post = null) {
    $logo = get_the_company_logo($post, $size);
	if (has_post_thumbnail($post)) {
		echo '<div class="company_logo" style="background-image: url(' . esc_url($logo) . '"></div>';
		// Before 1.24.0, logo URLs were stored in post meta.
	} elseif (!empty($logo) && (strstr($logo, 'http') || file_exists($logo))) {
		if ('full' !== $size) {
			$logo = job_manager_get_resized_image($logo, $size);
		}
		echo '<div class="company_logo" style="background-image: url(' . esc_url($logo) . ')"></div>';
	} elseif ($default) {
		echo '<div class="company_logo" style="background-image: url(' . esc_url($default) . ')"></div>';
	} else {
		echo '<div class="company_logo" style="background-image: url(' . get_stylesheet_directory_uri() . '/assets/images/company-placeholder.png)"></div>';
	}
}

function capture_job_listing_edition() {
    if (isset($_GET['editar_vaga']) && $_GET['editar_vaga'] == '1') {
        get_template_part( 'page-editar-vaga' );
    }
}
add_action('template_redirect', 'capture_job_listing_edition');