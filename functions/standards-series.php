<?php 
acf_add_local_field_group(
    array (
        'key' => 'standards_series',
        'title' => 'Standards/Series',
        'fields' => array (

            array (
                'key' => 'type_standards_series',
                'label' => 'Normes ou série',
                'name' => 'type_standards_series',
                'type' => 'true_false',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '100%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '1',
                // Specific for field type
                'message' => 0,
            ),

            array (
                'key' => 'parent_standards_series',
                'label' => 'Normes / série parente de la norme / série',
                'name' => 'parent_standards_series',
                'type' => 'true_false',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '100%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '1',
                // Specific for field type
                'message' => 0,
            ),

            array (
                'key' => 'slug_parent_standards_series',
                'label' => 'Norme / série parente',
                'name' => 'slug_parent_standards_series',
                'type' => 'taxonomy',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'parent_standards_series', 'operator' => '==', 'value' => '1'
                        )
                    )
                ),
                'wrapper' => array (
                    'width' => '50%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                // Specific for field type
                'taxonomy' => 'standards_series',
                'field_type' => 'checkbox',
                'allow_null' => 0,
                'load_save_terms' => 1,
                'return_format' => 'id',
                'add_term' => 1
            ),

            array (
                'key' => 'color_standards_series',
                'label' => 'Couleur liée à la norme / série',
                'name' => 'color_standards_series',
                'type' => 'text',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '100%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '#FFFFFF',
                // Specific for field type
                'placeholder' => 'example: #FFFFFF',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'standards_series',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => ''
    )
);