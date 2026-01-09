<?php get_header(); ?>

    <main id="main-content" class="site-main">
        <?php
        while (have_posts()) :
            the_post();
            get_template_part('template-parts/content', 'single');

            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
        endwhile;
        ?>
    </main>

<?php get_footer(); ?>