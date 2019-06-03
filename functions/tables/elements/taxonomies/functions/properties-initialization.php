<?php
Taxonomies::$properties = array(
    array ( 
        'name' => 'description', 
        'property_name' => 'taxonomy_description', 
        'type' => 'text', 
        'input_type' => 'textarea', 
        'placeholder' => __( 'Description', Oak::$text_domain ), 
        'description' => __( 'Description.', Oak::$text_domain ), 
        'width' => '100',
        'translatable' => true
    ),
    array (
        'name' => 'structure', 
        'property_name' => 'form_structure', 
        'type' => 'text', 
        'input_type' => 'select', 
        'select_multiple' => 'false', 
        'choices' => array ( 
            array ( 'value' => '0', 'innerHTML' => 'Fixe' ), 
        ), 
        'description' => __( 'Structure du formulaire', Oak::$text_domain ), 'width' => '50'
    ),
    array ( 
        'name' => 'publication', 
        'property_name' => 'taxonomy_publication', 
        'type' => 'text', 
        'input_type' => 'select',
        'select_multiple' => 'false',
        'choices' => Oak::$publications_array, 
        'description' => __( 'Publications liée', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'numerotation', 
        'property_name' => 'taxonomy_numerotation', 
        'type' => 'text',
        'input_type' => 'checkbox',
        'placeholder' => __( 'Numérotation', Oak::$text_domain ), 
        'description' => __( 'Numérotation.', Oak::$text_domain ), 
        'width' => '50'
    ),
    array ( 
        'name' => 'title', 
        'property_name' => 'taxonomy_title', 
        'type' => 'text', 
        'input_type' => 'checkbox',
        'placeholder' => __( 'Titre', Oak::$text_domain ), 
        'description' => __( 'Titre.', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true
    ),
    array (
        'name' => 'term_description', 
        'property_name' => 'taxonomy_term_description', 
        'type' => 'text',
        'input_type' => 'checkbox',
        'placeholder' => __( 'Déscription du terme', Oak::$text_domain ),
        'description' => __( 'Déscription du terme.', Oak::$text_domain ),
        'width' => '50',
        'translatable' => true
    ),
    array ( 
        'name' => 'color', 
        'property_name' => 'taxonomy_color', 
        'type' => 'text', 
        'input_type' => 'checkbox',
        'placeholder' => __( 'Couleur', Oak::$text_domain ), 
        'description' => __( 'Couleur.', Oak::$text_domain ), 
        'width' => '50' 
    ),
    array ( 
        'name' => 'brand', 
        'property_name' => 'taxonomy_brand', 
        'type' => 'text', 
        'input_type' => 'checkbox',
        'placeholder' => __( 'Logo', Oak::$text_domain ), 
        'description' => __( 'Logo.', Oak::$text_domain ), 
        'width' => '100',
        'translatable' => true
    ),
);