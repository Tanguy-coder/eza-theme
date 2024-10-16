<?php
// Sécurité : Désactiver l'éditeur de fichiers WordPress
define('DISALLOW_FILE_EDIT', true);

// Inclure les fichiers nécessaires
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/security.php';

// Activer la fonctionnalité des menus
function eza_register_menus() {
    register_nav_menus(array(
        'primary-menu' => __('Menu Principal', 'eza_architecture'),
        'footer-menu' => __('Menu Pied de Page', 'eza_architecture')
    ));
}
add_action('init', 'eza_register_menus');

// Ajouter la prise en charge des fonctionnalités de thème
function eza_theme_support() {
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
add_action('after_setup_theme', 'eza_theme_support');

// Charger les fichiers CSS et JS du thème
function eza_enqueue_scripts() {
    wp_enqueue_style('eza-style', get_stylesheet_uri(), array(), filemtime(get_stylesheet_directory() . '/style.css'));
    wp_enqueue_style('eza-animate', get_template_directory_uri() . '/assets/css/animate.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/animate.css'));
    wp_enqueue_script('eza-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/script.js'), true);
}
add_action('wp_enqueue_scripts', 'eza_enqueue_scripts');

// Fonction pour obtenir l'URL des icônes
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

if ( ! function_exists( 'eza_post_thumbnail' ) ) {
    function eza_post_thumbnail() {
        if ( has_post_thumbnail() ) {
            the_post_thumbnail();
        }
    }
}

function eza_customize_register($wp_customize) {
    // Ajouter une section dédiée pour les images de bannière
    $wp_customize->add_section('hero_images_section', array(
        'title' => __('Images de Bannière', 'eza'),
        'priority' => 30,
    ));

    // Ajouter les contrôles pour les 5 images de bannière
    for ($i = 1; $i <= 100; $i++) {
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

add_action('customize_register', 'eza_customize_register');


