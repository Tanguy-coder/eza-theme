<?php
/**
 * AJAX Handlers for ezaarchitectures
 */

// Filtrer les projets (AJAX)
add_action('wp_ajax_filter_projects', 'filter_projects_ajax');
add_action('wp_ajax_nopriv_filter_projects', 'filter_projects_ajax');

function filter_projects_ajax() {
    $theme = isset($_POST['theme']) ? sanitize_text_field($_POST['theme']) : '';
    $search_term = isset($_POST['search_term']) ? sanitize_text_field($_POST['search_term']) : '';

    $args = [
        'post_type' => 'project',
        'posts_per_page' => -1,
    ];

    if ($theme) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'project_theme',
                'field'    => 'slug',
                'terms'    => $theme,
            ]
        ];
    }

    if ($search_term) {
        $args['s'] = $search_term;
    }

    $projects = new WP_Query($args);

    if ($projects->have_posts()) {
        while ($projects->have_posts()) : $projects->the_post();
            ?>
            <div class="project-item">
                <a href="<?php the_permalink(); ?>" class="project-link">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium'); ?>
                    <?php endif; ?>
                    <h3><?php the_title(); ?></h3>
                </a>
            </div>
        <?php
        endwhile;
        wp_reset_postdata();
    } else {
        echo '<p>Aucun projet trouvé.</p>';
    }

    wp_die();
}

// Rechercher des projets (AJAX)
add_action('wp_ajax_search_projects', 'search_projects');
add_action('wp_ajax_nopriv_search_projects', 'search_projects');

function search_projects() {
    $query = isset($_POST['query']) ? sanitize_text_field($_POST['query']) : '';

    $args = array(
        'post_type' => 'project',
        'posts_per_page' => -1,
        's' => $query,
    );

    $search_query = new WP_Query($args);

    if ($search_query->have_posts()) :
        while ($search_query->have_posts()) : $search_query->the_post();
            get_template_part('template-parts/content', 'project');
        endwhile;
    else :
        echo '<p>Aucun projet trouvé.</p>';
    endif;

    wp_reset_postdata();
    wp_die();
}
