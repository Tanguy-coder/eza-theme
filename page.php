<?php get_header(); ?>

    <main id="main-content" class="site-main">
        <div class="content-wrapper">
            <!-- Contenu de la page -->
            <?php
            while (have_posts()) :
                the_post();
                get_template_part('template-parts/content', 'page');
            endwhile;
            ?>
        </div>

    </main>

<?php get_footer(); ?>