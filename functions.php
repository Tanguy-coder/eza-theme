<?php

add_action('admin_notices', 'my_acf_debug_notice');
function my_acf_debug_notice() {
    if (current_user_can('manage_options')) {
        echo '<div class="notice notice-info">';
        echo '<p>ACF function exists: ' . (function_exists('acf_add_local_field_group') ? 'Yes' : 'No') . '</p>';
        echo '<p>Post type "project" exists: ' . (post_type_exists('project') ? 'Yes' : 'No') . '</p>';
        echo '</div>';
    }
}
// Sécurité : Désactiver l'éditeur de fichiers WordPress
define('DISALLOW_FILE_EDIT', true);

// Inclure les fichiers nécessaires
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/security.php';

// Fonction d'initialisation du thème
function eza_theme_setup() {
    // Activer la fonctionnalité des menus
    register_nav_menus(array(
        'primary-menu' => __('Menu Principal', 'eza_architecture'),
        'footer-menu' => __('Menu Pied de Page', 'eza_architecture')
    ));

    // Ajouter la prise en charge des fonctionnalités de thème
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
}
add_action('after_setup_theme', 'eza_theme_setup');

// Charger les fichiers CSS et JS du thème
function eza_enqueue_scripts() {
    $theme_version = wp_get_theme()->get('Version');

    wp_enqueue_style('eza-style', get_stylesheet_uri(), array(), $theme_version);
    wp_enqueue_style('eza-animate', get_template_directory_uri() . '/assets/css/animate.css', array(), $theme_version);
    wp_enqueue_script('eza-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), $theme_version, true);
    wp_enqueue_style('archive-project-css', get_template_directory_uri() . '/css/archive-project.css', array(), $theme_version);

    if (is_singular('project')) {
        wp_enqueue_style('single-project-css', get_template_directory_uri() . '/css/single-project.css', array(), $theme_version);

        wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css');
        wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', array('jquery'), null, true);
        wp_enqueue_script('projects-js', get_template_directory_uri() . '/js/projects.js', array('jquery', 'swiper-js'), $theme_version, true);
        wp_localize_script('projects-js', 'projectsData', array(
            'ajaxurl' => admin_url('admin-ajax.php')
        ));
    }
}
add_action('wp_enqueue_scripts', 'eza_enqueue_scripts');

// Fonction pour obtenir l'URL des icônes
function eza_get_icon_url($icon_name) {
    return esc_url(get_template_directory_uri() . '/assets/icons/' . $icon_name);
}

// Ajouter une classe supplémentaire aux éléments de menu
function add_additional_class_on_li($classes, $item, $args) {
    if (isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

// Afficher la vignette du post
if (!function_exists('eza_post_thumbnail')) {
    function eza_post_thumbnail() {
        if (has_post_thumbnail()) {
            the_post_thumbnail();
        }
    }
}

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

// Filtrer les projets (AJAX)

add_action('wp_ajax_filter_projects', 'filter_projects');
add_action('wp_ajax_nopriv_filter_projects', 'filter_projects');

// Rechercher des projets (AJAX)
function search_projects() {
    $query = isset($_POST['query']) ? sanitize_text_field($_POST['query']) : '';

    $args = array(
        'post_type' => 'project',
        'posts_per_page' => -1,
        's' => $query,
    );

    $search_query = new WP_Query($args);

    if ($search_query->have_posts()) :
        while ($search_query->have_posts()) : $search_query->the_post();
            get_template_part('template-parts/content', 'project');
        endwhile;
    else :
        echo '<p>Aucun projet trouvé.</p>';
    endif;

    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_search_projects', 'search_projects');
add_action('wp_ajax_nopriv_search_projects', 'search_projects');

// Configuration ACF
if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key' => 'group_project_details',
        'title' => 'Détails du projet',
        'fields' => array(
            array(
                'key' => 'field_project_image_1',
                'label' => 'Image 1 du projet',
                'name' => 'project_image_1',
                'type' => 'image',
                'instructions' => 'Choisissez la première image du projet',
                'required' => 0,
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_project_image_2',
                'label' => 'Image 2 du projet',
                'name' => 'project_image_2',
                'type' => 'image',
                'instructions' => 'Choisissez la deuxième image du projet',
                'required' => 0,
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_project_image_3',
                'label' => 'Image 3 du projet',
                'name' => 'project_image_3',
                'type' => 'image',
                'instructions' => 'Choisissez la troisième image du projet',
                'required' => 0,
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_project_image_4',
                'label' => 'Image 4 du projet',
                'name' => 'project_image_4',
                'type' => 'image',
                'instructions' => 'Choisissez la quatrième image du projet',
                'required' => 0,
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_project_image_5',
                'label' => 'Image 5 du projet',
                'name' => 'project_image_5',
                'type' => 'image',
                'instructions' => 'Choisissez la cinquième image du projet',
                'required' => 0,
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_project_featured_image',
                'label' => 'Image mise en avant',
                'name' => 'project_featured_image',
                'type' => 'image',
                'instructions' => 'Choisissez l\'image principale du projet',
                'required' => 0,
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_project_description',
                'label' => 'Description du projet',
                'name' => 'project_description',
                'type' => 'wysiwyg',
                'instructions' => 'Entrez la description détaillée du projet',
                'required' => 0,
            ),
            array(
                'key' => 'field_project_file',
                'label' => 'Fiche du projet',
                'name' => 'project_file',
                'type' => 'file',
                'instructions' => 'Téléchargez la fiche du projet (PDF recommandé)',
                'required' => 0,
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_project_location',
                'label' => 'Localisation',
                'name' => 'project_location',
                'type' => 'text',
                'instructions' => 'Entrez la localisation du projet',
                'required' => 0,
            ),
            array(
                'key' => 'field_project_client',
                'label' => 'Client',
                'name' => 'project_client',
                'type' => 'text',
                'instructions' => 'Entrez le nom du client',
                'required' => 0,
            ),
            array(
                'key' => 'field_project_year',
                'label' => 'Année',
                'name' => 'project_year',
                'type' => 'number',
                'instructions' => 'Entrez l\'année du projet',
                'required' => 0,
            ),
            array(
                'key' => 'field_project_surface',
                'label' => 'Surface',
                'name' => 'project_surface',
                'type' => 'text',
                'instructions' => 'Entrez la surface du projet (ex: 5000 m²)',
                'required' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'project',
                ),
            ),
        ),
    ));
}

function filter_projects($query) {
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('project')) {

        // Filtrer par thème
        if (!empty($_GET['theme'])) {
            $query->set('tax_query', array(
                array(
                    'taxonomy' => 'project_theme',
                    'field'    => 'slug',
                    'terms'    => sanitize_text_field($_GET['theme']),
                ),
            ));
        }

        // Filtrer par année
        if (!empty($_GET['year'])) {
            $query->set('meta_query', array(
                array(
                    'key' => 'project_year',
                    'value' => sanitize_text_field($_GET['year']),
                    'compare' => '='
                )
            ));
        }
    }
}
add_action('pre_get_posts', 'filter_projects');
