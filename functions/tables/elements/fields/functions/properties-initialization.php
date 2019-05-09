<?php
Fields::$properties = array (
    array( 
        'name' => 'publication', 
        'property_name' => 'field_publication', 
        'type' => 'text', 
        'input_type' => 'select', 
        'select_multiple' => 'false', 
        'choices' => Oak::$publications_array,
        'description' => __( 'Publication', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'type',
        'property_name' => 'field_type', 
        'type' => 'text', 
        'input_type' => 'select', 
        'select_multiple' => 'false', 
        'choices' => Fields::$field_types,
        'description' => __( 'Nature des contenus compris dans le champ', Oak::$text_domain ), 
        'width' => '50',
        'condition' => true
    ),
    array ( 
        'name' => 'selector_options', 
        'property_name' => 'field_selector_options', 
        'type' => 'text', 
        'input_type' => 'text', 
        'placeholder' => __( 'Valeur', Oak::$text_domain ), 
        'description' => __( 'Exemple: Valeur1|Valeur2|Valeur3|...', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'Selecteur' ) )
        )
    ),
    array ( 
        'name' => 'function', 
        'property_name' => 'field_function', 
        'type' => 'text', 
        'input_type' => 'select', 
        'select_multiple' => 'false', 
        'choices' => Fields::$field_functions,
        'description' => __( 'Fonction du champ en tant que message', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'tag', 
        'property_name' => 'field_tag', 
        'type' => 'text', 
        'input_type' => 'text', 
        'placeholder' => __( 'Etiquette (Optionnel)', Oak::$text_domain ), 
        'description' => __( 'Contenu qui apparaitra dans le champ lorsqu\'inactif et non rempli. A défaut, la designation apparaitra.', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true
    ),
    array ( 
        'name' => 'help', 
        'property_name' => 'field_help', 
        'type' => 'text', 
        'input_type' => 'text', 
        'placeholder' => __( 'Aide au remplissage (Optionnel)', Oak::$text_domain ), 
        'description' => __( 'Contenu qui apparaitra sous le champ.', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true
    ),
    array ( 
        'name' => 'description', 
        'property_name' => 'field_description', 
        'type' => 'text', 
        'input_type' => 'textarea', 
        'placeholder' => __( 'Description (Optionnel)', Oak::$text_domain ), 
        'description' => __( 'Instruction liée à la forme comme au fond à apporter au contenu. Elle apparaîtront dans le volet des composants (à droite).', Oak::$text_domain ), 
        'width' => '100',
        'translatable' => true
    ),
);