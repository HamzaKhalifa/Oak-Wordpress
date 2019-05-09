<?php 
Good_Practices::$properties = array(
    array (
        'name' => 'short_designation', 
        'property_name' => 'goodpractice_short_designation', 
        'type' => 'text',
        'input_type' => 'text',
        'placeholder' => __( 'Nom court', Oak::$text_domain ), 
        'description' => __( 'Nom court.', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true
    ),
    array ( 
        'name' => 'description', 
        'property_name' => 'goodpractice_description', 
        'type' => 'text', 
        'input_type' => 'textarea',
        'placeholder' => __( 'Description', Oak::$text_domain ), 
        'description' => __( 'Description.', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true
    ),
    array ( 
        'name' => 'illustration', 
        'property_name' => 'goodpractice_illustration', 
        'type' => 'text',
        'input_type' => 'image',
        'placeholder' => __( 'Logo', Oak::$text_domain ), 
        'description' => __( 'Logo.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'link', 
        'property_name' => 'goodpractice_link', 
        'type' => 'text', 
        'input_type' => 'text',
        'placeholder' => __( 'Lien', Oak::$text_domain ), 
        'description' => __( 'Lien.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'link_title', 
        'property_name' => 'goodpractice_link_title', 
        'type' => 'text', 
        'input_type' => 'text',
        'placeholder' => __( 'Titre du lien', Oak::$text_domain ), 
        'description' => __( 'Titre du lien.', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true
    ),
    array ( 
        'name' => 'publication', 
        'property_name' => 'goodpractice_publication', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$publications_array,
        'placeholder' => __( 'Publication', Oak::$text_domain ), 
        'description' => __( 'Publication.', Oak::$text_domain ), 
        'width' => '50'
    ),
    array ( 
        'name' => 'objects', 
        'property_name' => 'goodpractice_objects', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'true',
        'choices' => Oak::$objects_array,
        'placeholder' => __( 'Objects liés', Oak::$text_domain ), 
        'description' => __( 'Objects liés.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'quantis', 
        'property_name' => 'goodpractice_quantis', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'true',
        'choices' => Oak::$quantis_array,
        'placeholder' => __( 'Indicteurs', Oak::$text_domain ), 
        'description' => __( 'Indicteurs.', Oak::$text_domain ), 
        'width' => '50' 
    ),
);