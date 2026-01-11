<?php
get_header();
?>

<section >
    <div class="social-links-inner">
        <a href="<?php echo esc_url(get_theme_mod('linkedin_url')); ?>"><img src="<?php echo eza_get_icon_url('linkedin.svg'); ?>" alt="LinkedIn"></a>
        <a href="<?php echo esc_url(get_theme_mod('facebook_url')); ?>"><img src="<?php echo eza_get_icon_url('facebook.svg'); ?>" alt="Facebook"></a>
        <a href="<?php echo esc_url(get_theme_mod('instagram_url')); ?>"><img src="<?php echo eza_get_icon_url('instagram.svg'); ?>" alt="Instagram"></a>
        <a href="<?php echo esc_url(get_theme_mod('twitter_url')); ?>"><img src="<?php echo eza_get_icon_url('twitter.svg'); ?>" alt="X"></a>
        <a href="mailto:<?php echo esc_attr(get_theme_mod('email_address')); ?>"><img src="<?php echo eza_get_icon_url('mail.svg'); ?>" alt="Email"></a>
        <a href="<?php echo esc_url(get_theme_mod('video_url')); ?>"><img src="<?php echo eza_get_icon_url('video.svg'); ?>" alt="Video"></a>
    </div>
</section>

<div class="project-archive-container">
    <div class="project-archive-header">
        <div class="forms">
            <!-- Barre de recherche -->
            <div class="search-bar">
                <form action="<?php echo esc_url(home_url('/')); ?>" method="get" id="search-form">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"/>
                        <path d="M21 21l-6 -6"/>
                    </svg>
                    <input type="text" name="s" id="search-input" placeholder="Rechercher un projet..." value="<?php echo get_query_var('s'); ?>"/>
                    <input type="hidden" name="post_type" value="project"/>
                </form>
            </div>

            <!-- Filtres -->
            <div class="filters">
                <div class="filter-theme-wrapper">
                    <button class="filter-theme-button" id="theme-button">
                        <span class="current-theme">Tous les thèmes</span>
                        <svg class="arrow-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path d="M7 10l5 5 5-5z"/>
                        </svg>
                    </button>
                    <div class="theme-dropdown" id="theme-dropdown">
                        <form action="<?php echo esc_url(home_url('/')); ?>" method="get" id="filters-form">
                            <input type="hidden" name="post_type" value="project"/>
                            <?php
                            $themes = get_terms(array('taxonomy' => 'project_theme', 'hide_empty' => false));
                            $current_theme = isset($_GET['theme']) ? get_term_by('slug', $_GET['theme'], 'project_theme') : null;
                            
                            echo '<div class="theme-option' . (!$current_theme ? ' active' : '') . '" data-value="">Tous les thèmes</div>';
                            
                            if (!empty($themes)) {
                                foreach ($themes as $theme) {
                                    $active_class = ($current_theme && $current_theme->slug === $theme->slug) ? ' active' : '';
                                    echo '<div class="theme-option' . $active_class . '" data-value="' . esc_attr($theme->slug) . '">' . esc_html($theme->name) . '</div>';
                                }
                            }
                            ?>
                            <input type="hidden" name="theme" id="theme-input" value="<?php echo isset($_GET['theme']) ? esc_attr($_GET['theme']) : ''; ?>"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vue mosaïque ou carte -->
        <div class="view-switcher">
            <label for="view-grid">
                Mosaïque
                <input type="radio" id="view-grid" name="vue" checked />
            </label>
            <label for="view-map">
                Vue sur carte
                <input type="radio" id="view-map" name="vue" />
            </label>
        </div>
    </div>

    <div class="contenue">
        <!-- Conteneur des projets en mosaïque -->
        <div id="project-grid" class="project-grid view-active">
            <?php
            // Récupérer les paramètres de recherche et de filtre
            $search_term = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
            $theme_filter = isset($_GET['theme']) ? sanitize_text_field($_GET['theme']) : '';

            // Définir les arguments de la requête WP
            $args = array(
                'post_type' => 'project',
                'posts_per_page' => -1,
                's' => $search_term,
            );

            if ($theme_filter) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'project_theme',
                        'field'    => 'slug',
                        'terms'    => $theme_filter,
                    ),
                );
            }

            $projects = new WP_Query($args);

            if ($projects->have_posts()) :
                while ($projects->have_posts()) : $projects->the_post();
                    ?>
                    <div class="project-item">
                        <a href="<?php the_permalink(); ?>" class="project-link">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium'); ?>
                            <?php endif; ?>
                            <h3 style="text-align: center;"><?php the_title(); ?></h3>
                        </a>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>Aucun projet trouvé.</p>';
            endif;
            ?>
        </div>

        <!-- Conteneur pour la vue carte -->
        <div id="project-map" class="project-map view-hidden"></div>
    </div>

</div>



<?php
get_footer();
?>
