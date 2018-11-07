<?php 
acf_add_local_field_group(
    array (
        'key' => 'regions',
        'title' => 'Régions',
        'fields' => array (
            array (
                'key' => 'acronym_regions',
                'label' => 'Acronyme',
                'name' => 'acronym_regions',
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
        ),
        'location' => array (
            array (
                array (
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'region',
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