<?php
Graphs::$properties = array (
    array ( 
        'name' => 'title', 
        'property_name' => 'graph_title', 
        'type' => 'text', 
        'input_type' => 'text', 
        'placeholder' => __( 'Titre', Oak::$text_domain ), 
        'description' => __( 'Titre', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true
    ),
    array (
        'name' => 'data', 
        'property_name' => 'graph_data', 
        'type' => 'text', 
        'input_type' => 'textarea', 
        'placeholder' => __( 'Données', Oak::$text_domain ), 
        'description' => __( 'Données', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true
    ),
    array (
        'name' => 'links', 
        'property_name' => 'graph_links', 
        'type' => 'text', 
        'input_type' => 'textarea', 
        'placeholder' => __( 'Liens/Classes', Oak::$text_domain ), 
        'description' => __( 'Liens/Classes', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true
    ),
    array (
        'name' => 'legend_configuration', 
        'property_name' => 'graph_legend_configuration', 
        'type' => 'text', 
        'input_type' => 'textarea', 
        'placeholder' => __( 'Configuration de la légende', Oak::$text_domain ), 
        'description' => __( 'Configuration de la légende', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true
    )
);