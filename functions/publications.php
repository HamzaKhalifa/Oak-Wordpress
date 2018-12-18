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
                    'width' => '100%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                // Specific for field type
            ),

            array (
                'key' => 'pub_file_type',
                'label' => __('Fichier ou lien', Dawn::$text_domain),
                'name' => 'pub_file_type',
                'type' => 'select',
                'prefix' => '',
                'instructions' => 'Spécifier si l\'organisation est de type entreprise ou non',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '50%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                // Specific for field type
                'choices' => array(
                    __('Fichier', Dawn::$text_domain),
                    __('Lien', Dawn::$text_domain)
                ),
                'message' => 0,
                'multiple' => 0
            ),

            array (
                'key' => 'file_publication',
                'label' => 'Fichier',
                'name' => 'file_publication',
                'type' => 'file',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'pub_file_type', 'operator' => '==', 'value' => '0'
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
                'return_format' => 'array',
                'library' => 'all',
                'min_size' => 0,
            ),

            array (
                'key' => 'pub_link',
                'label' => 'Lien',
                'name' => 'pub_link',
                'type' => 'text',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'pub_file_type', 'operator' => '==', 'value' => '1'
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
                'return_format' => 'array',
                'library' => 'all',
                'min_size' => 0,
                'placeholder' => __('Lien', Dawn::$text_domain)
            ),

            array (
                'key' => 'pub_des',
                'label' => __('Description', Dawn::$text_domain),
                'name' => 'pub_des',
                'type' => 'textarea',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' =>0,
                'wrapper' => array (
                    'width' => '100%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                // Specific for field type
                'return_format' => 'array',
                'library' => 'all',
                'min_size' => 0,
                'placeholder' => __('Description', Dawn::$text_domain)
            ),

            array (
                'key' => 'pub_year',
                'label' => __('Année', Dawn::$text_domain),
                'name' => 'pub_year',
                'type' => 'number',
                'prefix' => '',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' =>0,
                'wrapper' => array (
                    'width' => '100%',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                // Specific for field type
                'return_format' => 'array',
                'library' => 'all',
                'min_size' => 0,
                'placeholder' => __('Exemple: 2019', Dawn::$text_domain)
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