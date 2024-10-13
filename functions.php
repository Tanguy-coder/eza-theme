<?php
// Activer le Customizer pour le slider et les sections de contenu
function mon_theme_customizer_register($wp_customize) {

    // Section pour le Slider
    $wp_customize->add_section('slider_section', array(
        'title'    => __('Slider Settings', 'mon_theme'),
        'description' => __('Change the images of the homepage slider.', 'mon_theme'),
        'priority' => 30,
    ));

    // Champs pour les images du Slider
    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting("slider_image_$i", array(
            'default'   => '',
            'transport' => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "slider_image_$i", array(
            'label'    => __("Image $i", 'mon_theme'),
            'section'  => 'slider_section',
            'settings' => "slider_image_$i",
        )));
    }

    // Section pour le contenu de la page d'accueil
    $wp_customize->add_section('home_content_section', array(
        'title'    => __('Home Page Content', 'mon_theme'),
        'priority' => 35,
    ));

    // Champ pour le texte de bienvenue
    $wp_customize->add_setting('home_welcome_text', array(
        'default'   => 'Bienvenue sur notre site.',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('home_welcome_text_control', array(
        'label'    => __('Welcome Text', 'mon_theme'),
        'section'  => 'home_content_section',
        'settings' => 'home_welcome_text',
        'type'     => 'textarea',
    ));
}
add_action('customize_register', 'mon_theme_customizer_register');

// Activer la fonctionnalité des menus
function mon_theme_register_menus() {
    register_nav_menus(array(
        'primary-menu' => __('Primary Menu', 'mon_theme'),
    ));
}
add_action('init', 'mon_theme_register_menus');


// Charger les fichiers CSS et JS du thème
function mon_theme_enqueue_styles() {
    wp_enqueue_style('main-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('swiper-style', 'https://unpkg.com/swiper/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', array(), null, true);
    wp_enqueue_script('custom-swiper', get_template_directory_uri() . '/assets/js/custom-swiper.js', array('swiper-js'), null, true);
}
add_action('wp_enqueue_scripts', 'mon_theme_enqueue_styles');
?>
