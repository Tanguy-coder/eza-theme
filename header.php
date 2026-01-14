<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts - Roboto + Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://www.youtube.com/iframe_api"></script>
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="header <?php echo is_front_page() || is_singular('project') ? 'header-home' : 'header-inner'; ?>">
<div class="animation"></div>

    <nav class="navbar <?php echo is_front_page() || is_singular('project') ? 'navbar-home' : 'navbar-inner'; ?>">
        <div class="nav-links" style="font-weight: bold">
            <div class="logo">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a>';
                }
                ?>
            </div>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary-menu',
                'container'      => false,
                'menu_class'     => 'links',
            ));
            ?>
        </div>
        <div class="menu">
            <img src="<?php echo eza_get_icon_url('menu.svg'); ?>" alt="Menu">
        </div>
    </nav>
</header>



<div class="nav-mobile">
    <span class="close-menu">
        <img src="<?php echo eza_get_icon_url('x.svg'); ?>" alt="Fermer" width="30" height="30">
    </span>
    <div class="mobile_links">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary-menu',
            'container'      => false,
            'menu_class'     => 'mobile-links',
        ));
        ?>
        <div class="social-links-mobile-footer">
            <a href="<?php echo esc_url(get_theme_mod('linkedin_url')); ?>"><img src="<?php echo eza_get_icon_url('linkedin.svg'); ?>" alt="LinkedIn" width="24" height="24"></a>
            <a href="<?php echo esc_url(get_theme_mod('facebook_url')); ?>"><img src="<?php echo eza_get_icon_url('facebook.svg'); ?>" alt="Facebook" width="24" height="24"></a>
            <a href="<?php echo esc_url(get_theme_mod('instagram_url')); ?>"><img src="<?php echo eza_get_icon_url('instagram.svg'); ?>" alt="Instagram" width="24" height="24"></a>
            <a href="<?php echo esc_url(get_theme_mod('twitter_url')); ?>"><img src="<?php echo eza_get_icon_url('twitter.svg'); ?>" alt="X" width="24" height="24"></a>
            <a href="mailto:<?php echo esc_attr(get_theme_mod('email_address')); ?>"><img src="<?php echo eza_get_icon_url('mail.svg'); ?>" alt="Email" width="24" height="24"></a>
            <a href="<?php echo esc_url(get_theme_mod('video_url')); ?>"><img src="<?php echo eza_get_icon_url('video.svg'); ?>" alt="Video" width="24" height="24"></a>
        </div>
    </div>
</div>