<?php
Forms::$properties =  array (
    array ( 
        'name' => 'structure', 
        'property_name' => 'form_structure', 
        'type' => 'text',
        'input_type' => 'select', 
        'select_multiple' => 'false', 
        'choices' => Forms::$form_structures, 
        'description' => __( 'Structure du formulaire', Oak::$text_domain ), 
        'width' => '100' 
    ),
);

Forms::$other_elements = array (
    'title' => __( 'Champs du formulaire', Oak::$text_domain ),
    'first_option' => __( 'Sélectionner un champ', Oak::$text_domain ),
    'description' => __( 'Champ à insérer dans le formulaire', Oak::$text_domain ),
    'new_designation_description' => __( 'Nom du champ dans ce formulaire', Oak::$text_domain ),
    'required_description' => __( 'Champ requis ou non lors du remplissage du formulaire', Oak::$text_domain ),
    
    'elements' => Oak::$fields_without_redundancy,
    'elements_with_redundancy' => Oak::$fields,
    'table' => 'field',
    'table_name' => Oak::$forms_and_fields_table_name,
    
    'associative_tab_instances' => Oak::$all_forms_and_fields,

    'element_column_name' => 'form_identifier',
    'other_element_column_name' => 'field_identifier',
    'new_designation_column_name' => 'field_designation',
    'required_colmun_name' => 'field_required',
    'index_property' => 'field_index',

    'filters' => array(
        array( 'name_in_database' => 'field_type', 'filter_name' => 'oak_filter_field_type', 'title' => __( 'Nature des contenus compris dans le champ', Oak::$text_domain ), 'first_option' => 'Aucune nature attribuée', 'choices' => Fields::$field_types ),
        array( 'name_in_database' => 'field_function', 'filter_name' => 'oak_filter_field_function', 'title' => __( 'Fonction du champ en tant que message', Oak::$text_domain ), 'first_option' => 'Aucune fonction attribuée', 'choices' => Fields::$field_functions ),
    ),
);