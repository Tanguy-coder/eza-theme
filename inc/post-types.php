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

// ================================================
// Personnalisation des colonnes admin pour les Projets
// ================================================

// Ajouter les colonnes personnalisées
function eza_project_admin_columns($columns) {
    // Réorganiser les colonnes : Image, Titre, Description, Thème, Date
    $new_columns = array();
    
    // Checkbox pour les actions en masse
    $new_columns['cb'] = $columns['cb'];
    
    // Image mise en avant
    $new_columns['featured_image'] = __('Image', 'eza_architecture');
    
    // Titre
    $new_columns['title'] = $columns['title'];
    
    // Description
    $new_columns['description'] = __('Description', 'eza_architecture');
    
    // Thème (taxonomie)
    $new_columns['project_theme'] = __('Thème', 'eza_architecture');
    
    // Date de publication
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter('manage_project_posts_columns', 'eza_project_admin_columns');

// Afficher le contenu des colonnes personnalisées
function eza_project_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'featured_image':
            if (has_post_thumbnail($post_id)) {
                $thumbnail = get_the_post_thumbnail($post_id, array(80, 80));
                echo $thumbnail;
            } else {
                echo '<span style="color:#999;">—</span>';
            }
            break;
            
        case 'description':
            $description = get_field('project_description', $post_id);
            if ($description) {
                // Nettoyer le HTML et limiter à 100 caractères
                $description = wp_strip_all_tags($description);
                $description = mb_substr($description, 0, 100);
                echo esc_html($description);
                if (mb_strlen($description) >= 100) {
                    echo '...';
                }
            } else {
                // Fallback sur l'extrait WordPress
                $excerpt = get_the_excerpt($post_id);
                if ($excerpt) {
                    $excerpt = mb_substr($excerpt, 0, 100);
                    echo esc_html($excerpt);
                    if (mb_strlen($excerpt) >= 100) {
                        echo '...';
                    }
                } else {
                    echo '<span style="color:#999;">—</span>';
                }
            }
            break;
            
        case 'project_theme':
            $themes = get_the_terms($post_id, 'project_theme');
            if ($themes && !is_wp_error($themes)) {
                $theme_names = array();
                foreach ($themes as $theme) {
                    $theme_names[] = esc_html($theme->name);
                }
                echo implode(', ', $theme_names);
            } else {
                echo '<span style="color:#999;">—</span>';
            }
            break;
    }
}
add_action('manage_project_posts_custom_column', 'eza_project_admin_column_content', 10, 2);

// Rendre les colonnes triables (optionnel)
function eza_project_sortable_columns($columns) {
    $columns['project_theme'] = 'project_theme';
    $columns['date'] = 'date';
    return $columns;
}
add_filter('manage_edit-project_sortable_columns', 'eza_project_sortable_columns');

// CSS pour améliorer l'affichage des colonnes dans l'admin
function eza_project_admin_column_styles() {
    echo '<style>
        .column-featured_image {
            width: 100px;
        }
        .column-featured_image img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
        }
        .column-description {
            max-width: 300px;
        }
        .column-project_theme {
            width: 150px;
        }
    </style>';
}
add_action('admin_head', 'eza_project_admin_column_styles');

// ================================================
// Personnalisation des colonnes admin pour le Personnel
// ================================================

// Ajouter les colonnes personnalisées pour le personnel
function eza_personnel_admin_columns($columns) {
    $new_columns = array();
    
    // Checkbox pour les actions en masse
    $new_columns['cb'] = $columns['cb'];
    
    // Image mise en avant
    $new_columns['featured_image'] = __('Image', 'eza_architecture');
    
    // Titre
    $new_columns['title'] = $columns['title'];
    
    // Mention
    $new_columns['personnel_mention'] = __('Mention', 'eza_architecture');
    
    // Fonction
    $new_columns['personnel_function'] = __('Fonction', 'eza_architecture');
    
    // Description
    $new_columns['personnel_description'] = __('Description', 'eza_architecture');
    
    // Date de publication
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter('manage_personnel_posts_columns', 'eza_personnel_admin_columns');

// Afficher le contenu des colonnes personnalisées pour le personnel
function eza_personnel_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'featured_image':
            if (has_post_thumbnail($post_id)) {
                $thumbnail = get_the_post_thumbnail($post_id, array(80, 80));
                echo $thumbnail;
            } else {
                echo '<span style="color:#999;">—</span>';
            }
            break;
            
        case 'personnel_mention':
            $mention = get_field('personnel_mention', $post_id);
            if ($mention) {
                echo esc_html($mention);
            } else {
                echo '<span style="color:#999;">—</span>';
            }
            break;
            
        case 'personnel_function':
            $function = get_field('personnel_function', $post_id);
            if ($function) {
                echo esc_html($function);
            } else {
                echo '<span style="color:#999;">—</span>';
            }
            break;
            
        case 'personnel_description':
            $description = get_field('personnel_description', $post_id);
            if ($description) {
                // Nettoyer le HTML et limiter à 100 caractères
                $description = wp_strip_all_tags($description);
                $description = mb_substr($description, 0, 100);
                echo esc_html($description);
                if (mb_strlen($description) >= 100) {
                    echo '...';
                }
            } else {
                echo '<span style="color:#999;">—</span>';
            }
            break;
    }
}
add_action('manage_personnel_posts_custom_column', 'eza_personnel_admin_column_content', 10, 2);

// CSS pour améliorer l'affichage des colonnes du personnel dans l'admin
function eza_personnel_admin_column_styles() {
    echo '<style>
        .column-featured_image {
            width: 100px;
        }
        .column-featured_image img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
        }
        .column-personnel_mention {
            width: 150px;
        }
        .column-personnel_function {
            width: 180px;
        }
        .column-personnel_description {
            max-width: 300px;
        }
    </style>';
}
add_action('admin_head', 'eza_personnel_admin_column_styles');
