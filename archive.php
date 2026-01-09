<?php get_header(); ?>

<div class="container">
    <h1><?php the_archive_title(); ?></h1>
    <div class="grid-container">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post(); ?>
                <div class="grid-item">
                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                    <h3><?php the_title(); ?></h3>
                </div>
            <?php endwhile;
        else :
            echo '<p>Aucune archive trouvée.</p>';
        endif;
        ?>
    </div>
</div>

<?php get_footer(); ?>
