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

function enqueue_custom_styles() {
    wp_enqueue_style(
        'custom-style',
        get_stylesheet_directory_uri() . '/style.css',
        array(),
        filemtime(get_stylesheet_directory() . '/style.css') // Génère une version unique basée sur l'heure de modification
    );
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');

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
    wp_enqueue_style('page-agence', get_template_directory_uri() . '/css/page-agence.css');
    wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', array(), null, true);

    if (is_page_template('page-agence.php')) {
        // Charger Swiper.js et son CSS


        // Charger le CSS de la page agence
    }

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

function eza_customize_register($wp_customize)
{
    // Ajouter une section dédiée pour les images de bannière
    $wp_customize->add_section('hero_images_section', array(
        'title' => __('Images de Bannière', 'eza'),
        'priority' => 30,
    ));

    // Ajouter les contrôles pour les 5 images de bannière
    for ($i = 1; $i <= 100; $i++) {
        for ($i = 1; $i <= 5; $i++) {
            $wp_customize->add_setting("hero_background_image_$i", array(
                'default' => '',
                'sanitize_callback' => 'esc_url_raw',
            ));

            $wp_customize->add_control(new WP_Customize_Image_Control(
                $wp_customize,
                "hero_background_image_$i",
                array(
                    'label' => __("Image de bannière $i", 'eza'),
                    'section' => 'hero_images_section',
                    'settings' => "hero_background_image_$i"
                )
            ));
        }

        // Ajouter une section pour les logos des partenaires
        $wp_customize->add_section('partners_section', array(
            'title' => __('Partenaires', 'eza'),
            'description' => __('Ajouter les logos et liens des partenaires', 'eza'),
            'priority' => 30,
        ));

        // Ajout des logos et des liens pour 5 partenaires
        for ($i = 1; $i <= 100; $i++) {
            // Logo du partenaire
            $wp_customize->add_setting("partner_logo_$i", array(
                'default' => '',
                'sanitize_callback' => 'esc_url_raw',
            ));

            $wp_customize->add_control(new WP_Customize_Image_Control(
                $wp_customize,
                "partner_logo_$i",
                array(
                    'label' => __("Logo du partenaire $i", 'eza'),
                    'section' => 'partners_section',
                    'settings' => "partner_logo_$i",
                )
            ));

            // Lien du partenaire
            $wp_customize->add_setting("partner_link_$i", array(
                'default' => '',
                'sanitize_callback' => 'esc_url_raw',
            ));

            $wp_customize->add_control("partner_link_$i", array(
                'label' => __("Lien du partenaire $i", 'eza'),
                'section' => 'partners_section',
                'type' => 'url',
            ));
        }
    }
}

add_action('customize_register', 'eza_customize_register');

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
            array(
                'key' => 'field_project_location_lat',
                'label' => 'Latitude',
                'name' => 'project_location_lat',
                'type' => 'text',
                'instructions' => 'Entrez la latitude du projet',
                'required' => 0,
            ),
            array(
                'key' => 'field_project_location_lng',
                'label' => 'Longitude',
                'name' => 'project_location_lng',
                'type' => 'text',
                'instructions' => 'Entrez la longitude du projet',
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

function filter_projects_ajax() {
    $theme = isset($_POST['theme']) ? sanitize_text_field($_POST['theme']) : '';
    $search_term = isset($_POST['search_term']) ? sanitize_text_field($_POST['search_term']) : '';

    $args = [
        'post_type' => 'project',
        'posts_per_page' => -1,
    ];

    if ($theme) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'project_theme',
                'field'    => 'slug',
                'terms'    => $theme,
            ]
        ];
    }

    if ($search_term) {
        $args['s'] = $search_term;
    }

    $projects = new WP_Query($args);

    if ($projects->have_posts()) {
        while ($projects->have_posts()) : $projects->the_post();
            ?>
            <div class="project-item">
                <a href="<?php the_permalink(); ?>" class="project-link">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium'); ?>
                    <?php endif; ?>
                    <h3><?php the_title(); ?></h3>
                </a>
            </div>
        <?php
        endwhile;
        wp_reset_postdata();
    } else {
        echo '<p>Aucun projet trouvé.</p>';
    }

    wp_die();
}



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

// Ajouter les champs ACF pour le personnel

// Vérifie si la fonction ACF est disponible avant d'ajouter des champs.
if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key' => 'group_personnel_details', // Clé unique pour le groupe de champs.
        'title' => 'Détails du Personnel', // Titre affiché pour le groupe.
        'fields' => array(
            // Champ : Mention
            array(
                'key' => 'field_personnel_mention', // Clé unique pour le champ.
                'label' => 'Mention', // Étiquette affichée dans l'interface.
                'name' => 'personnel_mention', // Nom interne du champ.
                'type' => 'text', // Type de champ : texte simple.
                'instructions' => 'Entrez la mention.', // Instructions pour l'utilisateur.
                'required' => 0, // Champ non obligatoire.
            ),
            // Champ : Fonction
            array(
                'key' => 'field_personnel_function', // Clé unique pour le champ.
                'label' => 'Fonction', // Étiquette affichée dans l'interface.
                'name' => 'personnel_function', // Nom interne du champ.
                'type' => 'text', // Type de champ : texte simple.
                'instructions' => 'Entrez le poste de la personne.', // Instructions pour l'utilisateur.
                'required' => 0, // Champ obligatoire.
            ),
            // Champ : Description
            array(
                'key' => 'field_personnel_description', // Clé unique pour le champ.
                'label' => 'Description', // Étiquette affichée dans l'interface.
                'name' => 'personnel_description', // Nom interne du champ.
                'type' => 'wysiwyg', // Type de champ : éditeur WYSIWYG.
                'instructions' => 'Entrez une brève description de la personne.', // Instructions pour l'utilisateur.
                'required' => 0, // Champ obligatoire.
                'tabs' => 'all', // Permet d'activer tous les onglets (Visuel/Texte).
                'toolbar' => 'full', // Barre d'outils complète pour l'éditeur.
                'media_upload' => 0, // Désactive le bouton d'ajout de médias.
            ),
        ),
        // Localisation du groupe de champs.
        'location' => array(
            array(
                array(
                    'param' => 'post_type', // Appliquer à un type de contenu.
                    'operator' => '==', // Condition d'égalité.
                    'value' => 'personnel', // Type de contenu ciblé : "personnel".
                ),
            ),
        ),
        'menu_order' => 0, // Ordre d'affichage (0 = premier).
        'position' => 'normal', // Position dans l'interface (normal, side, etc.).
        'style' => 'default', // Style de présentation (default, seamless).
        'label_placement' => 'top', // Placement des étiquettes (top, left).
        'instruction_placement' => 'label', // Position des instructions (label, field).
        'active' => true, // Groupe actif.
        'description' => '', // Description optionnelle du groupe.
    ));
}


if (function_exists('acf_add_local_field_group')) {
    // Récupération de l'ID de la page "Agence" en fonction de son slug.
    $page_agence = get_page_by_path('agence'); // Remplacez 'agence' par le slug exact de votre page
    $page_agence_id = $page_agence ? $page_agence->ID : null;

    if ($page_agence_id) {
        acf_add_local_field_group(array(
            'key' => 'group_agency_images',
            'title' => 'Images de l’agence',
            'fields' => array(
                array(
                    'key' => 'field_agency_image_1',
                    'label' => 'Image 1',
                    'name' => 'agency_image_1',
                    'type' => 'image',
                    'return_format' => 'array',
                ),
                array(
                    'key' => 'field_agency_image_2',
                    'label' => 'Image 2',
                    'name' => 'agency_image_2',
                    'type' => 'image',
                    'return_format' => 'array',
                ),
                array(
                    'key' => 'field_agency_image_3',
                    'label' => 'Image 3',
                    'name' => 'agency_image_3',
                    'type' => 'image',
                    'return_format' => 'array',
                ),
                array(
                    'key' => 'field_agency_image_4',
                    'label' => 'Image 4',
                    'name' => 'agency_image_4',
                    'type' => 'image',
                    'return_format' => 'array',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page',
                        'operator' => '==',
                        'value' => $page_agence_id,
                    ),
                ),
            ),
        ));
    }
}





