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
        'edit_oportunidades' => true,
        'publish_oportunidades' => true,
        'edit_published_oportunidades' => true,
        'delete_oportunidades' => true,
        'delete_published_oportunidades' => true,
    ));
    add_role('parceiro', 'Parceiro', array(
        'read' => true,
        'edit_posts' => true,
        'publish_posts' => true,
        'edit_published_posts' => true,
        'delete_posts' => true,
        'delete_published_posts' => true,
        'edit_oportunidades' => true,
        'publish_oportunidades' => true,
        'edit_published_oportunidades' => true,
        'delete_oportunidades' => true,
        'delete_published_oportunidades' => true,
    ));
    add_role('lider', 'Líder', array(
        'read' => true,
        'candidatar_oportunidade' => true,
        'edit_oportunidades' => true,
        'upload_files' => true,
    ));
    add_role('palestrante', 'Palestrante', array(
        'read' => true,
        'edit_posts' => true,
        'publish_posts' => true,
        'edit_published_posts' => true,
        'delete_posts' => true,
        'delete_published_posts' => true,
        'edit_oportunidades' => true,
        'publish_oportunidades' => true,
        'edit_published_oportunidades' => true,
        'delete_oportunidades' => true,
        'delete_published_oportunidades' => true,
    ));
    add_role('contratante', 'Contratante', array(
        'read' => true,
        'edit_posts' => true,
        'publish_posts' => true,
        'edit_published_posts' => true,
        'delete_posts' => true,
        'delete_published_posts' => true,
        'adicionar_oportunidade' => true,
        'edit_oportunidades' => true,
        'publish_oportunidades' => true,
        'edit_published_oportunidades' => true,
        'delete_oportunidades' => true,
        'delete_published_oportunidades' => true,
    ));

    $editor = $wp_roles->get_role('editor');
    $moderador_caps = $editor->capabilities + [
        'adicionar_lider' => true,
        'adicionar_contratante' => true,
        'adicionar_oportunidade' => true,
    ];
    add_role('moderador', 'Moderador', $moderador_caps);

    add_role('inativo', 'Inativo', []);

    $administrator = $wp_roles->get_role('administrator');
    $administrator->add_cap('edit_oportunidades');
    $administrator->add_cap('publish_oportunidades');
    $administrator->add_cap('edit_published_oportunidades');
    $administrator->add_cap('delete_oportunidades');
    $administrator->add_cap('delete_published_oportunidades');

    $administrator->add_cap('edit_others_oportunidades');
    $administrator->add_cap('delete_others_oportunidades');

    $editor = $wp_roles->get_role('editor');
    $editor->add_cap('edit_oportunidades');
    $editor->add_cap('publish_oportunidades');
    $editor->add_cap('edit_published_oportunidades');
    $editor->add_cap('delete_oportunidades');
    $editor->add_cap('delete_published_oportunidades');

    $editor->add_cap('edit_others_oportunidades');
    $editor->add_cap('delete_others_oportunidades');

}

add_action('init', 'lemann_roles_capabilities');
