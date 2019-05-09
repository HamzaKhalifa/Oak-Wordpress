<?php
Terms::$properties = array (
    array(
        'name' => 'numerotation', 
        'property_name' => 'term_numerotation', 
        'type' => 'text',
        'input_type' => 'text',
        'placeholder' => __( 'Numérotation ', Oak::$text_domain ),
        'description' => __( 'Numérotation ', Oak::$text_domain ),
        'width' => '50'
    ),
    array(
        'name' => 'title', 
        'property_name' => 'term_title', 
        'type' => 'text',
        'input_type' => 'text',
        'placeholder' => __( 'Titre ', Oak::$text_domain ),
        'description' => __( 'Titre ', Oak::$text_domain ),
        'width' => '50',
        'translatable' => true
    ),
    array(
        'name' => 'description', 
        'property_name' => 'term_description', 
        'type' => 'text',
        'input_type' => 'text',
        'placeholder' => __( 'Déscription ', Oak::$text_domain ),
        'description' => __( 'Déscription ', Oak::$text_domain ),
        'width' => '100',
        'translatable' => true
    ),
    array(
        'name' => 'color', 
        'property_name' => 'term_color', 
        'type' => 'text',
        'input_type' => 'color',
        'placeholder' => __( 'Couleur ', Oak::$text_domain ),
        'description' => __( 'Couleur ', Oak::$text_domain ),
        'width' => '50'
    ),
    array(
        'name' => 'logo', 
        'property_name' => 'term_logo', 
        'type' => 'text',
        'input_type' => 'image',
        'placeholder' => __( 'Logo ', Oak::$text_domain ),
        'description' => __( 'Logo ', Oak::$text_domain ),
        'width' => '50'
    ),
    array(
        'name' => 'order', 
        'property_name' => 'term_order', 
        'type' => 'text',
        'input_type' => 'number',
        'placeholder' => __( 'Ordre dans le menu', Oak::$text_domain ),
        'description' => __( 'Ordre dans le menu', Oak::$text_domain ),
        'width' => '50'
    ),
    array(
        'name' => 'parent',
        'property_name' => 'term_parent', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$terms_array,
        'placeholder' => __( 'Terme Parent:', Oak::$text_domain ), 
        'description' => __( 'Terme Parent:', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array (
            array( 'name' => 'depends', 'values' => array( 'true' ) )
        )
    ),
);