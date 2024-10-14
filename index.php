<?php get_header(); ?>


<section class="projects-section container">
    <h2>Nos Projets</h2>
    <div class="grid-container">
        <?php
        $args = array('post_type' => 'projet', 'posts_per_page' => 6);
        $projects = new WP_Query($args);
        if ($projects->have_posts()) :
            while ($projects->have_posts()) : $projects->the_post(); ?>
                <div class="grid-item">
                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                    <h3><?php the_title(); ?></h3>
                </div>
            <?php endwhile;
        else :
            echo '<p>Aucun projet trouvé.</p>';
        endif;
        wp_reset_postdata();
        ?>
    </div>
</section>

<?php get_footer(); ?>
