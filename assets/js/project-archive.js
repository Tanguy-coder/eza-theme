/**
 * Project Archive Page Logic
 * Includes: View switching, Live search typing delay, Sticky header, and Leaflet Map
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. View Switcher (Grid vs Map)
    const gridViewRadio = document.getElementById('view-grid');
    const mapViewRadio = document.getElementById('view-map');
    const projectGrid = document.getElementById('project-grid');
    const projectMap = document.getElementById('project-map');
    let mapInitialized = false;
    let map;

    function switchView() {
        if (!gridViewRadio || !mapViewRadio) return;

        if (gridViewRadio.checked) {
            projectGrid.classList.remove('view-hidden');
            projectGrid.classList.add('view-active');
            projectMap.classList.remove('view-active');
            projectMap.classList.add('view-hidden');
            projectMap.style.display = 'none';

            if (mapInitialized && map) {
                map.remove();
                mapInitialized = false;
            }
        } else if (mapViewRadio.checked) {
            projectGrid.classList.remove('view-active');
            projectGrid.classList.add('view-hidden');
            projectGrid.style.display = 'none';
            projectMap.classList.remove('view-hidden');
            projectMap.classList.add('view-active');
            projectMap.style.display = 'block';

            if (!mapInitialized) {
                initMap();
            } else {
                map.invalidateSize();
            }
        }
    }

    function initMap() {
        if (typeof L === 'undefined') return;

        map = L.map('project-map', {
            zoomControl: true,
            scrollWheelZoom: true,
            maxBounds: L.latLngBounds(L.latLng(-90, -180), L.latLng(90, 180)),
            maxBoundsViscosity: 1.0,
            bounceAtZoomLimits: true,
            worldCopyJump: true
        }).setView([20, 0], 2);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            minZoom: 2,
            noWrap: true,
            bounds: [[-90, -180], [90, 180]],
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add markers from localized data
        if (window.projectArchiveData && window.projectArchiveData.markers) {
            let hasMarkers = false;
            window.projectArchiveData.markers.forEach(function (marker) {
                if (marker.lat && marker.lng) {
                    L.marker([marker.lat, marker.lng])
                        .addTo(map)
                        .bindPopup(marker.popup);
                    hasMarkers = true;
                }
            });

            if (!hasMarkers) {
                projectMap.innerHTML = '<h5 style="text-align: center; padding-top: 50px;">Aucun projet avec des coordonnées n\'est disponible.</h5>';
            }
        }

        map.invalidateSize();
        mapInitialized = true;
    }

    if (gridViewRadio && mapViewRadio) {
        gridViewRadio.addEventListener('change', switchView);
        mapViewRadio.addEventListener('change', switchView);
        switchView();
    }

    // 2. Search typing delay
    const searchInput = document.getElementById('search-input');
    const searchForm = document.getElementById('search-form');
    if (searchInput && searchForm) {
        let typingTimer;
        searchInput.addEventListener('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                searchForm.submit();
            }, 500);
        });
        searchInput.addEventListener('keydown', function () {
            clearTimeout(typingTimer);
        });
    }

    // 3. Sticky header sub-navigation
    const header = document.querySelector('.header');
    const projectArchiveHeader = document.querySelector('.project-archive-header');
    if (header && projectArchiveHeader) {
        const headerHeight = header.offsetHeight;
        window.addEventListener('scroll', function () {
            if (window.pageYOffset > headerHeight) {
                projectArchiveHeader.classList.add('fixed');
            } else {
                projectArchiveHeader.classList.remove('fixed');
            }
        });
    }

    // 4. Theme Dropdown
    const themeButton = document.getElementById('theme-button');
    const themeDropdown = document.getElementById('theme-dropdown');
    const currentThemeSpan = document.querySelector('.current-theme');
    const themeInput = document.getElementById('theme-input');
    const filterForm = document.getElementById('filters-form');

    if (themeButton && themeDropdown) {
        themeButton.addEventListener('click', function (e) {
            e.stopPropagation();
            themeDropdown.classList.toggle('show');
            themeButton.classList.toggle('active');
        });

        document.querySelectorAll('.theme-option').forEach(option => {
            option.addEventListener('click', function () {
                const value = this.dataset.value;
                const text = this.textContent;
                if (currentThemeSpan) currentThemeSpan.textContent = text;
                if (themeInput) themeInput.value = value;
                if (filterForm) filterForm.submit();
            });
        });

        document.addEventListener('click', function (e) {
            if (!themeButton.contains(e.target)) {
                themeDropdown.classList.remove('show');
                themeButton.classList.remove('active');
            }
        });
    }
});
