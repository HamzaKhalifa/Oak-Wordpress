<?php
Graphs::$properties = array (
    array (
        'name' => 'data', 
        'property_name' => 'graph_data', 
        'type' => 'text', 
        'input_type' => 'textarea', 
        'placeholder' => __( 'Données', Oak::$text_domain ), 
        'description' => __( 'Données', Oak::$text_domain ), 
        'width' => '50',
        'translatable' => true,
        'takeapart' => true
    ),
    array (
        'name' => 'links', 
        'property_name' => 'graph_links', 
        'type' => 'text', 
        'input_type' => 'textarea', 
        'placeholder' => __( 'Liens/Classes', Oak::$text_domain ), 
        'description' => __( 'Liens/Classes', Oak::$text_domain ), 
        'width' => '50',
    )
);