<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header>
    <nav class="navbar <?php echo is_front_page() ? 'navbar-home' : 'navbar-inner'; ?>">
        <div class="nav-links">
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