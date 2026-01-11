<?php
/**
 * ACF Field Groups Configuration for ezaarchitectures
 */

function dms_to_decimal($dms) {
    if (empty($dms)) return '';
    $direction = substr($dms, -1);
    $parts = explode('°', substr($dms, 0, -1));
    $degrees = floatval($parts[0]);
    $parts = explode("'", $parts[1]);
    $minutes = floatval($parts[0]);
    $seconds = floatval(substr($parts[1], 0, -1));
    $decimal = $degrees + ($minutes/60) + ($seconds/3600);
    if ($direction == 'W' || $direction == 'S') {
        $decimal = -$decimal;
    }
    return $decimal;
}

if (function_exists('acf_add_local_field_group')) {
    // Groupe de champs : Détails du projet
    acf_add_local_field_group(array(
        'key' => 'group_project_details',
        'title' => 'Détails du projet',
        'fields' => array(
            array(
                'key' => 'field_project_image_1',
                'label' => 'Image 1 du projet',
                'name' => 'project_image_1',
                'type' => 'image',
                'instructions' => 'Choisissez la première image du projet',
                'required' => 0,
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_project_image_2',
                'label' => 'Image 2 du projet',
                'name' => 'project_image_2',
                'type' => 'image',
                'instructions' => 'Choisissez la deuxième image du projet',
                'required' => 0,
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_project_image_3',
                'label' => 'Image 3 du projet',
                'name' => 'project_image_3',
                'type' => 'image',
                'instructions' => 'Choisissez la troisième image du projet',
                'required' => 0,
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_project_image_4',
                'label' => 'Image 4 du projet',
                'name' => 'project_image_4',
                'type' => 'image',
                'instructions' => 'Choisissez la quatrième image du projet',
                'required' => 0,
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_project_image_5',
                'label' => 'Image 5 du projet',
                'name' => 'project_image_5',
                'type' => 'image',
                'instructions' => 'Choisissez la cinquième image du projet',
                'required' => 0,
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_project_description',
                'label' => 'Description du projet',
                'name' => 'project_description',
                'type' => 'wysiwyg',
                'instructions' => 'Entrez la description détaillée du projet',
                'required' => 0,
            ),
            array(
                'key' => 'field_project_file',
                'label' => 'Fiche du projet',
                'name' => 'project_file',
                'type' => 'file',
                'instructions' => 'Téléchargez la fiche du projet (PDF recommandé)',
                'required' => 0,
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_project_type',
                'label' => 'Type de projet',
                'name' => 'project_type',
                'type' => 'text',
                'instructions' => 'Entrez le type de projet',
                'required' => 0,
            ),
            array(
                'key' => 'field_project_location',
                'label' => 'Localisation',
                'name' => 'project_location',
                'type' => 'text',
                'instructions' => 'Entrez la localisation du projet',
                'required' => 0,
            ),
            array(
                'key' => 'field_project_client',
                'label' => 'Client',
                'name' => 'project_client',
                'type' => 'text',
                'instructions' => 'Entrez le nom du client',
                'required' => 0,
            ),
            array(
                'key' => 'field_project_year',
                'label' => 'Année',
                'name' => 'project_year',
                'type' => 'number',
                'instructions' => 'Entrez l\'année du projet',
                'required' => 0,
            ),
            array(
                'key' => 'field_project_surface',
                'label' => 'Surface',
                'name' => 'project_surface',
                'type' => 'text',
                'instructions' => 'Entrez la surface du projet (ex: 5000 )',
                'required' => 0,
            ),
            array(
                'key' => 'field_project_location_lat',
                'label' => 'Latitude',
                'name' => 'project_location_lat',
                'type' => 'text',
                'instructions' => 'Entrez la latitude (ex: 48.8566)',
                'required' => 0,
                'wrapper' => array(
                    'width' => '50'
                )
            ),
            array(
                'key' => 'field_project_location_lng',
                'label' => 'Longitude',
                'name' => 'project_location_lng',
                'type' => 'text',
                'instructions' => 'Entrez la longitude (ex: 2.3522)',
                'required' => 0,
                'wrapper' => array(
                    'width' => '50'
                )
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'project',
                ),
            ),
        ),
    ));

    // Groupe de champs : Détails du Personnel
    acf_add_local_field_group(array(
        'key' => 'group_personnel_details',
        'title' => 'Détails du Personnel',
        'fields' => array(
            array(
                'key' => 'field_personnel_mention',
                'label' => 'Mention',
                'name' => 'personnel_mention',
                'type' => 'text',
                'instructions' => 'Entrez la mention.',
                'required' => 0,
            ),
            array(
                'key' => 'field_personnel_function',
                'label' => 'Fonction',
                'name' => 'personnel_function',
                'type' => 'text',
                'instructions' => 'Entrez le poste de la personne.',
                'required' => 0,
            ),
            array(
                'key' => 'field_personnel_description',
                'label' => 'Description',
                'name' => 'personnel_description',
                'type' => 'wysiwyg',
                'instructions' => 'Entrez une brève description de la personne.',
                'required' => 0,
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'personnel',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));

    // Groupe de champs : Images de l’agence
    $page_agence = get_page_by_path('agence');
    $page_agence_id = $page_agence ? $page_agence->ID : null;

    if ($page_agence_id) {
        acf_add_local_field_group(array(
            'key' => 'group_agency_images',
            'title' => 'Images de l’agence',
            'fields' => array(
                array(
                    'key' => 'field_agency_image_1',
                    'label' => 'Image 1',
                    'name' => 'agency_image_1',
                    'type' => 'image',
                    'return_format' => 'array',
                ),
                array(
                    'key' => 'field_agency_image_2',
                    'label' => 'Image 2',
                    'name' => 'agency_image_2',
                    'type' => 'image',
                    'return_format' => 'array',
                ),
                array(
                    'key' => 'field_agency_image_3',
                    'label' => 'Image 3',
                    'name' => 'agency_image_3',
                    'type' => 'image',
                    'return_format' => 'array',
                ),
                array(
                    'key' => 'field_agency_image_4',
                    'label' => 'Image 4',
                    'name' => 'agency_image_4',
                    'type' => 'image',
                    'return_format' => 'array',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page',
                        'operator' => '==',
                        'value' => $page_agence_id,
                    ),
                ),
            ),
        ));
    }
}
