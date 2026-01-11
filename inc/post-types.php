<?php
/**
 * Custom Post Types and Taxonomies for ezaarchitectures
 */

// Créer le type de contenu personnalisé 'project'
function create_project_post_type() {
    $labels = array(
        'name' => 'Projets',
        'singular_name' => 'Projet',
        'menu_name' => 'Projets',
        'add_new' => 'Ajouter un projet',
        'add_new_item' => 'Ajouter un nouveau projet',
        'edit_item' => 'Modifier le projet',
        'new_item' => 'Nouveau projet',
        'view_item' => 'Voir le projet',
        'search_items' => 'Rechercher des projets',
        'not_found' => 'Aucun projet trouvé',
        'not_found_in_trash' => 'Aucun projet trouvé dans la corbeille'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'projets')
    );

    register_post_type('project', $args);
}
add_action('init', 'create_project_post_type');

// Créer la taxonomie 'project_theme'
function create_project_taxonomy() {
    $labels = array(
        'name' => 'Thèmes',
        'singular_name' => 'Thème',
        'search_items' => 'Rechercher des thèmes',
        'all_items' => 'Tous les thèmes',
        'parent_item' => 'Thème parent',
        'parent_item_colon' => 'Thème parent :',
        'edit_item' => 'Modifier le thème',
        'update_item' => 'Mettre à jour le thème',
        'add_new_item' => 'Ajouter un nouveau thème',
        'new_item_name' => 'Nom du nouveau thème',
        'menu_name' => 'Thèmes'
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'theme-projet')
    );

    register_taxonomy('project_theme', array('project'), $args);
}
add_action('init', 'create_project_taxonomy');

// Enregistrer le type de contenu personnalisé "Personnel"
function register_personnel_post_type() {
    register_post_type('personnel', array(
        'labels' => array(
            'name' => 'Personnel',
            'singular_name' => 'Membre du Personnel',
        ),
        'public' => true,
        'has_archive' => false,
        'supports' => array('title', 'thumbnail'),
        'menu_icon' => 'dashicons-businessperson',
    ));
}
add_action('init', 'register_personnel_post_type');
