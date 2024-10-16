<?php
function eza_customizer_register($wp_customize) {
    // Section pour l'image de fond du héros
    $wp_customize->add_section('eza_hero_section', array(
        'title'    => __('Paramètres du Héros', 'eza_architecture'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('hero_background_image', array(
        'default'   => '',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image', array(
        'label'    => __('Image de fond du héros', 'eza_architecture'),
        'section'  => 'eza_hero_section',
        'settings' => 'hero_background_image',
    )));

    // Section pour les liens sociaux
    $wp_customize->add_section('eza_social_links', array(
        'title'    => __('Liens Sociaux', 'eza_architecture'),
        'priority' => 35,
    ));

    $social_links = array(
        'linkedin_url'  => 'LinkedIn URL',
        'facebook_url'  => 'Facebook URL',
        'instagram_url' => 'Instagram URL',
        'twitter_url'   => 'Twitter URL',
        'email_address' => 'Adresse Email',
        'video_url'     => 'URL Vidéo',
    );

    foreach ($social_links as $setting => $label) {
        $wp_customize->add_setting($setting, array(
            'default'   => '',
            'transport' => 'refresh',
        ));

        $wp_customize->add_control($setting, array(
            'label'    => __($label, 'eza_architecture'),
            'section'  => 'eza_social_links',
            'type'     => 'text',
        ));
    }
}
add_action('customize_register', 'eza_customizer_register');