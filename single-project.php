<?php get_header(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('project-single'); ?>>

    <!-- Slider Section -->
    <div class="swiper-container project-slider">
        <div class="swiper-wrapper">
            <?php
            $images = array();
            for ($i = 1; $i <= 5; $i++) {
                $image = get_field("project_image_{$i}");
                if ($image) {
                    $images[] = $image;
                }
            }
            if (!empty($images)) :
                foreach ($images as $image) : ?>
                    <div class="swiper-slide">
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                    </div>
                <?php endforeach;
            endif;
            ?>
        </div>
        <!-- Pagination and Navigation -->
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>

    <!-- Project Content starts after the slider -->
    <div class="project-content">
        <h1 class="project-title"><?php the_title(); ?></h1>

        <div class="project-main">
            <div class="project-description">
                <?php the_field('project_description'); ?>
            </div>
        </div>

        <aside class="project-sidebar">
            <div class="sidebar-content">
                <!-- Sidebar fields (Location, Client, Year, etc.) -->
                <?php if (get_field('project_location')) : ?>
                    <div class="sidebar-item">
                        <h3>Localisation</h3>
                        <p><?php the_field('project_location'); ?></p>
                    </div>
                <?php endif; ?>
                <?php if (get_field('project_client')) : ?>
                    <div class="sidebar-item">
                        <h3>Client</h3>
                        <p><?php the_field('project_client'); ?></p>
                    </div>
                <?php endif; ?>
                <?php if (get_field('project_year')) : ?>
                    <div class="sidebar-item">
                        <h3>Année</h3>
                        <p><?php the_field('project_year'); ?></p>
                    </div>
                <?php endif; ?>
                <?php if (get_field('project_surface')) : ?>
                    <div class="sidebar-item">
                        <h3>Surface</h3>
                        <p><?php the_field('project_surface'); ?></p>
                    </div>
                <?php endif; ?>
                <?php
                $themes = get_the_terms(get_the_ID(), 'project_theme');
                if ($themes && !is_wp_error($themes)) : ?>
                    <div class="sidebar-item">
                        <h3>Thèmes</h3>
                        <ul class="theme-list">
                            <?php foreach ($themes as $theme) : ?>
                                <li><?php echo esc_html($theme->name); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php
                $file = get_field('project_file');
                if ($file) : ?>
                    <div class="sidebar-item">
                        <a href="<?php echo esc_url($file['url']); ?>" class="download-button" target="_blank">
                            Télécharger la fiche projet
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </aside>
    </div>

    <!-- Related Projects Section -->
    <section class="related-projects">
        <div class="container">
            <h2>Projets similaires</h2>
            <div class="projects-grid">
                <!-- Loop through related projects -->
                <?php
                $related_projects = get_posts(array(
                    'post_type' => 'project',
                    'posts_per_page' => 3,
                    'post__not_in' => array(get_the_ID()),
                    'orderby' => 'rand'
                ));
                if ($related_projects) :
                    foreach ($related_projects as $project) : ?>
                        <article class="project-item">
                            <a href="<?php echo get_permalink($project->ID); ?>">
                                <?php
                                $featured_image = get_field('project_featured_image', $project->ID);
                                if ($featured_image) :
                                    echo wp_get_attachment_image($featured_image['id'], 'large', false, array('class' => 'project-thumbnail'));
                                elseif (has_post_thumbnail($project->ID)) :
                                    echo get_the_post_thumbnail($project->ID, 'large', array('class' => 'project-thumbnail'));
                                endif;
                                ?>
                                <h3><?php echo get_the_title($project->ID); ?></h3>
                            </a>
                        </article>
                    <?php endforeach;
                endif; ?>
            </div>
        </div>
    </section>

</article>

<?php get_footer(); ?>
