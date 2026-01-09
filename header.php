<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Inconsolata" rel="stylesheet">
    <script src="https://www.youtube.com/iframe_api"></script>
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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
            <a href="#"><img src="<?php echo eza_get_icon_url('linkedin.svg'); ?>" alt="LinkedIn" width="24" height="24"></a>
            <a href="#"><img src="<?php echo eza_get_icon_url('facebook.svg'); ?>" alt="Facebook" width="24" height="24"></a>
            <a href="#"><img src="<?php echo eza_get_icon_url('instagram.svg'); ?>" alt="Instagram" width="24" height="24"></a>
            <a href="#"><img src="<?php echo eza_get_icon_url('twitter.svg'); ?>" alt="X" width="24" height="24"></a>
            <a href="#"><img src="<?php echo eza_get_icon_url('mail.svg'); ?>" alt="Email" width="24" height="24"></a>
            <a href="#"><img src="<?php echo eza_get_icon_url('video.svg'); ?>" alt="Video" width="24" height="24"></a>
        </div>
    </div>
</div>