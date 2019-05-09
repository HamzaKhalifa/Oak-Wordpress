<?php
Organizations::$properties = array(
    array ( 
        'name' => 'acronym', 
        'property_name' => 'organization_acronym', 
        'type' => 'text',
        'input_type' => 'text',
        'placeholder' => __( 'Acronyme', Oak::$text_domain ), 
        'description' => __( 'Acronyme.', Oak::$text_domain ), 
        'width' => '100',
        'translatable' => true
    ),
    array ( 
        'name' => 'logo', 
        'property_name' => 'organization_logo', 
        'type' => 'text', 
        'input_type' => 'image',
        'placeholder' => __( 'Logo', Oak::$text_domain ), 
        'description' => __( 'Logo.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'description', 
        'property_name' => 'organization_description', 
        'type' => 'text', 
        'input_type' => 'textarea',
        'placeholder' => __( 'Description', Oak::$text_domain ), 
        'description' => __( 'Description.', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true
    ),
    array ( 
        'name' => 'url', 
        'property_name' => 'organization_url', 
        'type' => 'text', 
        'input_type' => 'text',
        'placeholder' => __( 'Url', Oak::$text_domain ), 
        'description' => __( 'Url.', Oak::$text_domain ), 
        'width' => '50'
    ),
    array ( 
        'name' => 'address', 
        'property_name' => 'organization_address', 
        'type' => 'text', 
        'input_type' => 'text',
        'placeholder' => __( 'Address', Oak::$text_domain ), 
        'description' => __( 'Address.', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true
    ),
    array ( 
        'name' => 'country', 
        'property_name' => 'organization_country', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$countries,
        'placeholder' => __( 'Pays', Oak::$text_domain ), 
        'description' => __( 'Pays.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'company', 
        'property_name' => 'organization_company', 
        'type' => 'text', 
        'input_type' => 'checkbox',
        'placeholder' => __( 'Entreprise ou non', Oak::$text_domain ), 
        'description' => __( 'Entreprise ou non.', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true
    ),
    array ( 
        'name' => 'type', 
        'property_name' => 'organization_type', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => array(
            array ( 'value' => 'type 1', 'innerHTML' => 'Type 1' ),
            array ( 'value' => 'type 2', 'innerHTML' => 'Type 2' ),
            array ( 'value' => 'type 3', 'innerHTML' => 'Type 3' ),
        ),
        'placeholder' => __( 'Entreprise', Oak::$text_domain ), 
        'description' => __( 'Entreprise.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'side', 
        'property_name' => 'organization_side', 
        'type' => 'text', 
        'input_type' => 'checkbox',
        'placeholder' => __( 'Cotée', Oak::$text_domain ), 
        'description' => __( 'Cotée.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'sectors', 
        'property_name' => 'organization_sectors', 
        'type' => 'text', 
        'input_type' => 'text',
        'placeholder' => __( 'Secteurs d\'activité', Oak::$text_domain ), 
        'description' => __( 'Secteurs d\'activité', Oak::$text_domain ), 
        'width' => '100' 
    ),
);