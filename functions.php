<?php
/**
 * Theme functions and definitions
 *
 * @package eza_architecture
 */

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

/**
 * Sécurité et Robustesse : Fallbacks pour ACF (évite les erreurs fatales si le plugin est désactivé)
 */
add_action('after_setup_theme', function() {
    if (!function_exists('get_field')) {
        function get_field($selector, $post_id = false, $format_value = true) {
            return false;
        }
    }
    if (!function_exists('the_field')) {
        function the_field($selector, $post_id = false, $format_value = true) {
            $value = get_field($selector, $post_id, $format_value);
            if (is_array($value)) {
                print_r($value);
            } else {
                echo $value;
            }
        }
    }
}, 1);

/**
 * Inclure les fichiers de configuration et de logique
 */
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/security.php';
require_once get_template_directory() . '/inc/post-types.php';
require_once get_template_directory() . '/inc/acf-fields.php';
require_once get_template_directory() . '/inc/ajax-handlers.php';


/**
 * Configuration initiale du thème
 */
function eza_theme_setup() {
    register_nav_menus(array(
        'primary-menu' => __('Menu Principal', 'eza_architecture'),
        'footer-menu' => __('Menu Pied de Page', 'eza_architecture')
    ));

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

/**
 * Charger les fichiers CSS et JS du thème
 */
function eza_enqueue_scripts() {
    $theme_version = wp_get_theme()->get('Version');

    wp_enqueue_style('eza-style', get_stylesheet_uri(), array(), filemtime(get_stylesheet_directory() . '/style.css'));
    wp_enqueue_style('eza-animate', get_template_directory_uri() . '/assets/css/animate.css', array(), $theme_version);
    wp_enqueue_script('eza-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), $theme_version, true);
    wp_enqueue_script('eza-animations', get_template_directory_uri() . '/assets/js/animations.js', array(), $theme_version, true);
    wp_enqueue_style('archive-project-css', get_template_directory_uri() . '/css/archive-project.css', array(), filemtime(get_template_directory() . '/css/archive-project.css'));
    wp_enqueue_style('page-agence', get_template_directory_uri() . '/css/page-agence.css', array(), filemtime(get_template_directory() . '/css/page-agence.css'));
    wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', array(), null, true);

    if (is_front_page()) {
        wp_enqueue_script('hero-slider', get_template_directory_uri() . '/assets/js/hero-slider.js', array('swiper-js'), $theme_version, true);
    }

    if (is_post_type_archive('project')) {
        // Enqueue Leaflet
        wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');
        wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), null, true);

        // Enqueue Archive Logic
        wp_enqueue_script('project-archive', get_template_directory_uri() . '/assets/js/project-archive.js', array('leaflet-js'), $theme_version, true);

        // Prepare Marker Data
        $projects = get_posts(array('post_type' => 'project', 'posts_per_page' => -1));
        $markers = array();

        foreach ($projects as $project) {
            $lat = get_field('project_location_lat', $project->ID);
            $lng = get_field('project_location_lng', $project->ID);

            if ($lat && $lng) {
                $featured_image = has_post_thumbnail($project->ID) ? get_the_post_thumbnail_url($project->ID, 'medium') : '';
                $location = get_field('project_location', $project->ID) ?: '';
                $year = get_field('project_year', $project->ID) ?: '';
                $info = array_filter(array($location, $year));

                // Formatter le contenu popup (identique à l'original)
                $popupContent = "<div style='width: 200px; text-align: center;'>";
                if ($featured_image) {
                    $popupContent .= "<img src='" . esc_url($featured_image) . "' alt='" . esc_attr(get_the_title($project->ID)) . "' style='width: 100%; height: auto; border-radius: 5px; margin-bottom: 10px;'>";
                }
                $popupContent .= "<h3 style='margin: 10px 0 5px;'>" . esc_html(get_the_title($project->ID)) . "</h3>";
                if (!empty($info)) {
                    $popupContent .= "<p style='margin: 0;'>" . esc_html(implode(' - ', $info)) . "</p>";
                }
                $popupContent .= "<a href='" . esc_url(get_permalink($project->ID)) . "' style='color: blue; text-decoration: underline; display: inline-block; margin-top: 8px;'>Voir le projet</a>";
                $popupContent .= "</div>";

                $markers[] = array(
                    'lat' => $lat,
                    'lng' => $lng,
                    'popup' => $popupContent
                );
            }
        }

        wp_localize_script('project-archive', 'projectArchiveData', array(
            'markers' => $markers
        ));
    }

    if (is_singular('project')) {
        wp_enqueue_style('single-project-css', get_template_directory_uri() . '/css/single-project.css', array(), $theme_version);
        wp_enqueue_script('projects-js', get_template_directory_uri() . '/js/projects.js', array('jquery', 'swiper-js'), $theme_version, true);
        wp_localize_script('projects-js', 'projectsData', array(
            'ajaxurl' => admin_url('admin-ajax.php')
        ));
    }
}
add_action('wp_enqueue_scripts', 'eza_enqueue_scripts');

/**
 * Utilitaires
 */
function eza_get_icon_url($icon_name) {
    return esc_url(get_template_directory_uri() . '/assets/icons/' . $icon_name);
}

function add_additional_class_on_li($classes, $item, $args) {
    if (isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

if (!function_exists('eza_post_thumbnail')) {
    function eza_post_thumbnail() {
        if (has_post_thumbnail()) {
            the_post_thumbnail();
        }
    }
}
