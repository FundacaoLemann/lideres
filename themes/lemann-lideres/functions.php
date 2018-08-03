<?php
defined( 'ABSPATH' ) || exit;

// Cria as roles e capabilities personalizadas do site.
require get_stylesheet_directory() . '/includes/roles-capabilities.php';

// RT Media Gallery.
require get_stylesheet_directory() . '/includes/rt-media-gallery.php';

// Custom Post Types e seus campos.
require get_stylesheet_directory() . '/post-types/index.php';

// Page builder.
require get_stylesheet_directory() . '/page-builder/index.php';

add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/assets/css/style.css' );

    wp_enqueue_style( 'js_composer_front' );
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

    // Administradores sempre veem tudo.
    if ( is_super_admin( $user_id ) ) {
        return true;
    }

    $user = get_userdata( $user_id );

    $profile_user_id = bp_displayed_user_id();
    $is_friend       = friends_check_friendship( $user_id, $profile_user_id );

    // Previne algum caso onde o usuário não foi encontrado.
    if ( ! empty( $user ) ) {
        switch ( $group_id ) {
            case 9: // Disponibilidade para Oportunidade.
                if ( in_array( 'contratante', $user->roles ) || $is_friend ) {
                    return true;
                }
                break;

            case 8: // Evento Anual.
            case 10: // Contribuição/Apoio para a Rede de Lideres Lemann.
            case 11: // Contribuição/Apoio da Fundação Lemann.
                if ( $is_friend ) {
                    return true;
                }
                break;
        }
    }

    return false;
}
