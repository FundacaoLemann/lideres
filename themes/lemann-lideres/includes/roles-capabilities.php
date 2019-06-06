<?php

/**
 * Cria as roles e capabilities personalizadas do site.
 */
function lemann_roles_capabilities() {
    global $wp_roles;

    add_role('equipe', 'Equipe', array(
        'read' => true,
        'edit_posts' => true,
        'publish_posts' => true,
        'edit_published_posts' => true,
        'delete_posts' => true,
        'delete_published_posts' => true,
    ));
    add_role('parceiro', 'Parceiro', array(
        'read' => true,
        'edit_posts' => true,
        'publish_posts' => true,
        'edit_published_posts' => true,
        'delete_posts' => true,
        'delete_published_posts' => true,
    ));
    add_role('lider', 'Líder', array(
        'read' => true,
        'edit_posts' => true,
        'publish_posts' => true,
        'edit_published_posts' => true,
        'delete_posts' => true,
        'delete_published_posts' => true,
        'candidatar_oportunidade' => true,
    ));
    add_role('palestrante', 'Palestrante', array(
        'read' => true,
        'edit_posts' => true,
        'publish_posts' => true,
        'edit_published_posts' => true,
        'delete_posts' => true,
        'delete_published_posts' => true,
    ));
    add_role('contratante', 'Contratante', array(
        'read' => true,
        'edit_posts' => true,
        'publish_posts' => true,
        'edit_published_posts' => true,
        'delete_posts' => true,
        'delete_published_posts' => true,
        'adicionar_oportunidade' => true,
    ));

    $editor = $wp_roles->get_role('editor');
    $moderador_caps = $editor->capabilities + [
        'adicionar_lider' => true,
        'adicionar_contratante' => true,
        'adicionar_oportunidade' => true,
    ];
    add_role('moderador', 'Moderador', $moderador_caps);

    add_role('inativo', 'Inativo', []);
}

add_action('init', 'lemann_roles_capabilities');
