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

        <div class="main_part">
            <aside class="project-sidebar">
                <div class="sidebar-content">
                    <!-- Sidebar fields (Location, Client, Year, etc.) -->
                    <div class="projects_infos">
                        <?php if (get_field('project_location')) : ?>
                            <div class="sidebar-item">
                                <span>Localisation</span> :
                                <span><b><?php the_field('project_location'); ?></b></span>
                            </div>
                        <?php endif; ?>
                        <?php if (get_field('project_client')) : ?>
                            <div class="sidebar-item">
                                <span>Client</span> :
                                <span> <b><?php the_field('project_client'); ?></b></span>
                            </div>
                        <?php endif; ?>
                        <?php if (get_field('project_year')) : ?>
                            <div class="sidebar-item">
                                <span>Année</span> :
                                <span> <b><?php the_field('project_year'); ?></b></span>
                            </div>
                        <?php endif; ?>
                        <?php if (get_field('project_surface')) : ?>
                            <div class="sidebar-item">
                                <span>Surface</span> :
                                <span> <b><?php the_field('project_surface'); ?> m²</b></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php
                    $themes = get_the_terms(get_the_ID(), 'project_theme');
                    if ($themes && !is_wp_error($themes)) : ?>
                        <div class="theme">
                            <div class="sidebar-item">
                                <h3>Thèmes</h3>
                                <ul class="theme-list">
                                    <?php foreach ($themes as $theme) : ?>
                                        <li><?php echo esc_html($theme->name); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                    <span class="separator"></span>
                    <?php
                    $file = get_field('project_file');
                    if ($file) : ?>
                        <div class="sidebar-item">
                            <div class="download_link">
                                <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-download"
                                >
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                    <path d="M7 11l5 5l5 -5" />
                                    <path d="M12 4l0 12" />
                                </svg>
                                <a href="<?php echo esc_url($file['url']); ?>" class="download-button" target="_blank">
                                    Télécharger la fiche projet
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </aside>
            <div class="project-main">
                <div class="project-description">
                 <p style="text-align: center; margin: 0 100px;"><?php the_field('project_description'); ?></p>
                </div>
            </div>

            
        </div>
    </div>

    <!-- Related Projects Section -->
    <section class="related-projects">
        <div class="container">
            <h2 class="similar_project_title">Projets similaires</h2>
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
                                <h3 class="project_title"><?php echo get_the_title($project->ID); ?></h3>
                            </a>
                        </article>
                    <?php endforeach;
                endif; ?>
            </div>
        </div>
    </section>

</article>

<?php get_footer(); ?>
