<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <!--<header class="entry-header">
        <?php /*the_title('<h1 class="entry-title">', '</h1>'); */?>
    </header>-->

    <?php eza_post_thumbnail(); ?>

    <div class="entry-content" style="margin-right: 2rem">
        <?php
        the_content();

        wp_link_pages(
            array(
                'before' => '<div class="page-links">' . __('Pages:', 'eza_architecture'),
                'after'  => '</div>',
            )
        );
        ?>
    </div>

    <section class="hero" style="background-image: url('<?php echo esc_url($random_hero_image); ?>'); background-position: center; background-repeat: no-repeat; background-size: cover; overflow: hidden;">
        <div class="social-links-inner">
            <a href="<?php echo esc_url(get_theme_mod('linkedin_url')); ?>"><img src="<?php echo eza_get_icon_url('linkedin.svg'); ?>" alt="LinkedIn"></a>
            <a href="<?php echo esc_url(get_theme_mod('facebook_url')); ?>"><img src="<?php echo eza_get_icon_url('facebook.svg'); ?>" alt="Facebook"></a>
            <a href="<?php echo esc_url(get_theme_mod('instagram_url')); ?>"><img src="<?php echo eza_get_icon_url('instagram.svg'); ?>" alt="Instagram"></a>
            <a href="<?php echo esc_url(get_theme_mod('twitter_url')); ?>"><img src="<?php echo eza_get_icon_url('twitter.svg'); ?>" alt="X"></a>
            <a href="mailto:<?php echo esc_attr(get_theme_mod('email_address')); ?>"><img src="<?php echo eza_get_icon_url('mail.svg'); ?>" alt="Email"></a>
            <a href="<?php echo esc_url(get_theme_mod('video_url')); ?>"><img src="<?php echo eza_get_icon_url('video.svg'); ?>" alt="Video"></a>
        </div>
    </section>

    <?php if (get_edit_post_link()) : ?>
        <footer class="entry-footer">
            <?php
            edit_post_link(
                sprintf(
                    wp_kses(
                        __('Edit <span class="screen-reader-text">%s</span>', 'eza_architecture'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post(get_the_title())
                ),
                '<span class="edit-link">',
                '</span>'
            );
            ?>
        </footer>
    <?php endif; ?>
</article>