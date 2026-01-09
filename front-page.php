<?php get_header(); ?>

<?php
// Récupérer les 5 images de bannière définies dans le Customizer
$hero_images = array(
    get_theme_mod('hero_background_image_1'),
    get_theme_mod('hero_background_image_2'),
    get_theme_mod('hero_background_image_3'),
    get_theme_mod('hero_background_image_4'),
    get_theme_mod('hero_background_image_5'),
);

// Filtrer les images vides
$hero_images = array_filter($hero_images);

// Sélectionner une image aléatoire parmi les images disponibles
$random_hero_image = '';
if (!empty($hero_images)) {
    $random_hero_image = $hero_images[array_rand($hero_images)];
}
?>

<section class="hero" style="background-image: url('<?php echo esc_url($random_hero_image); ?>'); background-position: center; background-repeat: no-repeat; background-size: cover; overflow: hidden;">
    <div class="social-links">
        <a href="<?php echo esc_url(get_theme_mod('linkedin_url')); ?>"><img src="<?php echo eza_get_icon_url('linkedin.svg'); ?>" alt="LinkedIn"></a>
        <a href="<?php echo esc_url(get_theme_mod('facebook_url')); ?>"><img src="<?php echo eza_get_icon_url('facebook.svg'); ?>" alt="Facebook"></a>
        <a href="<?php echo esc_url(get_theme_mod('instagram_url')); ?>"><img src="<?php echo eza_get_icon_url('instagram.svg'); ?>" alt="Instagram"></a>
        <a href="<?php echo esc_url(get_theme_mod('twitter_url')); ?>"><img src="<?php echo eza_get_icon_url('twitter.svg'); ?>" alt="X"></a>
        <a href="mailto:<?php echo esc_attr(get_theme_mod('email_address')); ?>"><img src="<?php echo eza_get_icon_url('mail.svg'); ?>" alt="Email"></a>
        <a href="<?php echo esc_url(get_theme_mod('video_url')); ?>"><img src="<?php echo eza_get_icon_url('video.svg'); ?>" alt="Video"></a>
    </div>
</section>

<section class="partners">
    <h2>Nos Partenaires</h2>
    <div class="partners-logos">
        <?php
        for ($i = 1; $i <= 10; $i++) {  // Ajuster pour 10 logos
            $logo = get_theme_mod("partner_logo_$i");
            $link = get_theme_mod("partner_link_$i");
            if ($logo) {
                echo '<a href="' . esc_url($link) . '" target="_blank">';
                echo '<img src="' . esc_url($logo) . '" alt="Partenaire ' . $i . '">';
                echo '</a>';
            }
        }
        ?>
    </div>
</section>



<?php
// Ajoutez ici le contenu supplémentaire de votre page d'accueil
?>

<?php get_footer(); ?>
