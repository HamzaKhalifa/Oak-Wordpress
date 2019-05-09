<?php
Publications::$properties = array (
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
        'description' => __( 'Année', Oak::$text_domain ), 
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
            array( 'value' => 'web', 'innerHTML' => 'WEB' ),
            array( 'value' => 'pdf', 'innerHTML' => 'Fichier PDF' ),
            array( 'value' => 'epub', 'innerHTML' => 'ePub' ),
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
        'input_type' => 'text',
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
        'placeholder' => __( 'Pays', Oak::$text_domain ), 
        'description' => __( 'Pays', Oak::$text_domain ), 
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
            array ( 'value' => 'reference-document', 'innerHTML' => __( 'Document de référence', Oak::$text_domain ) ),
            array ( 'value' => 'annual-report', 'innerHTML' => __( 'Rapport annuel', Oak::$text_domain ) ),
            array ( 'value' => 'integrated-reporting', 'innerHTML' => __( 'Reporting intégré', Oak::$text_domain ) ), 
            array ( 'value' => 'evaluation-initiatives', 'innerHTML' => __( 'Initiatives d\'évaluation (Notation)', Oak::$text_domain ) ),
            array ( 'value' => 'extra-finantial-notation', 'innerHTML' => __( 'Notation extra financière (Classement)', Oak::$text_domain ) ),
        ),
        'placeholder' => __( 'Type de rapport', Oak::$text_domain ), 
        'description' => __( 'Type de rapport', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array(
            array( 'name' => 'report_or_frame', 'values' => array( 'report' ) )
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
        'input_type' => 'text',
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