<?php 
acf_add_local_field_group(
    array (
        'key' => 'gri',
        'title' => 'Élément d\'information',
        'fields' => array (
            array (
                'key' => 'core_disclosure',
                'label' => 'Élément d’information essentiel',
                'name' => 'core_disclosure',
                'type' => 'true_false',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '50%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                // Specific for field type
                'message' => 0,
            ),

            array (
                'key' => 'comprehensive_disclosure',
                'label' => 'Élément d’information exhaustif',
                'name' => 'comprehensive_disclosure',
                'type' => 'true_false',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'core_disclosure', 'operator' => '==', 'value' => '1'
                        )
                    )
                ),
                'wrapper' => array (
                    'width' => '50%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '1',
                // Specific for field type
                'message' => 0,
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'gri',
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