<?php 
acf_add_local_field_group( array (
    'key' => 'results',
    'title' => __('Resultats', Oak::$text_domain ),
    'fields' => array (
        array (
            'key' => 'slug_organization',
            'label' => 'Organisation',
            'name' => 'slug_organization',
            'type' => 'post_object',
            'prefix' => '',
            'instructions' => __('Résultats de quelles organisations', Oak::$text_domain),
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
            'load_save_terms' => 1,
            'return_format' => 'object',
            'add_term' => 1
        ),

        array (
            'key' => 'year_res',
            'label' => __('Année', Oak::$text_domain),
            'name' => 'year_res',
            'type' => 'number',
            'prefix' => '',
            'instructions' => __('Spécifier l\'année de du résultat', Oak::$text_domain ),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '50%',
                'class' => '',
                'id' => '',
            ),
            'placeholder' => 'Example: 2018',
            'default_value' => '',
            // Specific for field type
            'message' => 0,
        ),
        array (
            'key' => 'turnover_res',
            'label' => __('Chiffre d’affaire', Oak::$text_domain),
            'name' => 'turnover_res',
            'type' => 'number',
            'prefix' => '',
            'instructions' => __('Spécifier le chiffre d\'affaire', Oak::$text_domain ),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '50%',
                'class' => '',
                'id' => '',
            ),
            'placeholder' => '',
            'default_value' => '',
            // Specific for field type
            'message' => 0,
        ),

        array (
            'key' => 'headcount_res',
            'label' => __('Nombre d\'employés', Oak::$text_domain),
            'name' => 'headcount_res',
            'type' => 'number',
            'prefix' => '',
            'instructions' => __('Spécifier le Nombre d\'employés', Oak::$text_domain ),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '100%',
                'class' => '',
                'id' => '',
            ),
            'placeholder' => '',
            'default_value' => '',
            // Specific for field type
            'message' => 0,
        ),

        array (
            'key' => 'balancesheet_res',
            'label' => __('Bilan', Oak::$text_domain),
            'name' => 'balancesheet_res',
            'type' => 'number',
            'prefix' => '',
            // 'instructions' => __('Bilan', Oak::$text_domain ),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '100%',
                'class' => '',
                'id' => '',
            ),
            'placeholder' => '',
            'default_value' => '',
            // Specific for field type
            'message' => 0,
        ),
    ),
    'location' => array (
        array (
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'results',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
));