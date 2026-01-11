<?php
function eza_customizer_register($wp_customize) {
    // Section pour les images de bannière (Héro)
    $wp_customize->add_section('hero_images_section', array(
        'title'    => __('Images de Bannière', 'eza_architecture'),
        'priority' => 30,
    ));

    // Ajouter les contrôles pour les 5 images de bannière
    for ($i = 1; $i <= 5; $i++) {
        $wp_customize->add_setting("hero_background_image_$i", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "hero_background_image_$i", array(
            'label'    => __("Image de bannière $i", 'eza_architecture'),
            'section'  => 'hero_images_section',
            'settings' => "hero_background_image_$i",
        )));
    }

    // Section pour les logos des partenaires
    $wp_customize->add_section('partners_section', array(
        'title'       => __('Partenaires', 'eza_architecture'),
        'description' => __('Ajouter les logos et liens des partenaires', 'eza_architecture'),
        'priority'    => 35,
    ));

    // Ajout des logos et des liens pour 10 partenaires
    for ($j = 1; $j <= 10; $j++) {
        // Logo du partenaire
        $wp_customize->add_setting("partner_logo_$j", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "partner_logo_$j", array(
            'label'    => __("Logo du partenaire $j", 'eza_architecture'),
            'section'  => 'partners_section',
            'settings' => "partner_logo_$j",
        )));

        // Lien du partenaire
        $wp_customize->add_setting("partner_link_$j", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control("partner_link_$j", array(
            'label'   => __("Lien du partenaire $j", 'eza_architecture'),
            'section' => 'partners_section',
            'type'    => 'url',
        ));
    }

    // Section pour les liens sociaux
    $wp_customize->add_section('eza_social_links', array(
        'title'    => __('Liens Sociaux', 'eza_architecture'),
        'priority' => 40,
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