<?php 
acf_add_local_field_group(
    array (
        'key' => 'publications',
        'title' => 'Publication',
        'fields' => array (
            array (
                'key' => 'cover_publication',
                'label' => 'Vignette',
                'name' => 'cover_publication',
                'type' => 'image',
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
            ),

            array (
                'key' => 'fle_publication',
                'label' => 'Fichier',
                'name' => 'fle_publication',
                'type' => 'file',
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
                'return_format' => 'array',
                // 'preview_size' => 'thumbnail',
                'library' => 'all',
                'min_size' => 0,
                // 'max_size' => 0,
                // 'mime_types' => '',
            ),

            array (
                'key' => 'slug_org',
                'label' => 'Organisation émettrice de la publication',
                'name' => 'slug_org',
                'type' => 'post_object',
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
                'post_type' => 'organization',
                'allow_null' => 0,
                'multiple' => 1,
                'return_format' => 'object',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'publication',
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