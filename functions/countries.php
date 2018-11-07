<?php 
acf_add_local_field_group(
    array (
        'key' => 'countries',
        'title' => 'Pays',
        'fields' => array (
            array (
                'key' => 'acronym_country',
                'label' => 'Acronyme',
                'name' => 'acronym_country',
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
                'default_value' => '',
                // Specific for field type
                'placeholder' => 'Acronyme',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
                'readonly' => 0,
                'disabled' => 0,
            ),

            array (
                'key' => 'flag_country',
                'label' => 'Drapeau',
                'name' => 'flag_country',
                'type' => 'image',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '100%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                // Specific for field type
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'country',
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