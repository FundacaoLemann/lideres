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

// Verifica se o usuário preencheu os campos obrigatórios e exibe msg.
require get_stylesheet_directory() . '/includes/bd-required-fields.php';

// RT Media Gallery.
require get_stylesheet_directory() . '/includes/rt-media-gallery.php';

// Custom Post Types e seus campos.
require get_stylesheet_directory() . '/post-types/index.php';

// Page builder.
require get_stylesheet_directory() . '/page-builder/index.php';

// Page builder.
require get_stylesheet_directory() . '/includes/search/search.php';

add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/assets/css/style.css' );

    wp_enqueue_style( 'js_composer_front' );

    wp_enqueue_script( 'lemann-scripts', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), null, true );
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
} );

/**
 * Sobrescreve as variáveis do tema.
 */
function ghostpool_custom_init_variables() {
    global $ghostpool_layout;

    // Exibe o conteúdo das oportunidades no layout certo.
    if ( is_singular( 'oportunidade' ) ) {
        $ghostpool_layout = 'gp-no-sidebar';
    }
}
