<?php
Publications::$properties = array (
    array ( 
        'name' => 'title', 
        'property_name' => 'publication_title', 
        'type' => 'text',
        'input_type' => 'text',
        'placeholder' => __( 'Titre', Oak::$text_domain ), 
        'description' => __( 'Titre', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true
    ),
    array ( 
        'name' => 'organization', 
        'property_name' => 'publication_organization', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$organizations_array, 
        'description' => __( 'Organisation', Oak::$text_domain ), 
        'width' => '50',
    ),
    array ( 
        'name' => 'year', 
        'property_name' => 'publication_year', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$years,
        'description' => __( 'Année de publication', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'covert_year', 
        'property_name' => 'publication_covert_year', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$years,
        'description' => __( 'Année de couverture', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'headpiece', 
        'property_name' => 'publication_headpiece', 
        'type' => 'text',
        'input_type' => 'image',
        'description' => __( 'Vignette', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true
    ),
    array ( 
        'name' => 'format', 
        'property_name' => 'publication_format', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => '0', 'innerHTML' => __( 'Aucun format sélectionné' ) ),
            array( 'value' => 'web', 'innerHTML' => __( 'WEB', Oak::$text_domain ) ),
            array( 'value' => 'pdf', 'innerHTML' => __( 'Fichier PDF', Oak::$text_domain ) ),
            array( 'value' => 'epub', 'innerHTML' => __( 'ePub', Oak::$text_domain ) ),
        ),
        'description' => __( 'Format', Oak::$text_domain ), 
        'width' => '50',
        'condition' => true,
    ),
    array (
        'name' => 'file', 
        'property_name' => 'publication_file', 
        'type' => 'text',
        'input_type' => 'file',
        'description' => __( 'Fichier', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array(
            array( 'name' => 'format', 'values' => array( 'pdf', 'epub' ) )
        )
    ),
    array ( 
        'name' => 'description', 
        'property_name' => 'publication_description', 
        'type' => 'text',
        'input_type' => 'textarea',
        'placeholder' => __( 'Description', Oak::$text_domain ), 
        'description' => __( 'Description', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true
    ),
    array ( 
        'name' => 'local', 
        'property_name' => 'publication_local', 
        'type' => 'text',
        'input_type' => 'checkbox',
        'placeholder' => __( 'Publication locale', Oak::$text_domain ), 
        'description' => __( 'Publication locale', Oak::$text_domain ), 
        'width' => '50',
        'condition' => true
    ),
    array (
        'name' => 'country', 
        'property_name' => 'publication_country', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$countries,
        'placeholder' => __( 'Pays/Région', Oak::$text_domain ), 
        'description' => __( 'Pays/Région', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array(
            array( 'name' => 'local', 'values' => array( 'true' ) )
        )
    ),
    array ( 
        'name' => 'language', 
        'property_name' => 'publication_language', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$languages,
        'placeholder' => __( 'Langue', Oak::$text_domain ), 
        'description' => __( 'Langue', Oak::$text_domain ), 
        'width' => '50'
    ),
    array ( 
        'name' => 'report_or_frame', 
        'property_name' => 'publication_report_or_frame', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => 'report', 'innerHTML' => 'Rapport' ),
            array( 'value' => 'frame', 'innerHTML' => 'Cadres RSE' ),
            array( 'value' => 'corporate', 'innerHTML' => 'Corporate' ),
        ),
        'placeholder' => __( 'Rapport/Cadre RSE', Oak::$text_domain ), 
        'description' => __( 'Rapport/Cadre RSE', Oak::$text_domain ), 
        'width' => '50',
        'condition' => true
    ),
    array ( 
        'name' => 'frame_type', 
        'property_name' => 'publication_frame_type', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array ( 'value' => 'universal-frame', 'innerHTML' => __( 'Cadres universels', Oak::$text_domain ) ),
            array ( 'value' => 'normes-and-sectorial-initiatives', 'innerHTML' => __( 'Normes et inititives sectorielles (Déploiement)', Oak::$text_domain ) ),
            array ( 'value' => 'directive-lines', 'innerHTML' => __( 'Lignes directrices et cadres de référence (Reporting)', Oak::$text_domain ) ), 
            array ( 'value' => 'evaluation-initiatives', 'innerHTML' => __( 'Initiatives d\'évaluation (Notation)', Oak::$text_domain ) ),
            array ( 'value' => 'extra-finantial-notation', 'innerHTML' => __( 'Notation extra financière (Classement)', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Type de cadres', Oak::$text_domain ), 
        'description' => __( 'Type de cadres', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array(
            array( 'name' => 'report_or_frame', 'values' => array( 'frame' ) )
        )
    ),
    array ( 
        'name' => 'report_type', 
        'property_name' => 'publication_report_type', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array ( 'value' => '0', 'innerHTML' => __( 'Aucun type n\'est sélectionné', Oak::$text_domain ) ),
            array ( 'value' => 'reference-document', 'innerHTML' => __( 'Document de référence', Oak::$text_domain ) ),
            array ( 'value' => 'annual-report', 'innerHTML' => __( 'Rapport annuel', Oak::$text_domain ) ),
            array ( 'value' => 'integrated-reporting', 'innerHTML' => __( 'Reporting intégré', Oak::$text_domain ) ), 
            array ( 'value' => 'evaluation-initiatives', 'innerHTML' => __( 'Initiatives d\'évaluation (Notation)', Oak::$text_domain ) ),
            array ( 'value' => 'extra-finantial-notation', 'innerHTML' => __( 'Notation extra financière (Classement)', Oak::$text_domain ) ),
            array ( 'value' => 'financial-report', 'innerHTML' => __( 'Rapport financier', Oak::$text_domain ) ),
            array ( 'value' => 'other', 'innerHTML' => __( 'Autre rapport', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Type de rapport', Oak::$text_domain ), 
        'description' => __( 'Type de rapport', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array(
            array( 'name' => 'report_or_frame', 'values' => array( 'report' ) )
        )
    ),
    array ( 
        'name' => 'corporate_type', 
        'property_name' => 'publication_corporate_type', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array ( 'value' => 'chart', 'innerHTML' => __( 'Charte', Oak::$text_domain ) ),
            array ( 'value' => 'politics', 'innerHTML' => __( 'Politique', Oak::$text_domain ) ),
            array ( 'value' => 'corporate-site', 'innerHTML' => __( 'Site Corporate', Oak::$text_domain ) ), 
        ),
        'placeholder' => __( 'Type de Publication Corporate', Oak::$text_domain ), 
        'description' => __( 'Type de Publication Corporate', Oak::$text_domain ), 
        'width' => '100',
        'depends' => array(
            array( 'name' => 'report_or_frame', 'values' => array( 'corporate' ) )
        )
    ),
    array ( 
        'name' => 'sectorial_frame', 
        'property_name' => 'publication_sectorial_frame', 
        'type' => 'text',
        'input_type' => 'checkbox',
        'placeholder' => __( 'Cadre sectoriel', Oak::$text_domain ), 
        'description' => __( 'Cadre sectoriel', Oak::$text_domain ), 
        'width' => '50',
        'condition' => true,
        'depends' => array(
            array( 'name' => 'report_or_frame', 'values' => array( 'frame' ) )
        )
    ),
    array ( 
        'name' => 'sectors', 
        'property_name' => 'publication_sectors', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array ( 'value' => '0', 'innerHTML' => __( 'Aucun secteur sélectionné', Oak::$text_domain ) ),
            array ( 'value' => '1', 'innerHTML' => __( 'Agroalimentaire', Oak::$text_domain ) ),
            array ( 'value' => '2', 'innerHTML' => __( 'Banque / Assurance', Oak::$text_domain ) ),
            array ( 'value' => '3', 'innerHTML' => __( 'Bois / Papier / Carton / Imprimente', Oak::$text_domain ) ),
            array ( 'value' => '4', 'innerHTML' => __( 'BTP / Matéiriaux de construction', Oak::$text_domain ) ),
            array ( 'value' => '5', 'innerHTML' => __( 'Chimie / Parachimie', Oak::$text_domain ) ),
            array ( 'value' => '6', 'innerHTML' => __( 'Commerce / Négoce / Distribution', Oak::$text_domain ) ),
            array ( 'value' => '7', 'innerHTML' => __( 'Edition / Communication / Multimédia', Oak::$text_domain ) ),
            array ( 'value' => '8', 'innerHTML' => __( 'Electronique / Electricité', Oak::$text_domain ) ),
            array ( 'value' => '9', 'innerHTML' => __( 'Industrie pharmaceutique', Oak::$text_domain ) ),
            array ( 'value' => '10', 'innerHTML' => __( 'Informatique / Télécoms', Oak::$text_domain ) ),
            array ( 'value' => '11', 'innerHTML' => __( 'Machines et équipements / Automobile', Oak::$text_domain ) ),
            array ( 'value' => '12', 'innerHTML' => __( 'Métallurgie / Travail du métal', Oak::$text_domain ) ),
            array ( 'value' => '13', 'innerHTML' => __( 'Plastique / Caoutchouc', Oak::$text_domain ) ),
            array ( 'value' => '14', 'innerHTML' => __( 'Sérvices aux entreprises', Oak::$text_domain ) ),
            array ( 'value' => '15', 'innerHTML' => __( 'Textile / Hibillement / Chaussure', Oak::$text_domain ) ),
            array ( 'value' => '16', 'innerHTML' => __( 'Transports / Logistique', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Secteurs d\'activité', Oak::$text_domain ), 
        'description' => __( 'Secteurs d\'activité', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array(
            array( 'name' => 'report_or_frame', 'values' => array( 'frame' ) ),
            array( 'name' => 'sectorial_frame', 'values' => array( 'true' ) )
        )
    ),
    array ( 
        'name' => 'gri_type', 
        'property_name' => 'publication_gri_type', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array( 'value' => 'no-gri', 'innerHTML' => 'Non - GRI' ),
            array( 'value' => 'citing-gri', 'innerHTML' => 'Citing - GRI' ),
            array( 'value' => 'gri-referenced', 'innerHTML' => 'GRI - Referenced' ),
            array( 'value' => 'gri-standards', 'innerHTML' => 'GRI - Standards' ),
        ),
        'placeholder' => __( 'Type GRI de rapport', Oak::$text_domain ), 
        'description' => __( 'Type GRI de rapport', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array(
            array( 'name' => 'report_or_frame', 'values' => array( 'report' ) )
        )
    ),
    array ( 
        'name' => 'sectorial_supplement', 
        'property_name' => 'publication_sectorial_supplement', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array ( 'value' => '0', 'innerHTML' => 'Aucun supplément selectionné' ),
            array ( 'value' => 'euss', 'innerHTML' => 'Services d’électricité (EUSS)' ),
            array ( 'value' => 'fsss', 'innerHTML' => 'Services financiers (FSSS)' ),
            array ( 'value' => 'fpsss', 'innerHTML' => 'Préparation alimentaire (FPSS)' ),
            array ( 'value' => 'mmss', 'innerHTML' => 'Mines et métaux (MMSS)' ),
            array ( 'value' => 'ngoss', 'innerHTML' => 'ONG (NGOSS)' ),
            array ( 'value' => 'aoss', 'innerHTML' => 'Opérateurs aéroportuaires (AOSS)' ),
            array ( 'value' => 'cress', 'innerHTML' => 'Construction et Immobilier (CRESS)' ),
            array ( 'value' => 'eoss', 'innerHTML' => 'Organisateur événementiels (EOSS)' ),
            array ( 'value' => 'ogss', 'innerHTML' => 'Pétrole et gaz (OGSS)' ),
            array ( 'value' => 'mss', 'innerHTML' => 'Médias (MSS)' ),
        ),
        'placeholder' => __( 'Supplément sectoriel', Oak::$text_domain ), 
        'description' => __( 'Supplément sectoriel', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array(
            array( 'name' => 'report_or_frame', 'values' => array( 'report' ) )
        )
    ),
);