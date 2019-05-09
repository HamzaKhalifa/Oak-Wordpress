<?php
Glossaries::$properties = array (
    array (
        'name' => 'publication', 
        'property_name' => 'glossary_publication', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$publications_array,
        'placeholder' => __( 'Publication dont est issue la terminologie', Oak::$text_domain ), 
        'description' => __( 'Publication dont est issue la terminologie', Oak::$text_domain ), 
        'width' => '50'
    ),
    array(
        'name' => 'object', 
        'property_name' => 'glossary_object', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$objects_array,
        'placeholder' => __( 'L\'objet auquel appartient la terminologie', Oak::$text_domain ), 
        'description' => __( 'L\'objet auquel appartient la terminologie', Oak::$text_domain ), 
        'width' => '50'
    ),
    array(
        'name' => 'depends', 
        'property_name' => 'glossary_depends', 
        'type' => 'text',
        'input_type' => 'checkbox',
        'placeholder' => __( 'Terminologie dépendante d’une autre:', Oak::$text_domain ), 
        'description' => __( 'Terminologie dépendante d’une autre:', Oak::$text_domain ), 
        'width' => '50',
        'condition' => true
    ),
    array(
        'name' => 'parent', 
        'property_name' => 'glossary_parent', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$glossaries_array,
        'placeholder' => __( 'Terminologie de niveau supérieur:', Oak::$text_domain ), 
        'description' => __( 'Terminologie de niveau supérieur:', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array(
            array( 'name' => 'depends', 'values' => array( 'true' ) )
        )
    ),
    array(
        'name' => 'definition', 
        'property_name' => 'glossary_definition', 
        'type' => 'text',
        'input_type' => 'textarea',
        'placeholder' => __( 'Définition', Oak::$text_domain ), 
        'description' => __( 'Définition', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true
    ),
    array(
        'name' => 'close', 
        'property_name' => 'glossary_close', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$glossaries_array,
        'placeholder' => __( 'Terminologie(s) proche(s) de la terminologie défnie: ', Oak::$text_domain ), 
        'description' => __( 'Terminologie(s) proche(s) de la terminologie défnie: ', Oak::$text_domain ), 
        'width' => '50',
    )
);