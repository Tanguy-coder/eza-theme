<?php
get_header();
?>

<div class="project-archive-container">
    <div class="project-archive-header">
        <div class="forms">
            <!-- Barre de recherche -->
            <div class="search-bar">
                <form action="<?php echo esc_url(home_url('/')); ?>" method="get" id="search-form">
                    <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.2"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"/>
                        <path d="M21 21l-6 -6"/>
                    </svg>
                    <input type="text" name="s" id="search-input" placeholder="Rechercher un projet..." value="<?php the_search_query(); ?>"/>
                    <input type="hidden" name="post_type" value="project"/>
                </form>
            </div>

            <!-- Filtres -->
            <div class="filters">
                <form method="get" id="filters-form">
                    <div class="filter-item">
                        <label for="theme">Thème</label>
                        <?php
                        $themes = get_terms(array('taxonomy' => 'project_theme', 'hide_empty' => false));
                        if (!empty($themes)) {
                            echo '<select name="theme" id="theme">';
                            echo '<option value="">Tous les thèmes</option>';
                            foreach ($themes as $theme) {
                                echo '<option value="' . esc_attr($theme->slug) . '">' . esc_html($theme->name) . '</option>';
                            }
                            echo '</select>';
                        }
                        ?>
                    </div>
                </form>
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

    <!-- Conteneur des projets en mosaïque -->
    <div id="project-grid" class="project-grid view-active">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <div class="project-item">
                    <a href="<?php the_permalink(); ?>" class="project-link">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium'); ?>
                        <?php endif; ?>
                        <h3><?php the_title(); ?></h3>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p>Aucun projet trouvé.</p>
        <?php endif; ?>
    </div>

    <!-- Conteneur pour la vue carte -->
    <div id="project-map" class="project-map view-hidden">
        <!-- Google Maps ou autre API de carte ici -->
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const gridViewRadio = document.getElementById('view-grid');
        const mapViewRadio = document.getElementById('view-map');
        const projectGrid = document.getElementById('project-grid');
        const projectMap = document.getElementById('project-map');

        // Fonction pour basculer entre vue mosaïque et vue carte
        function switchView() {
            if (gridViewRadio.checked) {
                projectGrid.classList.remove('view-hidden');
                projectGrid.classList.add('view-active');
                projectMap.classList.remove('view-active');
                projectMap.classList.add('view-hidden');
            } else if (mapViewRadio.checked) {
                projectGrid.classList.remove('view-active');
                projectGrid.classList.add('view-hidden');
                projectMap.classList.remove('view-hidden');
                projectMap.classList.add('view-active');
            }
        }

        // Appliquer la fonction lorsque l'utilisateur change de vue
        gridViewRadio.addEventListener('change', switchView);
        mapViewRadio.addEventListener('change', switchView);

        // Appel initial pour régler la vue correcte au chargement
        switchView();
    });
</script>

<!-- Script Leaflet pour afficher la carte -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var map = L.map('project-map').setView([48.8566, 2.3522], 2); // Centré sur Paris

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        setTimeout(function() {
            map.invalidateSize(); // Cela force Leaflet à recalculer la taille de la carte
        }, 500);

        // Ajouter des marqueurs pour chaque projet
        <?php
        $projects = get_posts(array('post_type' => 'project', 'posts_per_page' => -1));
        foreach ($projects as $project) {
            $lat = get_field('project_location_lat', $project->ID);
            $lng = get_field('project_location_lng', $project->ID);

            // Vérifier que les coordonnées existent
            if ($lat && $lng) {
                $title = get_the_title($project->ID);
                $permalink = get_permalink($project->ID);
                echo "L.marker([$lat, $lng]).addTo(map).bindPopup('<a href=\"$permalink\">$title</a>');";
            }
        }
        ?>
    });
</script>

<?php
get_footer();
?>
