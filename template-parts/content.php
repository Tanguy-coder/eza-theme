<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        if (is_singular()) :
            the_title('<h1 class="entry-title">', '</h1>');
        else :
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;

        if ('post' === get_post_type()) :
            ?>
            <div class="entry-meta">
                <?php
                eza_posted_on();
                eza_posted_by();
                ?>
            </div>
        <?php endif; ?>
    </header>

    <?php eza_post_thumbnail(); ?>

    <div class="entry-content">
        h1
        <?php
        the_content(
            sprintf(
                wp_kses(
                    __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'eza_architecture'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post(get_the_title())
            )
        );

        wp_link_pages(
            array(
                'before' => '<div class="page-links">' . __('Pages:', 'eza_architecture'),
                'after'  => '</div>',
            )
        );
        ?>
    </div>

    <footer class="entry-footer">
        <?php eza_entry_footer(); ?>
    </footer>
</article>