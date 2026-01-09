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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const gridViewRadio = document.getElementById('view-grid');
        const mapViewRadio = document.getElementById('view-map');
        const projectGrid = document.getElementById('project-grid');
        const projectMap = document.getElementById('project-map');
        let mapInitialized = false; // Indicateur pour vérifier si la carte est déjà initialisée
        let map; // Variable pour la carte Leaflet

        // Fonction pour basculer entre vue mosaïque et vue carte
        function switchView() {
            if (gridViewRadio.checked) {
                projectGrid.classList.remove('view-hidden');
                projectGrid.classList.add('view-active');
                projectMap.classList.remove('view-active');
                projectMap.classList.add('view-hidden');

                // Supprimer la carte et masquer le conteneur de la carte
                if (mapInitialized && map) {
                    map.remove();
                    mapInitialized = false;
                }
                projectMap.style.display = 'none'; // Masquer le conteneur
            } else if (mapViewRadio.checked) {
                projectGrid.classList.remove('view-active');
                projectGrid.classList.add('view-hidden');
                projectMap.classList.remove('view-hidden');
                projectMap.classList.add('view-active');

                projectMap.style.display = 'block'; // Afficher le conteneur de la carte

                // Initialiser la carte seulement si elle ne l'est pas déjà
                if (!mapInitialized) {
                    map = L.map('project-map', {
                        zoomControl: true,
                        scrollWheelZoom: true,
                        maxBounds: L.latLngBounds(
                            L.latLng(-90, -180),  // Sud-ouest
                            L.latLng(90, 180)     // Nord-est
                        ),
                        maxBoundsViscosity: 1.0,
                        bounceAtZoomLimits: true,
                        worldCopyJump: true
                    }).setView([20, 0], 2);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 18, // Augmentation du zoom maximum pour voir les rues
                        minZoom: 2,
                        noWrap: true,
                        bounds: [[-90, -180], [90, 180]],
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    // Ajouter des marqueurs pour chaque projet
                    <?php
                        $projects = get_posts(array('post_type' => 'project', 'posts_per_page' => -1));
                        $has_markers = false;

                        foreach ($projects as $project) {
                            $lat_dms = get_field('project_location_lat', $project->ID);
                            $lng_dms = get_field('project_location_lng', $project->ID);
                            
                            if ($lat_dms && $lng_dms) {
                                $lat = $lat_dms;
                                $lng = $lng_dms;
                                
                                if ($lat !== '' && $lng !== '') {
                                    $has_markers = true;
                                    $title = get_the_title($project->ID);
                                    $permalink = get_permalink($project->ID);
                                    $location = get_field('project_location', $project->ID) ?: '';
                                    $year = get_field('project_year', $project->ID) ?: '';
                                    
                                    // Récupérer l'image mise en avant
                                    $featured_image = '';
                                    if (has_post_thumbnail($project->ID)) {
                                        $featured_image = get_the_post_thumbnail_url($project->ID, 'medium');
                                    }
                                    
                                    // Build popup content
                                    $popupContent = "<div style='width: 200px; text-align: center;'>";
                                    
                                    // Add featured image if available
                                    if ($featured_image) {
                                        $popupContent .= "<img src='" . esc_url($featured_image) . "' alt='" . esc_attr($title) . "' style='width: 100%; height: auto; border-radius: 5px; margin-bottom: 10px;'>";
                                    }
                                    
                                    // Add title
                                    $popupContent .= "<h3 style='margin: 10px 0 5px;'>" . esc_html($title) . "</h3>";
                                    
                                    // Add location and year if available
                                    if ($location || $year) {
                                        $info = array_filter(array($location, $year));
                                        $popupContent .= "<p style='margin: 0;'>" . esc_html(implode(' - ', $info)) . "</p>";
                                    }
                                    
                                    // Add link
                                    $popupContent .= "<a href='" . esc_url($permalink) . "' style='color: blue; text-decoration: underline; display: inline-block; margin-top: 8px;'>Voir le projet</a>";
                                    $popupContent .= "</div>";
                                    
                                    echo "L.marker([$lat, $lng]).addTo(map).bindPopup(" . json_encode($popupContent) . ");";
                                }
                            }
                        }

                        if (!$has_markers) {
                            echo "document.getElementById('project-map').innerHTML = '<h5 style=\"text-align: center;\">Aucun projet avec des coordonnées n\'est disponible.</h5>';";
                        }
                    ?>

                    map.invalidateSize();
                    mapInitialized = true;
                } else {
                    map.invalidateSize(); // Réajuster la taille de la carte si elle est déjà initialisée
                }
            }
        }

        // Appliquer la fonction lorsque l'utilisateur change de vue
        gridViewRadio.addEventListener('change', switchView);
        mapViewRadio.addEventListener('change', switchView);

        // Appel initial pour régler la vue correcte au chargement
        switchView();
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-input');
        let typingTimer;

        searchInput.addEventListener('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                document.getElementById('search-form').submit();
            }, 500); // Délai de 500 ms après que l'utilisateur a fini de taper
        });

        searchInput.addEventListener('keydown', function () {
            clearTimeout(typingTimer);
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.header');
    const projectArchiveHeader = document.querySelector('.project-archive-header');
    const headerHeight = header.offsetHeight;

    window.addEventListener('scroll', function() {
        if (window.pageYOffset > headerHeight) {
            projectArchiveHeader.classList.add('fixed');
        } else {
            projectArchiveHeader.classList.remove('fixed');
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const themeButton = document.getElementById('theme-button');
    const themeDropdown = document.getElementById('theme-dropdown');
    const currentThemeSpan = document.querySelector('.current-theme');
    const themeInput = document.getElementById('theme-input');
    const filterForm = document.getElementById('filters-form');

    themeButton.addEventListener('click', function(e) {
        e.stopPropagation();
        themeDropdown.classList.toggle('show');
        themeButton.classList.toggle('active');
    });

    document.querySelectorAll('.theme-option').forEach(option => {
        option.addEventListener('click', function() {
            const value = this.dataset.value;
            const text = this.textContent;
            
            currentThemeSpan.textContent = text;
            themeInput.value = value;
            filterForm.submit();
        });
    });

    document.addEventListener('click', function(e) {
        if (!themeButton.contains(e.target)) {
            themeDropdown.classList.remove('show');
            themeButton.classList.remove('active');
        }
    });
});
</script>

<?php
get_footer();
?>
