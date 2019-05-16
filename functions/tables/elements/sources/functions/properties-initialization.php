<?php 
Sources::$properties = array(
    array (
        'name' => 'short_title', 
        'property_name' => 'source_short_title', 
        'type' => 'text',
        'input_type' => 'text',
        'placeholder' => __( 'Titre court', Oak::$text_domain ), 
        'description' => __( 'Titre court.', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true
    ),
    array (
        'name' => 'long_title', 
        'property_name' => 'source_long_title', 
        'type' => 'text',
        'input_type' => 'text',
        'placeholder' => __( 'Titre long', Oak::$text_domain ), 
        'description' => __( 'Titre long.', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true
    ),
    array ( 
        'name' => 'illustration', 
        'property_name' => 'source_illustration', 
        'type' => 'text',
        'input_type' => 'image',
        'placeholder' => __( 'Illustration', Oak::$text_domain ), 
        'description' => __( 'Illustration.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'description', 
        'property_name' => 'source_description', 
        'type' => 'text', 
        'input_type' => 'textarea',
        'placeholder' => __( 'Description', Oak::$text_domain ), 
        'description' => __( 'Description.', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true
    ),
    array(
        'name' => 'publication', 
        'property_name' => 'source_publication', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$publications_array,
        'placeholder' => __( 'Publication: ', Oak::$text_domain ),
        'description' => __( 'Publication: ', Oak::$text_domain ),
        'width' => '50'
    ),
    array ( 
        'name' => 'object', 
        'property_name' => 'source_object', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'true',
        'choices' => Oak::$objects_array,
        'placeholder' => __( 'Object', Oak::$text_domain ), 
        'description' => __( 'Object.', Oak::$text_domain ), 
        'width' => '50',
    ),
    array ( 
        'name' => 'type', 
        'property_name' => 'source_type', 
        'type' => 'text',
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array ( 'value' => 'internal', 'innerHTML' => 'Interne' ),
            array ( 'value' => 'external', 'innerHTML' => 'Externe' ),
        ),
        'placeholder' => __( 'Type', Oak::$text_domain ), 
        'description' => __( 'Type.', Oak::$text_domain ), 
        'width' => '100',
        'condition' => true
    ),
    array ( 
        'name' => 'link_object', 
        'property_name' => 'source_link_object', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'true',
        'choices' => Oak::$objects_array,
        'placeholder' => __( 'Object', Oak::$text_domain ), 
        'description' => __( 'Object.', Oak::$text_domain ), 
        'width' => '100',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'internal' ) ),
        ),
    ),
    array ( 
        'name' => 'link', 
        'property_name' => 'source_link', 
        'type' => 'text', 
        'input_type' => 'text',
        'placeholder' => __( 'Lien', Oak::$text_domain ), 
        'description' => __( 'Lien.', Oak::$text_domain ), 
        'width' => '50',
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'external' ) ),
        ),
    ),
    array ( 
        'name' => 'link_title', 
        'property_name' => 'source_link_title', 
        'type' => 'text', 
        'input_type' => 'text',
        'placeholder' => __( 'Titre du lien', Oak::$text_domain ), 
        'description' => __( 'Titre du lien.', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true,
        'depends' => array(
            array( 'name' => 'type', 'values' => array( 'external' ) ),
        ),
    ),
);