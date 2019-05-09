<?php
Models::$other_elements = array (
    'title' => __( 'Formulaires du modèle', Oak::$text_domain ),
    'first_option' => __( 'Sélectionner un formulaire', Oak::$text_domain ),
    'description' => __( 'Formulaire à insérer dans le modèle', Oak::$text_domain ),
    'new_designation_description' => __( 'Nom du formulaire dans ce modèle', Oak::$text_domain ),
    'required_description' => __( 'Formulaire requis ou non lors du remplissage de l\'objet', Oak::$text_domain ),
    
    'elements' => Oak::$forms_without_redundancy,
    'elements_with_redundancy' => Oak::$forms,
    'table' => 'form',
    'table_name' => Oak::$models_and_forms_table_name,

    'associative_tab_instances' => Oak::$all_models_and_forms,

    'element_column_name' => 'model_identifier',
    'other_element_column_name' => 'form_identifier',
    'new_designation_column_name' => 'form_designation',
    'required_colmun_name' => 'form_required',
    'index_property' => 'form_index',

    'filters' => array(
        array( 'name_in_database' => 'form_structure', 'filter_name' => 'oak_filter_form_structure', 'title' => __( 'Structure du formulaire', Oak::$text_domain ), 'first_option' => 'Aucune structure attribuée', 'choices' => Forms::$form_structures ),
        // array( 'name_in_database' => 'field_type', 'filter_name' => 'oak_filter_field_type', 'title' => __( 'Nature des contenus compris dans le champ', Oak::$text_domain ), 'first_option' => 'Aucune nature attribuée', 'choices' => Oak::$field_types ),
        // array( 'name_in_database' => 'field_function', 'filter_name' => 'oak_filter_field_function', 'title' => __( 'Fonction du champ en tant que message', Oak::$text_domain ), 'first_option' => 'Aucune fonction attribuée', 'choices' => Oak::$field_functions ),
    ),
);


Models::$properties = array (
    array( 
        'name' => 'types', 
        'property_name' => 'model_types', 
        'type' => 'text', 
        'input_type' => 'select', 
        'select_multiple' => 'false', 
        'choices' => array (
            array ( 'value' => '0', 'innerHTML' => 'Fixe' ), 
        ),
        'description' => __( 'Type du modèle', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array( 
        'name' => 'publications_categories', 
        'property_name' => 'model_publications_categories', 
        'type' => 'text', 
        'input_type' => 'select', 
        'select_multiple' => 'true', 
        'choices' => array ( 
            array ( 'value' => 'Catégorie 1', 'innerHTML' => 'Catégorie 1' ), 
            array ( 'value' => 'Catégorie 2', 'innerHTML' => 'Catégorie 2'), 
            array ( 'value' => 'Catégorie 3', 'innerHTML' => 'Catégorie 3' ), 
            array ( 'value' => 'Catégorie 4', 'innerHTML' => 'Catégorie 4' ) 
        ), 
        'description' => __( 'Type du modèle', Oak::$text_domain ), 
        'width' => '50' 
    ),
);